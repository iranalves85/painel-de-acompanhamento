<?php
    /*
    *  Template: Carrega os arquivos de acordo com o tipo de acesso
    *  30/08/2017
    */

    $type_user = '';
    
    if($type_user == 'superuser'): 

    elseif($type_user == 'manager'):
    
    elseif($type_user == 'human-resources'):

    else:
        include_once('content-manager.php');
    endif;  