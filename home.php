<?php
require 'includes/functions.php';
$message = '';
session_start();

if(!isset($_SESSION['username']))
{
    header('Location: index.php');
    exit();
}

if(count($_POST) > 0)
{
    $user = $_SESSION['username'];
    $title = trim($_POST['title']);
    $price = trim($_POST['price']);
    $desc = trim($_POST['description']);
    $check = checkPost($_FILES, $title, $price, $desc);
    if($check)
    {
        $picture = md5($user.time());
        move_uploaded_file($_FILES['picture']['tmp_name'], 'products/'.$picture);
        saveProfile($user, $title, $price, $desc, $picture);
    }
}
$products = getAllProducts();
$recentProducts = getAllRecentProducts();
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Project</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div id="wrapper">

    <div class="container">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1 class="login-panel text-center text-muted">
                    PHP Project
                </h1>
                <hr/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <button class="btn btn-default" data-toggle="modal" data-target="#newItem"><i class="fa fa-photo"></i> New Item</button>
                <a href="logout.php" class="btn btn-default pull-right"><i class="fa fa-sign-out"> </i> Logout</a>
            </div>
        </div>



        <div class="row">
            <div class="col-md-3">
                <h2 class="login-panel text-muted">
                    Recently Viewed
                </h2>
                <hr/>
            </div>
        </div>



        <!-- RECENTELY VIEWED -->
        <div class="row">

        <?php
        foreach($recentProducts as $recentProduct)
        {
            if($recentProduct['downvote'] <= 5)
            {
            echo '
                    <div class="col-md-3">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                    '.$recentProduct['title'].'';

            if($recentProduct['email'] == $_SESSION['username'])
            {
                echo '
                                <span class="pull-right text-muted">
                                    <a class="" href="delete.php?id='.$recentProduct['product_id'].'" data-toggle="tooltip" title="Delete item">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </span>';
            }
            echo '
                    </div>
                        <div class="panel-body text-center">
                            <p>
                                <a href="product.php?from=loggedin&=&title='.$recentProduct['title'].'&picture='.$recentProduct['picture'].'&description='.$recentProduct['description'].'&email='.$recentProduct['email'].'&price='.$recentProduct['price'].'&fname='.$recentProduct['fname'].'&lname='.$recentProduct['lname'].'&id='.$recentProduct['product_id'].'">
                                    <img class="img-rounded img-thumbnail" src="products/'.$recentProduct['picture'].'"/>
                                </a>
                            </p>
                            <p class="text-muted text-justify">
                                '.$recentProduct['description'].'
                            </p>
                            <a class="pull-left" href="downvote.php?value='.$recentProduct['downvote'].'&id='.$recentProduct['product_id'].'" data-toggle="tooltip" title="Downvote item">
                                <i class="fa fa-thumbs-down"></i>
                            </a>
                        </div>';
            
            echo '
            
                        <div class="panel-footer ">
                        <span><a href="mailto:'.$recentProduct['email'].'" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> '.$recentProduct['fname'].' '.$recentProduct['lname'].'</a></span>
                        <span class="pull-right">$ '.$recentProduct['price'].'</span>
                    </div>
                </div>
            </div>';
            }
        }

        ?>

        </div>


        <div class="row">

            <div class="col-md-3">
                <h2 class="login-panel text-muted">
                    Items For Sale
                </h2>
                <hr/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                    <form class="form-inline" name="search" role="form" method="get" action="searchlog.php?search=get">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                <input type="text" name="search" class="form-control" placeholder="Search"/>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-default" value="Search"/>
                        <!-- <button class="btn btn-default" data-toggle="tooltip" title="Shareable Link!"><i class="fa fa-share"></i></button> -->
                    </form>
                <br/>
            </div>
        </div>




        <!-- ITEMS FOR SALE -->
        <div class="row">

        <?php
        foreach($products as $product)
        {
            if($product['downvote'] <= 5)
            {
            echo '
                    <div class="col-md-3">
                        <div class="panel';

            if($_SESSION['username'])
            {
                echo ' '.$product['pin'].'">';
            }            
            
            echo '
                            <div class="panel-heading">
                                <a class="" href="pin.php?id='.$product['id'].'&pin='.$product['pin'].'" data-toggle="tooltip" title="Pin item">
                                    <i class="fa fa-dot-circle-o"></i>
                                </a>
                                <span>
                                    '.$product['title'].'
                                </span>';

            if($product['email'] == $_SESSION['username'])
            {
                echo '
                                <span class="pull-right">
                                <a class="" href="delete.php?id='.$product['id'].'" data-toggle="tooltip" title="Delete item">
                                    <i class="fa fa-trash"></i>
                                </a>
                                </span>';

            }

            echo '
                    </div>
                        <div class="panel-body text-center">
                            <p>
                                <a href="product.php?from=loggedin&=&title='.$product['title'].'&picture='.$product['picture'].'&description='.$product['description'].'&email='.$product['email'].'&price='.$product['price'].'&fname='.$product['fname'].'&lname='.$product['lname'].'&id='.$product['id'].'&downvote='.$product['downvote'].'">
                                    <img class="img-rounded img-thumbnail" src="products/'.$product['picture'].'"/>
                                </a>
                            </p>
                            <p class="text-muted text-justify">
                                '.$product['description'].'
                            </p>
                            <a class="pull-left" href="downvote.php?value='.$product['downvote'].'&id='.$product['id'].'" data-toggle="tooltip" title="Downvote item">
                                <i class="fa fa-thumbs-down"></i>
                            </a>
                        </div>';

            echo '
                        <div class="panel-footer ">
                            <span><a href="mailto:'.$product['email'].'" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> '.$product['fname'].' '.$product['lname'].'</a></span>
                            <span class="pull-right">'.$product['price'].'</span>
                        </div>
                    </div>
                </div>';
            }    
        }
        ?>

    </div>
</div>



<!-- NEW ITEM MODAL -->
<div id="newItem" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <form role="form" method="post" action="home.php" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">New Item</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input 
                        class="form-control"
                        name = "title" 
                        type="text"
                        placeholder = "Title"
                        autofocus>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input 
                        class="form-control" 
                        name = "price"
                        type="text"
                        placeholder = "Price">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input 
                        class="form-control" 
                        name = "description"
                        type="text"
                        placeholder = "Description">
                </div>
                <div class="form-group">
                    <label>Picture</label>
                    <input 
                        class="form-control" 
                        type="file"
                        name = "picture">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Post Item!"/>
            </div>
        </div><!-- /.modal-content -->
    </form>
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</html>
