<?php

class ReviewerMapper extends DB\SQL\Mapper{

	//allows loading of verdad database
	public function __construct(DB\SQL $db) {
	    parent::__construct($db,'reviewers');
	}
}
?>