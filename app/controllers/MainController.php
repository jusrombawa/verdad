<?php

class MainController extends Controller{

	function beforeroute(){
		//$f3->set('AUTOLOAD','autoload/');
	}

	function home(){
		$this->renderView('home.htm');
	}

	function framePlaceholder(){
		$this->renderView('article-placeholder.htm');
	}

	function registerPage(){
		$this->renderView("register.htm");
	}

	function verifyPage(){
		$this->renderView("verify.htm");
	}
	
	function profilePage(){
        $this->renderView("profile.htm");
    }

	function getArticles()
	{
		$artList = array();

		$am = new ArticleMapper($this->db);
		$pm = new PublisherMapper($this->db);
		$rm = new ReviewMapper($this->db);

		$am->load("1",array('order'=>'submit_date DESC'));

		while(!$am->dry())
		{
			$entry = array();
			$publisher_fk = $am->publisher_fk;
			$publisher = $pm->load(array("id=?",$publisher_fk));
			//push needed db values to entry
			array_push($entry,$am->title);
			array_push($entry,$am->author);
			array_push($entry,$am->publish_date);
			array_push($entry,$publisher->name);
			array_push($entry,$am->avg_score);
			array_push($entry,$am->satire);
			array_push($entry,$am->opinion);
			array_push($entry,$am->url);

			//build array of reviews then push to entry
			$article_id = $am->id;
			$reviews = $rm->load(array("article_fk=?",$article_id));
			$review_list = array();

			while(!$rm->dry())
			{
				$review_entry = array();
				//reviewer to be pushed later
				array_push($review_entry, $rm->score);
				array_push($review_entry, $rm->comments);
				array_push($review_entry, $rm->satire_flag);
				array_push($review_entry, $rm->opinion_flag);
				array_push($review_list,$review_entry);
				$rm->next();
		
			}
			//push review list into article entry
			array_push($entry, $review_list);

			//push id to list to identify what to review
			array_push($entry,$am->id);

			//push entry to artList
			array_push($artList,$entry);
			$am->next();
		}

		//ET phone home
		echo json_encode($artList);

	}

	/*This is a test, remove after you're done and don't forget to replace the FAQ link destination*/
	//I should also probably put this on beforeroute? Idk this is all new to me.
	function testFile(){
/*
		$host = "localhost";
		$login = "verdadadmin";
		$password = "verdadnews";

		$ftp = new \FtpClient\FtpClient();
		$ftp->connect($host);
		$items = $ftp->login($login, $password);

		$f3->set('FTP', $ftp);

		//$items = $ftp->scanDir();
		echo $items;
*/

		//$testfile = readfile("../files/test.asdf");
		$testfile = file_exists("../files/test.asdf");
		echo $testfile;
	}
	

	function sayhello(){
		echo 'Hola!';
	}

	//test only
	function uploadPhoto(){
		$this->f3->set('UPLOADS','../files/'); // don't forget to set an Upload directory, and make it writable!

		$overwrite = false; // set to true, to overwrite an existing file; Default: false
		$slug = true; // rename file to filesystem-friendly version

        $web = \Web::instance();

		$files = $web->receive(function($file,$formFieldName){
		        var_dump($file);
		        /* looks like:
		          array(5) {
		              ["name"] =>     string(19) "csshat_quittung.png"
		              ["type"] =>     string(9) "image/png"
		              ["tmp_name"] => string(14) "/tmp/php2YS85Q"
		              ["error"] =>    int(0)
		              ["size"] =>     int(172245)
		            }
		        */
		        // $file['name'] already contains the slugged name now

		        // maybe you want to check the file size
		        if($file['size'] > (2 * 1024 * 1024)) // if bigger than 2 MB
		            return false; // this file is not valid, return false will skip moving it

		        // everything went fine, hurray!
		        return true; // allows the file to be moved from php tmp dir to your defined upload dir
		    },
		    $overwrite,
		    $slug
		);

	}

}
?>