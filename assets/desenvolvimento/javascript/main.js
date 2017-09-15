function disableDefaultLinkAction() {
    menu = document.querySelector('div.menu').querySelectorAll('a.btn');
    this.addEventListener('click', function(e) {
        e.preventDeafult();
    });
}

//Função padrão para requisições de data para campos
function requestFields($http, $url) {

    var $data;

    //Retorna os dados de empresas para alimentar 'select' autocomplete
    $http.get($url).then(function(response) {
        //Atribuindo valores a$scope de escopo do controller
        if (response.data.length <= 0) {
            return false;
        }

        $data = response.data;

    });

    return $data;
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