<div class="project card block" ng-controller="project">

    <ul class="list-inline">
        <li class="list-inline-item">
            <h2 class="titulo-secao">
                Lista de Projetos
            </h2>
        </li>
        <li class="list-inline-item">
            <a href="#" class="btn btn-sm btn-primary">
                Adicionar Projeto
            </a>
        </li>
        <li class="list-inline-item float-right">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <select ng-init="order = [{value:'date_created',text:'Recentes'}, {value:'company',text:'Empresas'}, {value:'responsible',text:'Responsáveis'}]" name="" id="" class="btn btn-light" ng-model="order.data" ng-options="item as item.text for item in order track by item.value" ng-change="reorderProjectList()">
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
            <th>ID</th>
            <th>Empresa</th>
            <th>Modelo</th>
            <th>Responsável</th>
            <th>Aprovação</th>
            <th>Ação</th>
        </thead>
        <tbody>
            <tr ng-repeat="project in projects | filter:pesquisa">
                <td>{{project.id}}</td>
                <td>{{project.company}}</td>
                <td>{{project.model}}</td>
                <td>{{project.responsible}}</td>
                <td>{{project.approver}}</td>
                <td>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="btn btn-sm" href="painel#!/projects/edit/{{project.id}}">Editar</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-sm btn-danger delete" id="{{project.id}}" href="projects/delete/{{project.id}}">Excluir</a>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<!-- Lista de Projetos -->