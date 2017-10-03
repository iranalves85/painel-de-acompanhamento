$app.controller('project', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
        function projectController($http, $scope, $httpParamSerializerJQLike, $uibModal) {

            //Páginas
            $scope.steps = Array(); //lista de etapas
            $scope.page = Array(); //carregament de templates

            //Listas
            $scope.projects = Array(); //lista de projetos
            $scope.responsibles = Array(); //lista de responsavéis
            $scope.areas = Array(); //list de áreas

            //Atribuindo valores a$scope de escopo do controller
            $getProjectList = function(response) {
                //Atribuindo valores a$scope de escopo do controller
                response.data.forEach(function(element, index) {

                    $scope.projects[index] = {
                        id: element.id,
                        date_created: element.date_created,
                        company: element.company,
                        responsible: element.responsible,
                        approver: element.approver
                    };

                }, this);
            }
            $data = getData($http, 'projects/', $getProjectList);

            //Função para reordernar lista de projetos
            $scope.reorderProjectList = function() {
                //Verifica os valores dos campos estao setados
                $order = ($scope.order.order != undefined) ? '/' + $scope.order.order.value : "";
                $by = ($scope.order.by != undefined) ? '/' + $scope.order.by.value : "";

                getData($http,
                    'projects/' + $order + $by,
                    function(response) {
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


            //Função de deletar um projeto
            $scope.delete = function(id) {

                $response = confirm("Tem certeza que deseja excluir o projeto?");

                if ($response) {
                    //Retorna lista de planos baseado no id do user
                    $http({
                        url: 'projects/delete/' + id,
                        method: "DELETE"
                    }).then(function(response) {
                        //Atribuindo valores a$scope de escopo do controller
                        if (response.data.type != 'undefined') {
                            alert(response.data.msg);
                            location.reload();
                        }
                    });
                }
            };


        }
    ]).controller('updateProject', ['$http', '$scope', '$httpParamSerializerJQLike', 'FileUploader', 'FileItem', '$routeParams',
        function updateProjectController($http, $scope, $httpParamSerializerJQLike, FileUploader, FileItem, $routeParams) {

            //Inicializando variaveis de escopo geral do controller
            $scope.responsibles = Array();
            $scope.areas = Array();
            $projectID = $routeParams.id;

            /////////GET 

            //Retorna lista de companias cadastradas para alimentar field
            $companys = getData($http, 'projects/fields/company', function(response) {
                //requisição completa carrega input company
                if (response.xhrStatus == "complete") {
                    $scope.companys = response.data;
                }

                //Se retorno fn de carregar modelos for true, carrega dados do projeto
                if ($models() == true) {
                    $project(); //executa função projeto
                }

            });

            //retorna lista de modelos para alimentar field
            $models = function() {
                getData($http, 'projects/fields/model', function(response) {
                    $scope.models = response.data;
                });
                return true;
            };

            //Retorna dados do projeto
            $project = function() {
                getData($http, 'projects/' + $projectID, function(response) {
                    if (response.xhrStatus == "complete") {
                        $scope.project = response.data;
                        $areas($scope.project.users);
                    }
                });
            };

            //Atribuir opções no seletor de area
            $areas = function(objectToInterate) {
                angular.forEach(objectToInterate, function(value, key) {
                    value.area.forEach(function(el, index) {
                        //Verifica se já existe um item com mesmo valor
                        $elExist = $scope.areas.find(function(value) {
                            return (value.name == el) ? true : false;
                        }, this);
                        //Se falso, adiciona item ao array
                        if (!$elExist) {
                            $scope.areas.push({ name: el });
                        }
                    });
                });
            };

            //Adicionar etapas de projeto 
            $scope.updateProject = function() {

                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Definindo função de retorno
                $addProjectReturn = function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data.type == 'success') {
                        //Atribuindo resultado a objeto projectData
                        alert(response.data.msg);
                        location.reload();
                    } else {
                        alert(response.data.msg);
                    }
                };

                //Submete o formulário para add novo projeto
                $data = updateData($method, 'projects/', $projectID,
                    $scope.project, $addProjectReturn);

            };

            //Definindo o uploader de usuários
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
                'removeAfterUpload': true,
                onAfterAddingFile: function(item) {
                    $scope.alerts = [];
                    $scope.fileUploadProgress = 0;
                },
                onBeforeUploadItem: function(item, progress) {
                    //Adicionando dados antes do upload do arquivo
                    //Prevenindo o envio de dados vazio
                    item.formData.push({
                        project: $projectID,
                        company: $scope.project.company
                    });
                    //Desabilitar o input de arquivo
                    $scope.fileInput = angular.element('.btn-file').attr({ 'disabled': 'disabled' });
                },
                onProgressItem: function(item, progress) {
                    $scope.fileUploadProgress = progress;
                },
                onSuccessItem: function(item, response, status, headers) {

                    if (status == 200) {

                        if (!response.success && response.users.length == undefined) {

                            //Mostrar erros
                            $scope.alerts = [{
                                type: 'danger',
                                msg: response.error[0]
                            }];
                            //Zera o input para subir novamente
                            $scope.fileInput.removeAttr('disabled').val('');
                            return;

                        } else if (response.users.length > 0) {
                            //Atribuir valores no scopo do angular
                            response.users.forEach(function(element, index) {
                                //Adiciona a var responsibles
                                $scope.project.users[index] = {
                                    id: element.id,
                                    username: element.username,
                                    email: element.email,
                                    area: element.area
                                };
                            });

                            //Adiciona as áreas dos novos usuários
                            $areas($scope.project.users);

                            //Zera o input para subir novamente
                            $scope.fileInput.removeAttr('disabled').val('');
                        }

                    }

                }

            });

        }
    ]).controller('addProject', ['$http', '$scope', '$httpParamSerializerJQLike', 'FileUploader', 'FileItem',
        function addProjectController($http, $scope, $httpParamSerializerJQLike, FileUploader, FileItem) {

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
                    responsibles: '',
                    approver: ''
                }
            };

            //Adicionar etapas de projeto 
            $scope.addProject = function(step) {

                $url = steps[step]['url'];
                $method = {
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Definindo função de retorno
                $addProjectReturn = function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data > 0) {
                        //Atribuindo resultado a objeto projectData
                        $scope.page.projectData[$url] = response.data;
                        $scope.page.currentPage = steps[step + 1].number;
                        $scope.page.templateUrl = steps[step + 1].templateUrl;
                    }
                };

                //Submete o formulário para add novo projeto
                $data = postData($method, 'projects/fields/', $url, {
                    [$url]: $scope.page.dataSend
                }, $addProjectReturn);

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
                'removeAfterUpload': true,
                onAfterAddingFile: function(item) {
                    $scope.alerts = [];
                    $scope.fileUploadProgress = 0;
                },
                onBeforeUploadItem: function(item, progress) {
                    //Adicionando dados antes do upload do arquivo
                    //Prevenindo o envio de dados vazio
                    item.formData.push({
                        company: $scope.page.projectData.company.toString()
                    });
                    //Desabilitar o input de arquivo
                    $scope.fileInput = angular.element('.btn-file').attr({ 'disabled': 'disabled' });
                },
                onProgressItem: function(item, progress) {
                    $scope.fileUploadProgress = progress;
                },
                onSuccessItem: function(item, response, status, headers) {

                    if (status == 200) {

                        if (!response.success && response.users.length == undefined) {

                            //Mostrar erros
                            $scope.alerts = [{
                                type: 'danger',
                                msg: response.error[0]
                            }];
                            //Zera o input para subir novamente
                            $scope.fileInput.removeAttr('disabled').val('');
                            return;

                        } else if (response.users.length > 0) {
                            //Atribuir valores no scopo do angular
                            response.users.forEach(function(element, index) {
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
                            $scope.page.projectData.project = response.project;
                            $scope.page.currentPage = steps[3].number;
                            $scope.page.templateUrl = steps[3].templateUrl;
                        }

                    }

                }

            });

            //------------------------------------------------ Etapa 4

            //Selecionar responsáveis
            $scope.selectResponsibles = function() {

                //Se a seleção de responsavéis tiver algum id selecionado
                if ($scope.page.projectData.responsibles != undefined &&
                    $scope.page.projectData.responsibles.length > 0) {

                    //Redireciona para a página de aprovaçção
                    $scope.page.currentPage = steps[4].number;
                    $scope.page.templateUrl = steps[4].templateUrl;
                }
            };

            //------------------------------------------------ Etapa 5

            //Selecionar aprovador
            $scope.selectApprover = function() {

                //Dados faltantes do projeto
                $model = $scope.page.projectData.model; //Id do modelo
                $responsibles = $scope.page.projectData.responsibles; //Lista de id's selecionados
                $approver = $scope.page.projectData.approver; //Id selecionado
                $project = $scope.page.projectData.project; //id do projeto

                console.log($scope.page.projectData);

                $url = steps[4]['url']; //url post
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Definindo função de retorno
                $addProjectReturn = function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data.type == 'success') {
                        //Atribuindo resultado a objeto projectData
                        alert(response.data.msg);
                        location.reload();
                    } else {
                        alert(response.data.msg);
                    }
                };

                //Submete o formulário para add novo projeto
                $data = postData($method, 'projects/fields/', $url, {
                    model: $model,
                    approver: $approver,
                    responsibles: $responsibles,
                    project: $project
                }, $addProjectReturn);

            };

            /////////GET 

            //Retorna lista de companias cadastradas para alimentar field
            $companys = getData($http, 'projects/fields/company', function(response) {
                $scope.companys = response.data;
            });

            //retorna lista de modelos para alimentar field
            $models = getData($http, 'projects/fields/model', function(response) {
                $scope.models = response.data;
            });

        }
    ])
    .controller('model', ['$http', '$scope', '$httpParamSerializerJQLike',
        function modelController($http, $scope, $httpParamSerializerJQLike) {

            $scope.models = Array(); //Inicializa o array

            $getModelList = function(response) {
                //Atribuindo valores a$scope de escopo do controller
                response.data.forEach(function(element, index) {
                    $scope.models[index] = {
                        id: element.id,
                        model: element.name,
                        description: element.description,
                        topics: element.topics
                    };
                }, this);
            };

            //Retorna os modelos em lista
            $modelListData = getData($http, 'model/', $getModelList);

            //Função para reordernar lista de projetos
            $scope.reorderModelList = function() {
                //Verifica os valores dos campos estao setados
                $order = ($scope.order.order != undefined) ? '/' + $scope.order.order.value : "";
                $by = ($scope.order.by != undefined) ? '/' + $scope.order.by.value : "";
                //Retorna os dados reorganizados
                getData($http, 'model' + $order + $by, $getModelList);
            };

            //Função de deletar um modelo
            $scope.delete = function(id) {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'model/delete/' + id,
                    method: "GET"
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

        }
    ]).controller('addModel', ['$http', '$scope', '$httpParamSerializerJQLike',
        function addModelController($http, $scope, $httpParamSerializerJQLike) {

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

            $scope.submit = function() {

                //Atribuindo dados dos campos de tópicos
                topicos = {};
                $scope.addModel.modelItems.forEach(
                    function(element, index) {
                        topicos[index] = {
                            name: element.name,
                            description: element.description
                        };
                    }, this);

                //Objeto com objeto angular
                $method = {
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Definindo função de retorno
                $addModelReturn = function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data > 0) {
                        //Atribuindo resultado a objeto projectData
                        if ($scope.page != undefined) {
                            $scope.page.projectData.model = response.data;
                            $scope.page.currentPage = $scope.steps[2].number;
                            $scope.page.templateUrl = $scope.steps[2].templateUrl;
                        } else {
                            alert("Modelo criado com sucesso!");
                            location.reload();
                        }
                    }
                };

                //Submete o formulário para add novo model
                $data = postData($method, 'model', undefined, {
                    name: $scope.addModel.name,
                    description: $scope.addModel.description,
                    topics: topicos
                }, $addModelReturn);


            }; //submit
        }
    ]).controller('updateModel', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function updateModelController($http, $scope, $httpParamSerializerJQLike, $routeParams) {
            //Id do modelo atual
            $modelID = $routeParams.id;
            $scope.models = {};

            //Função de retorno na requisição
            $getModelReturn = function(response) {
                //Atribuindo valores a$scope de escopo do controller
                $scope.models = response.data;
            };
            //Retorna os modelos em lista
            $modelData = getData($http, 'model/' + $modelID, $getModelReturn);

            //Adicionar item in REALTIME
            $scope.updateModel = {};
            $scope.updateModel.modelItems = [];
            $scope.updateModel.updateItem = function() {
                if ($scope.updateModel.item === undefined) {
                    return;
                }
                $scope.models.topics.push({
                    name: $scope.updateModel.item.name,
                    description: $scope.updateModel.item.description
                });
                delete $scope.updateModel.item;
            };

            $scope.submit = function() {

                //Objeto com objeto angular
                $method = {
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Definindo função de retorno
                $addModelReturn = function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                };

                //Submete o formulário para add novo model
                $data = updateData($method, 'model/', $modelID, $scope.models, $addModelReturn);

            }; //submit
        }
    ]).config(function($routeProvider) {

        //Pagina inicial: Lista projetos
        $routeProvider.when('/', {
            templateUrl: 'app/panel-app/superuser/pages/lists/project.php',
            controller: 'project'
        });

        //Editar um projeto existente
        $routeProvider.when('/projects/edit/:id', {
            templateUrl: 'app/panel-app/superuser/pages/edit/project.php',
            controller: 'updateProject'
        });

        //Editar um projeto existente
        $routeProvider.when('/projects/new', {
            templateUrl: 'app/panel-app/superuser/pages/add/project.php',
            controller: 'addProject'
        });

        //Lista modelos existentes
        $routeProvider.when('/model', {
            templateUrl: 'app/panel-app/superuser/pages/lists/model.php',
            controller: 'model'
        });

        //Editar um modelo existente
        $routeProvider.when('/model/edit/:id/', {
            templateUrl: 'app/panel-app/superuser/pages/edit/model.php',
            controller: 'updateModel'
        });

        //Adicionar um novo modelo
        $routeProvider.when('/model/new/', {
            templateUrl: 'app/panel-app/superuser/pages/add/model.php',
            controller: 'addModel'
        });

    }).component('superuserApp', {
        // Note: The URL is relative to our `index.php` file
        templateUrl: 'app/panel-app/superuser/superuser.template.php',
        controller: ['$http', '$scope', '$httpParamSerializerJQLike', '$filter',
            function superuserAppController($http, $scope, $httpParamSerializerJQLike, $filter) {

                //Links de navegação
                $scope.navs = [{
                        link: "#",
                        title: "Dashboard"
                    },
                    {
                        link: "painel#!/model",
                        title: "Modelo"
                    }
                ];

            }
        ]
    });

//Filtro de multiseleção de usuários e áreas
//Iran 30-09-2017
$app.filter('areaFilter', function() {
    return function(items, name) {

        //Se var name for undefined ou vazio retorna todos os items
        if (name == undefined || name.area == '' || name.area == undefined) {
            return items;
        }

        //Lógica para filtragem de usuários
        var arrayToReturn = [];
        for (var i = 0; i < items.length; i++) {

            //Percorre arrays de elementos para verificar existencia da área
            items[i].area.forEach(function(element, index) {

                //Verifica se o item já foi adicionado a lista
                $elExist = name.area.find(function(find) {

                    //Se já houver um elemento no array a retornar
                    $exist = arrayToReturn.find(function(exist) {
                        return (exist.id == items[i].id) ? true : false;
                    }, this);

                    if ($exist) { //Se item já estiver no array, ir próximo item
                        return;
                    }

                    //Se elemento existe dentro do array de area
                    if (find == element) {
                        arrayToReturn.push(items[i]);
                    }

                }, this);

            });
        }
        return arrayToReturn;
    };
});