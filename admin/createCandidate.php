<?php
session_start();
// include connection file 
require "../config/connection.php";
// check if logged in before continue
if (!isset($_SESSION['auth'])) {
    $_SESSION['error'] = "You must login first!";
    return header("location:../");
}

$user = $_SESSION['auth'];


// collect form candidate's data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);

    // sql command
    $sql = "INSERT INTO `candidate`(`candidateNationalId`, `firstName`, `lastName`, `gender`, `dob`, `examDate`, `phoneNumber`) 
    VALUES ('$candidateNationalId','$firstName','$lastName','$gender','$dob','$examDate','$phoneNumber')";

    // execute query
    $ok = $conn->query($sql);
    if ($ok) {
        $_SESSION['success'] = "Candidate created successfuly!";
        header("location:index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | RDL</title>
    <link rel="stylesheet" href="..\bootstrap\css\bootstrap.min.css">
    <script src="..\bootstrap\js\bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light text-secondary">

    <!-- admin header -->
    <div class="bg-black text-white">
        <div class="container d-flex align-items-center justify-content-between">
            <h4>RDL | <?php echo $user->adminName; ?> </h4>

            <ul class="d-flex align-items-center gap-4 mt-3 list-unstyled">
                <li>
                    <a href="index.php" class="btn btn-link text-light text-decoration-none">Candidates</a>
                </li>
                <li>
                    <a href="grades.php" class="btn btn-link text-light text-decoration-none">Check Grades</a>
                </li>
                <li>
                    <a href="../auth/logout.php" class="btn btn-warning">logout</a>
                </li>
            </ul>

        </div>
    </div>

    <!-- page wrapper -->
    <div class="container my-3 bg-white rounded shadow-sm p-4">
        <div class="d-flex justify-content-between mb-4">
            <h3>Create a new candidate</h3>
            <a href="index.php" class="btn btn-dark">back</a>
        </div>
        <!-- candidate form -->
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">First name</label>
                        <input type="text" name="firstName" class="form-control" placeholder="ex: John">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" name="lastName" class="form-control" placeholder="ex: Doe">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">National ID</label>
                        <input type="number" name="candidateNationalId" class="form-control" placeholder="enter 16 digit of NID">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Date of birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Phone number</label>
                        <input type="number" name="phoneNumber" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Date of exam</label>
                        <input type="date" class="form-control" name="examDate">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mt-3">
                        <button class="btn btn-dark px-3">Save Candidate</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</body>

</html>