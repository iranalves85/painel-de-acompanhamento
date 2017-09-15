angular.
module('panelApp', ['ngRoute']).
controller('dashboard', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
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
        generateCharts();

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
]).
config(function($routeProvider) {

    $routeProvider.when('/', {
        templateUrl: 'app/panel-app/human-resources/pages/dashboard.html',
        controller: 'dashboard'
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
                    link: "painel#!/projetos",
                    title: "Projetos"
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
                    link: "painel#!/boas_vindas",
                    title: "E-mails Boas-Vindas"
                },
                {
                    link: "painel#!/planos",
                    title: "Planos de Ação"
                },
                {
                    link: "painel#!/termo_de_funcionarios",
                    title: "Termo de Funcionários"
                },
                {
                    link: "painel#!/regras",
                    title: "Definir Regras"
                }
            ];

        }
    ]
});