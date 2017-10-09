<!-- Template de Aprovação -->
<div ng-controller="approverPlans">  
    <div ng-include="approverPlansTemplate" ng-if="isApprover"></div>
    <!-- leadersPlans -->
</div>
<!-- dashboard -->

<div class="col-12 project card block" ng-controller="myPlans">

    <ul class="list-inline">
        <li class="list-inline-item">
            <h2 class="titulo-secao">
                Meus Planos
            </h2>
        </li>
        <li class="list-inline-item">
            <a href="painel#!/plan/new/" class="btn btn-sm btn-primary" ng-click="addPlan.open()">
                Adicionar Plano
            </a>
        </li>
        <li class="list-inline-item float-right">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <select name="" id="" class="btn btn-light" 
                    ng-model="order" ng-change="reorderList()">
                        <option ng-repeat="item in order track by item.value" 
                            value="{{item.value}}">{{item.text}}</option>
                    </select>
                </li>
                <li class="list-inline-item">
                    <input class="form-control" type="text" name="search" id="" placeholder="Pesquisa" ng-model="pesquisa">
                </li>
            </ul>
        </li>
    </ul>

    <table class="table table-striped table-sm table-bordered">
        <thead>
            <th>Plano</th>
            <th>Descrição</th>
            <th>Meta</th>
            <th>Prazo de Entrega</th>
            <th>Status</th>
            <th>Ação</th>
        </thead>
        <tbody>
            <tr ng-repeat="plan in plans | filter:pesquisa | orderBy:orderDefine:reverse">
                <td>{{plan.name}}</td>
                <td>{{plan.description}}</td>
                <td>{{plan.goal}}</td>
                <td>
                    {{plan.deadline | date:'dd-MM-yyyy'}}
                    <span class="badge badge-primary badge-{{ plan.rules.badge }}">
                        {{ plan.rules.msg }}
                    </span>
                </td>
                <td>
                    {{plan.statusText}}                    
                </td>
                <td>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a class="btn btn-sm btn-info" href="painel#!/plan/{{plan.id}}/activity/">Atividades</a></li>
                        <li class="list-inline-item"><a class="btn btn-sm btn-primary" href="painel#!/plan/edit/{{plan.id}}">Editar</a></li>
                        <li class="list-inline-item">
                            <button class="btn btn-sm btn-danger" 
                            ng-click="delete(plan.id)">Excluir</button>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<!-- Meus Planos -->

<!-- Elemento é condicional -->
<div ng-controller="leaderPlans"> 

    <div class="col-12 project card block" ng-if="isLeader">
        <ul class="list-inline">
            <li class="list-inline-item">
                <h2 class="titulo-secao">
                    Planos dos meus funcionários
                </h2>
            </li>
            <li class="list-inline-item float-right">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <select name="" id="" class="btn btn-light" ng-model="order"
                            ng-change="reorderList()">
                            <option ng-repeat="item in order track by item.value" 
                            value="{{item.value}}">{{item.text}}</option>
                        </select>
                    </li>                    
                    <li class="list-inline-item">
                        <input class="form-control" type="text" name="search" id="" placeholder="Pesquisa" ng-model="pesquisa">
                    </li>
                </ul>
            </li>
        </ul>

        <table class="table table-striped table-sm table-bordered">
            <thead>
                <th>Funcionário</th>
                <th>Plano</th>
                <th>Descrição</th>
                <th>Meta</th>
                <th>Prazo de Entrega</th>
                <th>Status</th>
                <th>Ação</th>
            </thead>
            <tbody>
                <tr ng-repeat="plan in plans | filter:pesquisa | orderBy:orderDefine:reverse">
                    <td>{{plan.username}}</td>
                    <td>{{plan.name}}</td>
                    <td>{{plan.description}}</td>
                    <td>{{plan.goal}}</td>
                    <td>
                        {{plan.deadline  | date:'dd-MM-yyyy'}}
                        <span class="badge badge-primary badge-{{ plan.rules.badge }}">
                            {{ plan.rules.msg }}
                        </span>
                    </td>
                    <td>
                        {{plan.statusText}}                    
                    </td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a class="btn btn-sm btn-info" href="painel#!/plan/{{plan.id}}/activity/">Atividades</a></li>
                            <li class="list-inline-item" ng-if="plan.statusID == 3">
                                <button type="button" class="btn btn-sm btn-primary" ng-click="openPlan(plan.id)">Reabrir</a>
                            </li>
                            <li class="list-inline-item" ng-if="plan.statusID == 1">
                                <button type="button" class="btn btn-sm btn-success" ng-click="approvePlan(plan.id)">Aprovar</a>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Meus Planos -->