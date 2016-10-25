<?php
/** 
@fileName: json.php
@descrtipn: This is the api file which will called from ajax request. 
@author: Suraj T. 
@version: 1.0 
*/
header('Content-Type: application/json');
include("config_db.php");
$listBranches = listBranches();
echo json_encode($listBranches);
?>