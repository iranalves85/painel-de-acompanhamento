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
                url: 'plan/list/',
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
                    url: 'plan/delete/',
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
                    url: 'plan/list/',
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
                    url: 'plan/',
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
    .controller('updatePlan', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function updatePlanController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            $scope.plan = Array(); //Inicializa o array
            $scope.updatePlan = Array();
            $scope.required = true;
            $scope.alerts = Array();
            var id = $routeParams.id; //Retorna parametros da url

            //Insere um novo plano no banco
            $scope.submit = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/' + id,
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        name: $scope.updatePlan.name,
                        description: $scope.updatePlan.description,
                        owner: $scope.updatePlan.owner,
                        cost: $scope.updatePlan.cost,
                        goal: $scope.updatePlan.goal,
                        deadline: $scope.updatePlan.deadline
                    }
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    $scope.alerts.push(response.data);
                });
            };

            //Retorna lista de planos baseado no id do user
            $http({
                url: 'plan/' + id,
                method: "GET"
            }).then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined) {
                    //Retorna lista de users
                    $scope.updatePlan = response.data;
                    $scope.updatePlan.deadline = new Date(response.data.deadline);
                    console.log($scope.updatePlan);
                }
            });

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
                    url: 'plan/activity/delete/' + id,
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
                    url: 'plan/list/',
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
    .controller('addActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function addActivityController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            $scope.addActivity = {};
            $scope.required = true;
            $scope.alerts = Array();

            id = $routeParams.id; //pega id URL

            //Adicionar item in REALTIME
            $scope.addItem = function() {
                $scope.addActivity.evidence.push({
                    topic: $scope.addActivity.addModel.item.topics,
                    action: $scope.addActivity.addModel.item.action
                });
                delete $scope.addActivity.addModel.item;
            };

            //Retorna dados da atividade
            $get = $http({
                url: 'plan/activity/' + id,
                method: "GET"
            }).then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined) {

                    //Adiciona dados de atividade e modelo
                    $scope.addActivity = response.data[0].activity;
                    $scope.addActivity.moment = new Date(response.data[0].activity.moment);
                    $scope.addActivity.model = response.data[0].model;
                    $scope.addActivity.evidence = Array();

                    response.data.forEach(function(element, index) {
                        $scope.addActivity.evidence[index] = element.evidence;
                    });
                }
            });


            //Insere um novo plano no banco
            $scope.submit = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/activity' + id,
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        name: $scope.addActivity.name,
                        description: $scope.addActivity.description,
                        evidence: $scope.addActivity.evidence,
                        what: $scope.addActivity.what,
                        because: $scope.addActivity.because,
                        place: $scope.addActivity.place,
                        moment: $scope.addActivity.moment,
                        who: $scope.addActivity.who,
                        cost: $scope.addActivity.cost
                    }
                }).then(function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    $scope.alerts.push(response.data);
                });
            };

        }
    ])
    .controller('addActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function addActivityController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            $scope.addActivity = {};
            $scope.required = true;
            $scope.alerts = Array();
            $scope.addActivity.evidence = Array();
            $scope.addActivity.model = Array();

            id = $routeParams.id; //pega id URL

            //Adicionar item in REALTIME
            $scope.addItem = function() {
                $scope.addActivity.evidence.push({
                    topic: $scope.addActivity.addModel.item.topics,
                    action: $scope.addActivity.addModel.item.action
                });
                delete $scope.addActivity.addModel.item;
            };

            //Retorna dados da atividade
            $get = $http({
                url: 'model/list',
                method: "GET"
            }).then(function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined) {
                    //Adiciona dados de atividade e modelo
                    response.data.forEach(function(element, index) {
                        $scope.addActivity.model[index] = element.topics;
                        console.log(element.topics);
                    });
                }
            });




            //Insere um novo plano no banco
            $scope.submit = function() {
                //Retorna lista de planos baseado no id do user
                $http({
                    url: 'plan/activity' + id,
                    method: "POST",
                    transformRequest: function(data) { return $httpParamSerializerJQLike(data); },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: {
                        name: $scope.addActivity.name,
                        description: $scope.addActivity.description,
                        evidence: $scope.addActivity.evidence,
                        what: $scope.addActivity.what,
                        because: $scope.addActivity.because,
                        place: $scope.addActivity.place,
                        moment: $scope.addActivity.moment,
                        who: $scope.addActivity.who,
                        cost: $scope.addActivity.cost
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
        $routeProvider.when('/plan/new/', {
            templateUrl: 'app/panel-app/manager/pages/add/plan.php',
            controller: 'addPlan'
        });

        //adiciona plano
        $routeProvider.when('/plan/edit/:id', {
            templateUrl: 'app/panel-app/manager/pages/add/updatePlan.php',
            controller: 'updatePlan'
        });

        //Atividades
        //retorna lista
        $routeProvider.when('/plan/activity/:id', {
            templateUrl: 'app/panel-app/manager/pages/lists/activity.php',
            controller: 'planActivity'
        });
        //retorna unico baseado em id
        $routeProvider.when('/plan/activity/edit/:id', {
            templateUrl: 'app/panel-app/manager/pages/add/addActivity.php',
            controller: 'addActivity'
        });
        //vai para tela de adição
        $routeProvider.when('/activity/new/', {
            templateUrl: 'app/panel-app/manager/pages/add/activity.php',
            controller: 'addActivity'
        });

    })
    .component('managerApp', {
        // Note: The URL is relative to our `index.html` file
        templateUrl: 'app/panel-app/manager/manager.template.php',
        controller: ['$http', '$scope', '$httpParamSerializerJQLike',
            function managerAppController($http, $scope, $httpParamSerializerJQLike) {

            }
        ]
    });