<form name="newProject" method="POST" class="ng-cloak" ng-submit="addProject(0)">
    <div class="form-group block card">
        <h3>Selecione ou cadastre-se uma nova empresa</h3>
        <div class="form-inline">
            <input type="text" ng-value="company.id" ng-model-options="fieldOptions" ng-model="fieldSelected" uib-typeahead="company.name for company in companys | filter:$viewValue | limitTo:8" class="form-control mr-sm-2" placeholder="Empresa" />  
            <input class="btn btn-success" type="submit" value="Continuar">
        </div>
    </div><!-- Formulário de Empresas -->
</form>