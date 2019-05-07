<?php

	class AdminController extends Controller
	{
		function home()
		{
			$this->renderview("admin.htm");
		}

		function adminLogin()
		{
			$username = $this->f3->get('POST.username');
	        $password = $this->f3->get('POST.password');

	        $admin = new AdminMapper($this->db);
	        $admin->getByName($username);

	        //username not found
	        if($admin->dry()) {
	            $info = 'Username not found';

	            $this->f3->set('SESSION.info', $info);
	            $this->f3->clear('SESSION.admin');
	        }

	        //successful login
	        else if(password_verify($password, $admin->password)) {
	            $username = $admin->username;

	            $this->f3->set('SESSION.admin', $username);
	            $this->f3->clear('SESSION.info');
	        }

	        //wrong password
	        else {
	            $info = 'Password incorrect';


	            $this->f3->set('SESSION.info', $info);
	            $this->f3->clear('SESSION.admin');
	        }
		}

		function adminLogout()
		{
	        if($this->f3->get('SESSION.admin') != null)
	        {
	            $this->f3->clear('SESSION.admin');
	            $this->f3->clear('SESSION.info');
	        }
	    }

	    function getPendingReviewers()
	    {
	    	$prList = array();

	    	$prm = new PendingReviewerMapper($this->db);
	    	$pam = new PendingAffiliationMapper($this->db);
	    	$um = new UserMapper($this->db);
	    	$om = new Organizationmapper($this->db);

	    	//$prm->load("1", array('order'=>'request_time DESC'));
	    	$prm->load(array("approved_reviewer = ?", false), array('order'=>'request_time DESC'));

	    	while(!$prm->dry())
	    	{
	    		$entry = array();
	    		$um->load(array("id=?",$prm->user_fk));

	    		//id
	    		array_push($entry, $prm->id);
	    		//username
	    		array_push($entry, $um->username);
	    		//last name
	    		array_push($entry, $um->last_name);
	    		//first name
	    		array_push($entry, $um->first_name);
	    		//middle name
	    		array_push($entry, $um->middle_name);
	    		//name suffix
	    		array_push($entry, $um->name_suffix);
	    		//date
	    		array_push($entry, $prm->request_time);
	    		//profile image
	    		array_push($entry, $prm->profile_img_path);
	    		//email
	    		array_push($entry, $um->email);
	    		//phone area
	    		array_push($entry, $prm->phone_area);
	    		//phone number
	    		array_push($entry, $prm->phone);

	    		//affiliations
	    		$pam->load(array("pending_reviewer_fk = ?", $prm->id));
	    		$affList = array();

	    		while(!$pam->dry())
	    		{
	    			$affEntry = array();

	    			//occupation
	    			array_push($affEntry, $pam->occupation);
	    			//org id
	    			array_push($affEntry, $pam->organization_fk);
	    			//get org name
	    			$om->load(array("id = ?", $pam->organization_fk));
	    			array_push($affEntry, $om->org_name);
	    			//org id path
	    			array_push($affEntry, $pam->id_img_path);

	    			//push to entry]

	    			array_push($affList, $affEntry);

	    			//go to next query entry
	    			$pam->next();
	    		}

	    		//push aff list to entry
	    		array_push($entry, $affList);

	    		//push entry to prlist
	    		array_push($prList, $entry);
	    		$prm->next();
	    	}

	    	echo json_encode($prList);

	    }

	    function sendInquiry()
	    {
	    	$id = $this->f3->get("POST.inquireID");
	    	$inquiry = $this->f3->get("POST.inquireText");

	    	$prm = new PendingReviewerMapper($this->db);
	    	$um = new UserMapper($this->db);

	    	$prm->load(array("id=?",$id));
	    	$um->load(array("id=?", $prm->user_fk));

	    	$username = $um->username;
	    	$email = $um->email;

	    	$smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", "thepresscorpse" );

			$txt = "Hello " . $username . "! We would like to inquire further about your registration as reviewer for Verdad. Specifically, we would like to ask the following: \n\n" . $inquiry . "\n\nYou may send your reply to the inquiry to this email. Thank you.";

			$smtp->set("From", 'verdadnewsreview@gmail.com');
			$smtp->set("To",  $email);
			$smtp->set("Subject", "Verdad Reviewer Registration Inquiry");
			$sent = $smtp->send($txt, true);

			if ($sent)
				echo $sent;
			else
				echo $smtp->log();

	    }

	    function denyRegistration()
	    {
	    	$id = $this->f3->get("POST.denyID");
	    	$reason = $this->f3->get("POST.denyText");

	    	$prm = new PendingReviewerMapper($this->db);
	    	$pam = new PendingAffiliationMapper($this->db);
	    	$um = new UserMapper($this->db);

	    	$prm->load(array("id=?", $id));
	    	$pam->load(array("pending_reviewer_fk = ?", $prm->id));
	    	$um->load(array("id=?", $prm->user_fk));

	    	$username = $um->username;
	    	$email = $um->email;

			$smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", "thepresscorpse" );

			$txt = "Hello " . $username . ". We regret to inform you that your registration as reviewer has been denied. Your registration has been denied because of the following: \n\n" . $reason . "\n\nYou may still contribute to the community by submitting articles for review. You may also try to register as a reviewer again. If you have any concerns, please reply to this email. Thank you.";

			$smtp->set("From", 'verdadnewsreview@gmail.com');
			$smtp->set("To",  $email);
			$smtp->set("Subject", "Verdad Reviewer Registration Inquiry");
			$sent = $smtp->send($txt, true);   	

	    	//send email

	    	//delete pending reviewer and affiliations and files
	    	while(!$pam->dry())
	    	{
	    		//delete org id file
	    		chown($pam->id_img_path, 666); //set to no owner I read this at https://stackoverflow.com/questions/11463581/how-to-use-unlink-function and might mitigate some errors in windows
	    		unlink($pam->id_img_path);
	    		//remove entry then go to next
	    		$pam->erase();
	    		$pam->next();
	    	}
	    	//delete profile image
	    	chown($prm->profile_img_path, 666);
	    	unlink($prm->profile_img_path);
	    	$prm->erase();
	    }

	    function approveRegistration()
	    {
	    	$id = $this->f3->get("POST.approveID");

	    	$prm = new PendingReviewerMapper($this->db);
	    	$pam = new PendingAffiliationMapper($this->db);
	    	$rm = new ReviewerMapper($this->db);
	    	$am = new Affiliationmapper($this->db);
	    	$um = new UserMapper($this->db);

	    	$prm->load(array("id=?", $id));

	    	//get email address

	    	$um->load(array("id = ?", $prm->user_fk));
	    	$email = $um->email;
	    	$username = $um->username;

	    	//transfer pending reviewer to reviewer table

	    	$rm->profile_img_path = $prm->profile_img_path;
	    	$rm->phone_number = $prm->phone;
	    	$rm->phone_area = $prm->phone_area;
	    	$rm->user_fk = $prm->user_fk;
	    	$um->reviewer_status = 1;
	    	$um->save();
	    	$rm->save();

	    	//load from $rm to get new reviewer's ID
	    	$rm->load(array("user_fk = ?", $rm->user_fk));

	    	//update affiliations
	    	$pam->load(array("pending_reviewer_fk = ?", $prm->id));
	    	while(!$pam->dry())
	    	{
	    		$am->occupation = $pam->occupation;
	    		$am->organization_fk = $pam->organization_fk;
	    		$am->reviewer_fk = $rm->id;
	    		$am->save();

	    		$am->reset();
	    		$pam->next();
	    	}

	    	//update pending reviewer as approved
	    	$prm->approved_reviewer = true;
	    	$prm->approved_reviewer_fk = $rm->id;
	    	$prm->save();

	    	//send email

	    	$smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", "thepresscorpse" );

			$txt = "Hello " . $username . "! We would like to inform you that your registration as reviewer has been approved. You may now review articles for Verdad. You may also contribute to the community by submitting articles for review. If you have any concerns, please reply to this email. Thank you.";

			$smtp->set("From", 'verdadnewsreview@gmail.com');
			$smtp->set("To",  $email);
			$smtp->set("Subject", "Verdad Reviewer Registration Inquiry");
			$sent = $smtp->send($txt, true);

	    }

	    function getReports()
	    {
	        //$user = $this->f3->get("SESSION.user");

	        //$um = new UserMapper($this->db);
	        //$revm = new ReviewerMapper($this->db);
	        $repm = new ReportMapper($this->db);
	        $am = new ArticleMapper($this->db);
	        $rm = new ReviewMapper($this->db);
	        $revm2 = new ReviewerMapper($this->db);
	        $um2 = new UserMapper($this->db);

	        //$um->load(array("username = ?", $user));
	        //$revm->load(array("user_fk = ?", $um->id));
	        $repm->load(array("checker_reviewer_fk IS NULL AND erroneous = 0"));
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
	        echo $denyID;

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
	        echo $confirmID;

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
?>