angular.
module('loginApp').
component('loginApp', {
    templateUrl: 'app/login-app/login-app.template.html',
    controller: ['$http', '$routeParams', function loginAppController($http, $routeParams) {
        var self = this;
    }]
});