$app = angular.
module('gafpApp', ['ngRoute', 'ui.bootstrap']);
$app.controller('dashboard', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
        function dashboardController($http, $scope, $httpParamSerializerJQLike, $uibModal) {

            //Retorna os dados
            $http.get('plan/list').then(function(response) {

                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length <= 0)
                    return;

                $scope.plans = Array(); //Inicializa o array

                //Atribuindo valores a$scope de escopo do controller
                response.data.forEach(function(element, index) {

                    $scope.plans[index] = {
                        id: element.id,
                        name: element.name,
                        description: element.description,
                        company: element.company,
                        gestor: element.owner,
                        deadline: element.deadline,
                        status: (element.status === 1) ? "warning" : "danger",
                        evidence: element.evidence,
                        dateCreated: element.date_created
                    };

                }, this);

            });

            //Função deve esperar objetos DOM Carregar
            generateCharts('status');
            generateCharts('planos');
            generateCharts('prazos');

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
    ]).controller('projetos', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
        function projetosController($http, $scope, $httpParamSerializerJQLike, $uibModal) {

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
                        model: element.model,
                        responsible: element.responsible,
                        approver: element.approver
                    };

                }, this);

            });

        }
    ]).controller('gestores', function gestoresController() {

    }).controller('cobranca', function cobrancaController() {

    }).controller('boasVindas', function boasVindasController() {

    }).controller('termoFuncionarios', function termoFuncionariosController() {

    }).controller('regras', ['$scope', function regrasController($scope) {
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
    }])
    .config(function($routeProvider) {

        $routeProvider.when('/', {
            templateUrl: 'app/panel-app/human-resources/pages/dashboard.html',
            controller: 'dashboard'
        });

        $routeProvider.when('/projetos', {
            templateUrl: 'app/panel-app/human-resources/pages/projetos.html',
            controller: 'projetos'
        });

        $routeProvider.when('/gestores', {
            templateUrl: 'app/panel-app/human-resources/pages/gestores.html',
            controller: 'gestores'
        });

        $routeProvider.when('/cobranca', {
            templateUrl: 'app/panel-app/human-resources/pages/cobranca.html',
            controller: 'cobranca'
        });

        $routeProvider.when('/boas-vindas', {
            templateUrl: 'app/panel-app/human-resources/pages/boas_vindas.html',
            controller: 'boasVindas'
        });

        $routeProvider.when('/regras', {
            templateUrl: 'app/panel-app/human-resources/pages/regras.html',
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
                },
                {
                    link: "painel#!/projetos",
                    title: "Histórico de Projetos"
                },
                {
                    link: "painel#!/gestores",
                    title: "Cadastro de Gestor"
                }, ,
                {
                    link: "painel#!/cobranca",
                    title: "E-mails de Cobrança"
                },
                {
                    link: "painel#!/boas-vindas",
                    title: "E-mails Boas-Vindas"
                },
                {
                    link: "painel#!/regras",
                    title: "Definir Regras"
                }
            ];

        }
    ]
});