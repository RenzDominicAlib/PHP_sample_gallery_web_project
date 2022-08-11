<?php session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ./index.php');
}
?>

<?php 
	include('./config/db_connection.php');
?>

<!-- Action to Specific Details based on ID GET Method -->
<?php 

	if ($_GET['id']) {
		
		if (isset($_GET['id'])) {

			$id = $_GET['id'];
		
			$sql = "SELECT * FROM items WHERE `id` = '$id'";

			$result = mysqli_query($conn, $sql);

			$item = mysqli_fetch_assoc($result);

			
			if ($item['item_video']) {

				if (preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $item['item_video'])) {

					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/GUohiLUXIk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';		
				}

				elseif(empty($item['item_video'])){

					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/GUohiLUXIk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}

				elseif (preg_match('/^[a-zA-Z\s]+$/', $item['item_video'])) {
					
					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/GUohiLUXIk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}


				elseif (preg_match('/^[0-9\s]+$/', $item['item_video'])) {
					
					$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/GUohiLUXIk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				}


				else {
					$videoframe = $item['item_video'];
				}
			}

			else{
				$videoframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/GUohiLUXIk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';


			}


			// print_r($hero);

			mysqli_free_result($result);

			mysqli_close($conn);

		}

	}

?>





<!DOCTYPE html>
<html lang="en">

<?php include('./template/header.php'); ?>

<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light hero_name_font"> <?php echo $item['item_name']; ?> </h1>
        <div id="backtotop"></div>
        <img src="./uploads/<?php echo $item['item_image'];?>" class="img-fluid mt-5 mb-5" alt="hero" style="padding:15px;width:25rem;height:25rem;">

        <p class="lead text-muted hero_description_font"><?php echo $item['item_description']; ?></p>

        <h4 class="fw-light hero_name_font"> Tier Category: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $item['tier_category']; ?></p>

        <h4 class="fw-light hero_name_font"> Item Gear: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $item['item_gear']; ?></p>

        <h4 class="fw-light hero_name_font"> Statistics: </h4>
        <p class="lead text-muted hero_description_font"><?php echo $item['stats']; ?></p>

        <p>
          <a href="./item.php"class="btn btn-primary my-2">Back</a>
          <a href="./item_edit.php?id=<?php echo $item['id'];?> " class="btn btn-secondary my-2">Edit</a>
          <a href="https://mobile-legends.fandom.com/wiki/<?php echo $item['item_name']; ?>" class="btn btn-secondary my-2" target="_blank">See more</a>
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