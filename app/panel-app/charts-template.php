<div class="container" ng-controller="chartsApp">            
    <div class="main">
        <div class="graficos-de-status text-center">
            
            <ul class="row list-inline">
                <li class="col-3">
                    <h2 class="text-center">Status do Projeto</h2>
                    <canvas id="status" width="100" height="100"></canvas>
                    <script>
                        generateCharts('status');
                    </script>
                </li>
                <li class="col-3">
                    <h2 class="text-center">Status de Aprovações</h2>
                    <canvas id="planos" width="150" height="150"></canvas>
                    <script>
                        generateCharts('planos');
                    </script>
                </li>
                <li class="col-3">
                    <h2 class="text-center">Plano de Funcionários</h2>
                    <canvas id="prazos" width="150" height="150"></canvas>
                    <script>
                        generateCharts('prazos');
                    </script>
                </li>
                <li class="col-3">
                    <h2 class="text-center">Plano Individual</h2>
                    <canvas id="prazos2" width="150" height="150"></canvas>
                    <script>
                        generateCharts('prazos2');
                    </script>
                </li>
            </ul>

        </div><!-- graficos-de-status -->
    </div><!-- main -->
</div><!-- container -->