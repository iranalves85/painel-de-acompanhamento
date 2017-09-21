<?php
    /*
    *  Template: SuperUser
    *  30/08/2017
    */
?>
<!DOCTYPE html>
<html ng-app="gafp-panel">

<head>
    <title><?php echo $_SESSION['user']['email']; ?> | GPTW - Painel de Acompanhamento</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    
    <link rel="stylesheet" href="assets/css/main.css" crossorigin="anonymous">
    <link rel="stylesheet" href="node_modules/angular-ui-bootstrap/dist/ui-bootstrap-csp.css" crossorigin="anonymous">
    <script src="assets/js/main.js" type="text/javascript"></script>

    <!-- Angular -->
    <script src="node_modules/angular/angular.js"></script>
    <script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
    <script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
    <script src="node_modules/angular-route/angular-route.min.js"></script>
    <script src="app/panel-app/app.module.js"></script>
    <script src="app/panel-app/superuser/superuser.module.js"></script>
    <script src="app/panel-app/superuser/superuser.component.js"></script>
    <script src="http://momentjs.com/downloads/moment.js" /></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js" ></script>
    
    <script>
        var user = {
            name: "<?php echo $_SESSION['user']['username']; ?>",
            email: "<?php echo $_SESSION['user']['email']; ?>",
        };
    </script>

</head>

<body class="panel panel-superuser">    
    <main>
        <panel-app></panel-app>
    </main>
</body>

</html>