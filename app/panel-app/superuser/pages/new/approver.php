<div class="col-md-4">
    <label for="approver">
        Aprovador
    </label>
    <select class="form-control" name="approver" ng-options="approver as approver.name for approver in fields.approvers track by approver.id" ng-model="approver"></select>
</div>

<div class="col-md-12">
    <input class="btn btn-success float-right" type="submit" value="Cadastrar">
</div>