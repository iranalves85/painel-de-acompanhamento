<div ng-controller="addPlan">
    <div class="modal-header">
        <h1 class="modal-title" id="modal-title">Adicionar Plano</h1>
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
                                <input type="text" name="name" ng-model="addPlan.name" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Descrição
                                </label>
                                <input type="text" name="description" ng-model="addPlan.description" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Responsável
                                </label>
                                <select class="form-control" name="owner" ng-model="addPlan.owner">
                                    <option ng-repeat="plan in plan.users" ng-value="plan.id">{{plan.username}}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Custo
                                </label>
                                <input type="text" name="cost" ng-model="addPlan.cost" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Meta
                                </label>
                                <input type="text" name="goal" ng-model="addPlan.goal" class="form-control" ng-required="required" />
                            </div>
                            <div class="col-md-4">
                                <label for="responsible">
                                    Data de Entrega
                                </label>
                                <?php
                                    $date = date('Y-m-d', time() );
                                ?>
                                <input type="date" min="<?php echo $date; ?>" name="deadline" ng-model="addPlan.deadline" class="form-control" ng-required="required" />
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
                        <input ng-disabled="add-project.$invalid" class="btn btn-success" type="submit" value="Cadastrar">
                    </li>
                </ul>            
            </div>
            
        </div>
    </form>
</div>