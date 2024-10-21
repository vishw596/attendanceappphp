<?php
session_start();
unset($_SESSION['current_admin']);
session_destroy();
$rv=[];
echo json_encode($rv);
?>