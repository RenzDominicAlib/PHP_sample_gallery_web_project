<?php session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ./index.php');
}
?>
<!doctype html>
<html lang="en">

<?php include('./template/header.php'); ?>
<div id="backtotop"></div>

<!-- this is for login alert message -->

<?php  if (isset($_SESSION['login'])) {  ?>

  <div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong><?php echo "Hello ". $_SESSION['username'] . "!"; ?></strong><?php echo " ". $_SESSION['login']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <?php unset($_SESSION['login']); ?>
<?php } ?>

<!-- ///////////////////////// -->

<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">

      <div class="col-lg-6 col-md-8 mx-auto">
        <?php if (isset($_SESSION['username'])) {?>
        <h1 class="fw-light">Welcome <?php echo $_SESSION['username']; ?> ! </h1>
        <?php } ?>
        <p class="lead text-muted">Now you can start to CRUD (create, read, update and delete) your fvorite heroes and make a good strategy using this web storage compilation</p>
        <p>
          <a href="./hero.php" class="btn btn-secondary my-2">Heroes Pocket</a>
          <a href="./item.php" class="btn btn-secondary my-2">Items Pocket</a>
          <a href="https://www.twitch.tv/" target="_blank" class="btn btn-primary my-2">Watch Live Streamer</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="10000">
            <img src="./images/banner_1.jpeg" class="d-block w-100" alt="banner">
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <img src="./images/banner_2.jpeg" class="d-block w-100" alt="banner">
          </div>
          <div class="carousel-item">
            <img src="./images/banner_3.jpeg" class="d-block w-100" alt="banner">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
</main>

<?php include('./template/footer.php'); ?>

</html>
