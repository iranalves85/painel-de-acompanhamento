<div ng-controller="updateActivity">
    <div class="modal-header">
        <h1 class="modal-title" id="modal-title">Atualizar Atividade</h1>
    </div>
    <div class="modal-body" id="modal-body">
        <form name="add-plan" method="POST" ng-submit="updateActivity.submit()">
            <div class="row">

                <div class="col-md-12 card block">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="business">
                                Nome da Atividade
                            </label>
                            <input type="text" name="name" ng-model="updateActivity.current.name" class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label for="responsible">
                                Descrição
                            </label>
                            <input type="text" name="description" ng-model="updateActivity.current.description" class="form-control" />
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
                        <tr ng-repeat="evidence in updateActivity.current.evidence">
                            <td>
                                <select class="form-control" ng-model="evidence.name">
                                    <option>opção 1</option>
                                    <option>opção 1</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" value="" 
                                name="" class="form-control" ng-model="evidence.description" />
                            </td>
                            <td>
                                <input type="text" value="" 
                                name="" class="form-control" ng-model="evidence.action" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control"></select>
                            </td>
                            <td>
                                <input type="text" ng-model="" class="form-control" />
                            </td>
                            <td>
                                <div class="form-inline">
                                    <input type="text" ng-model="" class="col-9 form-control" />
                                    <span class="btn btn-secondary" ng-click="">Adicionar</span>
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
                        <tr>
                            <td>
                                <input type="text" ng-model="updateActivity.current.what" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="updateActivity.current.because" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="updateActivity.current.place" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="updateActivity.current.moment" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="updateActivity.current.who" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="updateActivity.current.how" class="form-control" />
                            </td>
                            <td>
                                <input type="text" ng-model="updateActivity.current.cost" class="form-control" />
                            </td>                            
                        </tr>
                    </table>
                </div>               
            </div>
        </form>
    </div>
    <div class="modal-footer">

        <ul class="list-inline float-right">
            <li class="list-inline-item">
                <button class="btn btn-light" type="button" ng-click="updateActivity.cancel()">Cancel</button>
            </li>
            <li class="list-inline-item">
                <input class="btn btn-primary" type="submit" value="Finalizar">
            </li>
            <li class="list-inline-item">
                <input class="btn btn-success" type="submit" value="Gravar">
            </li>
        </ul>
        
    </div>
</div>