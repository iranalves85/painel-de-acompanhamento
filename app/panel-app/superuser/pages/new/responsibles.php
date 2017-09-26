<form name="newProject" method="POST" ng-submit="addProject(4)">
    <h2>Selecione os usuários com perfis de RH</h2>
    <!--<div ng-init="areas = [{name:'Diretoria'},
                         {name:'Marketing'},
                         {name:'Controladoria'},
                         {name:'Recursos Humanos'}]"></div>
    <div ng-init="responsibles =[
                        {id: 1, username:'John', area: [{name: 'Marketing'},{name:'Controladoria'}] },
                        {id: 2, username:'Mary', area: [{name: 'Recursos Humanos'}] },
                        {id: 3, username:'Mike', area: [{name: 'Marketing'}] },
                        {id: 4, username:'Adam', area: [{name: 'Controladoria'}] }
                         ]"></div>-->
    <div class="row">
        <div class="col-md-6">            
            <label for="area">
                Departamento
            </label>
            <select class="form-control" name="area" ng-model="areaFilter" multiple>
                <option value="">Todos</option>
                <option ng-repeat="area in areas" value="{{area.name}}">{{area.name}}</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="responsible">
                Responsável
            </label>
            <select class="form-control" name="responsible" ng-model="responsible" multiple>
                <option ng-repeat="responsible in responsibles | filter:areaFilter" ng-value="responsible.id">{{responsible.username}}</option>
            </select>
        </div>
        <div class="col-12">
            <br />
            <input class="btn btn-success float-right" type="submit" value="Continuar">
        </div>
    </div>
</form>
