angular.
module('loginApp').
component('loginApp', {
    templateUrl: 'app/login-app/login-app.template.html',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function loginAppController($http, $scope, $httpParamSerializerJQLike) {

            $scope.submit = function() {
                $http({
                    url: 'login',
                    method: 'POST',
                    //Função formatar as variaveis de forma a funcionar na requisição
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: {
                        email: $scope.email.text,
                        password: $scope.password.text
                    }
                }).then(function(response) {
                    //Se resposta for true redireciona ao painel
                    if (response.data == 1) {
                        window.location.assign('painel');
                    }
                });
            }
        }
    ]
});