<div class="col-12 project card block" ng-controller="planListActivity">

    <ul class="list-inline">
        <li class="list-inline-item">
            <h2 class="titulo-secao">
                Atividades do Plano
            </h2>
        </li>
        <li class="list-inline-item">
            <a href="painel#!/plan/{{id}}/activity/new/" class="btn btn-sm btn-primary">
                Adicionar Nova Atividade
            </a>
        </li>
        <li class="list-inline-item float-right">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <input class="form-control" type="text" name="search" id="" placeholder="Pesquisa" ng-model="pesquisa">
                </li>
            </ul>
        </li>
    </ul>

    <table class="table table-striped table-bordered">
        <thead class="thead-inverse">
            <th>Atividade</th>
            <th>Descrição</th>
            <th>Data de criação</th>
            <th>Prazo de Entrega</th>
            <th>Status</th>
            <th>Ação</th>
        </thead>
        <tbody>
            <tr ng-repeat="activity in activitys | filter:pesquisa">
                <td>{{activity.name}}</td>
                <td>{{activity.description}}</td>
                <td>{{activity.date_created}}</td>
                <td>
                    {{activity.moment}}
                    <span class="badge badge-primary badge-{{ activity.rule }}">
                        {{ activity.rule }}
                    </span>
                </td>
                <td>
                    {{activity.statusText}}                    
                </td>
                <td>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a class="btn btn-sm btn-primary" href="painel#!/plan/activity/edit/{{activity.id}}">Editar</a></li>
                        <li class="list-inline-item">
                            <button class="btn btn-sm btn-danger" 
                            ng-click="delete(activity.id)">Excluir</button>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

    <ul class="list-inline">
        <li class="list-inline-item float-right">
            <ul class="list-inline">
                <li class="list-inline-item">
                <a class="btn btn-light float-right" href="painel#!/" >Voltar</a>
                </li>
            </ul>
        </li>
    </ul>    

</div>
<!-- Minhas Atividades -->