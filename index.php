<?php

session_start();

$error = '';

// used to start the session and if the user is loged in then it redirects to the chatroom page 

if(isset($_SESSION['user_data']))
{
    // header('location:chatroom.php');
    if($_SESSION['user_state'] === 'teacher')
    {
        header('location:Discussion Forum/teacher.html');
    }
    else
    {
         header('location:Discussion Forum/LandingPage.html');
    }
    
    // header('location: Discussion Forum/LandingPage.html');
}

// here the redirecting happens 
// I am making changes here to redirect it to the Choose Subject page Instead. 


if(isset($_POST['login']))
{
    require_once('database/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserEmail($_POST['user_email']);

    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0)
    {
        if($user_data['user_status'] == 'Enable')
        {
            if($user_data['user_password'] == $_POST['user_password'])
            {
                $user_object->setUserId($user_data['user_id']);

                $user_object->setUserLoginStatus('Login');

                $user_token = md5(uniqid());

                $user_object->setUserToken($user_token);

                if($user_object->update_user_login_data())
                {
                    $_SESSION['user_data'][$user_data['user_id']] = [
                        'id'    =>  $user_data['user_id'],
                        'name'  =>  $user_data['user_name'],
                        'profile'   =>  $user_data['user_profile']
                        
                    ];
                    $_SESSION['current_user'] = $user_data['user_id'];
                    // echo $user_data['user_id'];

                     $_SESSION['user_state'] = $user_object -> getUserStateById($user_data['user_id']);
                    if($user_object -> getUserStateById($user_data['user_id']) === "teacher")
                    {

                        header('location:Discussion Forum/teacher.html');
                    }
                    else
                    {
                        header('location:Discussion Forum/LandingPage.html');
                    }

                }
            }
            else
            {
                $error = 'Wrong Password';
            }

            
        }
        else
        {
            $error = 'Please Verify Your Email Address';
        }
    }
    else
    {
        $error = 'Wrong Email Address';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Load Chat from Mysql Database | PHP Chat Application using Websocket</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>
<link rel="stylesheet" type="text/css" href="./vendor-front/parsley/parsley.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Comforter+Brush&display=swap" rel="stylesheet">

<style type="text/css">
    .background
    {
    width:100%;
    background: linear-gradient(#e66465, #9198e5);
    overflow-x: hidden;
    /*position: absolute;*/
    padding-bottom: 100px;
    }

    .Mainheading
    {
        text-align: center;
        color: white;

        font-family: 'Cinzel Decorative', cursive;
/*font-family: 'Comforter Brush', cursive;*/
text-shadow: 2px 2px 4px #000000;
    }

    .shadow 
    {
box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .btn:hover {
  outline: white !important;
  box-shadow: none;
  border-color: none;
}

.btn{
    box-shadow: none !important;
}
</style>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor-front/jquery/jquery.min.js"></script>
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
</head>

<body class="background">

    <div class="container">
        <br />
        <br />
        <h1 class="Mainheading"> Welcome To The Virtual Discussion Room! </h1>
        <h5 class="text-center"> Discuss Last minute Doubts with your Teachers and Peers, Submit your Assignments and so much more!</h5>
        <div class="row justify-content-md-center mt-5">
            
            <div class="col-md-4">
               <?php
               if(isset($_SESSION['success_message']))
               {
                    echo '
                    <div class="alert alert-success">
                    '.$_SESSION["success_message"] .'
                    </div>
                    ';
                    unset($_SESSION['success_message']);
               }

               if($error != '')
               {
                    echo '
                    <div class="alert alert-danger">
                    '.$error.'
                    </div>
                    ';
               }
               ?>
                <div class="card shadow">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form method="post" id="login_form">
                            <div class="form-group">
                                <label> <i>Enter Your Email Address </i></label>
                                <input type="text" name="user_email" id="user_email"  class="form-control" data-parsley-type="email" required />
                            </div>
                            <div class="form-group">
                                <label> <i> Enter Your Password </i> </label>
                                <input type="password" name="user_password" id="user_password" class="form-control" required />
                            </div>
                            <div class="form-group text-center">
                                <input style="background: linear-gradient(#e66465, #9198e5);" type="submit" name="login" id="login" class="btn btn-primary" value="Login" />
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>

$(document).ready(function(){
    
    $('#login_form').parsley();
    
});

</script>