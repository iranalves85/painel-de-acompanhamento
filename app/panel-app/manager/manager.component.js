$app = angular.
module('gafpApp', ['ngRoute', 'ui.bootstrap']);
$app.controller('myPlans', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal',
        function myPlansController($http, $scope, $httpParamSerializerJQLike, $uibModal) {

            $scope.addPlan = Array();
            $scope.plans = Array(); //Inicializa o array

            /*$scope.addPlan.open = function() {

                var modalInstance = $uibModal.open({
                    appendTo: angular.element('.modal-parent'),
                    animation: true,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'app/panel-app/manager/pages/add/plan.php',
                    controller: 'addPlan',
                    size: 'lg'
                });

            };*/

            //Retorna lista de planos baseado no id do user
            $http({
                url: 'plan/list',
                method: "POST",
                transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                data: {
                    id: user.id
                }
            }).then(function(response) {

                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length > 0) {
                    //Atribuindo valores a$scope de escopo do controller
                    response.data.forEach(function(element, index) {

                        $scope.plans[index] = {
                            id: element.id,
                            name: element.name,
                            description: element.description,
                            company: element.company,
                            goal: element.goal,
                            deadline: element.deadline,
                            status: (element.status === 1) ? "warning" : "danger",
                            dateCreated: element.date_created
                        };

                    }, this);
                }
            });

            $scope.delete = function(id) {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/delete',
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: { id: id }
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                    }
                });
            };

            $scope.reorderPlanList = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/list',
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        id: user.id,
                        order: { order: $scope.order.data.value, by: $scope.order.direction.value }
                    }
                }).then(function(response) {

                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.length > 0) {
                        //Atribuindo valores a$scope de escopo do controller
                        response.data.forEach(function(element, index) {

                            $scope.plans[index] = {
                                id: element.id,
                                name: element.name,
                                description: element.description,
                                company: element.company,
                                goal: element.goal,
                                deadline: element.deadline,
                                status: (element.status === 1) ? "warning" : "danger",
                                dateCreated: element.date_created
                            };

                        }, this);
                    }
                });
            };

        }
    ])
    .controller('leaderPlans', ['$http', '$scope', '$httpParamSerializerJQLike',
        function leaderPlansController($http, $scope, $httpParamSerializerJQLike) {

        }
    ])
    .controller('addPlan', ['$http', '$scope', '$httpParamSerializerJQLike',
        function addPlanController($http, $scope, $httpParamSerializerJQLike) {

            $scope.plan = Array(); //Inicializa o array
            $scope.addPlan = Array();
            $scope.required = true;
            $scope.alerts = Array();

            //Insere um novo plano no banco
            $scope.addPlan.submit = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan',
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        name: $scope.addPlan.name,
                        description: $scope.addPlan.description,
                        owner: $scope.addPlan.owner,
                        cost: $scope.addPlan.cost,
                        goal: $scope.addPlan.goal,
                        deadline: $scope.addPlan.deadline
                    }
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    $scope.alerts.push(response.data);
                });
            };

            //Retorna lista de planos baseado no id do user
            $http({
                url: 'plan/fields/users',
                method: "POST",
                transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                data: { company: user.company }
            }).then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length > 0) {
                    //Retorna lista de users
                    $scope.plan.users = response.data;
                }
            });
        }
    ])
    .controller('planActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal', '$routeParams',
        function planActivityController($http, $scope, $httpParamSerializerJQLike, $uibModal, $routeParams) {

            $scope.addActivity = Array();
            $scope.activitys = Array(); //Inicializa o array
            var id = $routeParams.id; //Retorna parametros da url

            //Retorna lista de planos baseado no id do user
            $http({
                url: 'plan/activity/list/' + id,
                method: "GET"
            }).then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length > 0) {
                    //Atribuindo valores a$scope de escopo do controller
                    response.data.forEach(function(element, index) {

                        $scope.activitys[index] = {
                            id: element.id,
                            name: element.name,
                            description: element.description,
                            dateCreated: element.date_created
                        };

                    }, this);
                }
            });

            $scope.delete = function(id) {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/delete',
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: { id: id }
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                    }
                });
            };

            $scope.reorderActivityList = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/list',
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        id: user.id,
                        order: { order: $scope.order.data.value, by: $scope.order.direction.value }
                    }
                }).then(function(response) {

                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.length > 0) {
                        //Atribuindo valores a$scope de escopo do controller
                        response.data.forEach(function(element, index) {

                            $scope.plans[index] = {
                                id: element.id,
                                name: element.name,
                                description: element.description,
                                company: element.company,
                                goal: element.goal,
                                deadline: element.deadline,
                                status: (element.status === 1) ? "warning" : "danger",
                                dateCreated: element.date_created
                            };

                        }, this);
                    }
                });
            };

        }
    ])
    .controller('updateActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function updateActivityController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            $scope.updateActivity = Array();
            $scope.updateActivity.current = Array(); //Inicializa o array
            $scope.required = true;
            $scope.alerts = Array();

            id = $routeParams.id; //pega id URL

            //Retorna dados da atividade
            $http({
                url: 'plan/activity/' + id,
                method: "GET"
            }).then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined) {
                    $scope.updateActivity.current = response.data;
                }
            });

            //Retorna dados da atividade
            $http({
                url: 'plan/activity/evidence/' + id,
                method: "GET"
            }).then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length > 0) {

                    response.data.forEach(function(element, index) {
                        $scope.updateActivity.current.evidence[index] = element;
                    });

                    console.log($scope.updateActivity.current.evidence);
                }
            });

            //Insere um novo plano no banco
            /*$scope.updateActivity.submit = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/activity',
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        name: $scope.addActivity.name,
                        description: $scope.addActivity.description,
                        owner: $scope.addActivity.owner,
                        cost: $scope.addActivity.cost,
                        goal: $scope.addActivity.goal,
                        deadline: $scope.addActivity.deadline
                    }
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    $scope.alerts.push(response.data);
                });
            };*/

        }
    ])
    .controller('addActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function addActivityController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            $scope.activity = Array(); //Inicializa o array
            $scope.addActivity = Array();
            $scope.required = true;
            $scope.alerts = Array();

            //Insere um novo plano no banco
            $scope.addActivity.submit = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/activity',
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        name: $scope.addActivity.name,
                        description: $scope.addActivity.description,
                        owner: $scope.addActivity.owner,
                        cost: $scope.addActivity.cost,
                        goal: $scope.addActivity.goal,
                        deadline: $scope.addActivity.deadline
                    }
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    $scope.alerts.push(response.data);
                });
            };

        }
    ])
    .config(function($routeProvider) {
        //Planos
        //retorna lista
        $routeProvider.when('/', {
            templateUrl: 'app/panel-app/manager/pages/lists/plans.php',
            controller: 'myPlans'
        });
        //adiciona plano
        $routeProvider.when('/plan/add', {
            templateUrl: 'app/panel-app/manager/pages/add/plan.php',
            controller: 'addPlan'
        });

        //Atividades
        //retorna lista
        $routeProvider.when('/plan/activity/:id', {
            templateUrl: 'app/panel-app/manager/pages/lists/activity.php',
            controller: 'planActivity'
        });
        //retorna unico baseado em id
        $routeProvider.when('/plan/activity/edit/:id', {
            templateUrl: 'app/panel-app/manager/pages/add/updateActivity.php',
            controller: 'updateActivity'
        });
        //vai para tela de adição
        $routeProvider.when('/plan/activity/add', {
            templateUrl: 'app/panel-app/manager/pages/add/activity.php',
            controller: 'addActivity'
        });

    })
    .component('managerApp', {
        // Note: The URL is relative to our `index.html` file
        templateUrl: 'app/panel-app/manager/manager.template.php',
        controller: ['$http', '$scope', '$httpParamSerializerJQLike',
            function managerAppController($http, $scope, $httpParamSerializerJQLike) {

                $scope.navs = [{
                    addPlan: {
                        link: "painel#!/plan/add",
                        title: "Adicionar Plano"
                    }
                }];

            }
        ]
    });