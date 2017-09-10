angular.
module('panelApp').
component('panelApp', {
    // Note: The URL is relative to our `index.html` file
    templateUrl: 'app/panel-app/superuser/superuser.template.html',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function panelAppController($http, $scope, $httpParamSerializerJQLike) {

            //Retorna os dados
            $http.get('projects').then(function(response) {
                //Atribuindo valores a var de escopo do controller
                $scope.projects = [{
                    id: response.data.id,
                    company: response.data.company,
                    model: response.data.model,
                    spreadsheet: response.data.spreadsheet,
                    responsible: response.data.responsible,
                    approver: response.data.approver
                }];
            });

            $scope.manager = {
                user: user.name
            };

            $scope.navs = [{
                    link: "#dashboard",
                    title: "Dashboard"
                }, {
                    link: "#dashboard",
                    title: "Responsável"
                },
                {
                    link: "#dashboard",
                    title: "Modelo"
                }, {
                    link: "#dashboard",
                    title: "Planilha"
                }, {
                    link: "#dashboard",
                    title: "Aprovador"
                }
            ];

        }
    ]
});