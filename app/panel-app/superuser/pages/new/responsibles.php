<form name="newProject" method="POST" ng-submit="selectResponsibles()">

    <h2>Selecione os usuários com perfis de RH</h2>

    <div class="row">
        <div class="col-md-6">            
            <label for="area">
                Filtro por Departamento
            </label>

            <select class="form-control" size="10" name="area" 
            ng-model="showAreaUsers" multiple>
                <option value="" selected>Todos</option>
                <option ng-repeat="area in areas" ng-value="area.name">{{area.name}}</option>           
            </select>      
                    
        </div>
        <div class="col-md-6">
            <label for="responsible">
                Responsável
            </label>

            <select class="form-control" size="10" name="responsible" ng-model="page.projectData.responsibles" multiple>
                <option 
                ng-repeat="responsible in responsibles | areaFilter:{area:showAreaUsers}" 
                ng-value="responsible.id">
                    {{responsible.username}} | {{responsible.email}}
                </option>
            </select>

        </div>
        <div class="col-12">
            <br />
            <input class="btn btn-success float-right" type="submit" value="Continuar">
        </div>
    </div>
</form>
