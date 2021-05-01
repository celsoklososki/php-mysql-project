<?php
define('SALT', 'a_very_random_salt_for_this_app');
define('FILE_SIZE_LIMIT', 4000000);

define('DB_HOST',     '127.0.0.1');
define('DB_PORT',     '8889');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'final3015');

function connect()
{
    $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
    if (!$link)
    {
        echo mysqli_connect_error();
        exit;
    }

    return $link;
}


function findUser($user, $pass)
{
    $found = false;

    $link = connect();
    $hash = md5($pass . SALT);

    $query   = 'select * from users where email = "'.$user.'" and password = "'.$hash.'"';
    $results = mysqli_query($link, $query);

    if (mysqli_fetch_array($results))
    {
        $found = true;
    }

    mysqli_close($link);
    return $found;
}


function saveUser($data)
{
    $fname = trim($data['fname']);
    $lname = trim($data['lname']);
    $username   = trim($data['username']);
    $password   = md5($data['password']. SALT);

    $link    = connect();
    $query   = 'insert into users(fname, lname, email, password) values("'.$fname.'","'.$lname.'","'.$username.'","'.$password.'")';
    $success = mysqli_query($link, $query); 

    mysqli_close($link);
    return $success;
}


function checkSignUp($data)
{
    $valid = true;


    if( trim($data['fname'])            == '' ||
        trim($data['lname'])            == '' ||
        trim($data['username'])         == '' ||
        trim($data['password'])         == '' ||
        trim($data['verify_password'])  == '')
    {
        $valid = false;
    }
    elseif(!preg_match('/^([a-zA-Z]{2,15})$/i', trim($data['fname'])))
    {
        $valid = false;
    }
    elseif(!preg_match('/^([a-zA-Z]{2,15})$/i', trim($data['lname'])))
    {
        $valid = false;
    }
    elseif(!preg_match('/(([a-z]|[0-9])){5,}+@{1}(gmail\.com|gmail\.ca)$/i', trim($data['username'])))
    {
        $valid = false;
    }
    elseif(!preg_match('/((?=.*[a-z])(?=.*[0-9])(?=.*[!?|@])){8}/', trim($data['password'])))
    {
        $valid = false;
    }
    elseif($data['password'] != $data['verify_password'])
    {
        $valid = false;
    }

    return $valid;
}


function checkPost($file, $title, $price, $description)
{
    $valid = true;

    if($file['picture']['size'] > FILE_SIZE_LIMIT)
    {
        $valid = false;
    }
    elseif( $title               == '' ||
            $price               == '' ||
            $description         == '' )

    {
        $valid = false;
    }
    elseif(!preg_match('/[A-Za-z0-9-]+$/', $title))
    {
        $valid = false;
    }
    elseif(!preg_match('/^[0-9\.]+$/i', $price))
    {
        $valid = false;
    }
    elseif(!preg_match('/[A-Za-z0-9-\.\,]+$/', $description))
    {
        $valid = false;
    }

    return $valid;
}


function saveProfile($user, $title, $price, $description, $picture)
{

    $link   = connect();
    $query  = "INSERT INTO items (email, title, price, description, picture, pin, downvote) VALUES ('$user', '$title', '$price', '$description', '$picture', 'panel-info', '0')";
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    return $result;

}


function saveRecentView($user, $title, $price, $description, $picture, $fname, $lname, $product_id, $downvote)
{

    $link   = connect();
    $query  = "INSERT INTO recent_view (email, title, price, description, picture, fname, lname, product_id, downvote) VALUES ('$user', '$title', '$price', '$description', '$picture', '$fname', '$lname', '$product_id', '$downvote')";
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    return $result;

}


function updatePin($id, $pin)
{

    $link   = connect();

    if($pin == 'panel-info')
    {
        $query  = "update items set pin = 'panel-warning' where id = '$id'";
    }
    else if($pin == 'panel-warning')
    {
        $query  = "update items set pin = 'panel-info' where id = '$id'";
    }
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    return $result;

}


function updateDownvote($id, $value)
{
    $new_value = $value + 1;
    $link   = connect();
    $query  = "update items set downvote = '$new_value' where id = '$id'";
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    return $result;
}

function updateDownvoteRecentView($id, $value)
{
    $new_value = $value + 1;
    $link   = connect();
    $query  = "update recent_view set downvote = '$new_value' where product_id = '$id'";
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    return $result;
}


function filterUserName($name)
{
    
    return preg_replace("/[^a-z0-9]/i", '', $name);
}


function getAllProducts()
{
    $link     = connect();
    $query    = 'select items.id, items.email, items.title, items.price, items.description, items.picture, items.pin, items.downvote, users.fname, users.lname from items left join users on items.email = users.email order by field(pin, "panel-warning") desc';
    $products = mysqli_query($link, $query);

    mysqli_close($link);
    return $products;
}

function getAllSearch($search)
{
    $link     = connect();
    $query    = 'select items.id, items.email, items.title, items.price, items.description, items.picture, items.pin, items.downvote, users.fname, users.lname from items left join users on items.email = users.email where title RLIKE "'.$search.'"';
    $products = mysqli_query($link, $query);

    mysqli_close($link);
    return $products;
}

function getAllRecentProducts()
{
    $link     = connect();
    $query    = '(select * from recent_view order by id desc limit 4) order by fname asc, cast(price as decimal(10,2)) desc  limit 4';
    $recentProducts = mysqli_query($link, $query);

    mysqli_close($link);
    return $recentProducts;
}


function deleteProducts($id)
{
    $link    = connect();
    $query   = 'delete from items where id = "'.$id.'"';
    $success = mysqli_query($link, $query);

    mysqli_close($link);
    return $success;
}

function deleteRecentView($id)
{
    $link    = connect();
    $query   = 'delete from recent_view where product_id = "'.$id.'"';
    $success = mysqli_query($link, $query);

    mysqli_close($link);
    return $success;
}

