<div class="col-12 project card block" ng-controller="myPlans">

    <ul class="list-inline">
        <li class="list-inline-item">
            <h2 class="titulo-secao">
                Meus Planos
            </h2>
        </li>
        <li class="list-inline-item">
            <a href="painel#!/plan/add" class="btn btn-sm btn-primary" ng-click="addPlan.open()">
                Adicionar Plano
            </a>
        </li>
        <li class="list-inline-item float-right">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <select ng-init="order = [{value:'date_created',text:'Recentes'}, {value:'deadline',text:'Prazo de Entrega'}, {value:'status',text:'Status'}]" name="" id="" class="btn btn-light" ng-model="order.data" ng-options="item as item.text for item in order track by item.value"
                        ng-change="reorderPlanList()">
                    </select>
                </li>
                <li class="list-inline-item">
                    <select ng-init="orderby = [{value:'ASC',text:'Alfabética'}, {value:'DESC',text:'Descendente'}]" name="" id="" class="btn btn-light" ng-model="order.direction" ng-options="item as item.text for item in orderby track by item.value " ng-change="reorderPlanList()">
                    </select>
                </li>
                <li class="list-inline-item">
                    <input class="form-control" type="text" name="search" id="" placeholder="Pesquisa" ng-model="pesquisa">
                </li>
            </ul>
        </li>
    </ul>

    <table class="table table-striped table-bordered">
        <thead class="thead-inverse">
            <th>Plano</th>
            <th>Descrição</th>
            <th>Meta</th>
            <th>Prazo de Entrega</th>
            <th>Status</th>
            <th>Ação</th>
        </thead>
        <tbody>
            <tr ng-repeat="plan in plans | filter:pesquisa">
                <td>{{plan.name}}</td>
                <td>{{plan.description}}</td>
                <td>{{plan.goal}}</td>
                <td>{{plan.deadline}}</td>
                <td>
                    <span class="badge badge-primary badge-{{ plan.status }}">
                        {{ plan.status === "danger" ? "Em atraso" : "Atenção" }}
                    </span>
                </td>
                <td>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a class="btn btn-sm btn-info" href="painel#!/plan/activity/{{plan.id}}">Atividades</a></li>
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