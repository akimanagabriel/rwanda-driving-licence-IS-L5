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

    // check if marks already recorded
    $existMarks = $conn->query("SELECT * FROM `grade` WHERE `candidateNationalId`='$candidateNID'")->fetch_object();
    if ($existMarks != null) {
        $_SESSION['error'] = "mark already recorded";
        return header("location:grades.php");
    }

    $decision = $marks >= 12 ? "Pass" : "Fail";

    $sql = "INSERT INTO `grade`(`candidateNationalId`, `licenseExamCategory`, `obtainedMarks`, `decision`) 
    VALUES ('$candidateNID','$category','$marks','$decision')";

    $ok = $conn->query($sql);

    if ($ok) {
        $_SESSION['success'] = "Mark assigned successfuly";
        return header("location:grades.php");
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
            <h3>Assign marks to a candidate</h3>
        </div>
        <!-- candidate form -->
        <form method="post">
            <div class="form-group">
                <label for="">Select a candidate</label>
                <select required name="candidateNID" class="form-control rounded-0">
                    <option value="" disabled selected>-- select a candidate --</option>
                    <?php
                    // list of candidates
                    $candidates = $conn->query("SELECT * FROM `candidate`");
                    while ($candidate = $candidates->fetch_object()) {
                        echo "<option value=", $candidate->candidateNationalId, ">", $candidate->firstName, " ", $candidate->lastName, "  ( ", $candidate->candidateNationalId, " )</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="">Licence category</label>
                <select required name="category" class="form-control rounded-0">
                    <option value="A">Cat A</option>
                    <option value="B">Cat B</option>
                    <option value="C">Cat C</option>
                    <option value="D">Cat D</option>
                    <option value="F">Cat F</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Marks obtained (max is 20)</label>
                <input type="number" max="20" name="marks" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-dark px-3 mt-3">Save</button>
            </div>
        </form>

    </div>
</body>

</html>