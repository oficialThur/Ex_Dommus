<?php

session_start();
 
// Verifica se o contador já foi iniciado na sessão
if(!isset($_SESSION['contador'])){
    // Se não, o inicializa com 0
    $_SESSION['contador'] = 0;
}
// Incrementa o contador a cada visita
$_SESSION['contador']++;
echo "Voce visitou a pagina ".$_SESSION['contador']." vezes.";

?>