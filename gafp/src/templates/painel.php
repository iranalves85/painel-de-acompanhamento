<?php
/*
*  Template: Human Resources
*  30/08/2017
*/

/* Informações do usuário */

$type_user  = $_SESSION['user']['type_user'];
$username   = $_SESSION['user']['username'];
$email      = $_SESSION['user']['email'];

?>
<!DOCTYPE html>
<html ng-app="gafpApp">

<head>
<title><?php echo $email; ?> | GPTW - Painel de Acompanhamento</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<link rel="stylesheet" href="assets/css/main.css" crossorigin="anonymous">
<link rel="stylesheet" href="node_modules/angular-ui-bootstrap/dist/ui-bootstrap-csp.css" crossorigin="anonymous">
<!-- Jquery -->
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<!-- Angular -->
<script src="node_modules/angular/angular.js"></script>
<script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
<script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
<script src="node_modules/angular-route/angular-route.min.js"></script>
<script src="node_modules/angular-file-upload/dist/angular-file-upload.min.js"></script>
<script src="node_modules/angular-filter/dist/angular-filter.min.js"></script>

<?php 
    //Adiciona arquivos de acordo com o tipo de acesso
    foreach ($type_user as $access) {
?>
    <script src="app/panel-app/<?php echo $access . '/'. $access;  ?>.component.js"></script> 

<?php
    }
?>

<script src="http://momentjs.com/downloads/moment.js" /></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js" ></script>
<script src="assets/js/main.js" type="text/javascript"></script>
<script>
    var user = <?php echo json_encode($_SESSION['user']); ?>;
</script>

</head>

<body class="panel"> 
    
    <header class="topo">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <img src="assets/images/gptw-logo-app.png" width="45px" alt="GPTW - Painel de Acompanhamento" /><strong class="panel-name">Painel de Acompanhamento</strong>
                </div>
                <div class="col-6">
                    <ul class="list-inline float-right">
                        <li class="list-inline-item btn btn-sm">Bem vindo, <b><?php echo $username; ?></b></li>
                        <li class="list-inline-item"><a class="btn btn-sm btn-outline-light" href="logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header><!-- Topo -->

    <main>

        <div class="container">
            <!--<h1>Dashboard</h1>
            <div class="block card main">
                <div class="graficos-de-status text-center">
                    <ul class="row list-inline">
                        <li class="col">
                            <h2 class="text-center">Status do Projeto</h2>
                            <canvas id="status" width="150" height="150"></canvas>
                        </li>
                        <li class="col">
                            <h2 class="text-center">Status de Aprovações</h2>
                            <canvas id="planos" width="150" height="150"></canvas>
                        </li>
                        <li class="col">
                            <h2 class="text-center">Plano de Funcionários</h2>
                            <canvas id="prazos" width="150" height="150"></canvas>
                        </li>
                        <li class="col">
                            <h2 class="text-center">Plano Individual</h2>
                            <canvas id="prazos" width="150" height="150"></canvas>
                        </li>
                    </ul>
                </div>
            </div>-->
        </div>

        <?php 
            //Adiciona as tags para inserção de template angular
            foreach ($type_user as $app) {
                //include_once('app/panel-app/superuser/superuser.template.php');
                echo '<' . $app . '-app></'. $app . '-app>';
            }
        ?>

        <div class="modal-parent"></div><!-- modal -->
        
    </main>

    <footer class="footer">
        <div class="row">
            <div class="col-12">
                <h6>
                    GPTW - Painel de Acompanhamento - v0.1
                </h6>
            </div>
        </div>
    </footer><!-- Rodapé -->

</body>

</html>