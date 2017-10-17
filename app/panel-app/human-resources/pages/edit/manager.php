<div class="container" ng-controller="editManager">

    <h1>Projeto / Gestores</h1>

    <div class="col-12 block card main">

        <div class="new-project">

            <h2>Atualizar Gestor</h2>

            <form name="add-manager" method="post" ng-submit="editUser()">
                <div class="row">
                    <div class="col-md-3">
                        <label for="responsible">
                            Nome Completo
                        </label>
                        <input type="text" name="name" ng-value="name" ng-model="manager.username" class="form-control" ng-required="required" placeholder="Insira o nome completo do usuário" />
                    </div>
                    <div class="col-md-3">
                        <label for="responsible">
                            E-mail
                        </label>
                        <input type="email" name="email" ng-value="name" class="form-control" ng-model="manager.email" ng-required="required" placeholder="Insira um e-mail válido." ng-disabled="id == user" />
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
                        <ul class="list-item  float-right">
                            <li class="list-inline-item">
                                <a onclick="window.history.back();" href="" class="btn btn-light">Voltar</a>
                            </li>
                            <li class="list-inline-item">
                                <input class="btn btn-success" type="submit" value="Atualizar">
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>