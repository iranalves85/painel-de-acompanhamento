<div ng-controller="updateProject">

    <form name="newProject" method="POST" ng-submit="updateProject()">

        <h1>Atualizar Projeto</h1>

        <div class="row" class="ng-cloak">

            <div class="form-group block card col-md-3">
                <h3>Empresa</h3>
                <select class="form-control" name="company" ng-model="project.company">
                    <option ng-repeat="company in companys track by company.id" 
                    ng-value="{{company.id}}" ng-selected="company.id == project.company">
                        {{company.name}}
                    </option>
                </select>
            </div><!-- Formulário de Empresas -->

            <div class="col-md-3 block card">
                <div class="form-group">
                    <h3>Modelo</h3>            
                    <select class="form-control" name="model" ng-model="project.model">
                        <option ng-repeat="model in models track by model.id" 
                        ng-value="{{model.id}}" ng-selected="model.id == project.model">
                        {{model.name}}</option>
                    </select> 
                    <a class="btn btn-sm btn-link" href="painel#!/model/new">Adicionar um novo modelo</a>
                </div>
                
            </div><!-- Formulário de Empresas -->

            <div class="form-group card block">
                <h3>Envio arquivo com usuários a serem adicionados ou atualizados no projeto</h3>
                <div uib-alert ng-repeat="alert in alerts" ng-class="'alert-' + (alert.type || 'warning')">
                    {{alert.msg}}
                </div>
                <div class="form-inline">
                    <input nv-file-select uploader="uploader" options="file" type="file" name="userFile" class="form-control btn-sm btn-file mr-sm-2" ng-model="fileInput" >
                    
                    <div class="col" ng-repeat="item in uploader.queue">
                        <div class="row">
                            
                            <button type="button" class="col-md-auto btn btn-primary" 
                                    ng-click="item.upload()">upload</button>

                            <div class="col">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:{{fileUploadProgress}}%" >{{fileUploadProgress}}%</div>   
                                </div>
                            </div>                   

                        </div>                                                 
                    </div>               
                            
                </div>
            </div><!-- formulário de upload -->

            <div class="col-md-12 block card">
                <h3>Usuários com perfis de RH</h3>

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

                        <select class="form-control" size="10" ng-model="project.responsible" multiple>
                            <option 
                            ng-repeat="responsible in project.users | areaFilter:{area:showAreaUsers}" 
                            ng-value="responsible.id" ng-selected="">
                                {{responsible.username}} | {{responsible.email}}
                            </option>
                        </select>

                    </div>
                </div>
            </div><!-- Seleção de responsáveis -->

            <div class="card block col-12">
                <h3>Usuário Aprovador</h3>

                <div class="row" ng-init="approvers = responsibles;">
                    <div class="col-md-3" ng-repeat="approver in project.users">   
                        <label for="{{approver.email}}" class="custom-control custom-radio">
                            <input id="{{approver.email}}" type="radio" ng-value="approver.id" name="approver" ng-model="project.approver" ng-selected="approver.id == project.approver" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">
                                {{approver.username}}
                            </span>
                        </label> 
                    </div>                    
                </div>                

            </div>    

            <div class="col block">
                <input class="btn btn-success float-right" type="submit" value="Atualizar Projeto">
            </div>     

    </form>
</div>