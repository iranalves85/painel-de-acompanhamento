<div ng-controller="updateActivity">
    <form name="updateActivity" method="POST" ng-submit="submit()">
        <div class="modal-header">
            <h1 class="modal-title" id="modal-title">Atualizar Atividade</h1>
        </div>
        <div uib-alert ng-repeat="alert in alerts" ng-class="'alert-' + (alert.type || 'warning')">
            {{alert.msg}}
        </div>
        <div class="modal-body" id="modal-body">
            
                <div class="row">

                    <div class="col-md-12 card block">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="business">
                                    Nome da Atividade
                                </label>
                                <input type="text" name="UpdateActivity.name" ng-model="updateActivity.name" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-6">
                                <label for="responsible">
                                    Descrição
                                </label>
                                <input type="text" name="UpdateActivity.description" ng-model="updateActivity.description" class="form-control" ng-required="required" />
                            </div>
                        </div>                    
                    </div>

                    <div class="col-md-12 card block">

                        <h2>5W2H</h2>

                        <table class="table table-striped table-sm table-bordered">
                            <thead>
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
                                    <input name="UpdateActivity.form.what" type="text" ng-model="updateActivity.what" class="form-control" ng-required="required"/>
                                </td>
                                <td>
                                    <input name="UpdateActivity.form.because" type="text" ng-model="updateActivity.because" class="form-control" ng-required="required" />
                                </td>
                                <td>
                                    <input name="UpdateActivity.form.place" type="text" ng-model="updateActivity.place" class="form-control" ng-required="required" />
                                </td>
                                <td>
                                    <?php
                                        $date = date('Y-m-d', time() );
                                    ?>
                                    <input name="UpdateActivity.form.moment" min="<?php echo $date; ?>" type="date" ng-model="updateActivity.moment" class="form-control" ng-value="{{updateActivity.moment | date:'Y-m-d'}}" />
                                </td>
                                <td>
                                    <input name="UpdateActivity.form.who" type="text" ng-model="updateActivity.who" class="form-control"  ng-required="required"/>
                                </td>
                                <td>
                                    <input name="UpdateActivity.form.how" type="text" ng-model="updateActivity.how" class="form-control" ng-required="required" />
                                </td>
                                <td>
                                    <input name="UpdateActivity.form.cost" type="text" ng-model="updateActivity.cost" class="form-control" ng-required="required" />
                                </td>                            
                            </tr>
                        </table>
                    </div> 
                    
                    <div class="col-md-12 card block">

                        <h2>Histórico | Evidências</h2>

                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <th>Modelo</th>
                                <th>Ação Realizada</th>                            
                            </thead>
                            <tr ng-repeat="evidence in updateActivity.evidence track by $index">
                                <td>
                                    <select class="form-control" 
                                    ng-model="updateActivity.evidence[$index].topic.name">
                                        <option 
                                        ng-value="model.name"
                                        ng-repeat="model in updateActivity.model.topics">
                                            {{model.name}}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" 
                                    ng-model="updateActivity.evidence[$index].action" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control" ng-options="model as model.name for model in updateActivity.model.topics track by model.name" ng-model="updateActivity.addModel.item.topics"></select>
                                </td>
                                <td>
                                    <div class="form-inline">
                                        <input ng-model="updateActivity.addModel.item.action" type="text" class="col-10 mr-2 form-control" />
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="addItem()">Adicionar</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div> 
                                  
                </div>
            
        </div>
        <div class="modal-footer">

            <ul class="list-inline float-right">
                <li class="list-inline-item">
                    <a onclick="window.history.back();" href="" class="btn btn-secondary">Voltar</a>
                </li>                
                <li class="list-inline-item">
                    <input class="btn btn-success" type="submit" value="Gravar">
                </li>
                <li class="list-inline-item" ng-if="updateActivity.status == 1">
                    <button type="button" class="btn btn-primary"
                    ng-click="finalizePlan()">Finalizar</button>
                </li>
                <li class="list-inline-item" ng-if="updateActivity.status == 2">
                    <button type="button" class="btn btn-primary"
                    ng-click="openPlan()">Reabrir</button>
                </li>
            </ul>
            
        </div>
    </form>
</div>