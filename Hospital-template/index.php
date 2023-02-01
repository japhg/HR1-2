<?php
require_once "database/connection.php";
require_once "function.php";

ob_start();
session_start();
$errors = array();


if (isset($_POST['login'])) {
    $ip = getUserIpAdd();
    $time = time() - 30;
    $check_attempt = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as total_attempt FROM attempt_table WHERE time_count>$time AND ip_address = '$ip'"));
    $total_count = $check_attempt['total_attempt'];
    if ($total_count == 3) {
        $errors['student_number'] = "Users are now locked. Please wait for 30 seconds! ";
    } else {
        $username = clean(mysqli_real_escape_string($con, $_POST["user"]));
        $password = clean(mysqli_real_escape_string($con, $_POST['password']));


        $query = "SELECT * FROM user_table WHERE username = '$username'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                if ($row['user_type'] == "SUPER ADMIN") {
                    mysqli_query($con, "DELETE FROM attempt_table WHERE ip_address = '$ip'");
                    header("location: dashboard.php");
                } else if ($row['user_type'] == "HR ADMIN") {
                    mysqli_query($con, "DELETE FROM attempt_table WHERE ip_address = '$ip'");
                    header("location: ../../hr/hrAdmin/dashboard.php");
                    exit(0);
                }
            } else {
                $total_count++;
                $time_remain = 5 - $total_count;
                $time = time();
                if ($time_remain == 0) {
                    $errors['student_number'] = "Users are now locked. Please wait for 30 seconds! ";
                } else {
                    $errors['username'] = "Username or Password is incorrect. " . $time_remain . " attempts  remaining. ";
                }
                mysqli_query($con, "INSERT INTO attempt_table(ip_address,time_count) VALUES('$ip','$time')");
            }
        }
        $total_count++;
        $time_remain = 5 - $total_count;
        $time = time();
        if ($time_remain == 0) {
            $errors['student_number'] = "Users are now locked. Please wait for 30 seconds! ";
        } else {
            $errors['username'] = "Username or Password is incorrect. " . $time_remain . " attempts  remaining. ";
        }
        mysqli_query($con, "INSERT INTO attempt_table(ip_address,time_count) VALUES('$ip','$time')");
    }
}
function getUserIpAdd()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/alegario_logo.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600&family=Bebas+Neue&family=Comfortaa:wght@500&family=Heebo:wght@100;200;300;400;500;600;700;800;900&family=Hind&family=Inter:wght@300;400;600;800&family=Poiret+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:wght@500;600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Source+Sans+3&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
    <title>Login - Alegario Cure Hospital</title>

</head>

<body>



    <div class="body"></div>

    <?php
    if (count($errors) > 0) { ?>
        <?php
        foreach ($errors as $showerror) {
        ?>
<script>
    
    Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $showerror ?>',
            })
</script>
        <?php
        }

        ?>
    <?php
    }
    ?>

    <main>
        <div class="row justify-content-left" style="width: 100vh;"></div>
        <img src="assets/img/Hospital wheelchair-bro.svg" width="50%" class="rounded" alt="..." id="bg">
        </div>

        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center" id="card">

                            <div class="d-flex justify-content-center py-4" id="logo">
                                <a href="index.php" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/alegario_logo.png" alt="HR Logo" width="30%">
                                    <span class="d-lg-block small mb-0" style="font-family: 'Poiret One', cursive !important; color: #000000; font-weight: 600;">ALEGARIO CURE HOSPITAL</span>
                                </a>
                            </div>
                            <!-- End Logo -->
                            <div class="card mb-3" style="border: none;">

                                <div class="card-body" id="card-body" style="background: #fff; color: #000000;">

                                    <div class="pt-4 pb-2">
                                        <h2 class="card-title text-center " style="color: #06bbac; font-family: 'Inter', sans-serif; font-weight: 800;">LOGIN YOUR ACCOUNT</h2>
                                        <br>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                                        <div class="form-floating mb-7">
                                            <input type="text" class="form-control" name="user" id="floatingInput" placeholder="Username" style="border-top: none; border-left: none; border-right: none; border-bottom: 1px solid #000 !important; box-shadow: none !important;" required>
                                            <label for="floatingInput">Username</label>
                                            <div class="invalid-feedback">
                                                Please enter a Username.
                                            </div>
                                        </div>

                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" style="background-color: inherit; border-top: none; border-left: none; border-right: none; border-bottom: 1px solid #000 !important; box-shadow: none !important;" required>
                                            <label for="floatingPassword">Password</label>
                                            <div class="invalid-feedback">
                                                Please enter a Password.
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <br>
                                            <button class="btn w-100" type="submit" name="login" style="box-shadow: none;">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0" style="text-align: center !important; color: #000000;"><a href="javascript:void(0)" class="first" style="color: #000;">Forgot Password?</a></p>
                                        </div>
                                        <br><br><br><br>
                                        <div class="col-12">
                                            <p class="small mb-0" style="text-align: center !important; color: #393939;">Copyright &copy; All Rights Reserved. Alegario Cure Hospital</p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </section>
        </div>


    </main><!-- End #main -->

<script>
    document.querySelector(".first").addEventListener('click', function(){
        Swal.fire("Makakalimutin yarn? Tawagan mo 'yung super admin niyo para mareset 'yung password mo.");
});
</script>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.min.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
</body>

</html>