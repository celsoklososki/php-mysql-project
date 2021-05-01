<?php
require 'includes/functions.php';

session_start();
if(!isset($_SESSION['loggedin']))
{
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];
$pin = $_GET['pin'];

if (preg_match("/^[0-9]+$/", $id))
{
    updatePin($id, $pin);
}

header('Location: home.php');
exit();
?>
