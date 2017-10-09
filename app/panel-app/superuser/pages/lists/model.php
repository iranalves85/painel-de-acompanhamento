<div class="container" ng-controller="model">

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
                        <select name="" id="" class="btn btn-light" ng-model="order" ng-change="reorderList()">
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
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ação</th>
            </thead>
            <tbody>
                <tr ng-repeat="model in models | filter:pesquisa | orderBy:orderDefine:reverse">
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