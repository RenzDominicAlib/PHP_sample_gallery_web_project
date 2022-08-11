<?php session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ./index.php');
}
?>
<?php 
  include('./config/db_connection.php');
?>

<!-- Input validation and Creating/Inserting Data to the Database -->
<?php 



    $itemName = $stats = $itemGear = $itemDescription = $itemVideo = '';

    $errors = ['item_name' => '', 'stats' => '', 'tier_category' => '', 'item_gear' => '', 'item_description' => '' ];

    if (isset($_POST['submit'])) {

      if (empty($_POST['item_name'])) {
          $errors['item_name'] = "(Hero Name is needed) <br>";
        }
        
      else{
          $itemName = $_POST['item_name'];
          if (!preg_match('/^[a-zA-Z\s]+$/', $itemName)) {
            $errors['item_name'] = "(Item name is invalid, it must be letters and space only) <br>";
          }
      }  

      if (empty($_POST['tier_category'])) {
          $errors['tier_category'] = "(Tier Category is needed) <br>";
        }
      else{
          $tierCategory = $_POST['tier_category'];
      } 
 

      if (empty($_POST['stats'])) {
          $errors['stats'] = "(statistics are needed) <br>";
        }
      else{
          $stats = $_POST['stats'];
      } 
      
      if (empty($_POST['item_gear'])) {
          $errors['item_gear'] = "(Suggested Item gear is needed) <br>";
        }
      else{
          $itemGear = $_POST['item_gear'];
      } 

      if (empty($_POST['item_description'])) {
          $errors['item_description'] = "(Item Description is required) <br>";
        }
      else{
          $itemDescription = $_POST['item_description'];
      }


      if (array_filter($errors)) {
        $itemVideo = $_POST['item_video'];
        // echo 'true, dont submit';
      }

      else{
        // echo 'false, okay to submit';

        $itemVideo = $_POST['item_video'];
        
        $itemImage = $_FILES['file']['name'];
        $itemTempname = $_FILES['file']['tmp_name'];
        
        // Construct sql

        $sql = "INSERT INTO items(item_name, tier_category, stats, item_gear, item_description, item_image, item_video) VALUES('$itemName', '$tierCategory', '$stats', '$itemGear', '$itemDescription', '$itemImage', '$itemVideo')";

        // Make Query and get Result
        $result = mysqli_query($conn, $sql);

        if ($result) {
          move_uploaded_file($itemTempname, "uploads/" . $itemImage );
          // print_r($result);
          $_SESSION['added_item'] = "Item added successfully!";
          header('Location: item.php');
        }

        else{
          echo 'There is an error: ' . mysqli_connect_error($conn);
        }    
      }
    }

?>

<!DOCTYPE html>
<html lang="en">

 <?php include('./template/header.php'); ?>
 <div id="backtotop"></div>

 <div class="album py-5 bg-light">
    <div class="container">

      <form class="row g-3" action=" <?php echo $_SERVER['PHP_SELF'];?> " method="POST" enctype="multipart/form-data"  >
        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Item Name:</label>
          <input type="text" class="form-control" id="inputEmail4" name="item_name" value="<?php echo $itemName; ?>" required="required">
          <p class="text-danger"> <?php echo $errors['item_name']; ?> </p>    
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label">Tier Category:</label>
          <select id="inputState" class="form-select" name="tier_category">
            <option selected>Tier Level I</option>
            <option>Tier Level II</option>
            <option>Tier Level III</option>
          </select>
        </div>
       
        <div class="col-12">
          <label for="inputAddress2" class="form-label">Statistics</label>
          <input type="text" class="form-control" id="inputAddress2" placeholder="" name="stats" value="<?php echo $stats; ?>" required="required"> 
          <p class="text-danger"> <?php echo $errors['stats']; ?> </p>  
        </div>
        
        <div class="col-md-3">
          <label for="inputState" class="form-label">Item Gear</label>
          <select id="inputState" class="form-select" name="item_gear" >
            <option selected>Attack Item</option>
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
          <p class="text-danger"> <?php echo $errors['item_description']; ?> </p>
          </div>
        </div>

        <div class="col-12">
          <div class="input-group">
          <span class="input-group-text">Item Highlight Video</span>
          <textarea class="form-control" aria-label="With textarea" name="item_video" placeholder="<iframe>. . .</iframe>" ><?php echo $itemVideo; ?></textarea>
          </div>
        </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary" name="submit" value="">Submit</button>
        <button type="reset" class="btn btn-primary" name="reset" value="">Reset</button>
        <a href="./item.php" class="btn btn-primary">Cancel</a>
      </div>
    </form>

  </div>
</div>

<?php include('./template/footer.php'); ?>

</html>