<?php

class MainController extends Controller{

	function home(){
		$this->renderView('home.htm');
	}

	function framePlaceholder(){
		$this->renderView('article-placeholder.htm');
	}

	function registerPage(){
		$this->renderView("register.htm");
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

	

	function sayhello(){
		echo 'Hola!';
	}
}
?>