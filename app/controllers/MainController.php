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

    function reviewerSignupPage(){
    	$this->renderView("reviewersignup.htm");
    }

    function reviewerSignupPendingPage(){
    	$this->renderView("revsignuppending.htm");
    }

    function checkReportsPage(){
    	$this->renderView("checkreports.htm");
    }

    function faqPage(){
    	$this->renderView("faq.htm");
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
			$reviews = $rm->load(array("article_fk=? AND erroneous_flag = false",$article_id));
			$review_list = array();

			$reviewer = new ReviewerMapper($this->db);
			$um = new UserMapper($this->db);

			while(!$rm->dry())
			{
				$review_entry = array();
				array_push($review_entry, $rm->score);
				array_push($review_entry, $rm->comments);
				array_push($review_entry, $rm->satire_flag);
				array_push($review_entry, $rm->opinion_flag);

				//push reviewer username
				$reviewer->load(array("id = ?", $rm->reviewer_fk));
				$um->load(array("id = ?", $reviewer->user_fk));
				array_push($review_entry, $um->username);
				//push review id in case of report
				array_push($review_entry, $rm->id);

				//push datetime_submitted
				array_push($review_entry, $rm->datetime_submitted);

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

	function sayhello(){
		echo 'Hola!';
	}


	function uploadPhoto(){
		$this->f3->set('UPLOADS','uploads/'); // don't forget to set an Upload directory, and make it writable!

		$overwrite = true; // set to true, to overwrite an existing file; Default: false
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
		        //check if image
		        /*if($file["type"] != "image/png" || $file["type"] != "image/gif" || $file["type"] != "image/jpeg" || $file["type"] != "image/pjpeg")
		        	return false;*/

		        //check if < 8 MB
		        if($file['size'] > (8 * 1024 * 1024))
		            return false;

		        return true;
		    },
		    $overwrite,
		    $slug
		);

		if($files[0] == true)
		{	
			//get filename, actually the key for first (and only) array element of $files
			$filename =  key($files); //old path: /uploads/filename.ext
			$username = $this->f3->get("SESSION.user");
			$newfile = "uploads/". $username ."/profile.".pathinfo($filename)["extension"]; //new path: /uploads/current username/profile.ext

			//create folder if not yet made
			if (!file_exists("uploads/". $username ."/")) {
				mkdir("uploads/". $username ."/", 0777, true);
			}

			rename($filename, $newfile);

			//change user profile path
			$um = new UserMapper($this->db);
			$rm = new ReviewerMapper($this->db);

			$um->load(array("username = ?", $username));
			$rm->load(array("user_fk = ?", $um->id));

			$rm->profile_img_path = $newfile;
			$rm->save();

			$this->f3->set("SESSION.profileImagePath", $newfile);

		}
		else
		{
			$info = "Upload failed.";
			$this->f3->set('SESSION.info', $info);
		}
	}

	function clearInfo()
	{
		$this->f3->clear('SESSION.info');
	}

	function getReportCount()
	{
		$user = $this->f3->get("SESSION.user");

		$um = new UserMapper($this->db);
		$revm = new ReviewerMapper($this->db);
		$repm = new ReportMapper($this->db);

		$um->load(array("username = ?", $user));
		$revm->load(array("user_fk = ?", $um->id));
		$repm->load(array("checker_reviewer_fk = ? AND erroneous = 0", $revm->id));

		//i have to count manually because apparently $repm->count() outputs all entries in table disregarding the query
		$count = 0;
		while(!$repm->dry())
		{
			$count++;
			$repm->next();
		}

		//send out count
		echo $count;
	}

	function suggestPublisher()
	{
		$hostURL = $this->f3->get("GET.hostURL");

		$pm = new PublisherMapper($this->db);
		$pm->load(array("url = ?", $hostURL));

		if($pm->dry())
			echo false;
		else
			echo $pm->name;
	}

}
?>