<div class="container" ng-controller="manager">

    <h1>Projeto / Gestores</h1>

    <div class="col-12 block card main">

        <div class="new-project">

            <h2>Novo Gestor</h2>

            <form name="add-manager" method="post" ng-submit="newUser()">
                <div class="row">

                    <div class="col-md-3">
                        <label for="responsible">
                            Nome Completo
                        </label>
                        <input type="text" name="name" ng-value="name" ng-model="manager.name" class="form-control" ng-required="required" placeholder="Insira o nome completo do usuário" />
                    </div>
                    <div class="col-md-3">
                        <label for="responsible">
                            E-mail
                        </label>
                        <input type="email" name="email" ng-value="name" class="form-control" ng-model="manager.email" ng-required="required" placeholder="Insira um e-mail válido." />
                    </div>
                    <div class="col-md-3">
                        <label for="model">
                            Password
                        </label>
                        <input type="text" name="password" ng-value="password" ng-model="manager.password" class="form-control" ng-required="required" placeholder="******" />
                    </div>

                    <div class="col-md-3">
                        <label for="business">
                            Área / Departamento
                        </label>
                        <input type="text" name="area" ng-value="area" ng-model="manager.area" class="form-control" ng-required="required"  placeholder="Insira as áreas na qual o usuário faz parte." />
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

        <table class="table table-striped table-sm table-bordered">
            <thead>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Área / Departamento</th>
                <th>Ação</th>
            </thead>
            <tbody>
                <tr ng-repeat="gestor in users | filter:pesquisa">
                    <td>{{gestor.username}}</td>
                    <td>{{gestor.email}}</td>
                    <td>
                        <ul>
                            <li ng-repeat="area in gestor.area">
                                {{area}}
                            </li>                            
                        </ul>
                    </td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="btn btn-sm" href="painel#!/projects/manager/edit/{{gestor.id}}">Editar</a>
                            </li>
                            <li class="list-inline-item">
                                <button type="button" class="btn btn-sm btn-danger" ng-click="deleteUser(gestor.id)">Excluir</a>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Prazos de Aprovação -->

</div>