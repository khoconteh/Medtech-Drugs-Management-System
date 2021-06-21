<?php
//include connection file
include("connect.php");

//handles login form
if (isset($_POST["login_button"])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {

        //declare variables to store users input
        $__email = trim($_POST['email']);
        $__password = trim($_POST['password']);
        $error_exists = false;



        //validate data
        if (empty($__email)) {
            echo '<h3 class="text-danger text-center">Email is required</h3>';
            $error_exists = true;
        } elseif (strlen($__email) > 200) {
            echo '<h3 class="text-danger text-center">Email is too long</h3>';
            $error_exists = true;
        }elseif (!filter_var($__email, FILTER_DEFAULT)) {
            echo '<h3 class="text-danger text-center">Invalid Email, please try again</h3>';
            $error_exists = true;
        } 
        if (empty($__password)) {
            echo '<h4 class="text-danger text-center">Password is required</h4>';
            $error_exists = true;
        }elseif (strlen($__password) < 8 || strlen($__password) > 50) {
            echo '<h4 class="text-danger text-center">Password range must be between 8 to 50 characters</h4>';
            $error_exists = true;
        }


        if (!$error_exists) {
            
            //declare sql statement varaiable
            $sql_query = "SELECT UserID,FullName,Email,UserPassword FROM userregister WHERE Email = ?";


            if ($stmt = $con->prepare($sql_query)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $__email);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Store result
                    $stmt->store_result();

                    // Check if email exists, if yes then verify password
                    if ($stmt->num_rows == 1) {

                        // Bind result variables
                        $stmt->bind_result($id, $fullname, $email, $password);
                        if ($stmt->fetch()) {

                            if (password_verify($__password, $password)) {
                                // Password is correct, so start a new session
                                
                                session_start();
                                session_regenerate_id();
                                // Store data in session variables
                                $_SESSION["loggedIn"] = true;
                                $_SESSION["user_id"] = $id;
                                $_SESSION["fullname"] = $fullname;
                                $_SESSION["email"] = $email;

                               
                                // Redirect user to welcome page
                                header("location: index.php");
                            } else {

                                echo '<h4 class="text-danger text-center"> Sorry Incorrect Email or Password</h4>';
                            }
                        }
                    }else{
                        echo '<h4 class="text-danger text-center"> Sorry Incorrect Email or Password </h4>';
                    }
                }
            }
        }
    } else {
        header("location: login.php");
    }
}


//handles register form
if (isset($_POST["register_button"])) {

    //use try catch to handle all errors
    try {
        if (isset($_POST["fullname"]) && isset($_POST["email"]) && isset($_POST["password"])) {

            //variables for storing form values
            $_fullname = trim($_POST["fullname"]);
            $_email = trim($_POST["email"]);
            $_password = trim($_POST["password"]);
            $error_exists = false;

            //validate users inputs
            if (empty($_fullname)) {
                echo '<h4 class="text-danger text-center">Fullname is required</h4>';
                $error_exists = true;
            } elseif (strlen($_fullname) < 3 || strlen($_fullname) > 200) {
                echo '<h4 class="text-danger text-center">Fullname must be between 3 to 200 character</h4>';
                $error_exists = true;
            }
            if (empty($_email)) {
                echo '<h4 class="text-danger text-center">Email is required</h4>';
                $error_exists = true;
            } elseif (strlen($_email) > 200) {
                echo '<h4 class="text-danger text-center">Email is too long</h4>';
                $error_exists = true;
            }
            if (empty($_password)) {
                echo '<h4 class="text-danger text-center">Password is required</h4>';
                $error_exists = true;
            }

            if (strlen($_password) < 8 || strlen($_password) > 50) {
                echo '<h4 class="text-danger text-center">Password must be between 8 to 50 characters</h4>';
                $error_exists = true;
            }

            if (!$error_exists) {
                //check if the email  exists
                $query = "SELECT * FROM userregister WHERE Email = ?";

                if ($stmt = $con->prepare($query)) {

                    $stmt->bind_param('s', $_email);

                    if ($stmt->execute()) {
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            //email already exists
                            echo '<h4 class="text-danger text-center">That email is already registered, please try another one</h4>';
                        } else {

                            //hash the users password
                            $_hashedPassword = password_hash($_password, PASSWORD_DEFAULT);
                            $_query = 'INSERT INTO userregister (FullName,Email,UserPassword) values (?,?,?)';
                            $statement = $con->prepare($_query);
                            $statement->bind_param('sss', $_fullname, $_email, $_hashedPassword);

                            if ($statement->execute()) {

                                echo '<h4 class="text-success text-center">Registeration Successful</h4>';
                            }
                        }
                    } else {

                        echo '<h4 class="text-danger text-center">Oops!! Something went wrong</h4>';
                    }
                } else {
                    echo '<h4 class="text-danger text-center">Oops!! Something went wrong</h4>';
                }
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}



?>
<!-- End of PHP Script -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="./css/main.css" type="text/css">
</head>

<body>
    <div class="container">
        <div class="row mt-5">

            <div class="col-md-12 text-center">
                <h1 class="display-3">Medtech Drugs Management System</h1>
            </div>
            <!-- Login Form -->
            <div class="col-md-5 p-5">
                <form action="login.php" method="post" autocomplete="off">
                    <h4 class="">Enter a valid Email to login</h4>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for=""> Enter Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                    </div>

                    <input type="submit" value="Login" class="form-control btn btn-warning my-3" name="login_button">
                </form>
            </div>
            <!-- /End of login Form -->

            <!-- Registeration Form -->
            <div class="col-md-7 p-5">
                <form action="login.php" method="POST" autocomplete="off">
                    <h4 class="">Register here to begin</h4>
                    <div class="form-group mb-2">
                        <label for="">Enter Fullname</label>
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname">
                    </div>

                    <div class="form-group mb-2">
                        <label for="">Enter Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                    </div>


                    <div class="form-group mb-2">
                        <label for="">Enter Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                    </div>

                    <input type="submit" value="Register" class="form-control btn btn-warning my-3" name="register_button">

                </form>
            </div>
            <!-- End of registeration Form -->
        </div>
    </div>

    <?php set_footer() ?>