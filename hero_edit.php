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

      $sql = "SELECT * FROM heroes WHERE id = '$id_to_update'";

      $result = mysqli_query($conn, $sql);

      $hero = mysqli_fetch_assoc($result);

      $heroName = $hero['hero_name'];
      $ultiSkill = $hero['ulti_skill'];
      $otherSkill = $hero['other_skill'];
      $passSkill = $hero['pass_skill'];
      $role = $hero['role'];
      $battleSpell = $hero['battle_spell'];
      $heroDescription = $hero['hero_description'];
      $heroImage = $hero['image'];
      $heroVideo = $hero['hero_video'];

      // print_r($hero);
    }
?>

<!-- Action for Update/Edit -->
<?php 

  if (isset($_POST['update'])) {


        $id_hidden = $_POST['id_to_update'];
        $heroName = $_POST['hero_name'];
        $role = $_POST['role'];
        $ultiSkill = $_POST['ulti_skill'];
        $otherSkill = $_POST['other_skill'];
        $passSkill = $_POST['pass_skill'];
        $battleSpell = $_POST['battle_spell'];
        $heroDescription = $_POST['hero_description'];
        $heroVideo = $_POST['hero_video'];
        $heroImage = $_FILES['file']['name'];
        $heroTempname = $_FILES['file']['tmp_name'];
        move_uploaded_file($heroTempname, "uploads/" . $heroImage );

        // Construct sql

        $sqel = "UPDATE heroes SET hero_name = '$heroName', role = '$role', ulti_skill = '$ultiSkill', other_skill = '$otherSkill', pass_skill = '$passSkill', battle_spell = '$battleSpell', hero_description = '$heroDescription', image = '$heroImage', hero_video = '$heroVideo' WHERE id = '$id_hidden'";

        // Make Query and get Result
        $result = mysqli_query($conn, $sqel);

        if ($result) {
          
          // print_r($result);
          header('Location: hero.php');
        }

        else{
          echo 'There is an error: ' . mysqli_connect_error($conn);
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
          <label for="inputEmail4" class="form-label">Hero Name:</label>
          <input type="text" class="form-control" id="inputEmail4" name="hero_name" value="<?php echo $heroName; ?>" required="required">

          <input type="hidden" name="id_to_update" value="<?php echo $hero['id']; ?>">
          
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label">Role:</label>
          <select id="inputState" class="form-select" name="role">
            <option selected><?php echo $role; ?></option >
            <option>Marksman</option>
            <option>Mage</option>
            <option>Tank</option>
            <option>Fighter</option>
            <option>Assassin</option>
            <option>Support</option>
          </select>
        </div>
        <div class="col-12">
          <label for="inputAddress" class="form-label">Ultimate Skill</label>
          <input type="text" class="form-control" id="inputAddress" placeholder="" name="ulti_skill" value="<?php echo $ultiSkill; ?>" required="required">
         
        </div>
        <div class="col-12">
          <label for="inputAddress2" class="form-label">Other Skills</label>
          <input type="text" class="form-control" id="inputAddress2" placeholder="" name="other_skill" value="<?php echo $otherSkill; ?>" required="required">
          
        </div>
        <div class="col-md-5">
          <label for="inputCity" class="form-label">Passive Skill</label>
          <input type="text" class="form-control" id="inputCity" name="pass_skill" value="<?php echo $passSkill; ?>" required="required">
          
        </div>
        <div class="col-md-3">
          <label for="inputState" class="form-label">Suggested Battle Spell</label>
          <select id="inputState" class="form-select" name="battle_spell" value="" >
            <option selected><?php echo $battleSpell; ?></option>
            <option>Execute</option>
            <option>Vangeance</option>
            <option>Aegis</option>
            <option>Retribution</option>
            <option>Inspire</option>
            <option>Sprint</option>
            <option>Healing Spell</option>
            <option>Petrify</option>
            <option>Purify</option>
            <option>Weaken</option>
            <option>Flicker</option>
            <option>Arrival</option>
            <option>Iron Wall</option>
          </select>
        </div>
        <div class="col-md-4">
           <label for="inputGroupFile03">Add Image </label>
          <input type="file" id="inputGroupFile03" name="file" required="required">
        </div>

        <div class="col-12">
          <div class="input-group">
          <span class="input-group-text">Hero Description</span>
          <textarea class="form-control" aria-label="With textarea" name="hero_description" required="required"><?php echo $heroDescription; ?></textarea>
          
          </div>
        </div>

        <div class="col-12">
          <div class="input-group">
          <span class="input-group-text">Hero Highlight Video</span>
          <textarea class="form-control" aria-label="With textarea" name="hero_video" placeholder="<iframe>. (optional) .</iframe>" ><?php echo $heroVideo; ?></textarea>
          </div>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary" name="update" >Update</button>
          <button type="reset" class="btn btn-primary" name="reset">Reset</button>
          <a href="./hero_details.php?id=<?php echo $hero['id']; ?>" class="btn btn-primary">Cancel</a>
        </div>
      </form>

    </div>
  </div>

<!-- Footer -->
  <?php include('./template/footer.php'); ?>

</html>