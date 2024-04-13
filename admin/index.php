<?php
session_start();
// include connection
require "../config/connection.php";
// check if logged in before continue
if (!isset($_SESSION['auth'])) {
    $_SESSION['error'] = "You must login first!";
    return header("location:../");
}

$user = $_SESSION['auth'];

// retrieve all candidates from db
$sql = "SELECT * FROM `candidate`";
$candidates = $conn->query($sql);

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
            <h3>All candidates</h3>
            <a href="createCandidate.php" class="btn btn-dark">add new candidate</a>
        </div>

        <!-- show success alert -->
        <?php
        if (isset($_SESSION['success'])) {
            echo "<p class='alert alert-success'>", $_SESSION['success'] ,"</p>";
            unset($_SESSION['success']);
        }
        ?>


        <!-- candidate table -->
        <?php
        if ($candidates) {
        ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>National ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Date of Exam</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($candidate = $candidates->fetch_object()) {
                    ?>
                        <tr>
                            <td><?php echo $candidate->candidateNationalId; ?></td>
                            <td><?php echo $candidate->firstName; ?></td>
                            <td><?php echo $candidate->lastName; ?></td>
                            <td><?php echo $candidate->dob; ?></td>
                            <td><?php echo $candidate->phoneNumber; ?></td>
                            <td><?php echo $candidate->gender; ?></td>
                            <td><?php echo $candidate->examDate; ?></td>
                            <td class="d-flex gap-2">
                                <a href="editCandidate.php?id=<?php echo $candidate->candidateNationalId; ?>" class="btn btn-sm btn-primary px-3">edit</a>
                                <button onclick="handleDeleteCandidate(<?php echo $candidate->candidateNationalId; ?>)" class="btn btn-sm btn-danger px-3">delete</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<p class='alert alert-info'> No candidate available</p>";
        }
        ?>
    </div>

    <script>
        const handleDeleteCandidate = id => {
            if (window.confirm(`are you sure? you want to dele a candidate with and ID of ${id}?`)) {
                window.location.href = "deleteCandidate.php?id=" + id
            }
        }
    </script>

</body>

</html>