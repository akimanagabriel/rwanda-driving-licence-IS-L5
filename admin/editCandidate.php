<?php
session_start();
$user = $_SESSION['auth'];

require "../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $candidateId = $_GET['id'];
    $candidate = $conn
        ->query("SELECT * FROM `candidate` WHERE `candidateNationalId` = '$candidateId'")
        ->fetch_object();

    if ($candidate == null) {
        die("Error occured, No candidate found with provided id");
    }
}


// update by using post method
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);

    $sql = "UPDATE `candidate` SET `firstName`='$firstName',`lastName`='$lastName',`gender`='$gender',`dob`='$dob',`examDate`='$examDate',`phoneNumber`='$phoneNumber' WHERE `candidateNationalId` = '$candidateNID'";
    if ($conn->query($sql)) {
        $_SESSION['success'] = "Candidate updated!";
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
            <h3>edit candidate information</h3>
            <a href="index.php" class="btn btn-dark">back</a>
        </div>
        <!-- candidate form -->
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">First name</label>
                        <input value="<?php echo $candidate->firstName; ?>" type="text" name="firstName" class="form-control" placeholder="ex: John">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Last Name</label>
                        <input value="<?php echo $candidate->lastName; ?>" type="text" name="lastName" class="form-control" placeholder="ex: Doe">
                    </div>
                </div>

                <input value="<?php echo $candidate->candidateNationalId; ?>" type="hidden"  name="candidateNID">
                


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Date of birth</label>
                        <input value="<?php echo $candidate->dob; ?>" type="date" name="dob" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Phone number</label>
                        <input value="<?php echo $candidate->phoneNumber; ?>" type="number" name="phoneNumber" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Date of exam</label>
                        <input value="<?php echo $candidate->examDate; ?>" type="date" class="form-control" name="examDate">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="Male" <?php echo $candidate->gender == "Male" ? "selected" : null; ?>>Male</option>
                            <option value="Female" <?php echo $candidate->gender == "Female" ? "selected" : null; ?>>Female</option>
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