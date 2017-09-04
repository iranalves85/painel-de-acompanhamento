<?php
    /*
    *  Template: Login
    *  30/08/2017
    */
?>
<html ng-app="gafp">

<head>
    <title>GPTW - Painel de Acompanhamento de plano de ações</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="assets/css/main.css" crossorigin="anonymous">
    <script src="assets/js/main.js" type="text/javascript"></script>

    <!-- Angular -->
    <script src="node_modules/angular/angular.js"></script>
    <script src="app/app.module.js"></script>
    <script src="app/painel-app/painel-app.module.js"></script>
    <script src="app/painel-app/painel-app.component.js"></script>
    <script src="app/login-app/login-app.module.js"></script>
    <script src="app/login-app/login-app.component.js"></script>

</head>

<body>
    
    <main>
        <section class="col-sm-4">
            <aside>
                <painel-actions></painel-app>
            </aside>
        </section>
        <section class="col-sm-8">
                <painel-app></painel-app>
        </section>
    </main>
    

</body>

</html>