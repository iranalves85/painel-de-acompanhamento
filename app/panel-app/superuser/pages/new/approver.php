<form name="newProject" method="POST" ng-submit="selectApprover()">

    <h2>Selecione o perfil de aprovador</h2>

    <div class="row" ng-init="approvers = responsibles;">
        <div class="col-md-3" ng-repeat="approver in approvers">   
            <label for="{{approver.email}}" class="custom-control custom-radio">
                <input id="{{approver.email}}" type="radio" ng-value="approver.id" name="approver" ng-model="page.projectData.approver" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">
                    {{approver.username}}
                </span>
            </label> 
        </div>
        <div class="col-12">
            <br />
            <input class="btn btn-success float-right" type="submit" value="Continuar">
        </div>
    </div>
</form>
