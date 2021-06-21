<?php
session_start();
//include all necessary files 
include("connect.php");
include("functions.php");


//checks if the user is logged in
if (!isset($_SESSION['loggedIn'])) {
    header("location: login.php");
}



$query = "SELECT * FROM medicine WHERE user_ID = " . $_SESSION['user_id'] . "";
$result = mysqli_query($con, $query);

$user_id = intval($_SESSION["user_id"]);

if (isset($_POST["saveDosageRecord"])) {

    $medicine_id = $_POST["medicine_id"];
    $date_taken = $_POST["date_taken"];
    $time_taken = $_POST["time_taken"];

    $query = "INSERT INTO tbl_dosages(medicine_id,user_id, date_taken, time_taken)
        VALUES(?,?,?,?)";

    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("iiss", $medicine_id, $user_id, $date_taken, $time_taken);

        if ($stmt->execute()) {
            echo '<h4 class="text-success text-center">Dosage Saved Successfully</h4>';
        } else {
            echo '<h4 class="text-danger text-center">Error Saving Dosage</h4>';
        }
    }else{
        echo '<h4 class="text-danger text-center">Sorry Incorrect Input</h4>';
    }
}


?>
<?php set_header("New Dosage") ?>

<div class="contianer">
    <div class="row mt-2">
        <div class="col-md-4 p-5">
            <h4 class="display-4">Dosages Record</h4>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Medicine Name</label>
                    <select name="medicine_id" id="medicine_id" class="form-select" required>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row['ID'] . "'>" . $row['medicine_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Date Taken</label>
                    <input type="date" name="date_taken" id="date_taken" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Time Taken</label>
                    <input type="time" name="time_taken" id="time_taken" required class="form-control">
                </div>

                <input type="submit" name="saveDosageRecord" value="Save" class="btn btn-success my-2 btn-block">
            </form>
        </div>

        <div class="col-md-8 p-5">
            <main>
            <h4>Dosages Record</h4>
                <ul class="list-group">
                <?php
                    $query = 'SELECT dosage_id,medicine_name,date_taken,time_taken FROM tbl_dosages inner join medicine on tbl_dosages.medicine_id = medicine.ID WHERE tbl_dosages.user_id = ' . $user_id . '';
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                <small>'.$row["medicine_name"].'</small>
                                <small>'.$row["date_taken"].'</small>
                                <small>'.$row["time_taken"].'</small>
                            </li>';
                            echo "<br>";
                        }
                    } else {
                        echo '<h4 class="text-mute text-center">No Dosage Record Found</h4>';
                    }
                    ?>
                    
                  
                </ul>
               
            </main>
        </div>
    </div>
</div>
<?php set_footer()?>