$app.component('chartsApp', {
    templateUrl: 'app/panel-app/charts-template.php',
    controller: ['$http', '$scope', '$httpParamSerializerJQLike',
        function chartsAppController($http, $scope, $httpParamSerializerJQLike) {

        }
    ]
}).controller('chartsList', ['$http', '$scope', '$httpParamSerializerJQLike',
    function chartsList($http, $scope, $httpParamSerializerJQLike) {

        $scope.isProjectResponsible = false;
        $scope.isProjectApprover = false;
        $scope.isIndividual = false;
        $scope.isLeader = false;

        $getProject = getData($http,
            'projects/' + user.project,
            function(response) {

                //Verifica se houove resposta, senão encerra função
                if (response.data != undefined) {
                    $data = response.data;
                } else {
                    return false;
                }

                //Função que verifica id em array de dados
                function idInArray(array) {
                    return array == user.id;
                }

                //Requisição para atribuir visão de RH ao usuário
                if ($data.responsible.find(idInArray)) {

                    getData($http,
                        'plan/status/count/' + user.project,
                        function(response) {
                            if (response.data == undefined)
                                return;

                            $scope.isProjectResponsible = true;
                            jQuery(document).ready(function() {
                                generateProjectChart('projeto', response.data.owner); //Inicializa gráfico
                            });

                        });
                }

                //Se aprovador do projeto igual ID do usuário
                if ($data.approver == user.id) {

                    getData($http,
                        'plan/approved/count/' + user.project,
                        function(response) {
                            if (response.data == undefined)
                                return;

                            $scope.isProjectApprover = true;
                            jQuery(document).ready(function() {
                                generateApprovedChart('aprovacao', response.data); //Inicializa gráfico
                            });

                        });
                }

                //Mostrar gráfico individual
                getData($http,
                    'plan/status/count/' + user.project + '/' + user.id,
                    function(response) {
                        if (response.data == undefined && response.data.lenght <= 0)
                            return;

                        $scope.isIndividual = true;
                        jQuery(document).ready(function() {
                            generateProjectChart('individual', response.data.owner); //Inicializa gráfico
                        });

                        if (response.data.leader == undefined || !response.data.leader)
                            return;

                        $scope.isLeader = true;
                        jQuery(document).ready(function() {
                            generateProjectChart('funcionarios', response.data.leader); //Inicializa gráfico
                        });

                    });

            });

    }
])