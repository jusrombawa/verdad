<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Home</title>

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

  <div id="login-area" class="container">
      <div class="row">
        <div class="col s3 offset-s9 z-depth-2">
          <form id="loginDesktop" class="right-align">
            <div class="input-field">
              <input id="loginUsernameDesktop">
              <label for="loginUsernameDesktop">E-mail</label>
            </div>
            <div class="input-field">
              <input id="loginPasswordDesktop" type="password">
              <label for="loginPasswordDesktop">Password</label>
            </div>

            <button id="loginButtonDesktop" class="btn waves-effect waves-light blue" type="button" name="action">Log In</button>
          </form>
          <br/>
        </div>  
      </div>
    </div>

  <div class="container">
    <div class="row"><div class="col s12"><h4 class="blue-text">Sign up as a reviewer</h4></div></div>
    <form id="revRegForm" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col s3">
          <input id="revRegPhoneArea" name="revRegPhoneArea" type="text">
          <label for="revRegPhoneArea">Phone Area (optional)</label>
        </div>
        <div class="col s9">
          <input id="revRegPhone" name="revRegPhone" type="text">
          <label for="revRegPhone">Phone Number</label>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h6 class="blue-text text-darken-2">Profile Image (optional): </h6><input type="file" name="profileUpload" id="profileUpload">
        </div>
      </div>

      <div class="row">
        <div class="col s12"><h5 class="blue-text">Affiliations</h5></div>
      </div>

      <div id="affiliationInputs">
      </div>
      
      <div class="row"><div class="col s12"><a id="add-affiliation" class="btn-flat waves-effect waves-light blue-text">Add an affiliation</a></div></div>
      <div class="row"><div class="col s12"><a id="revRegSubmit" class="btn waves-effect waves-light blue">Register</a></div></div>
      


    </form>
  </div>

  <!-- Modals -->

  <!--  Scripts-->
  <!--  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
  <script src="<?= ($UI. 'js/jquery.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/jquery-ui.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/materialize.js') ?>"></script>
  <script src="<?= ($UI . 'js/init.js') ?>"></script>
  <script src="app/views/verdad.js" type="application/javascript"></script>
  </body>
</html>
