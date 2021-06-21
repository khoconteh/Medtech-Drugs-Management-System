<?php
session_start();
include("connect.php");
include("functions.php");

if (!isset($_SESSION['loggedIn'])) {
    header("location: login.php");
} else {

    $medicine_id;

    if (isset($_GET["id"])) {
        $medicine_id = intval($_GET['id']);
        $query = "SELECT * FROM medicine WHERE ID = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $medicine_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        }
    }

    if (isset($_POST["updateMedicine"])) {

        //retrieve variables 
        $medicineName = trim($_POST["medicine_name"]);
        $dosageQty = intval(trim($_POST["dosage_quantity"]));
        $dosageUnit = trim($_POST["dosage_unit"]);
        $milligramQty = intval(trim($_POST["milligram_quantity"]));
        $milligramUnit = trim($_POST["milligram_unit"]);
        $frequencyQty = intval(trim($_POST["frequency_quantity"]));
        $frequencyUnit = trim($_POST["frequency_unit"]);


        $query = "UPDATE medicine SET 
        medicine_name = ?,
        dosage_quantity = ?,
        dosage_unit = ?,
        milligram_quantity = ?,
        milligram_unit = ?,
        frequency_quantity = ?,
        frequency_unit = ? WHERE ID = ?";

        if ($statement = $con->prepare($query)) {
            if ($statement->bind_param("sisisisi", $medicineName, $dosageQty, $dosageUnit, $milligramQty, $milligramUnit, $frequencyQty, $frequencyUnit, $medicine_id)) {

                if ($statement->execute()) {
                    echo "Successfully Updated";
                    header("location: index.php");
                } else {
                    echo "Error Updating";
                    header("location: edit_drug.php?id=" . $medicine_id. "");
                }
            } else {
                echo "error binding";
            }
        } else {
            echo "Error in sql statement";
        }


    
    }
}
?>

<?php set_header("Edit Medicine") ?>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <h5 class="display-5 my-1">Edit and Update Medicine</h5>
            <?php
            if (!empty($row)) {
                echo '
                    <form action="" method="post">
                    <div class="form-group">
                        <label for="">Medicine Name</label>
                        <input type="text" name="medicine_name" id="medicine_name" placeholder="Medicine Name" required class="form-control" value="' . $row["medicine_name"] . '">
                    </div>
                    <div class="form-group">
                        <label for="">Dosage Quantity</label>
                        <input type="number" name="dosage_quantity" id="dosage_quantity" required class="form-control" min="1" max="300" value="' . $row["dosage_quantity"] . '">
                    </div>
                    <div class="form-group">
                        <label for="">Dosage Unit</label>
                        <select name="dosage_unit" id="dosage_unit" class="form-select" required>
                            <option value="' . $row["dosage_unit"] . '" selected>' . $row["dosage_unit"] . '</option>
                            <option value="Tab" >Tab</option>
                            <option value="Bottle">Bottle</option>
                            <option value="Syringe/Injection">Syringe/Injection</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Milligrams</label>
                        <input type="text" name="milligram_quantity" id="milligram" placeholder="Milligram" required class="form-control" value="' . $row["milligram_quantity"] . '">
                    </div>
                    <div class="form-group">
                        <label for="">Unit(g/mg)</label>
                        <select name="milligram_unit" id="unit" class="form-select" required>
                            <option value="' . $row["milligram_unit"] . '" selected>' . $row["milligram_unit"] . '</option>
                            <option value="Grams" >Grams</option>
                            <option value="MilliGrams">MilliGrams</option>
                        </select>
                    </div>
    
                    <div class="form-group">
                        <label for="">Frequency Quantity</label>
                        <input type="number" name="frequency_quantity" id="frequency_quantity" placeholder="Frequency Quantity" required class="form-control" min="1" max="300" value="' . $row["frequency_quantity"] . '">
                    </div>
    
                    <div class="form-group">
                        <label for="">Frequency Unit</label>
                        <select name="frequency_unit" id="frequency_unit" class="form-select">
                            <option value="' . $row["frequency_unit"] . '" selected>' . $row["frequency_unit"] . '</option>
                            <option value="Daily" >Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Montly">Monthly</option>
                        </select>
                    </div>
                    <input type="submit" name="updateMedicine" value="Update Record" class="form-control btn btn-warning btn-block my-3">
                </form>';
            }

            ?>


        </div>
    </div>
</div>
<?php set_footer()?>