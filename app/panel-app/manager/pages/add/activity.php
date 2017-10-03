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
                            <input type="text" name="addActivity.name" ng-model="activty.name" class="form-control" ng-required="required" />
                        </div>
                        <div class="col-md-6">
                            <label for="responsible">
                                Descrição
                            </label>
                            <input type="text" name="addActivity.description" ng-model="activity.description" class="form-control" ng-required="required" />
                        </div>
                    </div>                    
                </div>
                
                <div class="col-md-12 card block">

                    <h2>Histórico | Evidências</h2>

                    <table class="table table-stripped table-bordered">
                        <thead class="thead-inverse">
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
                                    <button type="button" class="btn btn-secondary" ng-click="addItem()">Adicionar</button>
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
                                <input name="addActivity.form.who" type="text" ng-model="activity.who" class="form-control"  ng-required="required"/>
                            </td>
                            <td>
                                <input name="addActivity.form.how" type="text" ng-model="activity.how" class="form-control" ng-required="required" />
                            </td>
                            <td>
                                <input name="addActivity.form.cost" type="text" ng-model="aactivity.cost" class="form-control" ng-required="required" />
                            </td>                            
                        </tr>
                    </table>
                </div>               
            </div>
        
    </div>
    <div class="modal-footer">

        <ul class="list-inline float-right">
            <li class="list-inline-item">
                <a class="btn btn-light" href="painel#!/" >Voltar</a>
            </li>
            <li class="list-inline-item">
                <input class="btn btn-primary" type="submit" value="Finalizar">
            </li>
            <li class="list-inline-item">
                <input class="btn btn-success" type="submit" value="Gravar">
            </li>
        </ul>
        
    </div>
</form>
</div>