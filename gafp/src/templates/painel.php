<?php
    /*
    *  Template: Carrega os arquivos de acordo com o tipo de acesso
    *  30/08/2017
    */
    $type_user = $_SESSION['user']['type_user'];

    switch ($type_user) {
        case 'superuser':
            include_once('content-superuser.php');
            break;
        case 'human-resources':
            include_once('content-human-resources.php');
            break;
        case 'manager':
            include_once('content-manager.php');
            break;        
        default:
            echo "Erro";
            break;
    }