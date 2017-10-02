<div class="container" ng-controller="regras">

    <h1>{{projeto.name}} / Configuração de Regras</h1>

    <div class="regras">
        <form method="POST" name="definir-regras" ng-submit="defineRules()">
            <div class="row justify-content-end">
                
                <div class="col mr-2 block card">

                    <h2>Atenção <span class="text-center badge badge-warning">Exemplo de Alerta</span></h2>
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Quantidade</label>
                            <input class="form-control" type="number" min="1" name="yellow[qtd]" ng-model="yellow.qtd">
                        </div>
                        <div class="col-8">
                            <label>Mês / Dias / Horas</label>
                            <select class="form-control" name="yellow[type]" ng-options="type as type.name for type in fields.types track by type.name" ng-model="yellow.types"></select>
                        </div>
                    </div>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <input name="yellow[conditional]" type="radio" value="0" selected="selected" ng-model="yellow.conditional">Antes</li>
                        <li class="list-inline-item">
                            <input name="yellow[conditional]" type="radio" value="1" ng-model="yellow.conditional">Depois</li>
                    </ul>
                </div>

                <div class="col block card">
                    <h2>Em atraso <span class="text-center badge badge-danger">Exemplo de Alerta</span></h2>
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Quantidade</label>
                            <input class="form-control" type="number" min="1" name="red[qtd]" ng-model="red.qtd">
                        </div>
                        <div class="col-8">
                            <label>Mês / Dias / Horas</label>
                            <select class="form-control" name="red[type]" ng-options="type as type.name for type in fields.types track by type.name" ng-model="red.types"></select>
                        </div>
                    </div>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <input name="red[conditional]" type="radio" value="0" ng-model="red.conditional" selected="selected">Antes</li>
                        <li class="list-inline-item">
                            <input name="red[conditional]" type="radio" value="1" ng-model="red.conditional">Depois</li>
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