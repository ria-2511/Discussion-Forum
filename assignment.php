<?php
// connect to database
session_start();

$conn = mysqli_connect('localhost', 'root', 'ria2511#', 'chat');

// echo $_SESSION['current_user'];
// echo gettype($_SESSION['current_user']);
// $sql = "SELECT * FROM assignment_db WHERE teacher_id = $_SESSION['user_id']";
$userid = (int)$_SESSION['current_user'];
// echo gettype($userid);
$stmt = $conn->prepare("SELECT * FROM assignment_db WHERE teacher_id = ?");
$stmt->bind_param("s",$userid);
$stmt->execute();
$res = $stmt->get_result();

// $result = mysqli_query($conn, $sql);

// $files = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="style.css">
<!-- Bootstrap core CSS -->
    <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>
<link rel="stylesheet" type="text/css" href="./vendor-front/parsley/parsley.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Comforter+Brush&display=swap" rel="stylesheet">
    <!-- Bootstrap core JavaScript -->
    <script src="vendor-front/jquery/jquery.min.js"></script>
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>

  <title>Download files</title>

<style type="text/css">
  
  .background
  {
    background: rgb(250,205,114);
background: linear-gradient(90deg, rgba(250,205,114,1) 0%, rgba(255,0,91,1) 100%);
  }

  .Mainheading
    {
        text-align: center;
        color: black;

        font-family: 'Cinzel Decorative', cursive;
/*font-family: 'Comforter Brush', cursive;*/
text-shadow: 2px 2px 4px #FFFFFF;
    }

</style>

</head>
<body class="background">

<h2  class="Mainheading" style="padding-top: 20px;"> Evaluate Assignments </h2>
<h5 class="text-center"><i> Welcome! Here are the assignments submitted below by your students. Click on the Download Button to download them. </i></h5>

<div class="container-fluid">
  <table style="width:30rem;" class="table table-light">
<thead class="thead-dark">
  
    <th scope="col">Student ID</th>
    <!-- <th scope="col">Student Name</th>
    <th scope="col">Student Email Address</th> -->
    <th scope="col"> Download </th>
    
</thead>
<tbody>
  <?php

   foreach ($res as $file): ?>
    <tr class="thead-light">

      <td ><?php echo $file['user_id']; ?></td>
      <!-- <td><?php echo $file['user_name']; ?></td>
      <td><?php echo $file['user_email']; ?></td> -->
      <!-- <td><?php echo floor($file['size'] / 1000) . ' KB'; ?></td> 
      <td><?php echo $file['downloads']; ?></td> -->
      <td><a href="<?php echo 'Health/'.$file['file'] ?>" download >Download</a></td>
    </tr>
  <?php endforeach;?>

</tbody>
</table>
</div>

</body>
</html>