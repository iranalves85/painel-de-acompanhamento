<div class="container" ng-controller="rules">

    <h1>Projeto / Configuração de Regras</h1>

    <div class="regras">
        <form method="POST" name="definir-regras" ng-submit="defineRules()">
            <div class="row justify-content-end">
                
                <div class="col mr-2 block card">

                    <h2>Atenção <span class="text-center badge badge-warning">Exemplo de Alerta</span></h2>
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Quantidade</label>
                            <input class="form-control" type="number" min="1" name="warning[qtd]" ng-model="warning.qtd">
                        </div>
                        <div class="col-8">
                            <label>Mês / Dias / Horas</label>
                            <select class="form-control" name="warning[type]" ng-options="type as type.name for type in rules track by type.id" ng-model="warning.types"></select>
                        </div>
                    </div>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <input name="warning[conditional]" type="radio" value="0" selected="selected" ng-model="warning.conditional">Antes</li>
                        <li class="list-inline-item">
                            <input name="warning[conditional]" type="radio" value="1" ng-model="warning.conditional">Depois</li>
                    </ul>
                </div>

                <div class="col block card">
                    <h2>Em atraso <span class="text-center badge badge-danger">Exemplo de Alerta</span></h2>
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Quantidade</label>
                            <input class="form-control" type="number" min="1" name="danger[qtd]" ng-model="danger.qtd">
                        </div>
                        <div class="col-8">
                            <label>Mês / Dias / Horas</label>
                            <select class="form-control" name="danger[type]" ng-options="type as type.name for type in rules track by type.name" ng-model="danger.types"></select>
                        </div>
                    </div>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <input name="danger[conditional]" type="radio" value="0" ng-model="danger.conditional" selected="selected">Antes</li>
                        <li class="list-inline-item">
                            <input name="danger[conditional]" type="radio" value="1" ng-model="danger.conditional">Depois</li>
                    </ul>                    
                </div>

                <div class="col-12">
                    <br />
                    <input class="btn btn-success float-right" type="submit" value="Enviar">
                </div>
                
            </div>
            
        </form>
    </div>

</div>