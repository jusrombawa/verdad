<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Reviewer Sign Up</title>

  <!-- CSS  -->
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
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
              <li><a href="/faqPage">FAQs</a></li>
              <li><a id="logoutDesktop">Logout</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
            <li><a id="<?= ($SESSION['user']) ?>" class="user-profile">Hello, <?= ($SESSION['user']) ?></a></li>
            <?php if ($SESSION['reviewerStatus'] == false): ?>
              
                <li><a>Sign up as a reviewer!</a></li>
              
            <?php endif; ?>
            <li><a href="/faqPage">Frequently Asked Questions</a></li>
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
    <div class="row"><div class="col s12"><h4 class="blue-text text-darken-3">Sign up as a reviewer</h4></div></div>
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
          <h6 class="blue-text text-darken-3">Profile Image (optional): </h6><input type="file" name="profileUpload" id="profileUpload">
        </div>
      </div>

      <div class="row">
        <div class="col s12"><h5 class="blue-text text-darken-3">Affiliations</h5></div>
      </div>

      <div id="affiliationInputs">
      </div>
      
      <div class="row"><div class="col s12"><a id="add-affiliation" class="btn-flat waves-effect waves-light blue-text text-darken-3">Add an affiliation</a></div></div>
      <div class="row">
        <div class="col s12"><span class="red-text">Caution: Please crop the image first before uploading. There is currently an issue with uploads of unedited images not working. I am working to fix it as soon as possible. If you have further questions, please send an email at verdadnewsreview@gmail.com. Thank you for your patience.</span></div>
      </div>
      <div class="row"><div class="col s12"><a id="revRegSubmit" class="btn waves-effect waves-light blue darken-3">Register</a></div></div>

    </form>
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
                
                <li>Encountered a bug? Send an email to verdadnewsreview@gmail.com</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
        </div>
      
      <?php else: ?>
        <div class="container blue-text text-darken-4">
          <div class="row"><div class="col s12"><h5>Verdad is a peer review system for news articles.</h5></div></div>
          <div class="row"><div class="col s12">Encountered a bug? Send an email to verdadnewsreview@gmail.com</div></div>
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
  </body>
</html>
