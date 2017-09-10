<?php
    /*
    *  Template: Manager
    *  30/08/2017
    */
?>
<html ng-app="gafp-panel">

<head>
    <title>{{ usuario.ambiente }} | GPTW - Painel de Acompanhamento</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="assets/css/main.css" crossorigin="anonymous">
    <script src="assets/js/main.js" type="text/javascript"></script>

    <!-- Angular -->
    <script src="node_modules/angular/angular.js"></script>
    <script src="app/panel-app/app.module.js"></script>
    <script src="app/panel-app/manager/manager.module.js"></script>
    <script src="app/panel-app/manager/manager.component.js"></script>    

</head>

<body class="panel panel-manager">    
    <main>
        <panel-app></panel-app>
    </main>
</body>

</html>