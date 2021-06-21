<?php
session_start();
include("connect.php");
include("functions.php");

if (!isset($_SESSION['loggedIn'])) {
    header("location: login.php");
} else {
    
    if (isset($_POST["saveMedicine"])) {

        try {

            //store user_id from current session in a variable
            $user_id = $_SESSION["user_id"];
            //retrieve variables 
            $MedicineName = trim($_POST["medicine_name"]);
            $DosageQty = intval(trim($_POST["dosage_quantity"]));
            $Dosagetype = trim($_POST["dosage_unit"]);
            $MilligramQty = intval(trim($_POST["milligram_quantity"]));
            $MilligramUnit = trim($_POST["milligram_unit"]);
            $FrequencyQty = intval(trim($_POST["frequency_quantity"]));
            $Frequencytype = trim($_POST["frequency_unit"]);



            $query = "INSERT INTO medicine (medicine_name, dosage_quantity, dosage_unit, milligram_quantity, milligram_unit, frequency_quantity, frequency_unit, user_ID)
                VALUES (?,?,?,?,?,?,?,?);";

            if ($statement = $con->prepare($query)) {
                if ($statement->bind_param("sisisisi", $MedicineName, $DosageQty, $Dosagetype, $MilligramQty, $MilligramUnit, $FrequencyQty, $Frequencytype, $user_id)) {

                    if ($statement->execute()) {
                        echo '<h4 class="text-success text-center">Medicine Added Successfully</h4>';
                    } else {
                        echo '<h4 class="text-danger text-center">Error Saving Medicine</h4>';
                    }
                } else {
                    echo '<h4 class="text-danger text-center">Something went wrong, Please try again</h4>';
                }
            } else {
                echo '<h4 class="text-danger text-center">Something went wrong, Please try again</h4>';
            }


        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}


?>

<?php set_header("Save New Medicine"); ?>
<div class="container">
    <div class="row mt-5">

        <div class="col-md-8 offset-md-2">
            <h5 class="display-5">Add New Medicine</h5>
            <a href="index.php" class="btn btn-info pill-right mb-4">View All Medicines</a>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Medicine Name</label>
                    <input type="text" name="medicine_name" id="medicine_name" placeholder="Medicine Name" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Dosage Quantity</label>
                    <input type="number" name="Dosage_quantity" id="Dosage_quantity" required class="form-control" min="1" max="300" value="1">
                </div>
                <div class="form-group">
                    <label for="">Dosage type</label>
                    <select name="Dosage_type" id="Dosage_type" class="form-select" required>
                        <option value="Tab" selected>Tab</option>
                        <option value="Bottle">Bottle</option>
                        <option value="Syringe/Injection">Syringe/Injection</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Milligrams</label>
                    <input type="text" name="Milligram_quantity" id="Milligram" placeholder="Milligram" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Unit(g/mg)</label>
                    <select name="Milligram_unit" id="unit" class="form-select" required>
                        <option value="Grams" selected>Grams</option>
                        <option value="MilliGrams">MilliGrams</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Frequency Quantity</label>
                    <input type="number" name="Frequency_quantity" id="Frequency_quantity" placeholder="Frequency Quantity" required class="form-control" min="1" max="300" value="1">
                </div>

                <div class="form-group">
                    <label for="">Frequency type</label>
                    <select name="frequency_type" id="frequency_type" class="form-select">
                        <option value="Daily" selected>Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Montly">Monthly</option>
                    </select>
                </div>
                <input type="submit" name="saveMedicine" value="Save New Medicine" class="form-control btn btn-info btn-block my-3">
            </form>
            
        </div>
    </div>
</div>

<?php set_footer()?>