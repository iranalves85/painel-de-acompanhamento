<div class="col-md-4">
    <label for="model">
        Modelo
    </label>
    <select class="form-control" name="model" ng-options="model as model.name for model in fields.models track by model.id" ng-model="model">
    </select>
</div>

<div class="col-md-12">
    <input class="btn btn-success float-right" type="submit" value="Cadastrar">
</div>