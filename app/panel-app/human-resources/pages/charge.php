<div class="container" ng-controller="email">

    <div class="col-12 block card main">

        <ul class="list-inline">
            <li class="list-inline-item">
                <h2 class="titulo-secao">
                    Projeto / E-mail de Cobrança
                </h2>
            </li>
            <li class="list-inline-item">
                <a onclick="window.history.back();" href="" class="btn btn-sm btn-secondary">Voltar</a>
            </li>
        </ul>

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
                        <ul class="list-inline float-right">                            
                            <li class="list-inline-item">
                                <input class="btn btn-success" type="submit" value="Enviar">
                            </li>
                        </ul>                        
                    </div>
                </div>
            </form>
        </div>

    </div><!-- .card -->

</div>