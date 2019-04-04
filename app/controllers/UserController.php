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
            $rm->load(array("user_fk = ?", $user->id));

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
        $am = new ArticleMapper($this->db);
        
        $reviewArtID = $this->f3->get("POST.articleID");
        $reviewUsername = $this->f3->get("POST.reviewerUsername");
        $reviewScore = $this->f3->get("POST.score");
        $reviewComments = $this->f3->get("POST.comments");
        $reviewSatire = $this->f3->get("POST.satire");
        $reviewOpinion = $this->f3->get("POST.opinion");

        $reviewUsername = trim($reviewUsername);

        $user = $um->load(array("username=?",$reviewUsername));
        $userID = $user->id;

        //check if user already submitted a review for article
        $rm2 = new ReviewMapper($this->db);
        $checkreview = $rm2->load(array("article_fk=? AND reviewer_fk=?",$reviewArtID, $userID));

        //found a match
        if(!$rm2->dry())
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

            //recompute average score and satire/opinion for article

            $article = $am->load(array("id=?", $reviewArtID));

            $scores = array();
            $satireFlags =  array();
            $opinionFlags = array();

            //reuse rm2 to collect all reviews for same article
            $rm2->load(array("article_fk=?",$reviewArtID));

            while(!$rm2->dry())
            {
                array_push($scores,$rm2->score);
                array_push($satireFlags,$rm2->satire_flag);
                array_push($opinionFlags,$rm2->opinion_flag);
                $rm2->next();
            }

            //get average score
            $avgScore = array_sum($scores)/count($scores);
            //get majority satire flags
            $satYes = 0;
            $satNo = 0;
            foreach($satireFlags as $sat)
            {
                if($sat) $satYes++;//if satire, add 1 to $satYes
                else $satNo++;
            }
            if($satYes>=$satNo) $satMaj = true;
            else $satMaj = false;

            //same thing with opinions

            $opYes = 0;
            $opNo = 0;
            foreach($opinionFlags as $op)
            {
                if($op) $opYes++;//if satire, add 1 to $satYes
                else $opNo++;
            }
            if($opYes>=$opNo) $opMaj = true;
            else $opMaj = false;

            $article->avg_score = $avgScore;
            $article->satire = $satMaj;
            $article->opinion = $opMaj;
            $article->save();

        }
    }

    function registerUser(){

        $regUsername = $this->f3->get("POST.regUsername");
        $regPassword = password_hash($this->f3->get("POST.regPassword"), PASSWORD_DEFAULT); //OH MY DOG DON'T FORGET TO HASH YOUR PASSWORDS
        $regEmail = $this->f3->get("POST.regEmail");
        $regFirstName = $this->f3->get("POST.regFirstName");
        $regMiddleName = $this->f3->get("POST.regMiddleName");
        $regLastName = $this->f3->get("POST.regLastName");
        $regNameSuffix = $this->f3->get("POST.regNameSuffix");

        $pm = new PendingUserMapper($this->db);

        do{
            $rando = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),0,5); //modified this a bit https://stackoverflow.com/questions/19017694/one-line-php-random-string-generator to generate 6-character random string

            //check for repeated verification code
            $pm->load(array("verification_code", $rando));
        }while(!$pm->dry());

        //check if username and email are unique
        $um = new UserMapper($this->db);
        $um2 = new UserMapper($this->db);
        $pm = new PendingUserMapper($this->db);

        $um->load(array("username=?",$regUsername));
        $um2->load(array("email=?",$regEmail));
        $pm->load(array("username=? AND email=?",$regUsername,$regEmail));
        if(!$um->dry())
            echo "This username is already taken.";
        else if(!$um2->dry())
            echo "Only one account is allowed per email address.";
        else if(!$pm->dry())
        {
            //send verification email
            //set up SMTP
            $smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", "bluecoll@rman820" );

            $txt = "Hello " . $regFirstName . "! It seems that you are trying to register to Verdad again. To start using Verdad, please click on the verify account link bellow the register button then enter your verification code below. Thank you.\n\n\n " . $rando . "\n\nIf you have not signed up for Verdad News Review, please reply to this message stating so. Thank you.";

            $smtp->set("From", 'verdadnewsreview@gmail.com');
            $smtp->set("To",  $regEmail);
            $smtp->set("Subject", "Verdad User Registration Verification");
            $sent = $smtp->send($txt, true);
            
            echo "You already have a pending user registration. We sent another verification email in your account. Please click verify previous registration to enter the registration verification code.";
        }
        else
        {
            //write to pending_users to be approved later
            //reuse pm
            $pm = new PendingUserMapper($this->db);

            //id is auto-increment
            $pm->username = $regUsername;
            $pm->password = $regPassword;
            $pm->email = $regEmail;
            $pm->first_name = $regFirstName;
            $pm->middle_name = $regMiddleName;
            $pm->last_name = $regLastName;
            $pm->name_suffix = $regNameSuffix;
            $pm->verification_code = $rando;
            $pm->approved_user = false;

            $pm->save();
            
            //send verification email
            //set up SMTP
            $smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", "$anteria420" );

            $txt = "Hello " . $regFirstName . "! Thank you for registering to Verdad News Review. To verify your email, please copy the code below to the prompt given after your user registration. Thank you.\n\n\n " . $rando . "\n\nIf you have not signed up for Verdad News Review, please reply to this message stating so. Thank you.";

            $smtp->set("From", 'verdadnewsreview@gmail.com');
            $smtp->set("To",  $regEmail);
            $smtp->set("Subject", "Verdad User Registration Verification");
            $sent = $smtp->send($txt, true);

            echo true;
        }

    }

    function verifyUser()
    {
        //get verification code and make sure it matches
        $verificationCode = $this->f3->get("POST.verificationCode");

        $pm = new PendingUserMapper($this->db);
        $pm->load(array("verification_code = ?", $verificationCode));
    
        if(!$pm->dry())
        {
            //write to users
            $um = new UserMapper($this->db);
            //id is auto-increment
            $um->username = $pm->username;
            $um->password = $pm->password;
            $um->email = $pm->email;
            $um->last_name = $pm->last_name;
            $um->first_name = $pm->first_name;
            $um->middle_name = $pm->middle_name;
            $um->name_suffix = $pm->name_suffix;
            $um->reviewer_status = false; //default value
            //reviewer_fk is null
            $um->save();

            //update pending_users entry
            $um->load(array("username = ?", $pm->username)); //reuse $um because we won't be saving anything anymore
            $pm->approved_user = true;
            $pm->approved_user_fk = $um->id;
            $pm->save();

            //log in user
            $newUsername = $pm->username;
            $newUserStatus = false;
            $newUserInfo = "Thank you for registering for Verdad. You may start contributing by reading and submitting articles below.";

            $this->f3->set("SESSION.user", $newUsername);
            $this->f3->set("SESSION.reviewerStatus", $newUserStatus);
            $this->f3->set("SESSION.info", $newUserInfo);

            echo true;
        }
        else
        {
            echo "Invalid verification code. Please re-check your verification email and try again.";
        }
    }

    function userProfile()
    {
        //clear previous session profile stuff to ensure no spillover
        $this->f3->clear("SESSION.profileFirstName");
        $this->f3->clear("SESSION.profileLastName");
        $this->f3->clear("SESSION.profileNameSuffix");
        $this->f3->clear("SESSION.profileUsername");
        $this->f3->clear("SESSION.profileReviewerStatus");
        $this->f3->clear("SESSION.profileImagePath");
        $this->f3->clear("SESSION.profilePhoneNumber");
        $this->f3->clear("SESSION.profilePhoneArea");
        $this->f3->clear("SESSION.profileAffiliations");

        $username = $this->f3->get("GET.profileUsername");

        $um = new UserMapper($this->db);
        $um->load(array("username = ?",$username));

        if(!$um->dry())
        {
            $firstname = $um->first_name;
            $lastname = $um->last_name;
            $namesuffix = $um->name_suffix;
            if($namesuffix == 'Jr.' || $namesuffix == 'Sr.')
                $namesuffix == ', ' + $namesuffix;
            $reviewerstatus = $um->reviewer_status;

            $this->f3->set("SESSION.profileFirstName", $firstname);
            $this->f3->set("SESSION.profileLastName", $lastname);
            $this->f3->set("SESSION.profileNameSuffix", $namesuffix);
            $this->f3->set("SESSION.profileUsername", $username);
            $this->f3->set("SESSION.profileReviewerStatus", $reviewerstatus);

            if($reviewerstatus)
            {
                $rm = new ReviewerMapper($this->db);
                $rm->load(array("user_fk = ?",$um->id));

                $profileimagepath = $rm->profile_img_path;
                $phonenumber = $rm->phone_number;
                $phonearea = $rm->phone_area;

                $am = new AffiliationMapper($this->db);
                $om =new OrganizationMapper($this->db);
                
                $am->load(array("reviewer_fk = ?", $rm->id));
                $affiliations = array();

                while(!$am->dry())
                {   
                    $entry = array();
                    //occupation
                    array_push($entry,$am->occupation);
                    //organization
                    $om->load(array("id = ?",$am->organization_fk));
                    array_push($entry,$om->org_name);
                    //push to $affiliations
                    array_push($affiliations,$entry);
                    $am->next();
                }



                $this->f3->set("SESSION.profileImagePath", $profileiamgepath);
                $this->f3->set("SESSION.profilePhoneNumber", $phonenumber);
                $this->f3->set("SESSION.profilePhoneArea", $phonearea);
                $this->f3->set("SESSION.profileAffiliations", $affiliations);
            }
        }
    }



}
