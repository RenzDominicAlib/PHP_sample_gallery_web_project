<?php session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ./index.php');
}
?>

<?php 

include('./config/db_connection.php');

?>


<!-- Action for Deleting -->
<?php

    if (isset($_POST['delete'])) {

      $id_to_delete = $_POST['id_to_delete'];

      $sql = "DELETE FROM items WHERE `id` = '$id_to_delete' ";

      $result = mysqli_query($conn, $sql);

      if ($result) {

        header("Location:" . $_SERVER['PHP_SELF']);
      }

      else{
        echo 'There is an error: ' . mysqli_connect_error($conn);
      }

      mysqli_free_result($result);

      mysqli_close($conn);
      
    }
?>

<!-- Action for Reading the Database -->
<?php
    // Construct SQL

    $sql = 'SELECT id, item_name, item_gear, item_image, created_on FROM items ORDER BY created_on';

    // Make Query and Get Result

    $result = mysqli_query($conn, $sql);

    // Fetch result into Array

    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // print_r($items);

    mysqli_free_result($result);

    mysqli_close($conn);
?>





<!doctype html>
<html lang="en">

  <?php include('./template/header.php'); ?>
  <div id="backtotop"></div>

<!-- this is for item added alert message -->

  <?php  if (isset($_SESSION['added_item'])) {  ?>

    <div class="alert alert-primary alert-dismissible fade show" role="alert">
      <strong><?php echo $_SESSION['added_item']; ?></strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php unset($_SESSION['added_item']); ?>
  <?php } ?>

<!-- ///////////////////////// -->

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Mobile Legends Items Pocket!</h1>
        <p class="lead text-muted">This is your time to compile all your favorite items, store its tier, stats in this pocket and strategize for your next game!!!</p>
        <p>
          <a href="./add_item.php" class="btn btn-primary my-2">Add Items</a>
          <a href="./hero.php" class="btn btn-secondary my-2">Heroes</a>
          <a href="./home.php" class="btn btn-secondary my-2">Home</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        <?php foreach ($items as $item): ?>
          <div class="col">
            <div class="card shadow-sm" style="width: 22rem;height:35rem;">
              <img src="./uploads/<?php echo $item['item_image']; ?>" class="img-fluid" alt="sample"  style="padding:15px;width:20rem;height:20rem;">
              <div class="card-body">
                <h3 class="card-title"> <?php echo $item['item_name']; ?> </h3>
                <h5 class="card-text"><?php echo $item['item_gear']; ?></h5>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="./item_details.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                    <form action=" <?php echo $_SERVER['PHP_SELF'];?> " method="POST" enctype="multipart/form-data">
                      <input type="hidden" class="btn btn-sm btn-outline-danger" name="id_to_delete" value="<?php echo $item['id']; ?>" >
                      <input type="submit" class="btn btn-sm btn-outline-danger" name="delete" value="Delete" onclick="return confirmDel()">
                    </form>
                  </div>
                  <small class="text-muted"><?php echo 'Created on: ' . $item['created_on']; ?></small>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach ?>
</main>

<script src="confirmDel.js"></script>

<?php include('./template/footer.php'); ?>

</html>
