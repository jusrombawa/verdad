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

  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="" class="brand-logo">Verdad</a>
      

      <ul id="nav-mobile" class="sidenav">
        <li><a href="#loginModal">Login</a></li>
        <li><a href="#registerModal">Register</a></li>
		<li><a href="#>Frequently Asked Questions</a></li>
		<li><a href="#>About Verdad</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  
  
  <div class="container">
	<div class="section">
	
		<h3 id="article_title">Article Title</h3>
		<h4 id="article_rating">Rating: n/a.0<i class="material-icons">star_rate</i></h4>
		<h6 id="article_author">Author</h6>
		<h6 id="id_publisher">Publisher</h6>
		<h6 id="id_URL">Link</h6>
		
		<p id="id_body">
			Article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body article body
		</p>
		
		<h4>Reviews:</h4>
		<div class="row">
			<div class="col s4" id="review_section">
				<p>
					Review body review body review body review body review body review body review body review body review body review body review body review body review body review body review body
				</p>
				<h6>Written by:</h6>
				<h5>Rating: 0/0 <i class="material-icons">star_rate</i></</h5>
			</div>
			
			<div class="col s4">
				<p>
					Review body review body review body review body review body review body review body review body review body review body review body review body review body review body review body
				</p>
				<h6>Written by:</h6>
				<h5>Rating: 0/0 <i class="material-icons">star_rate</i></</h5>
			</div>
			
			<div class="col s4">
				<p>
					Review body review body review body review body review body review body review body review body review body review body review body review body review body review body review body
				</p>
				<h6>Written by:</h6>
				<h5>Rating: 0/0 <i class="material-icons">star_rate</i></</h5>
			</div>
		</div>
	</div>
  </div>
  
  <footer class="page-footer orange">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">About Verdad</h5>
          <p class="grey-text text-lighten-4">Verdad is a thing... that exists on the interwebs.</p>


        </div>
       
    </div>
    <div class="footer-copyright">
      <div class="container">
		A special project by Justin Aaron S. Rombawa and Prof. Jaderick P. Pabico
      </div>
    </div>
  </footer>
  
  <!-- Modals -->
  
  
  
  
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="<?= ($UI . 'js/materialize.js') ?>"></script>
  <script src="<?= ($UI . 'js/init.js') ?>"></script>
  </body>
</html>
