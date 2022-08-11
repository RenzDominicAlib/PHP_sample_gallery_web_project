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



    $heroName = $ultiSkill = $otherSkill = $passSkill = $heroDescription = $heroVideo = '';

    $errors = ['hero_name' => '', 'ulti_skill' => '', 'other_skill' => '', 'pass_skill' => '', 'hero_description' => '' ];

    if (isset($_POST['submit'])) {


      if (empty($_POST['hero_name'])) {
          $errors['hero_name'] = "(Hero Name is needed) <br>";
        }
        
      else{
          $heroName = $_POST['hero_name'];
          if (!preg_match('/^[a-zA-Z\s]+$/', $heroName)) {
            $errors['hero_name'] = "(Hero name is invalid, it must be letters and space only) <br>";
          }
      }  

      if (empty($_POST['role'])) {
          $errors['role'] = "(Heros Role is needed) <br>";
        }
      else{
          $role = $_POST['role'];
      } 

      if (empty($_POST['ulti_skill'])) {
          $errors['ulti_skill'] = "(Ultimate skill is needed) <br>";
        }
      else{
          $ultiSkill = $_POST['ulti_skill'];
      } 

      if (empty($_POST['other_skill'])) {
          $errors['other_skill'] = "(Other Skills are needed) <br>";
        }
      else{
          $otherSkill = $_POST['other_skill'];
          if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $otherSkill)) {
            $errors['other_skill'] = "(Skills must be words and comma separated list) <br>";
          }
      } 

      if (empty($_POST['pass_skill'])) {
          $errors['pass_skill'] = "(Passive skill is needed) <br>";
        }
      else{
          $passSkill = $_POST['pass_skill'];
      } 
      
      if (empty($_POST['battle_spell'])) {
          $errors['battle_spell'] = "(Suggested Battle Spell is needed) <br>";
        }
      else{
          $battleSpell = $_POST['battle_spell'];
      } 

      if (empty($_POST['hero_description'])) {
          $errors['hero_description'] = "(Hero Description is required) <br>";
        }
      else{
          $heroDescription = $_POST['hero_description'];
      }


      if (array_filter($errors)) {
        $heroVideo = $_POST['hero_video'];
        // echo 'true, dont submit';
      }

      else{
        // echo 'false, okay to submit';

        $heroVideo = $_POST['hero_video'];
        
        $heroImage = $_FILES['file']['name'];
        $heroTempname = $_FILES['file']['tmp_name'];
        
        // Construct sql

        $sql = "INSERT INTO heroes(hero_name, role, ulti_skill, other_skill, pass_skill, battle_spell, hero_description, image, hero_video) VALUES('$heroName', '$role', '$ultiSkill', '$otherSkill', '$passSkill', '$battleSpell', '$heroDescription', '$heroImage', '$heroVideo')";

        // Make Query and get Result
        $result = mysqli_query($conn, $sql);

        if ($result) {
          move_uploaded_file($heroTempname, "uploads/" . $heroImage );
          // print_r($result);

          $_SESSION['added'] = "Hero added successfully!";
          header('Location: hero.php');
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
        <label for="inputEmail4" class="form-label">Hero Name:</label>
        <input type="text" class="form-control" id="inputEmail4" name="hero_name" value="<?php echo $heroName; ?>">
        <p class="text-danger"> <?php echo $errors['hero_name']; ?> </p>
      </div>
      <div class="col-md-6">
        <label for="inputState" class="form-label">Role:</label>
        <select id="inputState" class="form-select" name="role">
          <option selected>Marksman</option >
          <option>Mage</option>
          <option>Tank</option>
          <option>Fighter</option>
          <option>Assassin</option>
          <option>Support</option>
        </select>
      </div>
      <div class="col-12">
        <label for="inputAddress" class="form-label">Ultimate Skill</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="" name="ulti_skill" value="<?php echo $ultiSkill; ?>">
        <p class="text-danger"> <?php echo $errors['ulti_skill']; ?> </p>
      </div>
      <div class="col-12">
        <label for="inputAddress2" class="form-label">Other Skills</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="" name="other_skill" value="<?php echo $otherSkill; ?>">
        <p class="text-danger"> <?php echo $errors['other_skill']; ?> </p>
      </div>
      <div class="col-md-5">
        <label for="inputCity" class="form-label">Passive Skill</label>
        <input type="text" class="form-control" id="inputCity" name="pass_skill" value="<?php echo $passSkill; ?>">
        <p class="text-danger"> <?php echo $errors['pass_skill']; ?> </p>
      </div>
      <div class="col-md-3">
        <label for="inputState" class="form-label">Suggested Battle Spell</label>
        <select id="inputState" class="form-select" name="battle_spell" value="">
          <option selected>Execute</option>
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
        <input type="file" id="inputGroupFile03" name="file">
        
      </div>

      <div class="col-12">
        <div class="input-group">
        <span class="input-group-text">Hero Description</span>
        <textarea class="form-control" aria-label="With textarea" name="hero_description"><?php echo $heroDescription; ?></textarea>
        <p class="text-danger"> <?php echo $errors['hero_description']; ?> </p>
        </div>
      </div>

      <div class="col-12">
        <div class="input-group">
        <span class="input-group-text">Hero Highlight Video</span>
        <textarea class="form-control" aria-label="With textarea" name="hero_video" placeholder="<iframe>. (optional) .</iframe>" ><?php echo $heroVideo; ?></textarea>
        </div>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary" name="submit" value="">Submit</button>
        <button type="reset" class="btn btn-primary" name="reset" value="">Reset</button>
        <a href="./hero.php" class="btn btn-primary">Cancel</a>
      </div>
    </form>

  </div>
</div>

<?php include('./template/footer.php'); ?>

</html>