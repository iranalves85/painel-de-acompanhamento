<div class="container" ng-controller="email">

    <h1>Projeto / E-mail de Cobrança</h1>

    <div class="col-12 block card main">

        <div class="cobranca">

            <form name="enviar-cobranca" method="post" ng-submit="sendEmail('charge')">
                <div class="row">
                    <div class="col-md-6">
                        <label for="mensagem">
                            Mensagem
                        </label>
                        <textarea id="charge" name="mensagem" rows="8" ng-model="email.msg" class="form-control" placeholder="Mensagem a ser enviada aos usuários pertecentes ao projeto."></textarea>
                    </div>
                    <div class="col">
                        <label for="responsible">
                            Lista de Usuários
                        </label>
                        <select class="form-control" size="7" name="emailList" ng-model="email.users" ng-options="user as user.username for user in users" multiple>
                        </select>
                    </div>
                    <div class="col">
                        <label for="model">
                            Ou Selecionar grupo inteiro
                        </label>
                        <select class="form-control" size="7" name="area" 
                        ng-model="email.areas" multiple>
                            <option value="" selected>Todos</option>
                            <option ng-repeat="area in areas" ng-value="area.name">{{area.name}}</option>          
                        </select>

                    </div>
                    <div class="col-12">
                        <br />
                        <input class="btn btn-success float-right" type="submit" value="Enviar">
                    </div>
                </div>
            </form>
        </div>

    </div><!-- .card -->

</div>