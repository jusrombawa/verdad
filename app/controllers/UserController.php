<?php

class UserController extends Controller{
    /*function render(){

        $template=new Template;
        echo $template->render('login.htm');
    }*/

    function beforeroute(){
    }

    function authenticate() {

        $loginInfo = array();

        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        $user = new User($this->db);
        $user->getByName($username);

        //username not found
        if($user->dry()) {
            //$this->f3->reroute('/login');
            $loginStatus = false;
            $loginUsername = 'a';
        }

        //successful login
        if(password_verify($password, $user->password)) {
            $this->f3->set('SESSION.user', $user->username);

            //$this->f3->reroute('/');
            $loginStatus = true;
            $loginUsername = $this->f3->get('SESSION.user');
        }

        //wrong password
        else {
            //$this->f3->reroute('/login');
            $loginStatus = false;
            $loginUsername = 'b';
        }

        array_push($loginInfo, $loginStatus);
        array_push($loginInfo, $loginUsername);
        array_push($loginInfo, $user->password);
        array_push($loginInfo, $password);

        echo json_encode($loginInfo);

    }
}
