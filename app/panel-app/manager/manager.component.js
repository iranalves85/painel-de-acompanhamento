angular.
module('panelApp').
component('panelApp', {
    // Note: The URL is relative to our `index.html` file
    templateUrl: 'app/panel-app/manager/manager.template.html',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function panelAppController($http, $scope, $httpParamSerializerJQLike) {

            //Retorna os dados
            $http.get('plans').then(function(response) {
                //Atribuindo valores a var de escopo do controller
                $scope.plans = [{
                    id: response.data.id,
                    name: response.data.name,
                    description: response.data.description,
                    owner: $scope.manager.user,
                    deadline: response.data.deadline,
                    status: response.data.status
                }];
            });

            $scope.manager = {
                user: "teste",
                business: "Making Pie"
            };

            $scope.navs = [{
                link: "#teste",
                title: "Primeiro item"
            }, {
                link: "#teste2",
                title: "Segundo item"
            }];


        }
    ]
});