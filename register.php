<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$error = '';

$success_message = '';

if(isset($_POST["register"]))
{
    session_start();

    if(isset($_SESSION['user_data']))
    {
        header('location:chatroom.php');
    }

    require_once('.\database\ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserName($_POST['user_name']);

    $user_object->setUserEmail($_POST['user_email']);

    // checking 
    if(strpos($_POST['user_email'], "@thapar.edu") === false and strpos($_POST['user_email'], "@gmail.com") === false )
    {
        $error = 'Enter Valid Email Address';
    }
    else
    {
       
    $user_object->setUserPassword($_POST['user_password']);

    $user_object->setUserProfile($user_object->make_avatar(strtoupper($_POST['user_name'][0])));

    $user_object->setUserStatus('Disabled');

    $user_object->setUserState($_POST['user_state']);

    $user_object->setUserCreatedOn(date('Y-m-d H:i:s'));

    $user_object->setUserVerificationCode(md5(uniqid()));

    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0)
    {
        $error = 'This Email is Already Registered';
    }
    else
    {
        if($user_object->save_data())
        {

            $mail = new PHPMailer(true);

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username   = 'rsoam_be18@thapar.edu';                     // SMTP username
            $mail->Password   = 'Trust88%Busy%%';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = 587;

            $mail->setFrom('rsoam_be18@thapar.edu', 'Ria');

            $mail->addAddress($user_object->getUserEmail());

            $mail->isHTML(true);

            $mail->Subject = 'Registration Verification for Chat Application Demo';

// check for error here as the file path is changed 

            $mail->Body = '
            <p>Thank you for registering to the Students Discussion Forum.</p>
                <p>This is a verification email, please click the link to verify your email address.</p>
                <p><a href="http://localhost:82/ratchet-chat-application-source-code/verify.php?code='.$user_object->getUserVerificationCode().'">Click to Verify</a></p>
                <p>Thank you...</p>
            ';

            $mail->send();


            $success_message = 'Verification Email sent to ' . $user_object->getUserEmail() . ', so before login first verify your email';
        }
        else
        {
            $error = 'Something went wrong try again';
        }
    }
 
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

    <title>Register | Students Discussion Forum made using PHP and Ratchet Websocket</title>

    <!-- Bootstrap core CSS -->
    <link href="./vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href="./vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

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
      text-decoration: underline;

}

.btn{
    box-shadow: none !important;
    width: 24rem !important;
    color: white;
}
</style>

    <!-- Bootstrap core JavaScript -->
    <script src="./vendor-front/jquery/jquery.min.js"></script>
    <script src="./vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="./vendor-front/parsley/dist/parsley.min.js"></script>
</head>

<body class="background">


            <div class="containter">
        <br />
        <br />
        <h1 class="Mainheading"> Welcome To The Virtual Discussion Room! </h1>
        <h5 class="text-center"> Discuss Last minute Doubts with your Teachers and Peers, Submit your Assignments and so much more!</h5>
        
        <div class="row justify-content-md-center">
            <div class="col col-md-4 mt-5">
                <?php
                if($error != '')
                {
                    echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      '.$error.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    ';
                }

                if($success_message != '')
                {
                    echo '
                    <div class="alert alert-success">
                    '.$success_message.'
                    </div>
                    ';
                }
                ?>
                <div class="card shadow">
                    <div class="card-header">Register Now!</div>
                    <div class="card-body">

                        <form method="post" id="register_form">

                            <div class="form-group">
                                <label><i>Enter Your Name</i></label>
                                <input type="text" name="user_name" id="user_name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                            </div>

                            <div class="form-group">
                                <label><i>Enter Your Email</i></label>
                                <input type="text" name="user_email" id="user_email" class="form-control" data-parsley-type="email" required />
                            </div>

                            <div class="form-group">
                                <label><i>Enter Your Password</i></label>
                                <input type="password" name="user_password" id="user_password" class="form-control" data-parsley-minlength="6" data-parsley-maxlength="12" data-parsley-pattern="^[a-zA-Z]+$" required />
                            </div>
<!--- CHANGES MADE ---->
                            <div class="form-group">
                                <label><i>Are you a Teacher or student?</i></label>
                                <input type="text" name="user_state" id="user_state" class="form-control"  data-parsley-pattern="^[a-zA-Z]+$" required />
                            </div>

 <!------>                  <div 
 style="background: linear-gradient(#e66465, #9198e5) !important;
 text-decoration-color: white !important; 
 outline: none !important;" 
 class="form-group text-center">
                            <input type="submit" name="register" class="btn bg-transparent" value="Register" />
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

    $('#register_form').parsley();

});

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(re.test(email)){
        //Email valid. Procees to test if it's from the right domain (Second argument is to check that the string ENDS with this domain, and that it doesn't just contain it)
        if(email.indexOf("@thapar.edu", email.length - "@thapar.edu".length) !== -1){
            //VALID
            console.log("VALID");
        }
    }
};

</script>