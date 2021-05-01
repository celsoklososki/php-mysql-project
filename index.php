<?php
require 'includes/functions.php';
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
                <a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"> </i> Login</a>
                <a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#signup"><i class="fa fa-user"> </i> Sign Up</a>
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
                                    '.$recentProduct['title'].'
                            </div>';

            echo '
                        <div class="panel-body text-center">
                            <p>
                                <a href="product.php?from=loggedin&=&title='.$recentProduct['title'].'&picture='.$recentProduct['picture'].'&description='.$recentProduct['description'].'&email='.$recentProduct['email'].'&price='.$recentProduct['price'].'&fname='.$recentProduct['fname'].'&lname='.$recentProduct['lname'].'&id='.$recentProduct['product_id'].'">
                                    <img class="img-rounded img-thumbnail" src="products/'.$recentProduct['picture'].'"/>
                                </a>
                            </p>
                            <p class="text-muted text-justify">
                                '.$recentProduct['description'].'
                            </p>
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
                    <form class="form-inline" name="search" role="form" method="get" action="search.php?search=">
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
                        <div class="panel panel-info">
                            <div class="panel-heading">
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
                                <a href="product.php?from=notloggedin&=&title='.$product['title'].'&picture='.$product['picture'].'&description='.$product['description'].'&email='.$product['email'].'&price='.$product['price'].'&fname='.$product['fname'].'&lname='.$product['lname'].'&id='.$product['id'].'">
                                    <img class="img-rounded img-thumbnail" src="products/'.$product['picture'].'"/>
                                </a>
                            </p>
                            <p class="text-muted text-justify">
                                '.$product['description'].'.
                            </p>
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
</div>






<!-- LOGIN MODAL -->
<div id="login" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <form name="login" role="form" method="post" action="redirect.php?from=login">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Login</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Email</label>
                    <input 
                        class="form-control"
                        value="" 
                        type="text"
                        name="username"
                        placeholder="Email"
                        autofocus >
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input 
                        class="form-control"
                        name="password" 
                        type="password"
                        placeholder="Password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Login!"/>
            </div>
        </div><!-- /.modal-content -->
    </form>
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->






<!-- SIGN UP MODAL -->
<div id="signup" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <form name="signup" role="form" method="post" action="redirect.php?from=signup">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Sign Up</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>First Name</label>
                    <input 
                        class="form-control"
                        name="fname"
                        value="" 
                        type="text"
                        placeholder="First Name"
                        autofocus>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input 
                        class="form-control"
                        name="lname" 
                        type="text"
                        placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input 
                        class="form-control"
                        name="username" 
                        type="text"
                        placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input 
                        class="form-control"
                        name="password" 
                        type="password"
                        placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Verify Password</label>
                    <input 
                        class="form-control"
                        name="verify_password" 
                        type="password"
                        placeholder="Verify Password">
                </div>
                <label>Note: To sign up for a new account the user must have and gmail.com or gmail.ca account.</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Sign Up!"/>
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
