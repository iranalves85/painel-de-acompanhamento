$app.controller('projects', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
        function projectsController($http, $scope, $httpParamSerializerJQLike, $uibModal) {

            $scope.projects = Array();

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
            };

            $data = getData($http, 'projects/', $getProjectList);

            //Função para reordernar lista de projetos
            $scope.reorderProjectList = function() {
                //Verifica os valores dos campos estao setados
                $order = ($scope.order.order != undefined) ? '/' + $scope.order.order.value : "";
                $by = ($scope.order.by != undefined) ? '/' + $scope.order.by.value : "";

                getData($http,
                    'projects/lists' + $order + $by,
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

        }
    ]).controller('manager', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function managerController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            //Definições de datas e parametros
            $scope.id = $routeParams.id;
            $scope.user = user.id;
            $scope.users = Array();
            $scope.manager = Array();

            //Retorna lista de usuários do projeto
            $users = getData($http, 'projects/users/manager/' + $scope.id, function(response) {
                if (response.data.length > 0) {
                    $scope.users = response.data;
                }
            });

            $scope.newUser = function() {

                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Submete o formulário para definir regras do projeto
                $data = postData($method, 'projects/users/manager/', $scope.id, {
                    username: $scope.manager.name,
                    email: $scope.manager.email,
                    password: $scope.manager.password,
                    area: $scope.manager.area
                }, function(response) {
                    console.log(response);
                    //Se não estiver definido, retorna fn
                    if (response.xhrStatus != 'complete') {
                        return;
                    }
                    //Mensagens de retorno
                    if (response.data > 0) {
                        alert("Gestor cadastrado com sucesso. ID: " + response.data);
                        location.reload();
                    } else {
                        alert("Gestor não cadastrado. Tente novamente.");
                    }

                });

            };


        }
    ]).controller('editManager', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams', function editManagerController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

        //Definições de datas e parametros
        $scope.id = $routeParams.id;
        $scope.user = user.id;
        $scope.users = Array();
        $scope.manager = Array();

        //Retorna lista de usuários do projeto
        $users = getData($http, 'projects/user/' + $scope.id, function(response) {
            if (response.data != undefined) {
                $scope.manager = response.data;
            }
        });

        $scope.editUser = function() {

            $method = { //definições de objetos
                http: $http,
                serializer: $httpParamSerializerJQLike,
            };

            $scope.manager.leader = user.email; //Adiciona o email do leader

            //Submete o formulário para definir regras do projeto
            $data = updateData($method, 'projects/user/',
                $scope.id, {
                    username: $scope.manager.username,
                    email: $scope.manager.email,
                    password: $scope.manager.password,
                    area: $scope.manager.area.toString()
                },
                function(response) {
                    //Se não estiver definido, retorna fn
                    if (response.xhrStatus != 'complete') {
                        return;
                    }
                    //Mensagens de retorno
                    if (response.data > 0) {
                        alert("Gestor atualizado com sucesso.");
                        location.reload();
                    } else {
                        alert("Gestor não atualizado. Tente novamente.");
                    }

                });

        };


    }]).controller('email', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function emailController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            //Definições de datas e parametros
            $scope.id = $routeParams.id;
            $scope.users = Array();
            $scope.email = Array();
            $scope.areas = Array();

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

            //Retorna lista de usuários do projeto
            $mensagem = function(id) {
                $type = angular.element('textarea[name="mensagem"]').attr('id');
                getData($http, 'projects/sendmail/' + $type + '/' + id, function(response) {
                    if (response.data != undefined) {
                        $scope.email.msg = response.data.message;
                    }
                });
            };

            //Retorna lista de usuários do projeto
            $users = getData($http, 'projects/users/' + $scope.id, function(response) {
                if (response.data.length > 0) {
                    $scope.users = response.data;
                    $areas($scope.users);
                    $mensagem($scope.id);
                }
            });

            $scope.sendEmail = function(type) {

                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Submete o formulário para definir regras do projeto
                $data = postData($method, 'projects/sendmail/', undefined, {
                    project: $scope.id,
                    type: type,
                    users: $scope.email.users,
                    areas: $scope.email.areas,
                    msg: $scope.email.msg
                }, function(response) {
                    console.log(response);
                    //Se não estiver definido, retorna fn
                    if (response.xhrStatus != 'complete') {
                        return;
                    }
                    //Mensagens de retorno
                    if (response.data.type == "success") {
                        alert(response.data.msg);
                        location.reload();
                    } else {
                        alert(response.data.msg);
                    }

                });

            };


        }
    ]).controller('rules', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function rulesController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            //Definições de datas e parametros
            $scope.id = $routeParams.id;
            $scope.rules = [{
                    id: 1,
                    name: "Mês",
                    identificador: 'm',
                },
                {
                    id: 2,
                    name: "Dias",
                    identificador: 'd'
                },
                {
                    id: 3,
                    name: "Horas",
                    identificador: 'h'
                }
            ];

            //Atribuindo valores a$scope de escopo do controller
            $data = getData($http, 'projects/rules/' + $scope.id, function(response) {

                if (response.data != undefined || response.data != '') {

                    $scope.warning = {
                        qtd: Number(response.data.rules.warning.qtd),
                        types: response.data.rules.warning.types,
                        conditional: response.data.rules.warning.conditional
                    };

                    $scope.danger = {
                        qtd: Number(response.data.rules.danger.qtd),
                        types: response.data.rules.danger.types,
                        conditional: response.data.rules.danger.conditional
                    };
                }

            });

            //Submeter: Update regras
            $scope.defineRules = function() {

                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Definindo função de retorno
                $addRuleReturn = function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data.type == 'success') {
                        //Atribuindo resultado a objeto projectData
                        alert(response.data.msg);
                        location.reload();
                    } else {
                        alert(response.data.msg);
                    }
                };

                //Submete o formulário para definir regras do projeto
                $data = updateData($method, 'projects/rules/', $scope.id, {
                    warning: $scope.warning,
                    danger: $scope.danger,
                }, $addRuleReturn);

            };

        }
    ])
    .config(function($routeProvider) {

        $routeProvider.when('/projects', {
            templateUrl: 'app/panel-app/human-resources/pages/projects.php',
            controller: 'projects'
        });

        $routeProvider.when('/projects/manager/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/manager.php',
            controller: 'manager'
        });

        $routeProvider.when('/projects/manager/edit/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/edit/manager.php',
            controller: 'editManager'
        });

        $routeProvider.when('/projects/charge/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/charge.php',
            controller: 'email'
        });

        $routeProvider.when('/projects/welcome/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/welcome.php',
            controller: 'email'
        });

        $routeProvider.when('/projects/rules/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/rules.php',
            controller: 'rules'
        });

    })
    .component('humanResourcesApp', {
        // Note: The URL is relative to our `index.html` file
        templateUrl: 'app/panel-app/human-resources/human-resources.template.php',
        controller: ['$http', '$scope', '$httpParamSerializerJQLike',
            function humanResourcesController($http, $scope, $httpParamSerializerJQLike) {

                $scope.required = true;

                //Links de navegação
                $scope.navs = [{
                    link: "#",
                    title: "Dashboard"
                }, {
                    link: "painel#!/projects",
                    title: "Projetos"
                }];

            }
        ]
    });