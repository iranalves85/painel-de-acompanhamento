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