<?php

session_start();

$_SERVER['contador'] = 'nome_do_contador'; 

if(!isset($_SERVER['contador'] )){
    $_SERVER['contador'] = 0;
};

$_SERVER['contador']++;

echo "Voce visitou a pagina".$_SERVER['contador']." vezes.";

?>