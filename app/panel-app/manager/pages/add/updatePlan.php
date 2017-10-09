<div ng-controller="updatePlan">
    <div class="modal-header">
        <h1 class="modal-title" id="modal-title">Editar Plano</h1>
    </div>
    <div uib-alert ng-repeat="alert in alerts" ng-class="'alert-' + (alert.type || 'warning')">
        {{alert.msg}}
    </div>
    <form name="add-plan" method="POST" ng-submit="submit()">
        <div class="modal-body" id="modal-body">        
                <div class="row">

                    <div class="col-md-12 card block">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="business">
                                    Nome do Plano
                                </label>
                                <input type="text" name="name" ng-model="updatePlan.name" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Descrição
                                </label>
                                <input type="text" name="description" ng-model="updatePlan.description" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Responsável
                                </label>
                                <select class="form-control" name="owner" ng-model="updatePlan.owner">
                                    <option ng-repeat="plan in plan.users" ng-value="plan.id">{{plan.username}}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Custo
                                </label>
                                <input type="text" name="cost" ng-model="updatePlan.cost" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Meta
                                </label>
                                <input type="text" name="goal" ng-model="updatePlan.goal" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Duração
                                </label>
                                <?php
                                    $date = date('Y-m-d', time() );
                                ?>
                                <input type="date" min="<?php echo $date; ?>" name="deadline" ng-model="updatePlan.deadline" class="form-control" ng-required="required" />
                            </div>
                        </div>                    
                    </div>
                                
                </div>        
        </div>
        <div class="modal-footer">
            
            <div class="col-md-12">            
                <ul class="list-inline float-right">                
                    <li class="list-inline-item">
                        <a class="btn btn-light" href="painel#!/">Voltar</a>
                    </li>
                    <li class="list-inline-item">
                        <input ng-disabled="add-project.$invalid" class="btn btn-success" type="submit" value="Atualizar">
                    </li>
                </ul>            
            </div>
            
        </div>
    </form>
</div>