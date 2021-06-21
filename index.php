<?php
session_start();
include("connect.php");
include("functions.php");


if ($_SESSION['loggedIn'] == false) {
  header("location: login.php");
  die;
}



if(isset($_GET["delete"]) && $_GET["delete"] == true && isset($_GET["medicine_id"]))
{
  $medicine_id =intval($_GET["medicine_id"]);
        
  $query = "DELETE FROM medicine WHERE ID = ?";
  if($stmt = $con->prepare($query)){
    $stmt->bind_param("i",$medicine_id);
    if($stmt->execute()){
      echo '<h5 class="display-4">Record Deleted Successfully</h5>';
      header("location: index.php");
    }else{
      echo '<h5 class="display-4">Error In Deleting Record, Please Try Again </h5>';
    }
  }

}


?>

<?php set_header("Home") ?>

<div class="container-fluid">
  <div class="row mt-5 px-5">
    <div class="col-md-12">

      <a href="saveMedicine.php" class="btn btn-success mb-3 mr-3">Save New Medicine</a>
      <a href="dosages.php" class="btn btn-info mb-3">Record New Dosage</a>
      <div class="table-responsive">

        <table class="table table-striped table-light">
          <thead>
            <tr>
             
              <th>Drugs Name</th>
              <th>Dosage Qty.</th>
              <th>Dosage Type</th>
              <th>Measurement Qty.</th>
              <th>Measurement Unit</th>
              <th>Frequency Qty.</th>
              <th>Frequency Type</th>
              <th colspan="2">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php
                $query = "SELECT * FROM medicine WHERE user_ID = ".$_SESSION['user_id']."";
                $result = mysqli_query($con, $query);

                if($result){
                    $count = 1;
                    while($rows = mysqli_fetch_array($result)){
                      echo '
                      <tr>
                        <td>' . $rows['medicine_name'] . '</td>
                        <td>' . $rows['dosage_quantity'] . '</td>
                        <td>' . $rows['dosage_unit'] . '</td>
                        <td>' . $rows['milligram_quantity'] . '</td>
                        <td>' . $rows['milligram_unit'] . '</td>
                        <td>' . $rows['frequency_quantity'] . '</td>
                        <td>' . $rows['frequency_unit'] . '</td>
                        <td><a class="btn btn-primary btn-block" href="edit_drug.php?id='.$rows['ID'].'">EDIT</a></td>
                        <td><a class="btn btn-danger btn-block" href="index.php?delete=true&medicine_id='.$rows['ID'].'">DELETE</a></td>
                    </tr>
                ';
                        $count += 1;
                    }
                }else{
                    echo "<h1>MEDICINE  NOT FOUND</h1>";
                }
            ?>
          </tbody>
        </table>
      </div>


    </div>

  </div>

</div>
<?php set_footer()?>