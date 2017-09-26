<div ng-controller="addActivity">
    <div class="modal-header">
        <h1 class="modal-title" id="modal-title">Adicionar Atividade</h1>
    </div>
    <div class="modal-body" id="modal-body">
        <form name="add-plan" method="POST" ng-submit="addActivity.submit()">
            <div class="row">

                <div class="col-md-12 card block">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="business">
                                Nome da Atividade
                            </label>
                            <input type="text" name="name" ng-model="addActivity.name" class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label for="responsible">
                                Descrição
                            </label>
                            <input type="text" name="description" ng-model="addActivity.description" class="form-control" />
                        </div>
                    </div>                    
                </div>
                
                <div class="col-md-12 card block">

                    <h2>Histórico | Evidências</h2>

                    <table class="table table-stripped table-bordered">
                        <thead class="thead-inverse">
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Arquivo</th>
                        </thead>
                        <tr ng-repeat="modelItem in addModel.modelItems">
                            <td>
                                <select class="form-control">
                                    <option>opção 1</option>
                                    <option>opção 1</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" value="{{modelItem.description}}" 
                                name="evidence[{{$index + 1}}][description]" class="form-control" /></td>
                            <td>
                                <input type="text" value="{{modelItem.file}}" 
                                name="evidence[{{$index + 1}}][description]" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" ng-options="option as addActivity.item.model in addActivity.item.models track by addActivity.item.model.id"></select>
                            </td>
                            <td>
                                <input type="text" ng-model="addActivity.item.description" class="form-control" />
                            </td>
                            <td>
                                <div class="form-inline">
                                    <input type="file" ng-model="addActivity.item.file" class="form-control col-9 mr-2" />
                                    <span class="btn btn-secondary" ng-click="addActivity.evidence.addItem()">Adicionar</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div> 
                <div class="col-md-12 card block">

                    <h2>5W2H</h2>

                    <table class="table table-stripped table-bordered">
                        <thead class="thead-inverse">
                            <th>O que</th>
                            <th>Porque</th>
                            <th>Onde</th>
                            <th>Quando</th>
                            <th>Quem</th>
                            <th>Como</th>
                            <th>Custo</th>
                        </thead>
                        <tr ng-repeat="modelItem in addModel.modelItems">
                            <td><input type="text" value="{{modelItem.name}}" name="evidence[{{$index + 1}}][name]" class="form-control" /></td>
                            <td><input type="text" value="{{modelItem.description}}" name="evidence[{{$index + 1}}][description]" class="form-control" /></td>
                            <td><input type="text" value="{{modelItem.file}}" name="evidence[{{$index + 1}}][description]" class="form-control" /></td>
                            <td><input type="text" value="{{modelItem.name}}" name="evidence[{{$index + 1}}][name]" class="form-control" /></td>
                            <td><input type="text" value="{{modelItem.description}}" name="evidence[{{$index + 1}}][description]" class="form-control" /></td>
                            <td><input type="text" value="{{modelItem.file}}" name="evidence[{{$index + 1}}][description]" class="form-control" /></td>
                            <td><input type="text" value="{{modelItem.name}}" name="evidence[{{$index + 1}}][name]" class="form-control" /></td>                            
                        </tr>
                        <tr>
                            <td>
                                <input type="text" ng-model="addActivity.item.name" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="addActivity.item.description" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="addActivity.item.description" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="addActivity.item.description" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="addActivity.item.description" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="addActivity.item.description" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="addActivity.item.description" class="form-control" />
                            </td>                            
                        </tr>
                    </table>
                    <span class="btn btn-secondary" ng-click="addActivity.addItem()">Adicionar</span>
                </div>               
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <div class="col-md-12">
            <input ng-disabled="add-project.$invalid" class="btn btn-success float-right" type="submit" value="Cadastrar">
        </div>
        <button class="btn btn-warning" type="button" ng-click="addActivity.cancel()">Cancel</button>
    </div>
</div>