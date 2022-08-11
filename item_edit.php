<?php session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ./index.php');
}
?>

<!-- Action to Display Existing Details -->
<?php 

  include('./config/db_connection.php');
   
    if (isset($_GET['id'])){

      $id_to_update = $_GET['id'];

      $sql = "SELECT * FROM items WHERE id = '$id_to_update' ";

      $result = mysqli_query($conn, $sql);

      $item = mysqli_fetch_assoc($result);

      $itemName = $item['item_name'];
      $tierCategory = $item['tier_category'];
      $itemDescription = $item['item_description'];
      $itemGear = $item['item_gear'];
      $stats = $item['stats'];
      $itemVideo = $item['item_video'];
      $itemImage = $item['item_image'];

      // print_r($item);
    }
?>


<!-- Action for Update/Edit -->
<?php 

  if (isset($_POST['update'])) {


        $id_hidden = $_POST['id_to_update'];
        $itemName = $_POST['item_name'];
        $tierCategory = $_POST['tier_category'];
        $itemDescription = $_POST["item_description"];
        $itemGear = $_POST['item_gear'];
        $stats = $_POST['stats'];
        $itemVideo = $_POST['item_video'];
        $itemImage = $_FILES['file']['name'];
        $itemTempname = $_FILES['file']['tmp_name'];
        move_uploaded_file($itemTempname, "uploads/" . $itemImage );

        // Construct sql

        $sqel = "UPDATE items SET item_name = '$itemName', tier_category = '$tierCategory', item_description = '$itemDescription', item_gear = '$itemGear', stats = '$stats', item_image = '$itemImage', item_video = '$itemVideo' WHERE id = '$id_hidden'";

        // Make Query and get Result
        $result = mysqli_query($conn, $sqel);

        if ($result) {
          
          // print_r($result);
          header('Location: item.php');
        }

        else{
          echo 'There is an updating error: ' . mysqli_connect_error($conn);
        }    
  }
?>



<!DOCTYPE html>
<html lang="en">

<!-- Header -->
 <?php include('./template/header.php'); ?>
 <div id="backtotop"></div>

<!-- Form -->
  <div class="album py-5 bg-light">
    <div class="container">

      <form class="row g-3" action=" <?php echo $_SERVER['PHP_SELF'];?> " method="POST" enctype="multipart/form-data"  >
        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Item Name:</label>
          <input type="text" class="form-control" id="inputEmail4" name="item_name" value="<?php echo $itemName; ?>" required="required">

          <input type="hidden" name="id_to_update" value="<?php echo $item['id']; ?>">
          
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label">Tier Category:</label>
          <select id="inputState" class="form-select" name="tier_category">
            <option selected><?php echo $tierCategory; ?></option >
            <option>Tier Level I</option>
            <option>Tier Level II</option>
            <option>Tier Level III</option>
          </select>
        </div>
       
        <div class="col-12">
          <label for="inputAddress2" class="form-label">Statistics</label>
          <input type="text" class="form-control" id="inputAddress2" placeholder="" name="stats" value="<?php echo $stats; ?>" required="required">   
        </div>
        
        <div class="col-md-3">
          <label for="inputState" class="form-label">Item Gear</label>
          <select id="inputState" class="form-select" name="item_gear" >
            <option selected><?php echo $itemGear; ?></option>
            <option>Attack Item</option>
            <option>Defense Item</option>
            <option>Magic Item</option>
            <option>Jungle Item</option>
            <option>Movement Item</option>
            <option>Roam Item</option>
            <option>Remove Item</option>
            
          </select>
        </div>
        <div class="col-md-4">
           <label for="inputGroupFile03">New Image </label>
          <input type="file" id="inputGroupFile03" name="file" required="required">
        </div>

        <div class="col-12">
          <div class="input-group">
          <span class="input-group-text">Item Description</span>
          <textarea class="form-control" aria-label="With textarea" name="item_description" required="required"><?php echo $itemDescription; ?></textarea>
          
          </div>
        </div>

        <div class="col-12">
          <div class="input-group">
          <span class="input-group-text">Item Highlight Video</span>
          <textarea class="form-control" aria-label="With textarea" name="item_video" placeholder="<iframe>. . .</iframe>" ><?php echo $itemVideo; ?></textarea>
          </div>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary" name="update" >Update</button>
          <button type="reset" class="btn btn-primary" name="reset">Reset</button>
          <a href="./item_details.php?id=<?php echo $item['id']; ?>" class="btn btn-primary">Cancel</a>
        </div>
      </form>

    </div>
  </div>

<!-- Footer -->
  <?php include('./template/footer.php'); ?>

</html>