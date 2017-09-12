angular.
module('panelApp').
component('panelApp', {
    // Note: The URL is relative to our `index.html` file
    templateUrl: 'app/panel-app/superuser/superuser.template.html',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function panelAppController($http, $scope, $httpParamSerializerJQLike) {

            //Nome do usuário
            $scope.manager = {
                user: user.name
            };

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


            //Links de navegação
            $scope.navs = [{
                    link: "#dashboard",
                    title: "Dashboard"
                },
                {
                    link: "#dashboard",
                    title: "Modelo"
                }
            ];

            $scope.addProject = function() {
                $http({
                    url: 'projects',
                    method: 'POST',
                    //Função formatar as$scopeiaveis de forma a funcionar na requisição
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
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
            };

        }
    ]
});