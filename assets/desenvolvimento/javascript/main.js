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
        $dataReturn = $returnFunction(response);
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
        $dataReturn = $returnFunction(response);
    });

    return $dataReturn;
}

function generateCharts($id) {

    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };

    var ctx = document.getElementById($id).getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
                backgroundColor: [
                    'blue',
                    'red',
                    'green'
                ],
                label: 'Dataset 1'
            }],
            labels: [
                "Em Progresso",
                "Em Atraso",
                "Finaliza"
            ]
        },
        options: {
            responsive: true
        }
    });

}