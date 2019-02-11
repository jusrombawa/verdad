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

    <?php if ($loggedIn == false): ?>
      
    <?php endif; ?>

    

    <?php if ($loggedIn == true): ?>
      


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

              <button id="loginButtonDesktop" class="btn waves-effect waves-light blue" type="button" name="action">Log In
                <i class="material-icons right">send</i>
              </button>
            </form>
            <br/>
          </div>  
        </div>
      </div>
    <?php endif; ?>

  <?php if ($SESSION­.user != ''): ?>
    
    
      <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="" class="brand-logo">Verdad</a>
          
          <ul id="nav-desktop" class="right hide-on-med-and-down">
              <li><a>Hello, <?= ($SESSION['user']) ?></a></li>
              <li><a>FAQs</a></li>
              <li><a id="logoutDesktop">Logout</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
            <li>Hello, <?= ($SESSION['user']) ?></li>
            <li><a href="">Frequently Asked Questions</a></li>
            <li><a id="logoutMobile">Logout</a></li>

          </ul>


          <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
      </nav>
    

    <?php else: ?>
      <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="" class="brand-logo">Verdad</a>
          
          <ul id="nav-desktop" class="right hide-on-med-and-down">
              <li><a href="#">FAQs</a></li>
              <li><a href="#registerModal">Register</a></li>
              <li><a id="login-popup">Login</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
            <br/>
            <li>
              <div class="container">
                  <div class="row">
                  <form id="loginMobile" action>
                    <div class="input-field">
                      <input id="loginUsernameMobile">
                      <label for="loginUsernameMobile">E-mail</label>
                    </div>

                    <div class="input-field">
                      <input id="loginPasswordMobile" type="password">
                      <label for="loginPasswordMobile">Password</label>
                    </div>
                    <button id="loginButtonMobile" class="btn waves-effect waves-light blue" type="button" name="action">Log In</button>
                   </form>
                    <br/>
                  </div>
                </div>
            </li>
            <li><a href="registerModal">Register</a></li>
            <li><a href="">Frequently Asked Questions</a></li>
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

  <div id="title_header" class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center blue-text">Verdad</h1>
      <div class="row center">
        <h5 class="header col s12 light">An online peer-review system for news articles</h5>
      </div>
      <div class="row center">
        <button id="read_button" class="btn-large waves-effect waves-light blue modal-trigger">Start reading articles</a>
      </div>
      <br><br>

    </div>
  </div>

  <div class="container" id="intro_sect">
    <div class="section">
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h5 class="center">Community-Driven Fact Checking</h5>

            <p class="light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h5 class="center">Reliable and Unbiased</h5>

            <p class="light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h5 class="center">Free... As The Truth Should Be</h5>

            <p class="light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>
      </div>

    </div>
    <br><br>
  </div>

  <!-- Article list-->
  
  
  	<div class="container" id="articles_sect">
  		
      <div class="row">
        <div class="col s5">
          <ul class="collapsible popout" id="article_list">
          </ul>
        </div>
        <div class="col s7">
            <iframe src="framePlaceholder" id="article_frame" height="600px" style="width:100%; margin: 0.5rem 0 1rem 0;"> </iframe>
        </div>
      </div>

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
