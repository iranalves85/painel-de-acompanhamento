<div class="row" class="ng-cloak">
    <div class="col-md-3"> 

        <div class="form-group block card">
            <h2>Modelo Existente</h2>            
            <form name="newProject" method="POST" ng-submit="addProject(1)">
                <select class="form-control mr-sm-2" name="model" ng-options="model as model.name for model in models track by model.id" ng-model-options="fieldOptions" ng-model="fieldSelected">
                </select>
                <br />
                <input class="btn btn-success float-right" type="submit" value="Continuar">
                <input type="hidden" name="company" ng-value="page.projectData.company" /> 
            </form>           
        </div>   
        
    </div><!-- Formulário de Empresas -->

    <div class="col-md-9" ng-model="addModel" ng-include="'app/panel-app/superuser/pages/add/model.php'"></div>
</div>
