<div class="col-12 main card block" ng-controller="updateModel">
        <div class="new-project">

            <h2>Novo Modelo</h2>

            <form name="add-model" method="POST" ng-submit="submit()">
                <div class="row">
                    <div class="col-md-6">
                        <label for="business">
                            Nome
                        </label>
                        <input type="text" name="name" ng-model="models.name" class="form-control" ng-required="required" />
                    </div>
                    <div class="col-md-6">
                        <label for="responsible">
                                Descrição
                            </label>
                        <input type="text" name="description" ng-model="models.description" class="form-control" ng-required="required" />
                    </div>
                    <br />
                    <div class="col-md-12 block">

                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <th>Nome</th>
                                <th>Descrição</th>
                            </thead>
                            <tr ng-repeat="topic in models.topics">
                                <td><input type="text" ng-value="topic.name" name="{{topic.name}}" class="form-control" /></td>
                                <td><input type="text" ng-value="topic.description" name="{{topic.description}}" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" ng-model="updateModel.item.name" class="form-control" />
                                </td>
                                <td>
                                    <div class="form-inline">
                                        <input type="text" ng-model="updateModel.item.description" class="form-control col-9 mr-2" />
                                        <button class="btn btn-secondary" type="button" ng-click="updateModel.updateItem()">Adicionar</button>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-12">
                        <ul class="list-inline float-right">
                            <li class="list-inline-item">
                                <a class="btn btn-light" href="painel#!/model">Voltar</a>
                            </li>
                            <li class="list-inline-item">
                                <input ng-disabled="add-project.$invalid" class="btn btn-success" type="submit" value="Cadastrar">
                            </li>
                        </ul>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>