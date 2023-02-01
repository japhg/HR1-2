<?php

require_once "connection.php";
require_once "function.php";
session_start();
$errors = array();

//UPDATE USER
if(isset($_POST['edit'])){
  $id = clean($_POST['id']);
  $username = clean(mysqli_real_escape_string($con, $_POST['username']));
  $firstname = clean(mysqli_real_escape_string($con, $_POST['firstname']));
  $middlename = clean(mysqli_real_escape_string($con, $_POST['middlename']));
  $lastname = clean(mysqli_real_escape_string($con, $_POST['lastname']));
  $usertype = clean(mysqli_real_escape_string($con, $_POST['usertype']));

  if(!empty($username) && !empty($firstname) && !empty($middlename) && !empty($lastname) && !empty($usertype))
  {
  $query = "UPDATE user_table SET username = '$username', firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', user_type = '$usertype' WHERE user_id = '$id'";

  if($result = mysqli_query($con, $query))
  {
    $_SESSION['success'] = "Successfully Updated";
            header("location: user.php");
  }
  else
  {
    echo '<script>
    swal({
      title: "Update unsuccessfully!",
      text: "Update unsucessfully",
      icon: "error",
    });</script>';
  }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="300; url=index.php">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Users | Alegario Cure Hospital</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/alegario_logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500&family=Inter:wght@300;400;600;800&family=Poiret+One&family=Poppins&family=Raleway:wght@500;600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  
    <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/vendor/">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <script src="js/sweetalert.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php 
    include 'header.php';
    include 'sidebar.php';
   ?>
 
 <main id="main" class="main">
 <?php
    if(count($errors) > 0)
    { ?>
         <?php
    foreach($errors as $showerror)
    {
    ?>
    <script> swal({
            title: "<?php echo $showerror?>",
            icon: "success",
            button: "OK"
          }) </script>
          <?php
    } 
    
?>
<?php
    }
  ?>
 <div class="pagetitle">
      <h1>Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="user.php">Users</a></li>
          <li class="breadcrumb-item active">Update Users</li>
        </ol>
      </nav>
    </div>

  <div class="card-body">
    <div class="container">
        <?php  
        if(isset($_POST['updates'])){
            $id = $_POST['updates'];
            $query = "SELECT * FROM user_table WHERE user_id = '$id'";
            $result = mysqli_query($con, $query);

            foreach ($result as $row) {
        ?>   
        <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <input type="hidden" name="id" value="<?php echo $row['user_id'];?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo $row['username']; ?>" required>
                <div class="invalid-feedback">Please enter username</div>
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $row['firstname']; ?>" required>
                <div class="invalid-feedback">Please enter firstname</div>
            </div>
            <div class="mb-3">
                <label for="middlename" class="form-label">Middlename</label>
                <input type="text" class="form-control" name="middlename" id="middlename" value="<?php echo $row['middlename']; ?>" required>
                <div class="invalid-feedback">Please enter middlename</div>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $row['lastname']; ?>" required>
                <div class="invalid-feedback">Please enter lastname</div>
            </div>
            <div class="mb-3">
                <label for="usertype" class="form-label">User type</label>

                <select name="usertype" id="usertype" class="form-select" aria-label="Default select example" value="<?php echo $row['user_type']; ?>" required>
                <option value="">Please Choose</option>
                <option value="SUPER ADMIN">SUPER ADMIN</option>
                <option value="HR ADMIN">HR ADMIN</option>
                <option value="CORE ADMIN">CORE ADMIN</option>
                <option value="LOGISTICS ADMIN">LOGISTICS ADMIN</option>
                <option value="FINANCIALS ADMIN">FINANCIALS ADMIN</option>
                </select>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button> <br>
            <button type="submit" class="btn btn-success" name="edit" id="edit">Update</button>
        </div>
        </form>
        <?php
            }
        }
        ?>  
        </div>
        </div>
 </main>











<?php include 'footer.php'?>
</body>
</html>