<div class="row">
    <div class="col-8">
        <h3>Etapa 1</h3>
        <label for="business">
            Empresa
        </label>
        <input type="text" name="company" ng-value="company.id" ng-model="company" uib-typeahead="company.name for company in companys | filter:$viewValue | limitTo:8" class="form-control" />  
    </div>    
    <input class="btn btn-success" type="submit" value="Cadastrar">
</div>