<div class="container" ng-controller="modelo">

    <h1>Modelos</h1>

    <div class="col-12 project block card block">

        <ul class="list-inline">
            <li class="list-inline-item">
                <h2 class="titulo-secao">
                    Lista de Modelos
                </h2>
            </li>
            <li class="list-inline-item">
                <a class="btn btn-sm btn-primary" href="#modal">
                    Adicionar Modelo
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
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ação</th>
            </thead>
            <tbody>
                <tr ng-repeat="model in models | filter:pesquisa">
                    <td>{{model.id}}</td>
                    <td>{{model.model}}</td>
                    <td>{{model.description}}</td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a class="btn btn-sm" href="model/edit/{{model.id}}">Editar</a></li>
                            <li class="list-inline-item"><a class="btn btn-sm btn-danger" href="model/delete/{{model.id}}">Excluir</a></li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Lista de Projetos -->
</div>
<!-- container -->