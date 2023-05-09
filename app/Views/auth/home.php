<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Starter Template · Bootstrap</title>
      <link rel="stylesheet" href="<?= base_url('vendor/fontawesome/css/fontawesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('vendor/fontawesome/css/solid.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('vendor/fontawesome/css/brands.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/starter-template.css'); ?>">
</head>

<body>

    <!-- main navigation -->
    <?= view('App\Views\auth\components\navbar') ?>

    

    <main role="main" class="">
      <div class="jumbotron bg-light">
          <div class="container heroe">
              <h1 class="font-weight-normal">Welcome, <span class="text-capitalize"><?=  $userData['firstname'] ?></span>!</h1>
              <h2 class="mt-4 font-weight-light">You logged in as <strong> <?= $userData['role']==='1'? "Admin" : 'Regular User' ?></strong>. Enjoy! </h2>
          </div>
      </div>
    </main>

    

    <script src="<?= base_url("vendor/jquery/jquery.min.js") ?>" type="text/javascript"></script>
    <script src="<?= base_url("vendor/bootstrap/js/bootstrap.bundle.min.js") ?>" type="text/javascript"></script>
</body>

</html>