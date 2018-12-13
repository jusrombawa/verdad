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

  <nav class="blue darken-3" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Verdad</a>
      

      <ul id="nav-mobile" class="sidenav">
        <li><a href="#loginModal">Login</a></li>
        <li><a href="#registerModal">Register</a></li>
		<li><a href="#>Frequently Asked Questions</a></li>
		<li><a href="#>About Verdad</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  
  
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
            <!-- <h2 class="center light-blue-text"><i class="material-icons">flash_on</i></h2> -->
            <h5 class="center">Community-Driven Fact Checking</h5>

            <p class="light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <!-- <h2 class="center light-blue-text"><i class="material-icons">group</i></h2> -->
            <h5 class="center">Reliable and Unbiased</h5>

            <p class="light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
<!--             <h2 class="center light-blue-text"><i class="material-icons">settings</i></h2>
 -->            <h5 class="center">Free... As The Truth Should Be</h5>

            <p class="light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>
      </div>

    </div>
    <br><br>
  </div>

  <!-- Article list-->
  
  
  	<div class="container" id="articles_sect">
  		<div class="section">
<!--   		  <table class="responsive-table highlight">
  			<thead>
  			  <tr>
  				  <th>Title</th>
            <th>Author</th>
  				  <th>Date Published</th>
  				  <th>Publisher</th>
  				  <th>Rating</th>
  				  <th>Satire/Opinion</th>
  				  <th>Original Article</th>
  			  </tr>
  			</thead>

  			<tbody id="article_table">
  			  <tr>
    				<td>Pigs Fly!</td>
            <td>Boaris McPigsly</td>
    				<td>April 2, 1984</td>
    				<td>Bacon News</td>
    				<td>4.23 <i class="material-icons">star_rate</i></td>
    				<td>Satire <i class="material-icons">mood</i></td>
    				<td><a href"">Link</a></td>
  			  </tr>
          
  			</tbody> 
  		  </table> -->

        <ul class="collapsible" id="article_list">


        </ul>
  		</div>
  	</div>
  
  <div>
  </div>
  
  <footer class="page-footer blue darken-3">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">About Verdad</h5>
          <p class="grey-text text-lighten-4">Verdad is an online peer review site for online news articles.</p>


        </div>
       
    </div>
    <div class="footer-copyright">
      <div class="container">
        A special project by Justin Aaron S. Rombawa and Prof. Jaderick P. Pabico<br/>
        Copyright 2018
      </div>
    </div>
  </footer>
  
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
