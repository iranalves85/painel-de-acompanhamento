<?php
    /*
    *  Template: Manager
    *  30/08/2017
    */
?>
<!DOCTYPE html>
<html ng-app="gafp-panel">

<head>
    <title><?php echo $_SESSION['user']['email']; ?> | | GPTW - Painel de Acompanhamento - Gestor</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="assets/css/main.css" crossorigin="anonymous">
    <script src="assets/js/main.js" type="text/javascript"></script>

    <!-- Angular -->
    <script src="node_modules/angular/angular.js"></script>
    <script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
    <script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
    <script src="node_modules/angular-route/angular-route.min.js"></script>
    <script src="app/panel-app/app.module.js"></script>
    <script src="app/panel-app/manager/manager.module.js"></script>
    <script src="app/panel-app/manager/manager.component.js"></script>
    
    <script>
        var user = {
            name: "<?php echo $_SESSION['user']['name']; ?>",
            email: "<?php echo $_SESSION['user']['email']; ?>",
        };
    </script>

</head>

<body class="panel panel-manager">    
    <main>
        <panel-app></panel-app>
    </main>
</body>

</html>