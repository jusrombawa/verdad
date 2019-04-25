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
  <span id="reviewerStatus" hidden> <?= ($SESSION['reviewerStatus']) ?> </span>
  
  <?php if ($SESSION['user'] != null): ?>
    
    
      <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">Verdad</a>
          
          <ul id="nav-desktop" class="right hide-on-med-and-down">
              <li><a id="<?= ($SESSION['user']) ?>" class="user-profile">Hello, <?= ($SESSION['user']) ?></a></li>
              <?php if ($SESSION['reviewerStatus'] == false): ?>
                
                  <li><a href="/reviewerSignup">Sign up as a reviewer!</a></li>
                
                <?php else: ?>
                  <li><a href="/checkReportsPage">Check Reported Reviews</a></li>
                
              <?php endif; ?>
              <li><a id="faq">FAQs</a></li>
              <li><a id="logoutDesktop">Logout</a></li>
            </ul>

          <ul id="nav-mobile" class="sidenav">
            <li><a id="<?= ($SESSION['user']) ?>" class="user-profile">Hello, <?= ($SESSION['user']) ?></a></li>
            <?php if ($SESSION['reviewerStatus'] == false): ?>
              
                <li><a href="/reviewerSignup">Sign up as a reviewer!</a></li>
              
              <?php else: ?>
                <li><a href="/checkReportsPage">Check Reported Reviews</a></li>
              
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
              <button id="loginButtonDesktop" class="btn waves-effect waves-light blue" type="button" name="action">Log In</button>
            </div>
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
        <button id="read_button" class="btn-large waves-effect waves-light blue">Start reading articles</a>
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
        <div id="art-collapsible-sect" class="col s5">
          <ul class="collapsible popout" id="article_list">
          </ul>
        </div>
        <div class="col s7">
            <iframe src="framePlaceholder" id="article_frame" height="600px" style="width:100%; margin: 0.5rem 0 1rem 0;"> </iframe>
        </div>
      </div>

  	</div>

  <?php if ($SESSION['user'] != null): ?>
    <div id="art-submit-modal-button" class="fixed-action-btn right-align">
      <a class="btn-floating btn-large waves-effect waves-light blue modal-trigger" href="#article-submit-modal"><i class="material-icons">add</i></a>
    </div>
  <?php endif; ?>

  <!-- <input id="test" type="text" class="timepicker"> -->

  <!-- Modals -->

  <div id="article-submit-modal" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Submit article</h4>
      <form id="article-submit-form">
          <div class="row">
            <div class="input-field">
              <h6>Link to the Article</h6>
                <input id="articleURL">
            </div>
          </div>

          <div class="row">
            <div class="input-field">
            <h6>Title</h6>
              <div class="col s9">
                <input type="text" id="articleTitle">
              </div>
              <div class="col s3 right-align">
                <a id="suggest-title" class="waves-effect waves-teal btn-flat">Suggest Title</a>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s6">
              <div class="input-field">
                <h6>Author</h6>
                <input id="articleAuthor">
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                <h6>Publisher</h6>
                <input id="articlePublisher">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s6">
              <div class="input-field">
                <h6>Publish Date</h6>
                <input id="articlePubDate" type="date">
              </div>
            </div>
            <div class="col s6">
              <div class="input-field">
                <h6>Publish Time</h6>
                <input id="articlePubTime" type="time">
              </div>
            </div>
          </div>

      </form>
    </div>
    <div class="modal-footer">
      <a class="modal-close waves-effect waves-blue btn-flat">Cancel</a>
      <a id="art-submit-button" class="modal-close waves-effect waves-blue btn-flat">Submit</a>
    </div>
  </div>

  <div id="review-submit-modal" class="modal modal-fixed-footer">
    <?php if ($SESSION['reviewerStatus'] == true): ?>
      
        <div class="modal-content">
          <h5>Submit review</h5>
          <span hidden id="article-review-id"></span>
          <form id="review-submit">
            <div class="input-field">
              <div class="row">
                <select id="review-rating">
                  <option value="no" disabled selected>Choose the rating</option>
                  <option value="5">5 star</option>
                  <option value="4">4 star</option>
                  <option value="3">3 star</option>
                  <option value="2">2 star</option>
                  <option value="1">1 star</option>
                </select>
              </div>

              <div class="row">
                <textarea id="review-comments" class="materialize-textarea"></textarea>
                <label for="review-comments">Comments</label>
              </div>

              <div class="row">
                <label>
                  <input type="checkbox" id="review-satire" class="filled-in"/>
                  <span>Satire article</span>
                </label>
              </div>

              <div class="row">
                <label>
                  <input type="checkbox" id="review-opinion" class="filled-in"/>
                  <span>Opinion article</span>
                </label>
              </div>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <a class="modal-close waves-effect waves-blue btn-flat">Cancel</a>
          <a id="review-submit-button" class="modal-close waves-effect waves-blue btn-flat">Submit</a>
        </div>
      
      <?php else: ?>
        <div class="modal-content">
          <h5>Sign up as a verified reviewer!</h5>
          <p>We at Verdad are dedicated to the pursuit of the truth. That is why we make sure that reviewers are verified professionals in their fields of expertise. If you would like to be a reviewer, please click on the sign up button below.</p>
        </div>

        <div class="modal-footer">
          <a class="modal-close waves-effect waves-blue btn-flat">Cancel</a>
          <a href="/reviewerSignup" class="modal-close waves-effect waves-blue btn-flat">Sign Up</a>
        </div>
      
    <?php endif; ?>
  </div>

  <div id="report-submit-modal" class="modal">
    <div class="modal-content">
      <div class="row">
        <div class="col s12">
          <h5>Report this review</h5>
        </div>
      </div>

      <form id="report-submit">
        <input type="hidden" id="reportedReviewID">
        <input type="hidden" id="reportSubmitterUsername">

        <div class="row">
          <div class="col s12">
            Reasons for reporting (please check at least one): <br/>

            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Erroneous/inaccurate review</span>
            </label>
            <br/>
            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Review lacks information/sources</span>
            </label>
            <br/>
            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Possible conflict of interest</span>
            </label>
            <br/>
            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Unprofessional language</span>
            </label>
            <br/>
            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Mistaken as satire/opinion</span>
            </label>
            <br/>
            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Article is actually satire/opinion</span>
            </label>
            <br/>
            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Hateful remarks in review (racism, sexism, violent threat)</span>
            </label>
            <br/>
            <label>
              <input type="checkbox" class="filled-in report-reason"/>
              <span>Others</span>
            </label>
            <br/>
          </div>
        </div>

          <div class="row">
            <div class="input-field col s12">
              <textarea id="report-comments" class="materialize-textarea"></textarea>
              <label for="report-comments">Comments</label>
            </div>
          </div>
      </form>
    </div>

    <div class="modal-footer">
      <a class="modal-close waves-effect waves-blue btn-flat">Cancel</a>
      <a id="submit-report" class="modal-close waves-effect waves-blue btn-flat">Report</a>
    </div>
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
