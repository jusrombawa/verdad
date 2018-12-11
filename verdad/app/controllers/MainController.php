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
			//array_push($entry,$am->publisher_fk);
			array_push($entry,$am->avg_score);
			array_push($entry,$am->satire);
			array_push($entry,$am->opinion);
			array_push($entry,$am->url);
			array_push($entry,$am->id);

			//push entry to artList
			array_push($artList,$entry);
			$am->next();
		}

		//echo json_encode($artList);

		//push artList into f3 instance
		$this->f3->set('artList',$artList);
		//toggle to show artList in home.htm
		$this->f3->set('showArtList',TRUE);
		//ET phone home
		echo json_encode($artList);

	}

	function readArticle(){
		$this->renderView("article.htm");
	}

	function sayhello(){
		echo 'Hola!';
	}
}
?>