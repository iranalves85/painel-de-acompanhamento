<div class="container" ng-controller="model">

    <h1>Modelos</h1>

    <div class="col-12 project block card block">

        <ul class="list-inline">
            <li class="list-inline-item">
                <h2 class="titulo-secao">
                    Lista de Modelos
                </h2>
            </li>
            <li class="list-inline-item">
                <a class="btn btn-sm btn-primary" href="painel#!/model/new/">
                    Adicionar Modelo
                </a>
            </li>
            <li class="list-inline-item float-right">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <select ng-init="order = [{value:'date_created',text:'Recentes'}, {value:'name',text:'Nome'}, {value:'description',text:'Descrição'}]" name="" id="" class="btn btn-light" ng-model="order.order" ng-options="item as item.text for item in order track by item.value" ng-change="reorderModelList()">
                        </select>
                    </li>
                    <li class="list-inline-item">
                        <select ng-init="orderby = [{value:'ASC',text:'Alfabética'}, {value:'DESC',text:'Descendente'}]" name="" id="" class="btn btn-light" ng-model="order.by" ng-options="item as item.text for item in orderby track by item.value " ng-change="reorderModelList()">
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
                            <li class="list-inline-item"><a class="btn btn-sm" href="painel#!/model/edit/{{model.id}}">Editar</a></li>
                            <li class="list-inline-item">
                                <button class="btn btn-sm btn-danger" ng-click="delete(model.id)">Excluir</button>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Lista de Projetos -->
</div>
<!-- container -->