<?php

class UserController extends Controller{

    function beforeroute(){
    }

    function authenticate() {

        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        $user = new UserMapper($this->db);
        $user->getByName($username);

        //username not found
        if($user->dry()) {
            $info = 'Username not found';

            $this->f3->set('SESSION.info', $info);
            $this->f3->clear('SESSION.user');
            $this->f3->clear('SESSION.reviewerStatus');
        }

        //successful login
        else if(password_verify($password, $user->password)) {
            $username = $user->username;

            $this->f3->set('SESSION.user', $username);
            //$this->f3->set('SESSION.info', $info);
            $this->f3->clear('SESSION.info');

            //check if user is reviewer
            $rm = new ReviewerMapper($this->db);
            $reviewer = $rm->load(array("user_fk", $user->id));

            if($rm->dry()) //not a reviewer
                $reviewerStatus = false;

            else
                $reviewerStatus = true;
            $this->f3->set("SESSION.reviewerStatus", $reviewerStatus);

            $this->f3->reroute('/');

        }

        //wrong password
        else {
            $info = 'Password incorrect';


            $this->f3->set('SESSION.info', $info);
            $this->f3->clear('SESSION.user');
            $this->f3->clear('SESSION.reviewerStatus');
        }

    }

    function logout() {
        if($this->f3->get('SESSION.user') != null)
        {
            $this->f3->clear('SESSION.user');
            $this->f3->clear('SESSION.info');
            $this->f3->clear('SESSION.reviewerStatus');
            $this->f3->reroute('/');
        }

        else
        {
        }
        
    }

    function submitArticle()
    {
        $am = new ArticleMapper($this->db);
        $pm = new PublisherMapper($this->db);

        $articleURL = $this->f3->get('POST.articleURL');
        $articleTitle = $this->f3->get('POST.articleTitle');
        $articleAuthor = $this->f3->get('POST.articleAuthor');
        $articlePublisher = $this->f3->get('POST.articlePublisher');
        $articlePubDate = $this->f3->get('POST.articlePubDate');
        $articlePubTime = $this->f3->get('POST.articlePubTime');
        $hostURL = $this->f3->get('POST.hostURL');

        //id is autoincrement
        $am->title = $articleTitle;
        $am->author = $articleAuthor;
        $am->url = $articleURL;

        //write publisher to publish_sites
        //check if publisher is already in database
        $publisher = $pm->load(array("name=?",$articlePublisher));

        //new publisher, add to publish_sites then write new id as fk to article publisher
        if($pm->dry())
        {
            //use new mapper just to be safe
            $pm2 = new PublisherMapper($this->db);
            //id is auto increment
            $pm2->name = $articlePublisher;
            $pm2->url = $hostURL;
            //apparently I didn't need to use regex, just regular-ass JS URL stuff. Yaaaaay!
            //but I think imma have to deal with some multiple url bullshit. Example: opinion.inquirer.net vs newsinfo.inquirer.net are all inquirer.
            //avg_score and published_by fk are all null by default
            $pm2->save();

            $am->publisher_fk = $pm2->id;
        }
        //found in publish_sites
        else
        {
            $am->publiser_fk = $pubisher->id;
        }

        $am->publish_date = $articlePubDate;
        $am->publish_time = $articlePubTime;
        //submit_date is current_timestamp
        //avg_score is null
        //note to self, make sure js deals with null satire and opinion fields because they should both be null by default
        $am->save();
    }

    function submitReview(){

        $rm = new ReviewMapper($this->db);
        $um = new UserMapper($this->db);
        
        $reviewArtID = $this->f3->get("POST.articleID");
        $reviewUsername = $this->f3->get("POST.reviewerUsername");
        $reviewScore = $this->f3->get("POST.score");
        $reviewComments = $this->f3->get("POST.comments");
        $reviewSatire = $this->f3->get("POST.satire");
        $reviewOpinion = $this->f3->get("POST.opinion");

        $user = $um->load(array("username=?",$reviewUsername));
        if(!$um->dry())
            $userID = $user->id;
        else
            $userID = 69;

        //check if user already submitted a review for article
        $rm2 = new ReviewMapper($this->db);
        $checkreview = $rm2->load(array("article_fk=?",$reviewArtID));
        //found a match
        $test = $userID;
        echo json_encode($test);
        /*if(!$rm2->dry() && $checkreview->reviewer_fk == $reviewUsername)
        {
            $info = "You already submitted a review for this article.";
            $this->f3->set("SESSION.info",$info);
        }
        //no match, valid review submission
        else
        {
            //id is auto-increment
            $rm->article_fk = $reviewArtID;
            $rm->reviewer_fk = $userID;
            $rm->score = $reviewScore;
            $rm->comments = $reviewComments;
            $rm->satire_flag = $reviewSatire;
            $rm->opinion_flag = $reviewOpinion;
            //erroneous flag is default false
            $rm->erroneous_flag = false;

            $rm->save();
        }*/
    }
}
