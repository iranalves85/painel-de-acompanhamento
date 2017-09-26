<div class="col-12 main card block" ng-controller="modelo">
        <div class="new-project">

            <h2>Novo Modelo</h2>

            <form name="add-project" method="POST" ng-submit="addModel.submit()">
                <div class="row">
                    <div class="col-md-6">
                        <label for="business">
                            Nome
                        </label>
                        <input type="text" name="name" ng-model="addModel.name" class="form-control" />
                    </div>
                    <div class="col-md-6">
                        <label for="responsible">
                                Descrição
                            </label>
                        <input type="text" name="description" ng-model="addModel.description" class="form-control" />
                    </div>
                    <br />
                    <div class="col-md-12 block">

                        <table class="table table-stripped table-bordered">
                            <thead class="thead-inverse">
                                <th>Nome</th>
                                <th>Descrição</th>
                            </thead>
                            <tr ng-repeat="modelItem in addModel.modelItems">
                                <td><input type="text" value="{{modelItem.name}}" name="topics[{{$index + 1}}][name]" class="form-control" /></td>
                                <td><input type="text" value="{{modelItem.description}}" name="topics[{{$index + 1}}][description]" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" ng-model="addModel.item.name" class="form-control" />
                                </td>
                                <td>
                                    <div class="form-inline">
                                        <input type="text" ng-model="addModel.item.description" class="form-control col-9 mr-2" />
                                        <span class="btn btn-secondary" ng-click="addModel.addItem()">Adicionar</span>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-12">
                        <input ng-disabled="add-project.$invalid" class="btn btn-success float-right" type="submit" value="Cadastrar">
                    </div>
                </div>
            </form>
        </div>
    </div>