<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Verdad - Home</title>

</head>
<body>

    <?php

		$f3 = require('app/lib/base.php');
		$f3 = Base::instance();
		
		class AppController {
			function beforeroute() {
				echo 'Before routing - ';
			}
			
			function afterroute() {
				echo ' - After routing';
			}
		}
		
		class AboutController extends AppController {
			function render() {
				echo 'About crap';
			}
		}
		
		class Main extends AppController{

			function render() {
				echo 'Testing 1, 2, 3...';
			}
			
			function sayhello() {
				echo 'Hola, pendejo!';
			}
			
		}
		
		
		$f3->route('GET /', 'Main->render');
		$f3->route('GET /hello', 'Main->sayhello');
		$f3->route('GET /about', 'AboutController->render');
		
		$f3->run();

	?>
  </body>
</html>
