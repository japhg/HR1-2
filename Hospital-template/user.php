<?php
session_start();
include 'connection.php';
require 'function.php';
?>

<?php
$errors = array();

//ADD USER
if (isset($_POST['insert'])) {
  $username = clean(mysqli_real_escape_string($con, $_POST['username']));
  $password = clean(mysqli_real_escape_string($con, $_POST['password']));
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $firstname = clean(mysqli_real_escape_string($con, $_POST['firstname']));
  $middlename = clean(mysqli_real_escape_string($con, $_POST['middlename']));
  $lastname = clean(mysqli_real_escape_string($con, $_POST['lastname']));
  $usertype = clean(mysqli_real_escape_string($con, $_POST['usertype']));

  if (!empty($username) && !empty($hashedPassword) && !empty($firstname) && !empty($middlename) && !empty($lastname) && !empty($usertype)) {
    $query = "INSERT INTO user_table(username, password, firstname, middlename, lastname, user_type) VALUES('$username', '$hashedPassword', '$firstname', '$middlename', '$lastname', '$usertype')";
    $result = mysqli_query($con, $query);

    $errors['username'] = "Successfully Added";
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
  <link href="assets/vendor/bootstrap/css/mdb.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <script src="js/sweetalert.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

  <style>
    button {
      font-family: 'Poppins', sans-serif;
      font-style: normal;
    }

    table thead {
      text-align: center;
      text-transform: uppercase;
    }

    table tbody tr th {
      font-weight: 400;
      font-family: 'Inter', sans-serif;
    }

    label {
      width: 100px;
    }

    .alert {
      display: none;
    }

    .requirements {
      list-style-type: none;
    }

    .wrong .fa-check {
      display: none;
    }

    .good .fa-times {
      display: none;
    }
  </style>
</head>

<body>

  <?php
  include 'header.php';
  include 'sidebar.php';
  ?>
  <main id="main" class="main">
    <?php
    if (isset($_SESSION['success'])) { ?>
      <script>
        swal({
          title: "<?php echo $_SESSION['success']; ?>",
          icon: "success",
          button: "OK"
        })
      </script>
    <?php unset($_SESSION['success']);
    } ?>

    <?php
    if (count($errors) > 0) { ?>
      <?php
      foreach ($errors as $showerror) {
      ?>
        <script>
          swal({
            title: "<?php echo $showerror ?>",
            icon: "success",
            button: "OK"
          })
        </script>
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
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
      </nav>
    </div>

    <div class="card-body">

      <!-- Modal for add button-->
      <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" name="username" id="username" required>
                  <div class="invalid-feedback">Please enter username</div>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control validate" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                  <div class="invalid-feedback">Please enter password</div>
                </div>
                <div class="alert alert-warning password-alert" role="alert">
                  <ul>
                    <li class="requirements leng"><i class="fas fa-check green-text"></i><i class="fas fa-times red-text"></i> Your password must have at least 8 chars.</li>
                    <li class="requirements big-letter"><i class="fas fa-check green-text"></i><i class="fas fa-times red-text"></i> Your password must have at least 1 big letter.</li>
                    <li class="requirements num"><i class="fas fa-check green-text"></i><i class="fas fa-times red-text"></i> Your password must have at least 1 number.</li>
                  </ul>
                </div>

                <div class="mb-3">
                  <label for="firstname" class="form-label">Firstname</label>
                  <input type="text" class="form-control" name="firstname" id="firstname" required>
                  <div class="invalid-feedback">Please enter firstname</div>
                </div>
                <div class="mb-3">
                  <label for="middlename" class="form-label">Middlename</label>
                  <input type="text" class="form-control" name="middlename" id="middlename" required>
                  <div class="invalid-feedback">Please enter middlename</div>
                </div>
                <div class="mb-3">
                  <label for="lastname" class="form-label">Lastname</label>
                  <input type="text" class="form-control" name="lastname" id="lastname" required>
                  <div class="invalid-feedback">Please enter lastname</div>
                </div>
                <div class="mb-3">
                  <label for="usertype" class="form-label">User type</label>

                  <select name="usertype" id="usertype" class="form-select" aria-label="Default select example" required>
                    <option value="">Please Choose</option>
                    <option value="SUPER ADMIN">SUPER ADMIN</option>
                    <option value="HR ADMIN">HR ADMIN</option>
                    <option value="CORE ADMIN">CORE ADMIN</option>
                    <option value="LOGISTICS ADMIN">LOGISTICS ADMIN</option>
                    <option value="FINANCIALS ADMIN">FINANCIALS ADMIN</option>
                  </select>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="insert" id="insert">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-12 float-right">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Add</button>
        </div>
      </div>
      <br>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0" style="border: 1px solid #121212;">
            <thead>
              <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>User Type</th>
                <th>Date Joined</th>
                <th colspan="2">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT * FROM user_table";
              $result = mysqli_query($con, $query);
              if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <tr>
                    <th><?php echo $row['user_id']; ?></th>
                    <th><?php echo $row['username']; ?></th>
                    <th><?php echo $row['firstname']; ?></th>
                    <th><?php echo $row['middlename']; ?></th>
                    <th><?php echo $row['lastname']; ?></th>
                    <th><?php echo $row['user_type']; ?></th>
                    <th><?php echo $row['date_joined']; ?></th>

                    <th style="text-align: center;">
                      <div class="row">
                        <div class="col-md-12">
                          <form action="updateUser.php" method="post">
                            <input type="hidden" name="updates" id="updates" value="<?php echo $row['user_id']; ?>">
                            <button type="submit" class="btn btn-success">Update</button>
                          </form>
                        </div>
                      </div>
                    </th>
                    <th>
                      <div class="row">
                        <div class="col-md-12">
                          <input type="hidden" name="deletes" class="deletes" id="delete" value="<?php echo $row['user_id']; ?>">
                          <a href="javascript:void(0)" class="delete_btn_ajax btn btn-danger">Delete</a>
                        </div>
                      </div>
                    </th>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <script>
      $(document).ready(function() {
        $('.delete_btn_ajax').click(function(e) {
          e.preventDefault();

          var deleteid = $(this).closest("tr").find('.deletes').val();

          swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this data again!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                $.ajax({
                  type: "POST",
                  url: "action.php",
                  data: {
                    "delete_btn_set": 1,
                    "delete_id": deleteid,
                  },
                  success: function(response) {

                    swal("Data Deleted Successfully!", {
                      icon: "success",
                    }).then((result) => {
                      location.reload();
                    });

                  }
                });

              }
            });

        });
      });
    </script>

    <script>
      $(function() {
        var $password = $(".form-control[type='password']");
        var $passwordAlert = $(".password-alert");
        var $requirements = $(".requirements");
        var leng, bigLetter, num, specialChar;
        var $leng = $(".leng");
        var $bigLetter = $(".big-letter");
        var $num = $(".num");
        // var $specialChar = $(".special-char");
        // var specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
        var numbers = "0123456789";

        $requirements.addClass("wrong");
        $password.on("focus", function() {
          $passwordAlert.show();
        });

        $password.on("input blur", function(e) {
          var el = $(this);
          var val = el.val();
          $passwordAlert.show();

          if (val.length < 8) {
            leng = false;
          } else if (val.length > 7) {
            leng = true;
          }


          if (val.toLowerCase() == val) {
            bigLetter = false;
          } else {
            bigLetter = true;
          }

          num = false;
          for (var i = 0; i < val.length; i++) {
            for (var j = 0; j < numbers.length; j++) {
              if (val[i] == numbers[j]) {
                num = true;
              }
            }
          }

          // specialChar=false;
          // for(var i=0; i<val.length;i++){
          //     for(var j=0; j<specialChars.length; j++){
          //         if(val[i]==specialChars[j]){
          //             specialChar = true;
          //         }
          //     }
          // }

          console.log(leng, bigLetter, num, specialChar);

          if (leng == true && bigLetter == true && num == true) {
            $(this).addClass("valid").removeClass("invalid");
            $requirements.removeClass("wrong").addClass("good");
            $passwordAlert.removeClass("alert-warning").addClass("alert-success");
          } else {
            $(this).addClass("invalid").removeClass("valid");
            $passwordAlert.removeClass("alert-success").addClass("alert-warning");

            if (leng == false) {
              $leng.addClass("wrong").removeClass("good");
            } else {
              $leng.addClass("good").removeClass("wrong");
            }

            if (bigLetter == false) {
              $bigLetter.addClass("wrong").removeClass("good");
            } else {
              $bigLetter.addClass("good").removeClass("wrong");
            }

            if (num == false) {
              $num.addClass("wrong").removeClass("good");
            } else {
              $num.addClass("good").removeClass("wrong");
            }

            // if(specialChar==false){$specialChar.addClass("wrong").removeClass("good");}
            // else{$specialChar.addClass("good").removeClass("wrong");}
          }


          if (e.type == "blur") {
            $passwordAlert.hide();
          }
        });
      });
    </script>

    <?php include 'footer.php' ?>
</body>

</html>