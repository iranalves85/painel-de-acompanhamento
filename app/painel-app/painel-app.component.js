angular.
module('painelApp').
component('painelApp', {
    templateUrl: 'app/painel-app/painel-app.template.html',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function painelAppController($http, $scope, $httpParamSerializerJQLike) {

        }
    ]
});