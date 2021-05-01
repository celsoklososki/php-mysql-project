<?php
require 'includes/functions.php';

if(count($_POST) > 0)
{
    if($_GET['from'] == 'login')
    {
        $found = false; // assume not found

        $user = trim($_POST['username']);
        $pass = trim($_POST['password']);

        $found = findUser($user, $pass);

        if($found)
        {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user;
            header('Location: thankyou.php?from=login&username='.filterUserName($user));
            exit();
        }

        header('Location: index.php');
        exit();
    }
    elseif($_GET['from'] == 'signup')
    {
        if(checkSignUp($_POST) && saveUser($_POST))
        {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = trim($_POST['username']);
            header('Location: thankyou.php?from=signup&username='.filterUserName(trim($_POST['username'])));
            exit();
        }


        header('Location: index.php');
        exit();
    }
}

header('Location: index.php');
exit();
?>