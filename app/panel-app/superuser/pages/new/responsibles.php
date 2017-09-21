<div class="col-md-4">
    <label for="responsible">
        Departamento
    </label>
    <select class="form-control" name="responsible" ng-model="area">
        <option ng-repeat="area in areas" value="{{area.id}}">{{area.name}}</option>
    </select>
</div>
<div class="col-md-4">
    <label for="responsible">
        Responsável
    </label>
    <select class="form-control" name="responsible" ng-options="responsible as responsible.name for responsible in fields.responsibles track by responsible.id" ng-model="responsible">
    </select>
</div>