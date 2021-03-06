<?php

class UserController extends Controller{

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
        }
    }

    function submitArticle()
    {
        $am = new ArticleMapper($this->db);
        $am2 = new ArticleMapper($this->db);
        $pm = new PublisherMapper($this->db);

        $articleURL = $this->f3->get('POST.articleURL');
        $articleTitle = $this->f3->get('POST.articleTitle');
        $articleAuthor = $this->f3->get('POST.articleAuthor');
        $articlePublisher = $this->f3->get('POST.articlePublisher');
        $articlePubDate = $this->f3->get('POST.articlePubDate');
        $articlePubTime = $this->f3->get('POST.articlePubTime');
        $hostURL = $this->f3->get('POST.hostURL');

        $am2->load(array("url=?", $articleURL));

        if($am2->dry())
        {
            //id is autoincrement
            $am->title = $articleTitle;
            $am->author = $articleAuthor;
            $am->url = $articleURL;

            //write publisher to publish_sites
            //check if publisher is already in database
            $publisher = $pm->load(array("url=?",$hostURL));

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
                $am->publisher_fk = $publisher->id;
                //note from future Jus, CHECK THE SPELLINGS OF YOUR VARIABLES.
                //NOTE FROM JUS FROM SLIGHTLY MORE FUTURE THAN THAT PREVIOUS FUTURE GUY, FUCKING CHECK YOUR VARIABLE NAMES CHRIST PHP HAS DYNAMIC VARIABLES IT DOESN'T THROW AN ERROR WHEN IT CAN'T FIND WHERE SOMETHING WAS DECLARED
            }

            $am->publish_date = $articlePubDate;
            $am->publish_time = $articlePubTime;
            //submit_date is current_timestamp
            //avg_score is null
            //note to self, make sure js deals with null satire and opinion fields because they should both be null by default
            $am->save();

            $info = "Article has been submitted.";
            $this->f3->set('SESSION.info', $info);
        }
        else
        {
            $info = "The article you tried to submit was already submitted to Verdad for review. Please submit another article.";
            $this->f3->set('SESSION.info', $info);   
        }
    }

    function submitReview(){

        $rm = new ReviewMapper($this->db);
        $um = new UserMapper($this->db);
        $revm = new ReviewerMapper($this->db);
        $am = new ArticleMapper($this->db);
        
        $reviewArtID = $this->f3->get("POST.articleID");
        $reviewUsername = $this->f3->get("POST.reviewerUsername");
        $reviewScore = $this->f3->get("POST.score");
        $reviewComments = $this->f3->get("POST.comments");
        $reviewSatire = $this->f3->get("POST.satire");
        $reviewOpinion = $this->f3->get("POST.opinion");

        $reviewUsername = trim($reviewUsername);

        $user = $um->load(array("username=?",$reviewUsername));
        $revm->load(array("user_fk = ?",$user->id));
        $reviewerID = $revm->id;

        //check if user already submitted a review for article
        $rm2 = new ReviewMapper($this->db);
        $checkreview = $rm2->load(array("article_fk=? AND reviewer_fk=?",$reviewArtID, $reviewerID));

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
            $rm->reviewer_fk = $reviewerID;
            $rm->score = $reviewScore;
            $rm->comments = $reviewComments;
            $rm->satire_flag = $reviewSatire;
            $rm->opinion_flag = $reviewOpinion;
            //erroneous flag is default false
            $rm->erroneous_flag = false;
            //datetime_submitted is default current timestamp

            $rm->save();

            //recompute average score and satire/opinion for article

            $article = $am->load(array("id=?", $reviewArtID));

            $scores = array();
            $satireFlags =  array();
            $opinionFlags = array();

            //reuse rm2 to collect all non-erroneous reviews for same article
            $rm2->load(array("article_fk=? AND erroneous_flag = 0",$reviewArtID));

            while(!$rm2->dry())
            {
                array_push($scores,$rm2->score);
                array_push($satireFlags,$rm2->satire_flag);
                array_push($opinionFlags,$rm2->opinion_flag);
                $rm2->next();
            }

            //get average score
            if(count($scores) != 0)
                $avgScore = array_sum($scores)/count($scores);
            else $avgScore = null;

            //get majority satire flags
            if(count($satireFlags) != 0)
            {
                $satYes = 0;
                $satNo = 0;
                foreach($satireFlags as $sat)
                {
                    if($sat) $satYes++;//if satire, add 1 to $satYes
                    else $satNo++;
                }
                if($satYes>=$satNo) $satMaj = true;
                else $satMaj = false;
            }
            else //if no valid flags AKA no non-erroneous review, set to null
                $satMaj = null;

            //same thing with opinions
            if(count($opinionFlags) != 0)
            {
                $opYes = 0;
                $opNo = 0;
                foreach($opinionFlags as $op)
                {
                    if($op) $opYes++;//if satire, add 1 to $opYes
                    else $opNo++;
                }
                if($opYes>=$opNo) $opMaj = true;
                else $opMaj = false;
            }
            else
                $opMaj = null;

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

            //get email password from file
            $fh = fopen('email pass.txt','r');
            $emailpassword = fgets($fh);
            fclose($fh);

            $smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", $emailpassword);

            $txt = "Hello " . $regFirstName . "! It seems that you are trying to register to Verdad again. To start using Verdad, please click on the verify account link bellow the register button then enter your verification code below. Thank you.\n\n\n " . $pm->verification_code . "\n\nIf you have not signed up for Verdad News Review, please reply to this message stating so. Thank you.";

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
            //get email password from file
            $fh = fopen('email pass.txt','r');
            $emailpassword = fgets($fh);
            fclose($fh);

            $smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", $emailpassword);

            $txt = "Hello " . $regFirstName . "! Thank you for registering to Verdad News Review. To verify your email, please copy the code below to the prompt given after your user registration. Thank you.\n\n\n " . $rando . "\n\nIf you have not signed up for Verdad News Review, please reply to this message stating so. Thank you.";

            $smtp->set("From", 'verdadnewsreview@gmail.com');
            $smtp->set("To",  $regEmail);
            $smtp->set("Subject", "Verdad User Registration Verification");
            $sent = $smtp->send($txt, true);

            if($sent)
                echo $sent;
            else
                echo $smtp->log();
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



                $this->f3->set("SESSION.profileImagePath", $profileimagepath);
                $this->f3->set("SESSION.profilePhoneNumber", $phonenumber);
                $this->f3->set("SESSION.profilePhoneArea", $phonearea);
                $this->f3->set("SESSION.profileAffiliations", $affiliations);
            }
        }
    }

    function registerReviewer()
    {
        $user = $this->f3->get("SESSION.user");

        //check if user already submitted a pending reviewer registration
        $um = new UserMapper($this->db);
        $um->load(array("username = ?", $user));

        $prm = new PendingReviewerMapper($this->db);
        $prm->load(array("user_fk = ? AND approved_reviewer = 0", $um->id));

        if(!$prm->dry())
        {
            echo "You still have a pending reviewer registration.";
            echo false;
        }

        else
        {
            $path = 'uploads/' . $user . "/";

            $this->f3->set('UPLOADS', $path);

            $overwrite = true;
            $slug = true;

            $web = \Web::instance();

            $files = $web->receive(function($file,$formFieldName){
                    var_dump($file);

                    //check if < 8 MB
                    if($file['size'] > (8 * 1024 * 1024))
                       return false;

                    return true;
                },
                $overwrite,
                function($fileBaseName, $formFieldName){
                    // input field name + file extension
                    return $formFieldName . ".". pathinfo($fileBaseName, PATHINFO_EXTENSION);
                }
            );

            if($files == true)
            {
                $dir = scandir($path,SCANDIR_SORT_DESCENDING);

                $firstfile = basename($dir[0], "." . pathinfo($dir[0])['extension']); //get first file w/o file extension

                $prm = new PendingReviewerMapper($this->db);
                $pam = new PendingAffiliationMapper($this->db);
                $um = new UserMapper($this->db);
                $om = new OrganizationMapper($this->db);
                
                //write other stuff first
                $um->load(array("username = ?",$user));
                $userid = $um->id;

                //id default auto-increment
                //if first file is profileUpload, then proceed and make i = 1
                if($firstfile == 'profileUpload'){
                    $prm->profile_img_path = $path . $dir[0];
                }
                //else make empty then i = 0;
                else{
                    //copy default profile image
                    copy("uploads/default_profile.png", $path."profileUpload.png");
                    //refresh $dir
                    $dir = scandir($path,SCANDIR_SORT_DESCENDING);
                    $prm->profile_img_path = $path.$dir[0];
                }
                
                $prm->phone = $this->f3->get("POST.revRegPhone");
                $prm->phone_area = $this->f3->get("POST.revRegPhoneArea");
                $prm->user_fk = $userid;
                //request_time default is current timestamp
                $prm->approved_reviewer = false;
                $prm->approved_reviewer_fk = null;
                $prm->save();

                $prm->load(array("user_fk = ? AND approved_reviewer = 0", $userid));

                $pendingReviewerID = $prm->id;

                $loop = sizeOf($dir) - 2;

                
                for($i = 1; $i < $loop; $i++) //last two entries are . and ..
                {
                    $occupation = $this->f3->get("POST.position" . ($i-1));
                    $orgName = $this->f3->get("POST.organization" . ($i-1));

                    $om->load(array("org_name = ?", $orgName));
                    //if non-existent, write new
                    if($om->dry())
                    {
                        //id is default
                        $om->org_name = $orgName;
                        $om->save();
                        //then get new id
                        $om->load(array("org_name = ?", $orgName));
                        $orgID = $om->id;
                    }
                    else
                        $orgID = $om->id;

                    //write values to pending affiliations
                    //id is default
                    $pam->occupation = $occupation;
                    $pam->id_img_path = $path . $dir[$loop - $i];
                    $pam->organization_fk = $orgID;
                    $pam->pending_reviewer_fk = $pendingReviewerID;
                    $pam->save();

                    //don't forget to reset
                    $om->reset();
                    $pam->reset();
                }
                ob_end_clean();
                echo true;
            }
            else
            {
                //file upload failed
                echo "Photo upload failed";
                
            }
        }
    }

    function reportReview()
    {
        $reportedReviewID = $this->f3->get("POST.reportedReviewID");
        $reportSubmitterUsername = $this->f3->get("POST.reportSubmitterUsername");
        $reasons = $this->f3->get("POST.reasons");
        $reportComments = $this->f3->get("POST.reportComments");

        $repm = new ReportMapper($this->db); //report
        $usm = new UserMapper($this->db); //submitter
        $rsm = new ReviewerMapper($this->db);
        $ucm = new UserMapper($this->db); //checker
        $rcm = new ReviewerMapper($this->db);
        $acm = new AffiliationMapper($this->db);
        $rwm = new ReviewerMapper($this->db); //writer
        $awm = new AffiliationMapper($this->db);
        $revm = new ReviewMapper($this->db); //reported review

        //load submitter
        $usm->load(array("username = ?", $reportSubmitterUsername));
        $rsm->load(array("user_fk = ?", $usm->id)); //get reviewer id of submitter
        
        //get someone else to review
        //a. get review writer's org
        $revm->load(array("id = ?", $reportedReviewID)); //getting reviewer_fk
        $rwm->load(array("id = ?", $revm->reviewer_fk)); //getting id to get affiliation
        $awm->load(array("reviewer_fk = ?", $rwm->id)); //getting affiliation

        $writerOrgs = array();
        while(!$awm->dry())
        {
            array_push($writerOrgs, $awm->organization_fk);
            $awm->next();
        }

        //build query to find exempted
        $querytext = '';
        $query = array();
        
        for($i = 0; $i < sizeOf($writerOrgs); $i++)
        {
            if($i == sizeOf($writerOrgs) - 1) // last entry
                $querytext = $querytext."organization_fk = ? ";
            else
                $querytext = $querytext."organization_fk = ? OR ";
        }
        //exempt report submitter
        $querytext = $querytext."OR reviewer_fk = ?";
        array_push($query, $querytext);

        for($i = 0; $i < sizeOf($writerOrgs); $i++)
            array_push($query, $writerOrgs[$i]);
        array_push($query, $rsm->id);

        $acm->load($query);
        $query2 = $query;

        $exempted = array();
        while(!$acm->dry())
        {
            array_push($exempted,$acm->reviewer_fk);
            $acm->next();
        }
        $exempted = array_values(array_unique($exempted)); //weed out possible duplicates then get rid of those pesky keys

        //build query to find possible candidates
        $querytext = '';
        $query = array();

        for($i=0; $i<sizeOf($exempted); $i++)
        {
            if($i == sizeOf($exempted)-1)
                $querytext = $querytext."reviewer_fk != ?";
            else
                $querytext = $querytext."reviewer_fk != ? AND ";
        }
        array_push($query, $querytext);

        for($i = 0; $i < sizeOf($exempted); $i++)
            array_push($query, $exempted[$i]);

        $acm->load($query);//should result to list of candidates
        $candidates = array();
        while(!$acm->dry())
        {
            array_push($candidates, $acm->reviewer_fk);
            $acm->next();
        }
        $candidates = array_values(array_unique($candidates));

        //if single candidate, choose as checker
        if(sizeOf($candidates) == 1)
            $checker = $candidates[0];
        else if (sizeOf($candidates) == 0) //no candidates, admin checks report
            $checker = null;
        else //more than one candidate, randomly choose
            $checker = $candidates[rand(0, sizeOf($candidates)-1)];

        //add the report to the table

        //id is auto-increment
        $repm->reasons = serialize($reasons);
        $repm->comments = $reportComments;
        $repm->erroneous = 0; //0 = pending, 1 = approved, -1 = disapproved. 0 is default
        $repm->review_id_fk = $reportedReviewID;
        $repm->reporter_reviewer_fk = $rsm->id;
        $repm->checker_reviewer_fk = $checker;

        $repm->save();

        //if no checker, state that admin will check
        if($checker == null)
            $info = "Report submited and will be checked by an admin.";
        //else state that another reviewer will check
        else
            $info = "Report submitted and will be checked by another reviewer.";

        echo $info;
        //echo json_encode($exempted);
    }

    function getReports()
    {
        $user = $this->f3->get("SESSION.user");

        $um = new UserMapper($this->db);
        $revm = new ReviewerMapper($this->db);
        $repm = new ReportMapper($this->db);
        $am = new ArticleMapper($this->db);
        $rm = new ReviewMapper($this->db);
        $revm2 = new ReviewerMapper($this->db);
        $um2 = new UserMapper($this->db);

        $um->load(array("username = ?", $user));
        $revm->load(array("user_fk = ?", $um->id));
        $repm->load(array("checker_reviewer_fk = ? AND erroneous = 0", $revm->id));
        /*$repm->load(array("checker_reviewer_fk IS NULL")); //query for admin, saving this for later*/

        $reports = array();
        while(!$repm->dry())
        {
            $report = array();

            $rm->load(array("id = ?", $repm->review_id_fk));
            $am->load(array("id = ?", $rm->article_fk));
            $revm2->load(array("id = ?", $rm->reviewer_fk));
            $um2->load(array("id = ?", $revm2->user_fk));

            //article title
            array_push($report, $am->title);
            //article link
            array_push($report, $am->url);
            //overall rating
            array_push($report, $am->avg_score);
            //satire/opinion flags
            array_push($report, $am->satire);
            array_push($report, $am->opinion);

            //review rating
            array_push($report, $rm->score);
            /*//reviewer id
            array_push($report, $rm->reviewer_fk);*/
            //reviewer username
            array_push($report, $um2->username);
            //review comments
            array_push($report, $rm->comments);
            //review flags
            array_push($report, $rm->satire_flag);
            array_push($report, $rm->opinion_flag);

            //reuse revm2 and um2 here to save space I could probably reuse revm and um again but naaaaah
            $revm2->load(array("id = ?", $repm->reporter_reviewer_fk));
            $um2->load(array("id = ?", $revm2->user_fk));

            //report writer username
            array_push($report, $um2->username);
            //report reasons
            array_push($report, unserialize($repm->reasons));
            //report comments
            array_push($report, $repm->comments);
            //report ID
            array_push($report, $repm->id);

            array_push($reports, $report);
            $repm->next();
        }

        echo json_encode($reports);

    }

    function denyReport()
    {
        $denyID = $this->f3->get("POST.denyID");

        $repm = new ReportMapper($this->db);
        $repm->load(array("id = ?", $denyID));
        $repm->erroneous = -1;
        $repm->save();

        $info = "Report #".$denyID." has been denied.";
        $this->f3->set('SESSION.info', $info);
    }

    function confirmReport()
    {
        //get confirmed report's id
        $confirmID = $this->f3->get("POST.confirmID");

        $repm = new ReportMapper($this->db);
        $revm = new ReviewMapper($this->db);
        $am = new ArticleMapper($this->db);

        $repm->load(array("id = ?", $confirmID));
        $revm->load(array("id = ?", $repm->review_id_fk));

        //get article ID for score recomputation later
        $artID =  $revm->article_fk;

        //mark report as 1 review confirmed erroneous
        $repm->erroneous = 1;
        $repm->save();

        //mark review as erroneous true
        $revm->erroneous_flag = true;
        $revm->save();

        //recalculate article's average score

        $am->load(array("id = ? ", $artID));
        //reuse revm to load remaining reviews
        $revm->load(array("article_fk=? AND erroneous_flag = 0",$artID));

        $scores = array();
        $satireFlags =  array();
        $opinionFlags = array();

        while(!$revm->dry())
        {
            array_push($scores,$revm->score);
            array_push($satireFlags,$revm->satire_flag);
            array_push($opinionFlags,$revm->opinion_flag);
            $revm->next();
        }

        //get average score
        if(count($scores) != 0)
            $avgScore = array_sum($scores)/count($scores);
        else $avgScore = null;

        //get majority satire flags
        if(count($satireFlags) != 0)
        {
            $satYes = 0;
            $satNo = 0;
            foreach($satireFlags as $sat)
            {
                if($sat) $satYes++;//if satire, add 1 to $satYes
                else $satNo++;
            }
            if($satYes>=$satNo) $satMaj = true;
            else $satMaj = false;
        }
        else //if no valid flags AKA no non-erroneous review, set to null
            $satMaj = null;

        //same thing with opinions
        if(count($opinionFlags) != 0)
        {
            $opYes = 0;
            $opNo = 0;
            foreach($opinionFlags as $op)
            {
                if($op) $opYes++;//if satire, add 1 to $opYes
                else $opNo++;
            }
            if($opYes>=$opNo) $opMaj = true;
            else $opMaj = false;
        }
        else
            $opMaj = null;

        $am->avg_score = $avgScore;
        $am->satire = $satMaj;
        $am->opinion = $opMaj;
        $am->save();

        $info = "Report #".$confirmID." has been confirmed.";
        $this->f3->set('SESSION.info', $info);
    }


}
