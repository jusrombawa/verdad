<?php

class UserController extends Controller{

    function beforeroute(){
    }

    function authenticate() {

        $loginInfo = array();

        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        $user = new UserMapper($this->db);
        $user->getByName($username);

        //username not found
        if($user->dry()) {
            //$this->f3->reroute('/login');
            $loginStatus = false;
            $loginError = 'Username not found';

            array_push($loginInfo, $loginStatus);
            array_push($loginInfo, $loginError);

            //echo json_encode($loginInfo);
            $this->f3->clear('SESSION.user');
        }

        //successful login
        else if(password_verify($password, $user->password)) {
            $this->f3->set('SESSION.user', $user->username);

            $this->f3->reroute('/');
            /*$loginStatus = true;
            $loginUsername = $this->f3->get('SESSION.user');*/
        }

        //wrong password
        else {
            //$this->f3->reroute('/login');
            $loginStatus = false;
            $loginError = 'Password incorrect';

            $this->f3->clear('SESSION.user');

            array_push($loginInfo, $loginStatus);
            array_push($loginInfo, $loginError);

            //echo json_encode($loginInfo);
        }

    }

    function logout() {
        if($this->f3->get('SESSION.user') != null)
        {
            $this->f3->clear('SESSION.user');
            $this->f3->reroute('/');
        }

        else
        {
        }
        
    }

    function submitArticle()
    {
        $am = new ArticleMapper($this->db);

        $articleURL = $this->f3->get('POST.articleURL');
        $articleTitle = $this->f3->get('POST.articleTitle');
        $articleAuthor = $this->f3->get('POST.articleAuthor');
        $articlePublisher = $this->f3->get('POST.articlePublisher');
        $articlePubDate = $this->f3->get('POST.articlePubDate');
        $articlePubTime = $this->f3->get('POST.articlePubTime');

        //id is autoincrement
        $am->title = $articleTitle;
        $am->author = $articleAuthor;
        $am->url = $articleURL;
        //write publisher to publish_sites
        $am->publish_date = $articlePubDate;
        $am->publish_time = $articlePubTime;
        //submit_date is current_timestamp
        //avg_score is null
        //note to self, make sure js deals with null satire and opinion fields because they should both be null by default
    }
}
