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
	}
?>