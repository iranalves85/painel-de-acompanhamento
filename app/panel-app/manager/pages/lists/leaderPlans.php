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
                    <select ng-init="order = [{value:'date_created',text:'Recentes'}, {value:'deadline',text:'Prazo de Entrega'}, {value:'gestor',text:'Gestor'}]" name="" id="" class="btn btn-light" ng-model="order.data" ng-options="item as item.text for item in order track by item.value"
                        ng-change="reorderProjectList()">
                    </select>
                </li>
                <li class="list-inline-item">
                    <select ng-init="orderby = [{value:'ASC',text:'Alfabética'}, {value:'DESC',text:'Descendente'}]" name="" id="" class="btn btn-light" ng-model="order.by" ng-options="item as item.text for item in orderby track by item.value " ng-change="reorderProjectList()">
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
            <th>Gestor</th>
            <th>Prazo de Entrega</th>
            <th>Status</th>
            <th>Ação</th>
        </thead>
        <tbody>
            <tr ng-repeat="plan in plans | filter:atraso">
                <td>{{plan.name}}</td>
                <td>{{plan.description}}</td>
                <td>{{plan.gestor}}</td>
                <td>{{plan.deadline}}</td>
                <td>
                    <span class="badge badge-primary badge-{{ plan.status }}">
                                            {{ plan.status === "danger" ? "Em atraso" : "Atenção" }}
                                        </span>
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