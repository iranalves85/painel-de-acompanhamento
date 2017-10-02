$app = angular.
module('gafpApp', ['ngRoute', 'ui.bootstrap']);
$app.controller('dashboard', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
        function dashboardController($http, $scope, $httpParamSerializerJQLike, $uibModal) {

            $scope.leaderPlans = Array();
            $scope.leaderPlansTemplate = 'app/panel-app/human-resources/pages/leaderPlans.php';
            $scope.myPlansTemplate = 'app/panel-app/manager/pages/lists/plans.php';

            //Atribuindo valores a$scope de escopo do controller
            $getLeaderPlanList = function(response) {
                response.data.forEach(function(element, index) {

                    $scope.leaderPlans[index] = {
                        id: element.id,
                        project: element.project,
                        name: element.name,
                        description: element.description,
                        cost: element.cost,
                        goal: element.goal,
                        deadline: element.deadline,
                        status: {
                            id: element.statusID,
                            text: element.statusText
                        },
                        dateCreated: element.date_created
                    };

                }, this);
            }
            $data = getData($http, 'plan/leader/list/' + user.id, $getLeaderPlanList);

            //Aprovar um plano
            $scope.approvePlan = function(id) {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $approveResponse = function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                }
                $data = updateData($method, 'plan/status/', id, { status: 3 }, $approveResponse);
            };

            //Aprovar um plano
            $scope.openPlan = function(id) {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $openResponse = function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                }
                $data = updateData($method, 'plan/status/', id, { status: 1 }, $openResponse);
            };

            //Função deve esperar objetos DOM Carregar
            //generateCharts('status');
            //generateCharts('planos');
            //generateCharts('prazos');

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
    ]).controller('projects', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
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
    ]).controller('gestores', function gestoresController() {

    }).controller('cobranca', function cobrancaController() {

    }).controller('boasVindas', function boasVindasController() {

    }).controller('regras', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal', '$routeParams', function regrasController($http, $scope, $httpParamSerializerJQLike, $uibModal, $routeParams) {

        //Definições de datas e parametros
        $ProjectID = $routeParams.id;
        $scope.fields = { types: Array() };
        $scope.fields.types = [{
                id: 1,
                name: "Mês"
            },
            {
                id: 2,
                name: "Dias"
            },
            {
                id: 3,
                name: "Horas"
            }
        ];

        //Update regras
        $scope.defineRules = function() {
            console.log($scope.yellow);
        };

    }])
    .config(function($routeProvider) {

        $routeProvider.when('/', {
            templateUrl: 'app/panel-app/human-resources/pages/dashboard.php',
            controller: 'dashboard'
        });

        $routeProvider.when('/projects', {
            templateUrl: 'app/panel-app/human-resources/pages/projects.php',
            controller: 'projects'
        });

        $routeProvider.when('/projects/gestores/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/gestores.php',
            controller: 'gestores'
        });

        $routeProvider.when('/projects/cobranca/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/cobranca.php',
            controller: 'cobranca'
        });

        $routeProvider.when('/projects/boas-vindas/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/boas_vindas.php',
            controller: 'boasVindas'
        });

        $routeProvider.when('/projects/regras/:id', {
            templateUrl: 'app/panel-app/human-resources/pages/regras.php',
            controller: 'regras'
        });

    }).
component('humanResourcesApp', {
    // Note: The URL is relative to our `index.html` file
    templateUrl: 'app/panel-app/human-resources/human-resources.template.php',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function humanResourcesController($http, $scope, $httpParamSerializerJQLike) {

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