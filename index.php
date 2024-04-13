<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RDL</title>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex justify-content-center align-items-center bg-light text-secondary" style="height: 100vh;">
    <form class="bg-white p-5 rounded" method="post" action="auth/login.php">
        <h1 class="pb-4 text-center">RDL</h1>

        <!-- display error messages -->
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='alert alert-danger alert-sm'>", $_SESSION['error'], "</p>";
        }
        unset($_SESSION['error']);
        ?>

        <div class="row mb-3">
            <label for="inputEmail3" class="">Email</label>
            <div class="">
                <input name="adminName" type="text" class="form-control" id="inputEmail3">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputPassword3" class="">Password</label>
            <div class="">
                <input name="adminPassword" type="password" class="form-control" id="inputPassword3">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2">Sign in</button>
    </form>
</body>

</html>