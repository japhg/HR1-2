<!--DELETE USER-->
<?php
  require "connection.php";
session_start();
  
  if(isset($_POST['delete_btn_set'])){
    $id = $_POST['delete_id'];
    
    $query = "DELETE FROM user_table WHERE user_id = '$id'";
    $result = mysqli_query($con, $query);
    
    $_SESSION['success'] = "User is succesfully deleted!";
    header("location: user.php");
  }
?>