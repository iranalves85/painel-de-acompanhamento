<div class="container" ng-controller="rules">

    <div class="regras block card">

        <ul class="list-inline">
            <li class="list-inline-item">
                <h2 class="titulo-secao">
                    Projeto / Configuração de Regras
                </h2>
            </li>
            <li class="list-inline-item">
                <a onclick="window.history.back();" href="" class="btn btn-sm btn-secondary">Voltar</a>
            </li>
        </ul>

        <form method="POST" class="col-12" name="definir-regras" ng-submit="defineRules()">
            <div class="row">
                
                <div class="col mr-2 block card">

                    <h2>Atenção <span class="text-center badge badge-warning">Exemplo de Alerta</span></h2>
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Quantidade</label>
                            <input class="form-control" type="number" min="1" name="warning[qtd]" ng-model="warning.qtd" ng-required="required">
                        </div>
                        <div class="col-8">
                            <label>Mês / Dias / Horas</label>
                            <select class="form-control" name="warning[type]" ng-options="type as type.name for type in rules track by type.id" ng-model="warning.types" ng-required="required"></select>
                        </div>
                    </div>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <label for="warning[conditional]" class="custom-control custom-radio">
                                <input id="warning[conditional]" type="radio" value="0" selected="selected" ng-model="warning.conditional" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">
                                    Antes
                                </span>
                            </label>
                        </li>
                        <li class="list-inline-item">
                            <label for="warning[conditional][after]" class="custom-control custom-radio">
                                <input id="warning[conditional][after]" type="radio" value="1" ng-model="warning.conditional" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">
                                   Depois
                                </span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="col block card">
                    <h2>Em atraso <span class="text-center badge badge-danger">Exemplo de Alerta</span></h2>
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Quantidade</label>
                            <input class="form-control" type="number" min="1" name="danger[qtd]" ng-model="danger.qtd" ng-required="required">
                        </div>
                        <div class="col-8">
                            <label>Mês / Dias / Horas</label>
                            <select class="form-control" name="danger[type]" ng-options="type as type.name for type in rules track by type.name" ng-model="danger.types" ng-required="required"></select>
                        </div>
                    </div>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <label for="danger[conditional]" class="custom-control custom-radio">
                                <input id="danger[conditional]" type="radio" value="0" selected="selected" ng-model="danger.conditional" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">
                                    Antes
                                </span>
                            </label>
                        </li>
                        <li class="list-inline-item">
                            <label for="danger[conditional][after]" class="custom-control custom-radio">
                                <input id="danger[conditional][after]" type="radio" value="1" ng-model="danger.conditional" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">
                                Depois
                                </span>
                            </label>
                        </li>
                    </ul>                    
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

</div>