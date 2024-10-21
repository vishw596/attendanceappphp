<?php
session_start();
unset($_SESSION['current_user']);
session_destroy();
$rv=[];
echo json_encode($rv);
?>