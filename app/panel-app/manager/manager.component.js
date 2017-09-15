angular.
module('panelApp', ['ngRoute'])
    .controller('dashboard', ['$http', '$scope', '$httpParamSerializerJQLike',
        function dashboardController($http, $scope, $httpParamSerializerJQLike) {
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
        }
    ])
    .config(function($routeProvider) {

        $routeProvider.when('/', {
            templateUrl: 'app/panel-app/manager/pages/dashboard.html',
            controller: 'dashboard'
        });

    })
    .component('panelApp', {
        // Note: The URL is relative to our `index.html` file
        templateUrl: 'app/panel-app/manager/manager.template.html',
        controller: ['$http', '$scope', '$httpParamSerializerJQLike',
            function panelAppController($http, $scope, $httpParamSerializerJQLike) {

                $scope.manager = {
                    user: user.name
                };

                $scope.navs = [{
                    link: "#",
                    title: "Dashboard"
                }];

            }
        ]
    });