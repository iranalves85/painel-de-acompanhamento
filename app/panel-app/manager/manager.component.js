$app.controller('humanResources', ['$http', '$scope', '$httpParamSerializerJQLike', '$location', '$route',
        function humanResourcesController($http, $scope, $httpParamSerializerJQLike, $location, $route) {
            //Setando default 'false'
            $scope.isResponsible = false;
            //Requisição para atribuir visão de RH ao usuário
            $responsible = getData($http,
                'projects/users/responsible/' + user.project + '/' + user.id,
                function(response) {
                    if (response.data != undefined || response.data != '') {
                        $scope.isResponsible = true;
                    }
                });

        }
    ]).controller('approverPlans', ['$http', '$scope', '$httpParamSerializerJQLike', '$location', '$route',
        function approverPlansController($http, $scope, $httpParamSerializerJQLike, $location, $route) {

            $scope.leaderPlans = Array();
            $scope.approverPlansTemplate = 'app/panel-app/manager/pages/lists/approverPlans.php';
            $scope.isApprover = false;

            $approver = getData($http, 'projects/' + user.project, function(response) {
                if (response.data <= 0) {
                    return;
                }
                //Se aprovador do projeto igual ID do usuário
                if (response.data.approver == user.id) {
                    $scope.isApprover = true;
                }
            });

            //Atribuindo valores a$scope de escopo do controller
            $data = getData($http, 'plan/leader/list/' + user.id, function(response) {
                response.data.forEach(function(element, index) {

                    $scope.leaderPlans[index] = element;

                }, this);
            });

            //Função para reordernar lista de projetos
            var order = [{ value: 'date_created', text: 'Recentes' },
                { value: 'deadline', text: 'Prazo de Entrega' },
                { value: 'statusText', text: 'Status' }
            ];
            $scope.order = order;
            $scope.orderDefine = 'date_created';
            $scope.reverse = true;
            $scope.reorderList = function() {
                $scope.reverse = ($scope.orderDefine === $scope.order.value) ? !$scope.reverse : false;
                $scope.orderDefine = $scope.order.value;
            };

            //Aprovar um plano
            $scope.approvePlan = function(id) {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $data = updateData($method, 'plan/status/', id, { status: 3 }, function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

            //Aprovar um plano
            $scope.openPlan = function(id) {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $data = updateData($method, 'plan/status/', id, { status: 1 }, function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

        }
    ]).controller('myPlans', ['$http', '$scope', '$httpParamSerializerJQLike',
        function myPlansController($http, $scope, $httpParamSerializerJQLike) {

            $scope.addPlan = Array(); //Adiciona plan
            $scope.plans = Array(); //Inicializa o array

            //Atribuindo valores a$scope de escopo do controller
            $data = getData($http, 'plan/list/' + user.id, function(response) {
                response.data.forEach(function(element, index) {
                    $scope.plans[index] = element;
                }, this);
            });

            $scope.delete = function(id) {
                //Retorna lista de planos baseado no id do user
                $method = { //definições de objetos
                    http: $http
                };
                //Requisição
                deleteData($http, 'plan/delete/' + id, function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

            //Função para reordernar lista de projetos
            var order = [{ value: 'date_created', text: 'Recentes' },
                { value: 'deadline', text: 'Prazo de Entrega' },
                { value: 'statusText', text: 'Status' }
            ];
            $scope.order = order;
            $scope.orderDefine = 'date_created';
            $scope.reverse = true;
            $scope.reorderList = function() {
                $scope.reverse = ($scope.orderDefine === $scope.order.value) ? !$scope.reverse : false;
                $scope.orderDefine = $scope.order.value;
            };

        }
    ])
    .controller('leaderPlans', ['$http', '$scope', '$httpParamSerializerJQLike',
        function leaderPlansController($http, $scope, $httpParamSerializerJQLike) {

            $scope.plans = Array(); //Inicializa o array
            $scope.isLeader = false;

            //Atribuindo valores $scope de status: element.status,escopo do controller
            $data = getData($http, 'plan/leader/list/' + user.id, function(response) {
                if (response.data <= 0) {
                    return;
                }
                //Atribuindo planos
                response.data.forEach(function(element, index) {
                    $scope.plans[index] = element;
                }, this);

                $scope.isLeader = true; //Habilitar tela de leader

            });

            //Função para reordernar lista de projetos
            var order = [{ value: 'date_created', text: 'Recentes' },
                { value: 'deadline', text: 'Prazo de Entrega' },
                { value: 'statusText', text: 'Status' },
                { value: 'gestor', text: 'Gestor' }
            ];
            $scope.order = order;
            $scope.orderDefine = 'date_created';
            $scope.reverse = true;
            $scope.reorderList = function() {
                $scope.reverse = ($scope.orderDefine === $scope.order.value) ? !$scope.reverse : false;
                $scope.orderDefine = $scope.order.value;
            };

            //Aprovar um plano
            $scope.approvePlan = function(id) {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $data = updateData($method, 'plan/status/', id, { status: 3 }, function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

            //Aprovar um plano
            $scope.openPlan = function(id) {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $data = updateData($method, 'plan/status/', id, { status: 1 }, function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

            $scope.delete = function(id) {
                //Retorna lista de planos baseado no id do user
                $method = { //definições de objetos
                    http: $http
                };
                //Requisição
                deleteData($method, 'plan/delete/', id, undefined, function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

        }
    ])
    .controller('addPlan', ['$http', '$scope', '$httpParamSerializerJQLike',
        function addPlanController($http, $scope, $httpParamSerializerJQLike) {

            $scope.plan = Array(); //Inicializa o array
            $scope.alerts = Array();
            $scope.required = true;

            //Insere um novo plano no banco
            $scope.submit = function() {
                //Retorna lista de planos baseado no id do user
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Submete o formulário para definir regras do projeto
                $data = postData($method, 'plan', undefined, {
                    project: user.project,
                    name: $scope.addPlan.name,
                    description: $scope.addPlan.description,
                    owner: $scope.addPlan.owner,
                    cost: $scope.addPlan.cost,
                    goal: $scope.addPlan.goal,
                    deadline: $scope.addPlan.deadline
                }, function(response) {

                    //Se não estiver definido, retorna fn
                    if (response.xhrStatus != 'complete') {
                        return;
                    }

                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                        location.reload();
                    }

                });
            };

            //Retorna lista de planos baseado no id do user
            $users = getData($http, 'projects/users/' + user.project, function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length > 0) {
                    //Retorna lista de users
                    $scope.plan.users = response.data;
                }
            });

        }
    ])
    .controller('updatePlan', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams', '$filter',
        function updatePlanController($http, $scope, $httpParamSerializerJQLike, $routeParams, $filter) {

            $scope.plan = Array(); //Inicializa o array
            $scope.updatePlan = Array();
            $scope.required = true;
            $scope.alerts = Array();
            var id = $routeParams.id; //Retorna parametros da url

            //Insere um novo plano no banco
            $scope.submit = function() {

                //Retorna lista de planos baseado no id do user
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                //Submete o formulário para definir regras do projeto
                $data = updateData($method, 'plan/', id, {
                    name: $scope.updatePlan.name,
                    description: $scope.updatePlan.description,
                    owner: $scope.updatePlan.owner,
                    cost: $scope.updatePlan.cost,
                    goal: $scope.updatePlan.goal,
                    deadline: $scope.updatePlan.deadline
                }, function(response) {
                    //Se não estiver definido, retorna fn
                    if (response.xhrStatus != 'complete') {
                        return;
                    }

                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });

            };

            //Retorna lista de planos baseado no id do user
            $getPlan = getData($http, 'plan/' + id, function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined) {
                    //Retorna lista de users
                    $scope.updatePlan = response.data;
                    $scope.updatePlan.deadline = new Date(response.data.deadline);
                }
            });

            //Retorna lista de planos baseado no id do user
            $users = getData($http, 'projects/users/' + user.project, function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length > 0) {
                    //Retorna lista de users
                    $scope.plan.users = response.data;
                }
            });
        }
    ])
    .controller('planListActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$uibModal', '$routeParams',
        function planListActivityController($http, $scope, $httpParamSerializerJQLike, $uibModal, $routeParams) {

            $scope.addActivity = Array();
            $scope.activitys = Array(); //Inicializa o array
            $scope.id = $routeParams.id; //Retorna parametros da url

            $activity = getData($http, 'plan/activity/list/' + $scope.id, function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined && response.data.length > 0) {
                    //Atribuindo valores a$scope de escopo do controller
                    response.data.forEach(function(element, index) {
                        $scope.activitys[index] = element;
                    }, this);
                }
            });

            //Função para reordernar lista de projetos
            var order = [{ value: 'date_created', text: 'Recentes' },
                { value: 'moment', text: 'Prazo de Entrega' },
                { value: 'statusText', text: 'Status' }
            ];
            $scope.order = order;
            $scope.orderDefine = 'username';
            $scope.reverse = true;
            $scope.reorderList = function() {
                $scope.reverse = ($scope.orderDefine === $scope.order.value) ? !$scope.reverse : false;
                $scope.orderDefine = $scope.order.value;
            };

            //Deletar uma atividade
            $scope.delete = function(id) {

                deleteData($http, 'plan/activity/delete/' + id, function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data.type != 'undefined') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });

            };

        }
    ])
    .controller('updateActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function updateActivityController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            //Vars
            $scope.updateActivity = {};
            $scope.required = true;
            $scope.alerts = Array();

            $id = $routeParams.id; //pega id URL

            //Adicionar item in REALTIME
            $scope.addItem = function() {
                $scope.updateActivity.evidence.push({
                    topic: $scope.updateActivity.addModel.item.topics,
                    action: $scope.updateActivity.addModel.item.action
                });
                delete $scope.updateActivity.addModel.item;
            };

            //Retorna dados da atividade
            $activity = getData($http, 'plan/activity/' + $id, function(response) {

                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined && response.data.length > 0) {

                    //Adiciona dados de atividade e modelo
                    $scope.updateActivity = response.data[0].activity;
                    $scope.updateActivity.moment = new Date(response.data[0].activity.moment);
                    $scope.updateActivity.model = response.data[0].model;
                    $scope.updateActivity.evidence = Array();

                    response.data.forEach(function(element, index) {
                        $scope.updateActivity.evidence[index] = element.evidence;
                    });
                }
            });


            //Insere um novo plano no banco
            $scope.submit = function() {
                //Metódos
                $method = {
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };

                updateData($method, 'plan/activity/', $id, $scope.updateActivity, function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data != undefined) {
                        //Atribuindo valores $scope de escopo do controller
                        alert(response.data.msg);
                        location.reload();
                    }
                });

            };

            //Aprovar um plano
            $scope.finalizePlan = function() {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $data = updateData($method, 'plan/activity/status/', $id, { status: 2 }, function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

            //Aprovar um plano
            $scope.openPlan = function() {
                $method = { //definições de objetos
                    http: $http,
                    serializer: $httpParamSerializerJQLike,
                };
                //função de retorno
                $data = updateData($method, 'plan/activity/status/', $id, { status: 1 }, function(response) {
                    if (response.data.type != undefined && response.data.type == 'success') {
                        alert(response.data.msg);
                        location.reload();
                    }
                });
            };

        }
    ])
    .controller('addActivity', ['$http', '$scope', '$httpParamSerializerJQLike', '$routeParams',
        function addActivityController($http, $scope, $httpParamSerializerJQLike, $routeParams) {

            $scope.addActivity = {};
            $scope.evidences = Array();
            $scope.models = Array();
            $scope.alerts = Array();
            $scope.project = "";
            $scope.plan = "";
            $scope.activity = {};
            $scope.required = true;

            id = $routeParams.id; //pega id URL

            //Objeto com objeto angular
            $method = {
                http: $http,
                serializer: $httpParamSerializerJQLike,
            };

            //Adicionar item in REALTIME
            $scope.addItem = function() {
                $scope.evidences.push({
                    topic: $scope.addActivity.addModel.item.topics,
                    action: $scope.addActivity.addModel.item.action
                });
                delete $scope.addActivity.addModel.item;
            };

            //Retorna lista de planos baseado no id do user
            $users = getData($http, 'projects/users/' + user.project, function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data.length > 0) {
                    //Retorna lista de users
                    $scope.activity.users = response.data;
                }
            });

            //Retorna dados da atividade
            $get = getData($http, 'model/plan/' + id, function(response) {
                //Atribuindo valores a$scope de escopo do controller
                if (response.data != undefined) {
                    //Adiciona dados de atividade e modelo
                    $scope.project = response.data.project; //projeto atual
                    $scope.plan = response.data.plan; //plano atual
                    $scope.models = response.data.topics;
                }
            });

            //Insere um novo plano no banco
            $scope.submit = function() {
                //Adicionando um nova atividade
                postData($method, 'plan/activity/', undefined, {
                    project: $scope.project,
                    plan: $scope.plan,
                    name: $scope.activity.name,
                    description: $scope.activity.description,
                    evidence: $scope.evidences,
                    what: $scope.activity.what,
                    because: $scope.activity.because,
                    place: $scope.activity.place,
                    moment: $scope.activity.moment,
                    who: $scope.activity.who,
                    how: $scope.activity.who,
                    cost: $scope.activity.cost
                }, function(response) {
                    //Atribuindo valores a$scope de escopo do controller
                    if (response.data != undefined) {
                        //Atribuindo valores $scope de escopo do controller
                        $scope.alerts.push(response.data);
                        alert(response.data.msg);
                        location.reload();
                    }
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
        $routeProvider.when('/plan/:id/activity/', {
            templateUrl: 'app/panel-app/manager/pages/lists/activity.php',
            controller: 'planListActivity'
        });
        //retorna unico baseado em id
        $routeProvider.when('/plan/activity/edit/:id', {
            templateUrl: 'app/panel-app/manager/pages/add/updateActivity.php',
            controller: 'updateActivity'
        });
        //Adicionar uma nova atividade
        $routeProvider.when('/plan/:id/activity/new/', {
            templateUrl: 'app/panel-app/manager/pages/add/activity.php',
            controller: 'addActivity'
        });

    })
    .component('managerApp', {
        // Note: The URL is relative to our `index.html` file
        templateUrl: 'app/panel-app/manager/manager.template.php',
        controller: ['$http', '$scope', '$httpParamSerializerJQLike',
            function managerAppController($http, $scope, $httpParamSerializerJQLike) {
                $scope.required = true;
            }
        ]
    });