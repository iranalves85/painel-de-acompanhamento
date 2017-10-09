<div ng-controller="addActivity">
<form name="addActivity" method="POST" ng-submit="submit()">
    <div class="modal-header">
        <h1 class="modal-title" id="modal-title">Adicionar Atividade</h1>
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
                            <input type="text" name="addActivity.name" ng-model="activity.name" class="form-control" ng-required="required" />
                        </div>
                        <div class="col-md-6">
                            <label for="responsible">
                                Descrição
                            </label>
                            <input type="text" name="addActivity.description" ng-model="activity.description" class="form-control" ng-required="required" />
                        </div>
                    </div>                    
                </div><!-- nome/descrição -->

                <div class="col-md-12 card block">

                    <h2>5W2H</h2>

                    <table class="table table-sm table-striped table-bordered">
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
                                <input name="addActivity.form.what" type="text" ng-model="activity.what" class="form-control" ng-required="required"/>
                            </td>
                            <td>
                                <input name="addActivity.form.because" type="text" ng-model="activity.because" class="form-control" ng-required="required" />
                            </td>
                            <td>
                                <input name="addActivity.form.place" type="text" ng-model="activity.place" class="form-control" ng-required="required" />
                            </td>
                            <td>
                                <?php
                                    $date = date('Y-m-d', time() );
                                ?>
                                <input name="addActivity.form.moment" min="<?php echo $date; ?>" type="date" ng-model="activity.moment" class="form-control" ng-value="{{addActivity.moment | date:'Y-m-d'}}" ng-required="required" />
                            </td>
                            <td>
                                <select class="form-control" name="addActivity.form.who" ng-model="activity.who" ng-required="required">
                                    <option ng-repeat="user in activity.users" ng-value="user.id">
                                    {{user.username}}</option>
                                </select>
                            </td>
                            <td>
                                <input name="addActivity.form.how" type="text" ng-model="activity.how" class="form-control" ng-required="required" />
                            </td>
                            <td>
                                <input name="addActivity.form.cost" type="text" ng-model="activity.cost" class="form-control" ng-required="required" />
                            </td>                            
                        </tr>
                    </table>
                </div><!-- 5w2h-->
                
                <div class="col-md-12 card block">

                    <h2>Histórico | Evidências</h2>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Modelo</th>
                            <th>Ação Realizada</th>                            
                        </thead>
                        <tr ng-repeat="evidence in evidences">
                            <td>
                                <select name="addActivity.form.evidence[][topic]" class="form-control" ng-model="evidence.topic" ng-options="model as model.name for model in models track by model.name" >
                                </select>
                            </td>
                            <td>
                                <input name="addActivity.form.evidence[][action]" type="text" value="" class="form-control" ng-model="evidence.action" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" ng-options="model as model.name for model in models track by model.name" ng-model="addActivity.addModel.item.topics"></select>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <input ng-model="addActivity.addModel.item.action" type="text" class="col-10 mr-2 form-control" />
                                    <button type="button" class="btn btn-sm btn-primary" ng-click="addItem()">Adicionar</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div> <!-- evidencias -->
                               
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
        </ul>
        
    </div>
</form>
</div>