function disableDefaultLinkAction() {
    menu = document.querySelector('div.menu').querySelectorAll('a.btn');
    this.addEventListener('click', function(e) {
        e.preventDeafult();
    });
}

//Função padrão para requisições de GET via objeto Angular
function getData($http, $url, $returnFunction) {

    var $dataReturn;
    //Retorna os dados
    $http.get($url).then(function(response) {
        //Atribuindo valores a$scope de escopo do controller
        if (response.data && response.status == 200) {
            $dataReturn = $returnFunction(response);
        }
    });

    return $dataReturn;
}

//Função padrão para requisições de GET via objeto Angular
function postData($obj, $url, $aditional, $data, $returnFunction) {

    var $dataReturn;
    if ($aditional == undefined) {
        $aditional = "";
    }

    $obj.http({
        url: $url + $aditional,
        method: 'POST',
        //Função formatar as$scopeiaveis de forma a funcionar na requisição
        transformRequest: function(data) { return $obj.serializer(data); },
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        data: $data
    }).then(function(response) {

        loading(function() {
            $dataReturn = $returnFunction(response);
            if ($obj.scope != undefined) {
                $obj.scope.$apply();
            }
        }); //Tela de loading
    });

    return $dataReturn;
}

//Função padrão para requisições de GET via objeto Angular
function updateData($obj, $url, $aditional, $data, $returnFunction) {

    var $dataReturn;
    if ($aditional == undefined) {
        $aditional = "";
    }

    $obj.http({
        url: $url + $aditional,
        method: 'PUT',
        //Função formatar as$scopeiaveis de forma a funcionar na requisição
        transformRequest: function(data) { return $obj.serializer(data); },
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        data: $data
    }).then(function(response) {
        loading(function() {
            $dataReturn = $returnFunction(response);
            if ($obj.scope != undefined) {
                $obj.scope.$apply();
            }
        }); //Tela de loading
    });

    return $dataReturn;
}

//Função padrão para requisições de DELETE
function deleteData($http, $url, $returnFunction) {

    var $dataReturn;

    $http({
        url: $url,
        method: 'DELETE'
    }).then(function(response) {
        loading(function() {
            $dataReturn = $returnFunction(response);
        }); //Tela de loading        
    });

    return $dataReturn;
}

//Carrega loading antes de requisições POST, PUT ou DELETE
function loading($fn) {
    jQuery('body').append("<div class='loading'><img src='assets/images/loading.gif' /></div>");
    setTimeout(function() {
        $fn();
    }, 680);
}

//Gerar gráficos
function generateProjectChart($id, $data) {

    //Valores
    $values = [
        $data.default.value,
        $data.warning.value,
        $data.danger.value
    ];

    //Labels
    $label = [
        $data.default.badge,
        $data.warning.badge,
        $data.danger.badge
    ];

    var ctx = document.getElementById($id).getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: $values,
                backgroundColor: [
                    '#007bff', //Azul
                    '#ffc107', //Amarelo
                    '#dc3545' //Vermelho
                ],
                label: 'Dataset 1'
            }],
            labels: $label
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 5,
                    fontSize: 10
                }
            }
        }
    });

}

//Gerar gráficos planos aprovados
function generateApprovedChart($id, $data) {

    //Valores
    $values = [
        $data.default.value,
        //$data.finished.value,
        $data.approved.value
    ];

    //Labels
    $label = [
        $data.default.badge,
        //$data.finished.badge,
        $data.approved.badge
    ];

    var ctx = document.getElementById($id).getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: $values,
                backgroundColor: [
                    '#306fb3', //Azul
                    //'#771f60', //Roxo
                    '#28a745' //Verde
                ],
                label: 'Dataset 1'
            }],
            labels: $label
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 5,
                    fontSize: 10
                }
            }
        }
    });

}