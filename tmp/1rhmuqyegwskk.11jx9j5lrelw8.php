<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Verify User Registration</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?= ($UI . 'css/materialize.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?= ($UI . 'css/style.css') ?>" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <span id="info" hidden> <?= ($SESSION['info']) ?> </span>
  
  <nav class="blue darken-3" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">Verdad</a>
      
      <ul id="nav-desktop" class="right hide-on-med-and-down">
          <li><a href="/faqPage">FAQs</a></li>
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
          <li><button id="loginButtonMobile" class="btn waves-effect waves-light blue darken-3" type="button" name="action">Log In</button></li>
        </form>
          <li><a href="/register">Register</a></li>
          <li><a href="/faqPage">Frequently Asked Questions</a></li>
      </div>
      </ul>


      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>

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

            <button id="loginButtonDesktop" class="btn waves-effect waves-light blue darken-3" type="button" name="action">Log In</button>
          </form>
          <br/>
        </div>  
      </div>
    </div>

    <div class="container">
      <div class="row">
        <h5 class="blue-text text-darken-3">Verify your personal account</h5>
      </div>
      <div class="row">
        <p> Thank you for registering for Verdad, the community-driven news fact-checking service. To verify your registration, please copy the verification code from the email that we sent to you below.</p>
      </div>
      <form>
        <div class="row center-align">
          <div class="col s4 offset-s4">
            <input id="verificationCode" type="text">
            <label for="verificationCode">Verification Code</label>
          </div>
        </div>
        <div class="row center-align">
          <div class="col s4 offset-s4">
            <a id="verify-submit" class="waves-effect waves-light btn blue darken-3">verify</a>
          </div>
        </div>

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
