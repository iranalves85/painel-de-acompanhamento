<div class="container" ng-controller="boasVindas">

    <h1>{{projeto.name}} / E-mail de Boas Vindas</h1>

    <div class="col-12 block card main">

        <div class="boasVindas">

            <form name="enviar-boas-vindas" method="post">
                <div class="row">

                    <div class="col-md-8">
                        <label for="responsible">
                                    Mensagem
                                </label>
                        <textarea name="mensagem" rows="10" ng-value="mensagem" ng-model="mensagem" class="form-control"></textarea>
                        <br />
                        <input class="btn btn-success float-right" type="submit" value="Enviar">
                    </div>
                    <div class="col-md-4">
                        <label for="responsible">
                                    Lista de E-mail
                                </label>
                        <select class="form-control" name="approver" ng-options="approver as approver.name for approver in fields.approvers track by approver.id" ng-model="approver" multiple>
                                </select>

                        <br />

                        <label for="model">
                                    Ou Selecionar grupo inteiro
                                </label>
                        <select class="form-control" name="approver" ng-options="approver as approver.name for approver in fields.approvers track by approver.id" ng-model="approver">
                                </select>

                    </div>

                </div>
            </form>
        </div>

    </div>

</div>