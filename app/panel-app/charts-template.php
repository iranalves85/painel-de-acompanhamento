<div class="container" ng-controller="chartsList">            
    <div class="main">
        <div class="chart-status text-center">
            
            <ul class="row list-inline justify-content-center">
                <li class="col" ng-if="isProjectResponsible">
                    <h4>Status do Projeto</h4>
                    <canvas id="projeto" width="100" height="100"></canvas>
                </li>
                <li class="col" ng-if="isProjectApprover">
                    <h4>Status de Aprovações</h4>
                    <canvas id="aprovacao" width="150" height="150"></canvas>
                </li>
                <li class="col" ng-if="isIndividual">
                    <h4>Plano Individual</h4>
                    <canvas id="individual" width="150" height="150"></canvas>
                </li>
                <li class="col" ng-if="isLeader">
                    <h4>Plano de Funcionários</h4>
                    <canvas id="funcionarios" width="150" height="150"></canvas>
                </li>                
            </ul>

        </div><!-- graficos-de-status -->
    </div><!-- main -->
</div><!-- container -->