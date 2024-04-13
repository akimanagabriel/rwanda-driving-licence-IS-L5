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

// read a result of user
$gradeResult = "";
if (isset($_GET['candidateNID'])) {
    $candidateId = $_GET['candidateNID'];
    $sql = "SELECT * FROM grade,candidate 
    WHERE grade.candidateNationalId = candidate.candidateNationalId 
    AND candidate.candidateNationalId= '$candidateId'";

    $gradeResult = $conn->query($sql)->fetch_object();
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
            <h3>Grading page</h3>
            <div>
                <a class="btn px-3  btn-secondary" href="assignGradeToCandidate.php">Assign Marks to Candidate</a>
                <a href="index.php" class="btn btn-dark">back</a>
            </div>
        </div>

        <div class="py-2">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='alert alert-danger'>", $_SESSION['error'], "</p>";
                unset($_SESSION['error']);
            } else if (isset($_SESSION['success'])) {
                echo "<p class='alert alert-success'>", $_SESSION['success'], "</p>";
                unset($_SESSION['success']);
            }
            ?>
        </div>

        <div class="form-group">
            <label>find a someones grade? choose his/her national id.</label>
            <form>
                <div class="d-flex">
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
                    <button class="btn btn-dark rounded-0" style="width: 150px;">Find Now</button>
                </div>
            </form>
        </div>



    </div>

    <?php
    if (isset($gradeResult) && $gradeResult != null) { ?>

        <div class="container my-3 bg-white rounded shadow-sm p-4">
            <h4>Result of <strong><?php echo $gradeResult->firstName, " ", $gradeResult->lastName ?></strong></h4>
            <table class="table">
                <tr>
                    <td class="fw-bold">Names</td>
                    <td>
                        <?php echo $gradeResult->firstName, " ", $gradeResult->lastName ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Telephone number</td>
                    <td>
                        <?php echo $gradeResult->phoneNumber ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Gender</td>
                    <td>
                        <?php echo $gradeResult->gender ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Born on</td>
                    <td>
                        <?php echo $gradeResult->dob ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">National ID</td>
                    <td>
                        <?php echo $gradeResult->candidateNationalId ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Licence category</td>
                    <td>
                        CAT <strong class="fw-bold text-success"><?php echo $gradeResult->licenseExamCategory ?></strong>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Marks</td>
                    <td>
                        <?php echo $gradeResult->obtainedMarks ?> / 20
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Done on</td>
                    <td>
                        <?php echo $gradeResult->examDate ?>
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Decision</td>
                    <td>
                        <span class="badge px-3 text-uppercase <?php echo $gradeResult->decision == 'Pass' ? 'bg-success' : 'bg-danger' ?>"><?php echo $gradeResult->decision ?></span>
                    </td>
                </tr>
            </table>
        </div>
    <?php
    } else if ($gradeResult === null) {

    ?>
        <div class="container">
            <div class="alert alert-info">The selected candidates doesn't have any grade.</div>
        </div>
    <?php

    }
    ?>

</body>

</html>