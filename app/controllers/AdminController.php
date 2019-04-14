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
	            $this->f3->reroute('/admin');
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

	    	$smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", "philtyphilphilantropist" );

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

			$smtp = new SMTP ( "smtp.gmail.com", 465, "SSL", "verdadnewsreview@gmail.com", "philtyphilphilantropist" );

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
	}
?>