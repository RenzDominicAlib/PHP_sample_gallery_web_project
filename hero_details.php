<?php session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ./index.php');
}
?>

<?php 
	include('./config/db_connection.php');
?>

<!-- Action to Specific Details based on id GET Method -->
<?php 

	// if ($_GET['id']) {
		
		if (isset($_GET['id'])) {

			$id = $_GET['id'];
		
			$sql = "SELECT * FROM heroes WHERE `id` = '$id'";

			$result = mysqli_query($conn, $sql);

			$hero = mysqli_fetch_assoc($result);

			
			if ($hero['hero_video']) {

				if (preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $hero['hero_video'])) {

					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/1WolDM3mnSY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';		
				}

				elseif(empty($hero['hero_video'])){

					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/1WolDM3mnSY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}

				elseif (preg_match('/^[a-zA-Z\s]+$/', $hero['hero_video'])) {
					
					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/1WolDM3mnSY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}


				elseif (preg_match('/^[0-9\s]+$/', $hero['hero_video'])) {
					
					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/1WolDM3mnSY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}


				else {
					$videoframe = $hero['hero_video'];
				}
			}

			else{
				$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/1WolDM3mnSY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';


			}


			// print_r($hero);

			mysqli_free_result($result);

			mysqli_close($conn);

		}

	// }
?>





<!DOCTYPE html>
<html lang="en">

<?php include('./template/header.php'); ?>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light hero_name_font"> <?php echo $hero['hero_name']; ?> </h1>
        <div id="backtotop"></div>
        <img src="./uploads/<?php echo $hero['image'];?>" class="img-fluid mt-5 mb-5" alt="hero" style="padding:15px;width:20rem;height:25rem;">

        <p class="lead text-muted hero_description_font"><?php echo $hero['hero_description']; ?></p>

        <h4 class="fw-light hero_name_font"> Ultimate Skill: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $hero['ulti_skill']; ?></p>

        <h4 class="fw-light hero_name_font"> Passive Skill: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $hero['pass_skill']; ?></p>

        <h4 class="fw-light hero_name_font"> Other Skills: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $hero['other_skill']; ?></p>

        <h4 class="fw-light hero_name_font"> Game Role: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $hero['role']; ?></p>

        <h4 class="fw-light hero_name_font"> Suggested Battle Spell: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $hero['battle_spell']; ?></p>




        <p>
          <a href="./hero.php"class="btn btn-primary my-2">Back</a>
          <a href="./hero_edit.php?id=<?php echo $hero['id'];?> " class="btn btn-secondary my-2">Edit</a>
          <a href="https://mobile-legends.fandom.com/wiki/<?php echo $hero['hero_name']; ?>" class="btn btn-secondary my-2" target="_blank">See more</a>
        </p>
      </div>
    </div>
  </section>

  <section class="py-5 text-center container">
	  <div class="ratio ratio-16x9">
	  <?php echo $videoframe; ?>
	  </div>
  </section>>

</main>

<?php include('./template/footer.php'); ?>