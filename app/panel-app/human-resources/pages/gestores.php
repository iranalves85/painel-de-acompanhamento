<div class="container" ng-controller="gestores">

    <h1>{{projeto.name}} / Gestores</h1>

    <div class="col-12 block card main">

        <div class="new-project">

            <h2>
                Novo Gestor
            </h2>

            <form action="projects" name="add-project" method="post" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-md-3">
                        <label for="responsible">
                            Nome Completo
                        </label>
                        <input type="text" name="name" ng-value="name" ng-model="name" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="responsible">
                            E-mail
                        </label>
                        <input type="email" name="email" ng-value="name" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="model">
                            Password
                        </label>
                        <input type="password" name="password" ng-value="password" ng-model="password" class="form-control" />
                    </div>

                    <div class="col-md-3">
                        <label for="business">
                            Área
                        </label>
                        <input type="text" name="area" ng-value="area.id" ng-model="area" uib-typeahead="company.company for company in companys | filter:$viewValue | limitTo:8" class="form-control" />
                    </div>
                    <div class="col-md-12">
                        <br />
                        <input class="btn btn-success float-right" type="submit" value="Cadastrar">
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="col-12 project card block">

        <ul class="list-inline">
            <li class="list-inline-item">
                <h2 class="titulo-secao">
                    Lista de Gestores
                </h2>
            </li>
            <li class="list-inline-item float-right">
                <input class="form-control" type="text" name="search" id="" placeholder="Pesquisa" ng-model="pesquisa">
            </li>
        </ul>

        <table class="table table-stripped table-bordered">
            <thead class="thead-inverse">
                <th>Nome</th>
                <th>E-mail</th>
                <th>Área</th>
                <th>Ação</th>
            </thead>
            <tbody>
                <tr ng-repeat="gestor in gestores | filter:pesquisa">
                    <td>{{gestor.name}}</td>
                    <td>{{gestor.email}}</td>
                    <td>{{gestor.area}}</td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="gestor/edit/{{plan.id}}">Editar</a></li>
                            <li class="list-inline-item"><a href="gestor/delete/{{plan.id}}">Excluir</a></li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Prazos de Aprovação -->

</div>