<div class="container" ng-controller="projects">

    <h1>Projetos</h1>

    <div class="col-12 project card block">

        <ul class="list-inline">
            <li class="list-inline-item">
                <h2 class="titulo-secao">
                    Meus projetos
                </h2>
            </li>
            <li class="list-inline-item float-right">
                <input class="form-control" type="text" name="search" id="" placeholder="Pesquisa" ng-model="prazo">
            </li>
        </ul>

        <table class="table table-striped table-sm table-bordered">
            <thead>
                <th>Responsável</th>
                <th>Aprovação</th>
                <th>Ação</th>
            </thead>
            <tbody>
                <tr ng-repeat="project in projects | filter:prazo">
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item badge badge-dark" ng-repeat="responsible in project.responsible">{{responsible.username}}</li>
                        </ul>
                    </td>
                    <td>{{project.approver}}</td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="btn btn-sm" href="painel#!/projects/cobranca/{{project.id}}">E-mail de Cobrança</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-sm" href="painel#!/projects/boas-vindas/{{project.id}}">E-mail de Boas-Vindas</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-sm" href="painel#!/projects/gestores/{{project.id}}">Gestores</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-sm" href="painel#!/projects/regras/{{project.id}}">Definir Regras</a>
                            </li>                            
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Prazos de Aprovação -->

</div>