<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Check Reports</title>

  <!-- CSS  -->
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
  <link href="<?= ($UI . 'css/materialize.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?= ($UI . 'css/style.css') ?>" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <span id="info" hidden> <?= ($SESSION['info']) ?> </span>
  <span id="loggedInUser" hidden> <?= ($SESSION['user']) ?> </span>
  <span id="reviewerStatus" hidden> <?= ($SESSION['reviewerStatus']) ?> </span>
  
  <?php if ($SESSION['user'] != null): ?>
    
    
      <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">Verdad</a>
          
          <ul id="nav-desktop" class="right hide-on-med-and-down">
              <li><a id="<?= ($SESSION['user']) ?>" class="user-profile">Hello, <?= ($SESSION['user']) ?></a></li>
              <?php if ($SESSION['reviewerStatus'] == false): ?>
                
                  <li><a href="/reviewerSignup">Sign up as a reviewer!</a></li>
                
                <?php else: ?>
                  <li><a href="/checkReportsPage">Check Reported Reviews <span data-badge-caption="" class="report-count new badge orange lighten-1"></span></a></li>
                
              <?php endif; ?>
              <li><a href="/faqPage">FAQs</a></li>
              <li><a id="logoutDesktop">Logout</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
            <li><a id="<?= ($SESSION['user']) ?>" class="user-profile">Hello, <?= ($SESSION['user']) ?></a></li>
            <?php if ($SESSION['reviewerStatus'] == false): ?>
              
                <li><a href="/reviewerSignup">Sign up as a reviewer!</a></li>
              
              <?php else: ?>
                <li><a href="/checkReportsPage">Check Reported Reviews <span data-badge-caption="" class="report-count new badge orange lighten-1"></span></a></li>
              
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
    
  <?php endif; ?>

  <div id="login-area" class="container">
    <div class="row">
      <div class="col s4 offset-s8 z-depth-2">
        <form id="loginDesktop">
          <div class="input-field">
            <span>Username</span>
            <input id="loginUsernameDesktop">
          </div>
          <div class="input-field">
            <span>Password</span>
            <input id="loginPasswordDesktop" type="password">
          </div>
          <div class="right-align">
            <button id="loginButtonDesktop" class="btn waves-effect waves-light blue darken-3" type="button" name="action">Log In</button>
          </div>
        </form>
        <br/>
      </div>  
    </div>
  </div>

  <div class="container">
    <div class="row"><div class="col s12">
      <h4 class="blue-text text-darken-3">Check Reported Reviews</h4> 
    </div></div>

    <div class="row">
      <div id="report-sect" class="col s12">
        <ul id="report-list" class="collapsible popout">
          
        </ul>
      </div>
    </div>
  </div>

  <!-- Footer -->
  
  <footer class="page-footer blue lighten-4">
    <?php if ($SESSION['user'] != ''): ?>
      
        <div class="container blue-text text-darken-4">
        <div class="row">
          <div class="col l6 s12">
            <h5>We would like to know about your experience with Verdad!</h5>
            <p>If you have the time, please take Verdad's user experience survey.</p>
          </div>
          <div class="col l4 offset-l2 s12">
            <h5>Survey forms</h5>
            <ul>
              <?php if ($SESSION['reviewerStatus'] == true): ?>
                
                  <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSe5H27dQHl3CqnrcllHksT3j4jXbZ6WPln7SzQqg1GOrnJUDw/viewform?usp=sf_link">Reviewer survey form</a></li>
                
                <?php else: ?>
                  <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSdwBF5kpzRYhxxRDybkzbiGI3Z0PWsbhZZ28t10R3x_kS4cdw/viewform?usp=sf_link">User survey form</a></li>
                
              <?php endif; ?>
            </ul>
          </div>
        </div>
        </div>
      
      <?php else: ?>
        <div class="container blue-text text-darken-4">
          <div class="row"><div class="col s12">Verdad is a peer review system for news articles.</div></div>
        </div>
      
    <?php endif; ?>
    <div class="footer-copyright">
      <div class="container blue-text text-darken-4">
      © 2019 by Justin Aaron Rombawa
      <a class="right" href="https://sites.google.com/site/verdadpeerreview/home" target='_blank' rel='noopener noreferrer'>Verdad's Google Sites page</a><br/>
      <a class="right" href="https://github.com/jusrombawa/verdad" target='_blank' rel='noopener noreferrer'>Verdad's GitHub page</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <!--  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
  <script src="<?= ($UI. 'js/jquery.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/jquery-ui.min.js') ?>"></script>
  <script src="<?= ($UI . 'js/materialize.js') ?>"></script>
  <script src="<?= ($UI . 'js/init.js') ?>"></script>
  <script src="app/views/verdad.js" type="application/javascript"></script>
  <script src="app/views/reports.js" type="application/javascript"></script>
  </body>
</html>
