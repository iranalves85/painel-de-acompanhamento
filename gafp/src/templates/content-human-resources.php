<?php
/*
*  Template: Human Resources
*  30/08/2017
*/
?>
<html ng-app="gafp-human-resources">

<head>
<title>{{usuario.ambiente}} | GPTW - Painel de Acompanhamento</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="assets/css/main.css" crossorigin="anonymous">
<script src="assets/js/main.js" type="text/javascript"></script>

<!-- Angular -->
<script src="node_modules/angular/angular.js"></script>
<script src="app/painel-app/painel-app.module.js"></script>
<script src="app/painel-app/painel-app.component.js"></script>    

</head>

<body class="panel panel-human-resources">    
<main  class="row">
    <header-app></header-app>
    <column-app></column-app>
    <panel-app></panel-app>
</main>
</body>

</html>