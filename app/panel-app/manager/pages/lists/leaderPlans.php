<div class="col-12 project card block" ng-controller="leaderPlans">

    <ul class="list-inline">
        <li class="list-inline-item">
            <h2 class="titulo-secao">
                Planos de meus funcionários
            </h2>
        </li>
        <li class="list-inline-item float-right">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <select name="" id="" class="btn btn-light" ng-model="order"
                        ng-change="reorderProjectList()">
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
            <th>Gestor</th>
            <th>Prazo de Entrega</th>
            <th>Status</th>
            <th>Ação</th>
        </thead>
        <tbody>
            <tr ng-repeat="plan in plans | filter:atraso | orderBy:orderDefine:reverse">
                <td>{{plan.name}}</td>
                <td>{{plan.description}}</td>
                <td>{{plan.gestor}}</td>
                <td>{{plan.deadline}}</td>
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
                        <li class="list-inline-item"><a class="btn btn-sm" href="plan/edit/{{plan.id}}">Editar</a></li>
                        <li class="list-inline-item"><a class="btn btn-sm btn-danger" href="plan/delete/{{plan.id}}">Excluir</a></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<!-- Planos de funcionários -->