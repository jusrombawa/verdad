<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Profile</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?= ($UI . 'css/materialize.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?= ($UI . 'css/style.css') ?>" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <span id="info" hidden> <?= ($SESSION['info']) ?> </span>
  <span id="loggedInUser" hidden> <?= ($SESSION['user']) ?> </span>
  
  <?php if ($SESSION['user'] != null): ?>
    
    
      <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">Verdad</a>
          
          <ul id="nav-desktop" class="right hide-on-med-and-down">
              <li><a id="<?= ($SESSION['user']) ?>" class="user-profile">Hello, <?= ($SESSION['user']) ?></a></li>
              <?php if ($SESSION['reviewerStatus'] == false): ?>
                
                  <li><a>Sign up as a reviewer!</a></li>
                
              <?php endif; ?>
              <li><a id="faq">FAQs</a></li>
              <li><a id="logoutDesktop">Logout</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
            <li><a id="<?= ($SESSION['user']) ?>" class="user-profile">Hello, <?= ($SESSION['user']) ?></a></li>
            <?php if ($SESSION['reviewerStatus'] == false): ?>
              
                <li><a>Sign up as a reviewer!</a></li>
              
            <?php endif; ?>
            <li><a id="">Frequently Asked Questions</a></li>
            <li><a id="logoutMobile">Logout</a></li>

          </ul>


          <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
    

    <?php else: ?>
      <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">Verdad</a>
          
          <ul id="nav-desktop" class="right hide-on-med-and-down">
              <li><a id="faq" href="">FAQs</a></li>
              <li><a href="/register">Register</a></li>
              <li><a id="login-popup">Login</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
          <div class="container black-text">
            <form id="loginMobile" action>
              <li><h6>Username<h6></li>
              <li><input id="loginUsernameMobile"></li>
              <li><h6>Password<h6></li>
              <li><input id="loginPasswordMobile" type="password">
              </li>
              <li><button id="loginButtonMobile" class="btn waves-effect waves-light blue" type="button" name="action">Log In</button></li>
            </form>
              <li><a href="/register">Register</a></li>
              <li><a id="faq">Frequently Asked Questions</a></li>
          </div>
          </ul>


          <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
    
  <?php endif; ?>

    <div id="user-profile-page" class="container">
      <div class="row">
        <h5 class="blue-text"><?= ($SESSION['profileFirstName']) ?> <?= ($SESSION['profileLastName']) ?><?php if ($SESSION['profileNameSuffix'] != ''): ?> <?= ($SESSION['profileNameSuffix']) ?> <?php endif; ?></h5>
      </div>
      <?php if ($SESSION['profileReviewerStatus'] == true): ?>
        <div class="row">
          <h6 class="blue-text text-darken-2">Verified Reviewer <i class="material-icons">verified_user</i></h6>
        </div>
      <?php endif; ?>
      <div class="row">Username: <?= ($SESSION['profileUsername']) ?></div>
      <?php if ($SESSION['profileReviewerStatus']): ?>
        <!-- <div class="row"><img width="300" height="300" src=" <?= ($SESSION['profileImagePath']) ?> " alt="Profile Picture"/> <?= ($SESSION['profileImagePath']) ?></div> -->
        <?php if ($SESSION['profileImagePath'] == null): ?>
          
            <div class="row"><img width="200" height="200" src="uploads/default_profile.png" /></div>
            <p>Path: <?= ($SESSION['profileImagePath'])."
" ?>
          
          <?php else: ?>
            <div class="row"><img width="200" height="200" src="<?= ($SESSION['profileImagePath']) ?>" /></div>
            <p>Path: <?= ($SESSION['profileImagePath']) ?></p>
          
        <?php endif; ?>

        <?php if ($SESSION['profileUsername'] == $SESSION['user']): ?>
          <div class="row"><a href="#change-pic-modal" class="btn waves-effect waves-light blue modal-trigger">Change Profile Picture</a></div>
        <?php endif; ?>

        <div class="row">Contact number: <?php if ($SESSION['profilePhoneArea'] != ''): ?>(<?= ($SESSION['profilePhoneArea']) ?>) <?php endif; ?><?= ($SESSION['profilePhoneNumber']) ?></div>
        <!-- then show occupation and organization -->
        <?php if ($SESSION['profileAffiliations'] != null): ?>
          <div class="row"><h6 class="blue-text text-darken-2">Affiliations</h6></div>
          <div class="row">
            <ul>
              <?php foreach (($SESSION['profileAffiliations']?:[]) as $affiliation): ?>
                <div class="row">
                  <li style="list-style-type:disc;">
                    <i><?= ($affiliation[0]) ?></i> <br />
                    <a class="organization blue-text text-darken-3"><?= ($affiliation[1]) ?></a>
                  </li>
                </div>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
      <?php endif; ?>      
    </div>

  <!-- Modals -->

    <div id="change-pic-modal" class="modal">
    <div class="modal-content">
      <div class="row">
        <h4>Change Profile Picture</h4>
      </div>

      <form id="change-pic-form" method="POST" enctype="multipart/form-data">
        <div class="row">
          Select image to upload:
          <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
      </div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-blue btn-flat">Cancel</a>
        <a id="change-pic-submit" class="modal-close waves-effect waves-blue btn-flat">Submit</a>
      </div>
    </form>
  </div>
  

  <!--  Scripts-->
  <!--  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
  <script src="<?= ($UI. 'js/jquery.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/jquery-ui.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/materialize.js') ?>"></script>
  <script src="<?= ($UI . 'js/init.js') ?>"></script>
  <script src="app/views/verdad.js" type="application/javascript"></script>
  </body>
</html>
