angular.
module('panelApp', ['ngRoute']).
controller('project', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
        function projectController($http, $scope, $httpParamSerializerJQLike, $uibModal) {

            //Retorna os dados
            $http.get('projects/list').then(function(response) {

                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0)
                    return;

                $scope.projects = Array(); //Inicializa o array

                //Atribuindo valores a$scope de escopo do controller
                response.data.forEach(function(element, index) {

                    $scope.projects[index] = {
                        id: element.id,
                        company: element.company,
                        model: element.model,
                        spreadsheet: element.spreadsheet,
                        responsible: element.responsible,
                        approver: element.approver
                    };

                }, this);

            });

            //Retorna os dados
            $http.get('projects/fields').then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0)
                    return;

                $scope.fields = {
                    models: Array(),
                    approvers: Array(),
                    responsibles: Array(),
                }; //Inicializa o array                

                //Atribuindo valores a$scope de escopo do controller
                response.data.forEach(function(element, index) {

                    $scope.fields.models[index] = {
                        id: element.modelID,
                        name: element.model
                    };

                    $scope.fields.approvers[index] = {
                        id: element.approverID,
                        name: element.approver
                    };

                    $scope.fields.responsibles[index] = {
                        id: element.userID,
                        name: element.name
                    };

                }, this);

            });

            //Retorna os dados de empresas para alimentar 'select' autocomplete
            $http.get('projects/companys').then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0) {
                    return false;
                }

                $scope.companys = response.data;

            });


            /*$scope.addProject = function() {
                $http({
                    url: 'projects',
                    method: 'POST',
                    //Função formatar as$scopeiaveis de forma a funcionar na requisição
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    data: {
                        company: $scope.company,
                        responsible: $scope.responsible.id,
                        model: $scope.model.id,
                        approver: $scope.approver.id,
                        spreadsheet: $scope.spreadsheet
                    }
                }).then(function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data > 0) {
                        $scope.projects.unshift(response.data);
                    }
                });
            };*/
        }
    ])
    .controller('modelo', ['$http', '$scope', '$httpParamSerializerJQLike',
        function modeloController($http, $scope, $httpParamSerializerJQLike) {

            //Adicionar item in REALTIME
            $scope.modelItems = [];
            $scope.addItem = function() {
                $scope.modelItems.push({
                    name: $scope.item.name,
                    description: $scope.item.description
                });
                delete $scope.item.name;
                delete $scope.item.description;
            };

            //Retorna os dados
            $http.get('model/list').then(function(response) {

                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0)
                    return;

                $scope.models = Array(); //Inicializa o array

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

            $scope.addModel = function() {
                $http({
                    url: 'model',
                    method: 'POST',
                    //Função formatar as$scopeiaveis de forma a funcionar na requisição
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: {
                        name: $scope.name,
                        description: $scope.description,
                        topics: $scope.modelItems
                    }
                }).then(function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data > 0) {
                        alert("Novo modelo criado");
                        $scope.models.unshift(response.data);
                    }
                });
            };
        }
    ]).
config(function($routeProvider) {

    $routeProvider.when('/', {
        templateUrl: 'app/panel-app/superuser/pages/project.html',
        controller: 'project'
    });

    $routeProvider.when('/modelo', {
        templateUrl: 'app/panel-app/superuser/pages/model.html',
        controller: 'modelo'
    });
}).
component('panelApp', {
    // Note: The URL is relative to our `index.html` file
    templateUrl: 'app/panel-app/superuser/superuser.template.html',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function panelAppController($http, $scope, $httpParamSerializerJQLike) {
            //Nome do usuário
            $scope.manager = {
                user: user.name
            };

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