<div class="project card block" ng-controller="project">

    <ul class="list-inline">
        <li class="list-inline-item">
            <h2 class="titulo-secao">
                Lista de Projetos
            </h2>
        </li>
        <li class="list-inline-item">
            <a href="painel#!/projects/new/" class="btn btn-sm btn-primary">
                Adicionar Projeto
            </a>
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
            <th>ID</th>
            <th>Criado</th>
            <th>Empresa</th>
            <th>Modelo</th>
            <th>Responsável</th>
            <th>Aprovação</th>
            <th>Ação</th>
        </thead>
        <tbody>
            <tr ng-repeat="project in projects | filter:pesquisa | orderBy:orderDefine:reverse">
                <td>{{project.id}}</td>
                <td>{{project.date_created | date:'Y-m-d'}}</td>
                <td>{{project.company}}</td>
                <td>{{project.model}}</td>
                <td>
                    <ul>
                        <li ng-repeat="responsible in project.responsible">{{responsible.username}}</li>
                    </ul>
                </td>
                <td>{{project.approver}}</td>
                <td>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="btn btn-sm" href="painel#!/projects/edit/{{project.id}}">Editar</a>
                        </li>
                        <li class="list-inline-item">
                            <button class="btn btn-sm btn-danger" ng-click="delete(project.id)">Excluir</button>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<!-- Lista de Projetos -->