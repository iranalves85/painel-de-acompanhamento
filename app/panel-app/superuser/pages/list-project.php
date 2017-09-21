<div class="container" ng-controller="project">

    <h1>Projetos</h1>

    <div class="col-12 block card main">

        <div class="graficos-de-status text-center">
            <ul class="row list-inline">
                <li class="col">
                    <h2 class="text-center">Status do Projeto</h2>
                    <canvas id="status" width="150" height="150"></canvas>
                </li>
                <li class="col">
                    <h2 class="text-center">Planos</h2>
                    <canvas id="planos" width="150" height="150"></canvas>
                </li>
                <li class="col">
                    <h2 class="text-center">Prazos de Aprovação</h2>
                    <canvas id="prazos" width="150" height="150"></canvas>
                </li>
            </ul>
        </div>
    </div>

    <div class="block card main">

        <div class="new-project" ng-model="newProject">

            <h2>
                Novo Projeto
            </h2>

            <form name="newProject" method="post" enctype="multipart/form-data" ng-submit="submit()">
                <div ng-include="'app/panel-app/superuser/pages/new/company.php'"></div>
            </form>

        </div>

    </div>

    <div class="col-12 project card block">

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
                        <select name="" id="" class="btn btn-primary" ng-model="order">
                            <option  selected>Ordernar</option>
                            <option value="company">Empresa</option>
                            <option value="responsible">Responsável</option>                            
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
                            <li class="list-inline-item"><a class="btn btn-sm" href="projects/edit/{{project.id}}">Editar</a></li>
                            <li class="list-inline-item"><a class="btn btn-sm btn-danger" href="projects/delete/{{project.id}}">Excluir</a></li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Lista de Projetos -->

</div>
<!-- container -->