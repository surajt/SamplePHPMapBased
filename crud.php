<?php
/** 
@fileName: crud.php
@descrtipn: The file is used to do the CRUD operation. User can see the data, Insert the new data and delete. Update is not working right now. 
@author: Suraj T. 
@version: 1.0 
*/
include("config_db.php");
if(isset($_GET["mode"])) {
	$mode=$_GET["mode"];
	if($mode=="del") {
		$id = $_GET["id"];
		if(deleteBranch($id)) {
			$msg="Success";	
		}
	}
}

$errorMsg = "";
if(isset($_POST["submit"])) {
	$branch_name	=	$_POST["branch_name"];
	$contact_info	=	$_POST["contact_info"];
	$state			=	$_POST["state"];
	$city			=	$_POST["city"];
	$zip_code		=	$_POST["zip_code"];
	$phone			=	$_POST["phone"];
	$email			=	$_POST["email"];
	$contact_person	=	$_POST["contact_person"];
	$is_active		=	isset($_POST["is_active"])?$_POST["is_active"]:0;
	
	if($branch_name=="" || $contact_info=="" || $state=="" || $city=="" || $zip_code=="") {
		$errorMsg.=" Please fill the required field.  ";	
	}
	$postData = array("branch_name"=>$branch_name,"contact_info"=>$contact_info,"state"=>$state,"city"=>$city,"zip_code"=>$zip_code,"phone"=>$phone,"email"=>$email,"contact_person"=>$contact_person,"is_active"=>$is_active);
	if($errorMsg=="") {
		if(!addBranch($postData)) {
			$errorMsg.="Error: Contact admin";	
		} else {
			header("location: crud.php");
			die();
		}
	}
}

require_once("header.php");
?>

  <div class="row">
    <div class="col-md-3">
     <p>
     	<?php echo $errorMsg; ?>
     </p>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
         
          <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Branch Name">
        </div>
        <div class="form-group">         
          <input type="text" class="form-control" id="contact_info" name="contact_info" placeholder="Address">
        </div>
        
         <div class="form-group">         
          <select class="form-control" id="state" name="state" placeholder="Select State">
          	<option value="">--STATE--</option>
            <?php 
				foreach($us_states as $key=>$value) {
					echo "<option value=\"$key\">$value</option>";	
				}
			?>
          </select>
        </div>
        
        <div class="form-group">         
          <input type="text" class="form-control" id="city" name="city" placeholder="City">
        </div>
        
         <div class="form-group">         
          <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code">
        </div>
        
         <div class="form-group">         
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
        </div>
        
        <div class="form-group">         
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        
        <div class="form-group">         
          <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person">
        </div>
        
        <div class="checkbox">
    <label>
      <input type="checkbox" value="1" name="is_active" checked> Is Active
    </label>
  </div>
     	
        <button type="submit" name="submit" class="btn btn-primary">Add New</button>
      </form>
    </div>
    <div class="col-md-9">
    <h3>List of Branches</h3>
      <?php
			$listBranches = listBranches();
		?>
      <table class="table table-bordered table-responsive">
        <thead>
          <tr>
            <th>Branch Name</th>
            <th>Address</th>
            <th>Contact Person</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
				foreach($listBranches as $key=>$value) {
			?>
          <tr>
            <td><?php echo $value["branch_name"]; ?></td>
            <td><?php echo $value["contact_info"]." ".$value["city"]. " ".$value["state"]." ".$value["zip_code"] ; ?></td>
            <td><?php echo $value["contact_person"]; ?></td>
            <td><a class="btn btn-primary btn-sm" href="#"> <i class="fa fa-pencil-square fa-lg"></i> </a> <a class="btn btn-danger btn-sm" href="?mode=del&id=<?php echo $value["id"]; ?>" onClick="return cofirmDelete()"> <i class="fa fa-trash-o fa-lg"></i> </a></td>
          </tr>
          <?php 
				}
			?>
        </tbody>
      </table>
    </div>
  </div>
 <?php
 require_once("footer.php");
 ?>