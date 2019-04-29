<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Frequently Asked Questions</title>

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
    <div class="row">
      <div class="col s12">
        <h4 class="blue-text text-darken-3">Frequently Asked Questions</h4>
      </div>
      
      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">What is Verdad?</h5>
          <p>Verdad is a peer review system for news articles. Originally conceptualized by my adviser Jaderick P. Pabico, Verdad takes cues from the peer review system implemented in research journals, where fellow professionals critique other research papers. Verdad takes this concept and applies it to news articles published online.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">How do I get involved?</h5>
          <p>You can start by reading articles submitted here. Click on the Start Reading Articles Button and the page will show a list of articles submitted to the system and any reviews for them. If you want to start submitting news articles, click on Register, fill out the details, and wait for the verification code in your e-mail. If you want to be a reviewer, click on Sign Up as a Reviewer and send your credentials in the form.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">What credentials are required?</h5>
          <p>As a user, all we need is your email address. As a reviewer though, we would need your phone number (preferrably office number), an optional profile picture, information about your affiliations, and photos of your employee/membership IDs.<br/><br/>

          For this open beta test, student IDs are fine, as long as you indicate your degree in you affiliation (e. g. Student, B. S. Computer Science).</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">Why do you need so much information for me to become a reviewer?</h5>
          <p>The information you send us is for verification purposes only. Other than your profile picture and office number, no other information will be available publicly.<br/></br/>

          After this beta test, all data will be deleted, including the personal information you sent us.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">I've registered as a reviewer, but I can't review articles yet. What's going on?</h5>
          <p>We manually aprrove or disapprove reviewer signup requests to make sure that all reviewers are qualified to review articles. Expect a response sent to your email within the day. Thank you for your patience.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">I'm already a verified reviewer. What now?</h5>
          <p>You can now submit a review by clicking on the Write a Review button. Fill out the review form and click submit to send your first review.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">I've seen an erroneous review. What can I do?</h5>
          <p>If you would like to report a review, click on the Report button below the review and state why you feel that the review is erroneous. Another reviewer with no conflict of interest or an admin (if a reviewer is unavailable) will check your report. If they find the review erroneous as well, the review will not be displayed and its score will be removed from the article's average.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">How can I check reports?</h5>
          <p>On the Check Reported Revies button, an orange notification will appear if you can check a report. Click on it and you will then be shown the reports that you can check, along with information on both the article and the review.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">I have a question and there is no answer here. Where can I ask you about it?</h5>
          <p>You can send an email to verdadnewsreview@gmail.com for any inquiries regarding Verdad.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">What can I do to help the project out more?</h5>
          <p>You can start by filling out the survey forms linked below. It would mean a lot to me to know if you think that Verdad is effective in the fight against fake news.

          In addition, Verdad is open-source and freely available through GitHub. If you can program, you could help out by either contributing to the code after the open beta test, study the code, or branching the system out to make an improved news review system. Just don't forget to credit Verdad.</p>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h5 class="blue-text text-darken-3">Special thanks</h5>
          <p>Verdad is a one-man operation at the time-being, but I have gotten some help and I would like to thank them all here.<br/><br/>

          My adviser Jaderick Pabico for the original concept and by guiding me through the project.<br/><br/>

          My friend and former boss Czar John Demafeliz for helping me out from time to time throughout Verdad's development.<br/><br/>

          My friend and orgmate Yves Robert Sta. Ana for helping me in hosting Verdad to the web.<br/><br/>

          My parents for being patient with me and supporting me throughout the project.<br/><br/>

          And you, for helping me test Verdad and helping me graduate.

          </p>
        </div>
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
