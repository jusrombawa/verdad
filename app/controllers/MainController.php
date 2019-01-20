<?php

class MainController extends Controller{

	function home(){
		$this->renderView('home.htm');
		//$this->getArticles();
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
			//array_push($entry,$am->id);

			//build array of reviews then push to entry
			$article_id = $am->id;
			$reviews = $rm->load(array("article_fk=?",$article_id));
			$review_list = array();

			//ERROR!!! Infinite loop
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

			//push entry to artList
			array_push($artList,$entry);
			$am->next();
		}

		//push artList into f3 instance
		/*$this->f3->set('artList',$artList);
		//toggle to show artList in home.htm
		$this->f3->set('showArtList',TRUE);*/
		//ET phone home
		echo json_encode($artList);

	}

	function readArticle(){

		$am = new ArticleMapper($this->db);
		//retrieve id to be viewed from GET
		//but for now...
		//$articleID = 1;
		$articleID = $this->f3->get('GET.articleID');
		$article = $am->load(array("id=?",$articleID));
		

		//$articleID = $_GET['articleID'];

		$output = array();

		array_push($output,$article->body);
		array_push($output, $articleID);

		echo json_encode($output);

		//$this->renderView("article.htm");
	}

	function sayhello(){
		echo 'Hola!';
	}
}
?>