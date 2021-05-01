<?php
require 'includes/functions.php';

session_start();
if(!isset($_SESSION['loggedin']))
{
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];
$value = $_GET['value'];

if (preg_match("/^[0-9]+$/", $id))
{
    updateDownvote($id, $value);
    updateDownvoteRecentView($id, $value);
}

header('Location: home.php');
exit();
?>