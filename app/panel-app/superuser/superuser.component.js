$app = angular.module('gafpApp', ['ngRoute', 'angularFileUpload', 'ui.bootstrap']);
$app.controller('project', ['$http', '$scope', '$httpParamSerializerJQLike', 'FileUploader', 'FileItem', '$uibModal',
        function projectController($http, $scope, $httpParamSerializerJQLike, FileUploader, FileItem, $uibModal) {

            //-------------------------------------------------------------------

            //Inicializando variaveis de escopo geral do controller
            $scope.projects = Array();
            $scope.steps = Array();
            $scope.page = Array();
            $scope.responsibles = Array();
            $scope.areas = Array();

            //------------------------------------ Etapa 1 e 2 - Empresa e Modelo

            /* Retorna o valor selecionado no component de seleção*/
            var _selected;

            $scope.fieldSelected = function(value) {
                if (arguments.length) {
                    _selected = value;
                    $scope.page.dataSend = value;
                } else {
                    return _selected;
                }
            };
            // Retorna valor de seleção escolhido
            $scope.fieldOptions = {
                debounce: {
                    default: 500,
                    blur: 250
                },
                getterSetter: true
            };

            //Templates de etapas para inclusão de projeto
            steps = [{
                    number: 1,
                    templateUrl: 'app/panel-app/superuser/pages/new/company.php',
                    url: 'company'
                },
                {
                    number: 2,
                    templateUrl: 'app/panel-app/superuser/pages/new/model.php',
                    url: 'model'
                },
                {
                    number: 3,
                    templateUrl: 'app/panel-app/superuser/pages/new/users.php',
                    url: 'users'
                },
                {
                    number: 4,
                    templateUrl: 'app/panel-app/superuser/pages/new/responsibles.php',
                    url: 'responsible'
                },
                {
                    number: 5,
                    templateUrl: 'app/panel-app/superuser/pages/new/approver.php',
                    url: 'approver'
                }
            ];

            //Adicionado os passos ao escopo global
            $scope.steps = steps;

            //Setando a primeira etapa a ser exibida quando acessar página
            $scope.page = {
                currentPage: steps[0].number, //padrão 0
                templateUrl: steps[0].templateUrl, //padrão 0
                dataSend: _selected,
                projectData: {
                    company: '',
                    model: '',
                    users: '',
                    responsible: '',
                    approver: ''
                }
            };

            //Adicionar etapas de projeto 
            $scope.addProject = function(step) {

                url = steps[step]['url'];

                $http({
                    url: 'projects/fields/' + url,
                    method: 'POST',
                    //Função formatar as$scopeiaveis de forma a funcionar na requisição
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: {
                        [url]: $scope.page.dataSend
                    }
                }).then(function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data > 0) {
                        //Atribuindo resultado a objeto projectData
                        $scope.page.projectData[url] = response.data;
                        $scope.page.currentPage = steps[step + 1].number;
                        $scope.page.templateUrl = steps[step + 1].templateUrl;
                    }
                });
            };

            //-------------------------------------------- Etapa 3 - Upload de arquivo

            //Definindo o uploader
            $scope.uploader = new FileUploader({
                'url': 'projects/fields/users',
                'queueLimit': 1,
                'filters': [{
                    fn: function(item) {
                        result = item.name.search(/\.(xls|xlsx|csv)/); //arquivos suportados
                        if (result > 0)
                            return true;
                    }
                }],
                'formData': [{ company: $scope.page.projectData.company.toString() }],
                'removeAfterUpload': true,
                onBeforeUploadItem: function(item, progress) {
                    angular.element('.btn-file').attr({ 'disabled': 'disabled' });
                },
                onProgressItem: function(item, progress) {
                    $scope.fileUploadProgress = progress;
                },
                onSuccessItem: function(item, response, status, headers) {
                    if (status == 200 && response.length > 0) {
                        //Atribuir valores no scopo do angular
                        response.forEach(function(element, index) {

                            //Adiciona a var responsibles
                            $scope.responsibles[index] = {
                                id: element.id,
                                username: element.username,
                                email: element.email,
                                area: Array()
                            };

                            //Para cada array de área adicionar                            
                            element.area.forEach(function(el, ind) {
                                if (el !== "") {
                                    $scope.areas.push({ name: el });
                                    $scope.responsibles[index].area.push({ name: el });
                                }
                            });

                        });

                        //Atribuindo resultado a objeto projectData
                        $scope.page.currentPage = steps[3].number;
                        $scope.page.templateUrl = steps[3].templateUrl;
                    }

                }

            });


            //---------------------------------------------------------------

            //Retorna os dados
            $http.get('projects/list').then(function(response) {

                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0)
                    return;

                //Atribuindo valores a$scope de escopo do controller
                response.data.forEach(function(element, index) {

                    $scope.projects[index] = {
                        id: element.id,
                        company: element.company,
                        model: element.model,
                        responsible: element.responsible,
                        approver: element.approver
                    };

                }, this);

            });

            $scope.reorderProjectList = function() {
                var data = $scope.order; //dados dos selects

                $http({
                    url: 'projects/list',
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: {
                        order: data.data,
                        by: data.by
                    }
                }).then(function(response) {

                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.length <= 0)
                        return;

                    //Atribuindo valores a$scope de escopo do controller
                    response.data.forEach(function(element, index) {

                        $scope.projects[index] = {
                            id: element.id,
                            company: element.company,
                            model: element.model,
                            responsible: element.responsible,
                            approver: element.approver
                        };

                    }, this);

                });
            };

            //Retorna os dados de empresas para alimentar 'select' autocomplete
            $http.get('projects/fields/company').then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0) {
                    return false;
                }
                $scope.companys = response.data;
            });

            //Retorna os dados de empresas para alimentar 'select' autocomplete
            $http.get('projects/fields/model').then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0) {
                    return false;
                }
                $scope.models = response.data;
            });

            //Deletar um projeto
            angular.element('a.delete').on('click', function(event) {
                event.preventDefault();
                href = this.attr('href'); //pega url
                id = this.attr('id');
                action = confirm('Deseja excluir o projeto?'); //abre modal

                if (action) {
                    //Requisição http (delete)
                    $http({
                        url: href,
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }).then(function(response) {
                        if (response.data <= 0)
                            return;

                        $scope.projects.splice(id, 1);

                    });
                }
            });

        }
    ])
    .controller('modelo', ['$http', '$scope', '$httpParamSerializerJQLike',
        function modeloController($http, $scope, $httpParamSerializerJQLike) {

            $scope.listsModel = true; //habilitar list de modelos
            $scope.models = Array(); //Inicializa o array

            //----------


            //Adicionar item in REALTIME
            $scope.addModel = {};
            $scope.addModel.modelItems = [];
            $scope.addModel.addItem = function() {
                $scope.addModel.modelItems.push({
                    name: $scope.addModel.item.name,
                    description: $scope.addModel.item.description
                });
                delete $scope.addModel.item;
            };

            //Existe listagem de modelos se model listsModel estiver definido
            if ($scope.listsModel != undefined) {
                //Retorna os dados
                $http.get('model/list').then(function(response) {

                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.length <= 0)
                        return;

                    //Atribuindo valores a$scope de escopo do controller
                    response.data.forEach(function(element, index) {

                        $scope.models[index] = {
                            id: element.id,
                            model: element.model,
                            description: element.description,
                            topics: element.topics
                        };

                    }, this);

                });
            }

            $scope.addModel.submit = function() {

                //Atribuindo dados dos campos de tópicos
                topicos = {};
                $scope.addModel.modelItems.forEach(
                    function(element, index) {
                        topicos[index] = {
                            name: element.name,
                            description: element.description
                        };
                    }, this);

                //Requisição http (insert)
                $http({
                    url: 'model',
                    method: 'POST',
                    //Função formatar as$scopeiaveis de forma a funcionar na requisição
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: {
                        name: $scope.addModel.name,
                        description: $scope.addModel.description,
                        topics: topicos
                    }
                }).then(function(response) {
                    if (response.data <= 0)
                        return;

                    if ($scope.steps) {
                        //Atribuindo resultado a objeto projectData
                        $scope.page.projectData.model = response.data;
                        $scope.page.currentPage = $scope.steps[2].number;
                        $scope.page.templateUrl = $scope.steps[2].templateUrl;
                    }

                });
            }; //submit

        }
    ]).config(function($routeProvider) {

        $routeProvider.when('/', {
            templateUrl: 'app/panel-app/superuser/pages/project-page.php',
            controller: 'project'
        });

        $routeProvider.when('/projects/edit/', {
            templateUrl: 'app/panel-app/superuser/pages/edit/project.php',
            controller: 'editProject'
        });

        $routeProvider.when('/modelo', {
            templateUrl: 'app/panel-app/superuser/pages/model-page.php',
            controller: 'modelo'
        });

    }).component('superuserApp', {
        // Note: The URL is relative to our `index.php` file
        templateUrl: 'app/panel-app/superuser/superuser.template.php',
        controller: ['$http', '$scope', '$httpParamSerializerJQLike',
            function superuserAppController($http, $scope, $httpParamSerializerJQLike) {

                //Links de navegação
                $scope.navs = [{
                        link: "#",
                        title: "Dashboard"
                    },
                    {
                        link: "painel#!/modelo",
                        title: "Modelo"
                    }
                ];

            }
        ]
    });