<?php
/** 
@fileName: class.barnches.php
@descrtipn: The file is used to do the CRUD operation in branch table of MySQL 
@author: Suraj T. 
@version: 1.0 
*/
function listBranches($id=null){
	if($id!=null) {
     return ORM::forTable('branches')->where('id', $id)->findOne();
	} else {
		return ORM::forTable('branches')->order_by_desc('id')->find_array();	
	}
}

function addBranch($postData=array()) {
	$branchAction = ORM::for_table('branches')->create();
	$branchAction->branch_name = $postData["branch_name"];
	$branchAction->contact_info = $postData["contact_info"];    	
	$branchAction->state = $postData["state"];
	$branchAction->city = $postData["city"];
	$branchAction->zip_code = $postData["zip_code"];
	$branchAction->phone = $postData["phone"];
	$branchAction->email = $postData["email"];
	$branchAction->contact_person = $postData["contact_person"];
	$branchAction->is_active = $postData["is_active"];    	
	$branchAction->set_expr('updated_date', 'NOW()');
	$branchAction->save();	
	return $branchAction->id();
}

function deleteBranch($id=null) {
	$branchAction = ORM::for_table('branches')->find_one($id);
	if($branchAction) {
	return $branchAction->delete();
	} else {
		return false;	
	}
}

function updateBranch($id,$postData=array()){
	$branchAction = ORM::for_table('branches')->find_one($id);
	$branchAction->set($postData);
	$branchAction->save();
}

?>