<?php
/** 
@fileName: index.php
@descrtipn: This is the main page.  
@author: Suraj T. 
@version: 1.0 
*/
require_once("config_db.php");
require_once("header.php");
?>

  <!-- Jumbotron -->
  <div class="jumbotron">
    <h1>WELCOME TO ROTARY</h1>  
    <p>Click on the state of map to see the details information</p>
  </div>
  <!-- Example row of columns -->
  <div class="row">
  	<div class="col-md-12">
  	<div id="jvm-map" style="width: 100%; height: 500px;"></div>
    </div>
    
    <div class="col-md-12">
    	<div id="branch_data"></div>
    </div>
  
  </div>
 <?php
 require_once("footer.php");
 ?>