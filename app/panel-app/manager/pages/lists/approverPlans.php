<div class="col-12 project card block">

    <ul class="list-inline">
        <li class="list-inline-item">
            <h2 class="titulo-secao">
                Planos de Ações com Atraso
            </h2>
        </li>
        <li class="list-inline-item float-right">
            <input class="form-control" type="text" name="search" id="" placeholder="Pesquisa" ng-model="atraso">
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
            <tr ng-repeat="plan in leaderPlans | filter:atraso">
                <td>{{plan.name}}</td>
                <td>{{plan.description}}</td>
                <td>{{plan.goal}}</td>
                <td>
                    {{plan.deadline}}
                    <span class="badge badge-primary badge-{{plan.deadline.badge}}">
                        {{plan.rule.text}}
                    </span>
                </td>
                <td>
                    {{plan.status.text}}
                </td>
                <td>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="btn btn-sm" href="painel#!/plan/edit/{{plan.id}}">Editar</a>
                        </li>
                        <li class="list-inline-item" ng-if="plan.status.id == 3">
                            <button type="button" class="btn btn-sm btn-primary" ng-click="openPlan(plan.id)">Reabrir</a>
                        </li>
                        <li class="list-inline-item" ng-if="plan.status.id == 1">
                            <button type="button" class="btn btn-sm btn-success" ng-click="approvePlan(plan.id)">Aprovar</a>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<!-- Lista de Planos de Lideres -->