<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Admin</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?= ($UI . 'css/materialize.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?= ($UI . 'css/style.css') ?>" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <span id="info" hidden> <?= ($SESSION['info']) ?> </span>
  <span id="loggedInAdmin" hidden> <?= ($SESSION['admin']) ?> </span>
  
  <?php if ($SESSION['admin'] != null): ?>
    
    
      <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">Verdad</a>
          
          <ul id="nav-desktop" class="right hide-on-med-and-down">
              <li><a id="<?= ($SESSION['admin']) ?>" class="admin-profile">Hello, <?= ($SESSION['admin']) ?></a></li>
              <li><a id="faq">FAQs</a></li>
              <li><a id="logoutDesktop">Logout</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
            <li><a id="<?= ($SESSION['admin']) ?>" class="admin-profile">Hello, <?= ($SESSION['admin']) ?></a></li>
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
              <label for="loginUsernameDesktop">Username</label>
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

  <!-- Article list-->
  
  
  	<div class="container" id="admin_sect">
  		
      <div class="row">
        <div class="col s12"><h3 class="blue-text text-darken-3">Admin Login</h3></div>
      </div>
      <div class="row">
        <div class="col s12">
          <p>
            This is the admin login page. If you are a user or a reviewer and you somehow ended up here, <a href="/">click here</a> to go back to Verdad's home page.
          </p>
          </div>
        </div>
      </div>

  	</div>

  <!-- Modals -->

  <div id="inquiry-modal" class="modal">
    <div class="modal-content">
      <h4>Send inquiry</h4>
      <form>
        <input type="hidden" id="inquire-pr-id">
        <textarea id="inquire-text" class="materialize-textarea"></textarea>
        <label for="textarea1">Inquiry</label>
      </form>
    </div>
    <div class="modal-footer">
      <a id="inquiry-send" class="modal-close waves-effect waves-green btn-flat">Send</a>
      <a class="modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
  </div>

  <div id="deny-modal" class="modal">
    <div class="modal-content">
      <h4>Deny reviewer registration</h4>
      <form>
        <input type="hidden" id="deny-pr-id">
        <textarea id="deny-text" class="materialize-textarea"></textarea>
        <label for="textarea1">Reasons for denying</label>
      </form>
    </div>
    <div class="modal-footer">
      <a id="deny-rev-submit" class="modal-close waves-effect waves-green btn-flat">Deny</a>
      <a class="modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
  </div>

  <!--  Scripts-->
  <!--  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
  <script src="<?= ($UI. 'js/jquery.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/jquery-ui.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/materialize.js') ?>"></script>
  <script src="<?= ($UI . 'js/init.js') ?>"></script>
  <script src="app/views/admin.js" type="application/javascript"></script>
  </body>
</html>
