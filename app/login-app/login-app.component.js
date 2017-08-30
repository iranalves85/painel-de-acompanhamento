angular.
module('loginApp').
component('loginApp', {
    templateUrl: 'app/login-app/login-app.template.html',
    controller: ['$http', '$scope', function loginAppController($http, $scope) {
        var self = this;
        $scope.submit = function() {
            $http({
                url: 'login/',
                method: 'POST',
                data: 'email=iranjosealves@gmail.com,senha=Depeche0',
                headers: {
                    'Content-Type': 'application/javascript'
                }
            });
        }
    }]
});