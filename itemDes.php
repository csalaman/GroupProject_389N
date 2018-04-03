<?php
/**
 * Created by PhpStorm.
 * User: csalaman
 * Date: 3/21/2018
 * Time: 10:56 PM
 */

require_once("support.php");
require_once("dbAccessInfo.php");
require_once("DatabaseInstance.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $database = new DatabaseInstance($host, $user, $password, $database, "items");
    $item = $database->getItemById($id);
} else {
    header("Location: main.php");
}

$page = <<<EOBODY
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Book Sellers</title>
        <meta charset="UTF-8">
        <link rel="icon" href="bootstrap/images/book.png">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="bootstrap/css/mainstyle.css">

        <script>
            function validateLogin() {
                var username = document.getElementById("usernameLogin").value;
                var password = document.getElementById("passwordLogin").value;

                <!-- CHECK LOGIN USING DATABASE -->
                if (username === "admin" && password === "password") {
                    header("refresh:0; url=portal.php");
                    document.getElementById("updateLogin").innerHTML = "Successful login.";
                }
                else document.getElementById("updateLogin").innerHTML = "Invalid username and/or password.";
            }

            function validateRegister() {
                var username = document.getElementById("usernameRegister").value;
                var password = document.getElementById("passwordRegister").value;
                var name = document.getElementById("nameRegister").value;
                var email = document.getElementById("emailRegister").value;

                <!-- CHECK THAT USERNAME AND EMAIL HAVE NOT ALREADY BEEN REGISTERED -->
                document.getElementById("updateRegister").innerHTML = "Successful register.";
            }
        </script>
    </head>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <!-- Navigation Part 1-->
                <div class="navbar-header">
                    <!-- button visible when navbar collapses -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarcontent">
                        <!-- displaying icon representing button -->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Navigation Part 2 has main content of navigation bar -->
                <div id="navbarcontent" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
                        <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#registerModal">Register</a></li>
                    </ul>
                    <div class="col-sm-3 col-md-3 pull-right">
                        <form class="navbar-form" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div id="loginModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Login</h4>
                    </div>
                    <div class="modal-body">
                        <strong><p id="updateLogin"></p></strong>
                        <p>
                            <label for="usernameLogin">Username:</label>
                            <input type="text" class="form-control" id="usernameLogin" name="usernameLogin" maxlength="16" required/>
                        </p>
                        <p>
                            <label for="passwordLogin">Password:</label>
                            <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" maxlength="16" required/>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="validateLogin()">Login</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="registerModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Register</h4>
                    </div>
                    <div class="modal-body">
                        <strong><p id="updateRegister"></p></strong>
                        <p>
                            <label for="usernameRegister">Username:</label>
                            <input type="text" class="form-control" id="usernameRegister" name="usernameRegister" maxlength="16" required/>
                        </p>
                        <p>
                            <label for="passwordRegister">Password:</label>
                            <input type="password" class="form-control" id="passwordRegister" name="passwordRegister" maxlength="16" required/>
                        </p>
                        <p>
                            <label for="nameRegister">Name:</label>
                            <input type="text" class="form-control" id="nameRegister" name="nameRegister" maxlength="50" required/>
                        </p>
                        <p>
                            <label for="emailRegister">Email:</label>
                            <input type="email" class="form-control" id="emailRegister" name="emailRegister" maxlength="100" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required/>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="validateRegister()">Register</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <header>
            <h1>$item[item_name]</h1><hr>
        </header>

        <!-- Portfolio Item Row -->
        <div class="row" style="padding-bottom:20px;">
            <div class="col-md-3">
                <img src="$item[item_file_name]" alt="$item[item_name]" height="400">
            </div>
            <div class="col-md-4">
                <h3 class="my-3">Description</h3>
                <p>$item[item_description]</p>
                <h3 class="my-3">Post Date</h3>
                <p>$item[item_post_date]</p>
                <h3 class="my-3">Seller</h3>
                <p>$item[item_seller]</p>
                <h3 class="my-3">Price</h3>
                <p>$$item[item_price]</p>
            </div>
        </div>

        <footer>Copyright &copy; Book Sellers</footer>

        <script src="bootstrap/jquery-3.3.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
EOBODY;

echo $page;
?>