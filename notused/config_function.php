<?php
ORM::configure('id_column_overrides', array(
                'employee' => 'user_id'
            ));
$listPages=array("change_request","corporate_bulletin","event","newsletter","poll","quotes","room","shoutouts","store","vendor");
function listDepartment($dep_id=NULL) {
	if($dep_id==NULL) {
		return ORM::for_table('department')->where(array("is_active"=>"Y"))->order_by_asc('department_name')->find_array();	
	}else {
		return ORM::for_table('department')->where(array('id' => $dep_id))->where_not_in("id",array(11,18,21))->order_by_asc('department_name')->find_array();
	}
}
function listAllDepartment($dep_id=NULL) {
	if($dep_id==NULL) {
		return ORM::for_table('department')->order_by_asc('department_name')->find_array();	
	}else {
		return ORM::for_table('department')->where(array('id' => $dep_id))->order_by_asc('department_name')->find_array();
	}
}
function getSingleDepartment($dep_id=NULL){
	return ORM::for_table('department')->where('id', $dep_id)->find_one();
}
function getSingleEmployee($user_id=null) {
	return ORM::for_table('employee')->where('user_id', $user_id)->find_one();	
}
function listAnnoucement($dep_id=NULL,$limit=0,$offset=5){
	if($dep_id==NULL) {
		return ORM::for_table("annoucement")->where('show_public', 'N')->order_by_desc("id")->limit(5)->offset(0)->find_array();
	} else {
		return ORM::for_table("annoucement")->where(array('department'=>$dep_id))->order_by_desc("id")->limit(5)->offset(0)->find_array();
	}	
}
function listAnnoucementSingle($id=null){
     return ORM::forTable('annoucement')->where('id', $id)->findOne();
}
function AddAnnoucement($title=NULL,$body_text=NULL,$department=NULL,$show_public=NULL){
    $annoucement = ORM::for_table('annoucement')->create();
    $annoucement->title = $title;
    $annoucement->body_text = $body_text;
    $annoucement->set_expr('updated_date', 'NOW()');
    $annoucement->created_by = $_SESSION["userdetails"]["user_id"];
    $annoucement->department = $department;
	 $annoucement->show_public = $show_public;
    $annoucement->save();
    return $annoucement->id();
}
function UpdateAnnoucement($id=null,$title=NULL,$body_text=NULL,$show_public=NULL){
    $annoucement = ORM::for_table('annoucement')->find_one($id);
    $annoucement->set(array(
        'title' => $title,
        'body_text'  => $body_text,
		'show_public' => $show_public
    ));
    $annoucement->save();
}
function listEvent($dep_id=NULL,$limit=0,$offset=5){
	if($dep_id==NULL) {
		return ORM::for_table("event")->order_by_desc("id")->limit(2)->find_array();
	} else {
		
		return ORM::for_table("event")->where(array('department'=>$dep_id))->limit(5)->find_array();
	}
	
}
function listFaq($dep_id=NULL) {
	if($dep_id==NULL) {
		return ORM::for_table('faq')->order_by_asc('id','order_by')->find_array();	
	}else {
		return ORM::for_table('faq')->where(array('department' => $dep_id))->order_by_asc('order_by','id')->find_array();
	}
}
function getSingleFaq($id=NULL){
    return ORM::for_table('faq')->where('id', $id)->find_one();
}
function AddFaq($title=NULL,$body_text=NULL,$department=NULL){
    $faq = ORM::for_table('faq')->create();
    $faq->title = $title;
    $faq->body_text = $body_text;
    $faq->set_expr('updated_date', 'NOW()');
    $faq->created_by = $_SESSION["userdetails"]["user_id"];
    $faq->department = $department;
    $faq->save();
    return $faq->id();
}
function UpdateFaq($id=NULL,$title=NULL,$body_text=NULL){
    $faq = ORM::for_table('faq')->find_one($id);
    $faq->set(array(
        'title' => $title,
        'body_text'  => $body_text
    ));
    $faq->save();    
}
function AddDocument($dep_id=NULL,$cat_id=NULL,$title=NULL,$filename=NULL){
    $doc = ORM::for_table('file_folder')->create();
    $doc->title=$title;
    $doc->category=$cat_id;
    $doc->department =$dep_id;
    $doc->path = $filename;
    $doc->set_expr('updated_date', 'NOW()');
    $doc->created_by = $_SESSION["userdetails"]["user_id"];
    $doc->save();
    return $doc->id();
    
}
function listUsefulLink($dep_id=NULL) {
	if($dep_id==NULL) {
		return ORM::for_table('useful_links')->order_by_desc('id')->find_array();	
	}else {
		return ORM::for_table('useful_links')->where(array('department' => $dep_id,'menu_id' => 1))->order_by_desc('id')->find_array();
	}
}
/*used the field menuid in useful links table for filtering "Bond Market Agency Information Links"  */
function listBondMarketAgencyLinks($menu_id=0) {
	
		return ORM::for_table('useful_links')->where(array('department' => 4,'menu_id'=>$menu_id))->order_by_desc('id')->find_array();
}

function listStaff($dep_id=NULL) {
	if($dep_id==NULL) {
		return ORM::for_table('employee')->order_by_asc('order_by')->find_array();	
	}else {
		return ORM::for_table('employee')->where(array('department' => $dep_id))->order_by_asc('order_by')->find_array();
	}
}
function listStaffLike($letter='%A') {	
    return ORM::for_table('employee')
           ->where_like('fullname', $letter)
		   ->where('active','Y')
            ->order_by_asc('fullname')
            ->find_array();	
}
function listCategory($dep_id=NULL,$parent_id=0,$search=""){
    if($search=="") {
        $q["cat_name"]="%%";
    } else {
        $q["cat_name"]="%$search%";
    }
    $catdata= ORM::for_table('category')->where(array('dep_id' => $dep_id,"parent_id"=>$parent_id))->where_not_equal(array("cat_name"=>"Archives"))->where_like($q)->order_by_asc('cat_name')->find_array();
    if($catdata) {
        return $catdata;
    } else {
        return ORM::for_table('category')->where(array('dep_id' => $dep_id,"parent_id"=>$parent_id))->where_not_equal(array("cat_name"=>"Archives"))->order_by_asc('cat_name')->find_array();
    }
}
function listAllCategory($dep_id=NULL,$parent_id=0){
    return ORM::for_table('category')->where(array('dep_id' => $dep_id,"parent_id"=>$parent_id))->order_by_asc('cat_name')->find_array();
}
function listDocuments($dep_id=NULL,$category_id=NULL,$search=""){
    if($search=="") {
        $q["title"]="%%";
    } else {
        $q["title"]="%$search%";
    }
    return ORM::for_table('file_folder')->where(array('department' =>$dep_id,"category"=>$category_id))->where_like($q)->order_by_asc('title')->find_array();
}
function getSingleFile($id=NULL) {
    return ORM::for_table('file_folder')->where('id', $id)->find_one();	
}
function listProductSingle($id=NULL) {
	return ORM::for_table("products")->where('id',$id)->find_one();	
}
function listDocumentWithCategory($dep_id=NULL,$search=""){
    if($search!="") {
        $q["p1.title"]="%$search%";
    } else {
        $q["p1.title"]="%%";
    }
    return ORM::for_table('file_folder')
    ->table_alias('p1')
    ->select('p1.*')
    ->select('p2.cat_name')
    ->join('category', array('p1.category', '=', 'p2.id'), 'p2')
    ->where(array('p1.department'=>$dep_id))
    ->where_like($q)
    ->where_not_equal(array('p2.cat_name'=>'Archives'))        
    ->order_by_asc('title')
    ->find_array();
}
function listProducts($p_type="Store"){
    return ORM::for_table('products')
            ->table_alias("p1")
            ->select("p1.*")
            ->join("employee", array("p1.created_by",'=','p2.user_id'),'p2')
            ->where(array('p1.p_type' => $p_type))
            ->order_by_desc('p1.id')->find_array();
}
function listCartUser(){
   return ORM::for_table('cart')
           ->table_alias('p1')
           ->select("p1.*")
           ->select("p2.title")
           ->select("p2.pic_thumb")
		   ->select("p2.p_type")
           ->where(array("p1.user_id"=>$_SESSION["userdetails"]["user_id"]))
           ->join("products", array('p1.product_id', '=', 'p2.id'),"p2")
           ->order_by_desc("p1.updated_date")           
           ->find_array();
}
function getSumCart(){
     return ORM::for_table('cart')->where(array("user_id"=>$_SESSION["userdetails"]["user_id"]))->sum("amount");
}

function listStaffWithDepartment($letter="",$search="",$department=""){
    $allData=NULL;
    $q=array();
    $q1="";
    
    if($letter!=""){
        $q[]=array("p1.fullname"=>"$letter");
    }
    if($search!=""){
        $q[]=array("p1.fullname"=>"$search%");
    }
    $sql="SELECT `p1`.*, `p2`.`department_name` FROM `employee` `p1` LEFT OUTER JOIN `department` `p2` ON `p1`.`department` = `p2`.`id` WHERE 1=1  ";
    if($letter!="") {
        $sql.=" AND p1.fullname LIKE '$letter' ";
    }
    if($search!="") {
        $sql.=" AND p1.fullname like '$search%' ";
    }
    if($department!="") {
        $sql.=" AND p1.department='$department'";
    }
    
    $allData=ORM::for_table('employee')->raw_query($sql)->find_array();
    
    
    return $allData;
}

function mb_substrws($text, $length = 250) {
		if((mb_strlen($text) > $length)) {
			$whitespaceposition = mb_strpos($text, ' ', $length) - 1;
			if($whitespaceposition > 0) {
				$chars = count_chars(mb_substr($text, 0, ($whitespaceposition + 1)), 1);
                                
				if ($chars[ord('<')] > $chars[ord('>')]) {
					$whitespaceposition = mb_strpos($text, ">", $whitespaceposition) - 1;
				}
				$text = mb_substr($text, 0, ($whitespaceposition + 1));
			}
			// close unclosed html tags
			if(preg_match_all("|(<([\w]+)[^>]*>)|", $text, $aBuffer)) {
				if(!empty($aBuffer[1])) {
					preg_match_all("|</([a-zA-Z]+)>|", $text, $aBuffer2);
					if(count($aBuffer[2]) != count($aBuffer2[1])) {
						$closing_tags = array_diff($aBuffer[2], $aBuffer2[1]);
						$closing_tags = array_reverse($closing_tags);
						foreach($closing_tags as $tag) {
								$text .= '</'.$tag.'>';
						}
					}
				}
			}
		}
		return $text;
} 
function CreateDir($id=NULLL,$folder="uploaddoc") {
	$dir = $id+999-(($id-1)%1000);
	$campdir = "$folder/$dir/$id/";
	$camp_path_array = explode("/",$campdir);
	array_pop($camp_path_array );
	array_pop($camp_path_array );
	$maindir = implode("/", $camp_path_array)."/";
	
	if(!is_dir($maindir) )   { 
		mkdir($maindir, 0777); 
		chmod($maindir, 0777); 
		$handle = fopen($maindir."index.php", 'x+');
		fclose($handle);
	}
	
	if(!is_dir($campdir) )   {
	  mkdir($campdir, 0777);
	  chmod($campdir, 0777);
	  //$handle = fopen($campdir."/index.php", 'x+');
	  //fclose($handle);
	}
	
	return GetDir($id,$folder);
	
}

function GetDir($id=NULL,$folder="uploaddoc") {
	$dir = $id+999-(($id-1)%1000);
	$campdir = "$folder/$dir/$id/";
	return $campdir;
}


function findexts($filename){ 
 $filename = strtolower($filename) ; 
 $exts = split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts;
} 
function printIcons($filetype=NULL){
    switch($filetype){
        case "doc":
        case "docx":
            return "<i class='fa fa-file-word-o' style='color:#174594'></i>";
            break;
        case "xls":
        case "xlsx":
            return "<i class='fa fa-file-excel-o' style='color:#335d13'></i>";
            break;
        case "zip":
        case "tar":
        case "bz":
            return "<i class='fa fa-file-archive-o' style='color:#c1131c'></i>";
            break;
        case "pdf":
            return "<i class='fa fa-file-pdf-o' style='color:#8c0505'></i>";
            break;
        case "txt":
            return "<i class='fa fa-file-text' style='color:#bee1e9'></i>";
            break;
        case "jpg":
        case "png":
        case "jpef":
        case "gif":
        case "tiff":
            return "<i class='fa fa-file-picture-o' style='color:#DB6000'></i>";
            break;
        case "flv":
        case "mov":
        case "avi":
        case "swf":
            return "<i class='fa fa-file-movie-o' style='color:#174594'></i>";
            break;
        case "ppt":
        case "pptx":
            return "<i class='fa fa-file-powerpoint-o' style='color:#174594'></i>";
            break;
        default:
            return "<i class='fa fa-file' style='color:#174594'></i>";
            break;
        
    }
}

function displayCategoryTree($dep_id,$parent,$level){
    $l_a_s=listCategory($dep_id,$parent);
     foreach($l_a_s as $vvv) {
                
                        echo "<div class='treetype'>";
                        echo "<div class='treetitle'>".  str_repeat("--", $level)."<a class='treetoggle' data-id='".$vvv['id']."' href='javascript:void(0)'><i class='fa fa-folder'></i> &nbsp;".$vvv['cat_name']."</a></div>";
                        echo "<div class='treecontent' style='display:none' id='treeid".$vvv['id']."'>";
                            
                        $doc_list_a = listDocuments($dep_id,$vvv['id']);
                   
                    foreach($doc_list_a as $vvvv) {
                        $path = strtolower(str_replace(" ","",$vvvv['path']));
                        $p_encode = urlencode($path);
                        $t = $vvvv['title'];
                        $i=$vvvv['id'];
                        $ext = explode(".",$path);
                        $a=pathinfo($path, PATHINFO_EXTENSION);
                        echo "<div class='doc_list_icons'>";
                        echo "<div class='col-md-10'>";
                       /* echo printIcons($a)."<a href=\"".$path."\" data-which=\"event\" data-title=\"".$vvvv['title']."\" data-id=\"".$vvvv['id']."\" class=\"annoucement_modal\" data-toggle=\"modal\" data-target=\".bs-example-modal-lg\">".$vvvv['title']."</a>";*/
                        echo printIcons($a)."<a target='_blank' href='https://drive.google.com/viewerng/viewer?url=http://mynfm.com/".$path."'>".$vvvv['title']."</a>";
						echo "</div>";
                        echo "<div class='col-md-2'>";
                        echo "<a href='forcedownload.php?file=".$path."' class='btn btn-xs btn-default pull-right'><i class='fa fa-download'></i></a> <a target='_blank' href='https://drive.google.com/viewerng/viewer?url=http://mynfm.com/".$path."' class=' pull-right'><i class='fa fa-search'></i></a>";
                        echo "</div>";
                        echo "</div>";
                        
                    }
                        
                        
                        echo "</div>";
                        
                        echo "</div>";
                       displayCategoryTree($dep_id,$vvv['id'],$level+2);
                    }
}
function treeCategory($parent_id=0,$dep_id=NULL) {
    $cat_list=  listCategory($dep_id, $parent_id);
    if(!empty($cat_list)) {
        if($parent_id==0) {
            echo '<ul class="treeview" id="tree">';
        } else {
            echo '<ul style="display: none;">';      
        }
        foreach($cat_list as $v) {
            echo '<li class="expandable"> <div class="hitarea expandable-hitarea"></div><a class="editme" data-pk="'.$v['id'].'" href="javascript:void(0);">'.$v['cat_name'].'</a>  &nbsp;&nbsp;&nbsp;&nbsp;<a class="pull-right confirm btn btn-danger btn-xs" href="manage_folder.php?mode=del&dep_id='.$dep_id.'&id='.$v['id'].'"><i class="fa fa-remove"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
            treeCategory($v['id'],$dep_id);
            echo ' </li> ';
            
        }
        echo '</ul>';
    }
    
}
//for department head documents
function treeCategoryDepHead($parent_id=0,$dep_id=NULL,$created_by=NULL,$is_admin=NULL) {
    $cat_list=  listCategory($dep_id, $parent_id);
    if(!empty($cat_list)) {
        if($parent_id==0) {
            echo '<ul class="treeview" id="tree">';
        } else {
            echo '<ul style="display: none;">';      
        }
        foreach($cat_list as $v) {
			if($created_by==$v['created_by'] || $is_admin=="Y"){
            echo '<li class="expandable"> <div class="hitarea expandable-hitarea"></div><a class="editme" data-pk="'.$v['id'].'" href="javascript:void(0);">'.$v['cat_name'].'</a>  &nbsp;&nbsp;&nbsp;&nbsp;<a class="pull-right confirm btn btn-danger btn-xs" href="dep_head_manage_folder.php?mode=del&dep_id='.$dep_id.'&id='.$v['id'].'"><i class="fa fa-remove"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
            treeCategory($v['id'],$dep_id);
            echo ' </li> ';
			}
			else{
			 echo '<li class="expandable"> <div class="hitarea expandable-hitarea"></div><a class="" data-pk="'.$v['id'].'" href="#">'.$v['cat_name'].'</a> ';
            treeCategoryDepHead($v['id'],$dep_id);
            echo ' </li> ';
			}
            
        }
        echo '</ul>';
    }
    
}

function display_childrencat($parent,$level,$dep_id=NULL,$selected=NULL) {
		$cat = listAllCategory($dep_id,$parent);
	
	
   foreach ($cat as $row) {
   		if($row['id']==trim($selected)) {
			$a="selected";
		} else {
			$a="";
		}
       $allData=$allData."<option value='".$row['id']."' $a>".str_repeat('--',$level).$row['cat_name']." </option>";
       $allData=$allData.display_childrencat($row['id'], $level+1,$dep_id,$selected);
   }

  return $allData;
}

function search_widget_annoucement($search=""){
	$listData = ORM::for_table("annoucement")->where_like(array("title"=>"%$search%","body_text"=>"%$search%"))->order_by_desc("id")->find_array();
	if(!empty($listData)) {
	echo '
	<div id="search_annoucement" >
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Annoucements</h3>
  </div>
  <div class="panel-body" style="height:300px;overflow:auto;">';
    foreach($listData as $v) {
				$by_who = getSingleEmployee($v['created_by']);
			 $b_w="public";
			 if(!empty($by_who)) {
					$b_w = $by_who->fullname; 
			 }
                    
		?>
        <div class="content">
		<h4 class="title"><a href="javascript:void()"><?php echo $v['title'];?></a></h4>
		<div class="postinfo">Posted On: <?php echo date_format(date_create($v['updated_date']),'m-d-y G:i A'); ?> By: <?php echo $b_w; ?></div>
		<div class="postbody">
                    <?php echo substr(strip_tags($v['body_text']),0,250); ?> 
                </div>
	  </div>
        <?php		
		}
	  
	
echo '  </div>
</div></div>';
	}
}

function search_widget_event($search=""){
	if(!empty($listData)) {
	$listData = ORM::for_table("event")->where_like(array("title"=>"%$search%","body_text"=>"%$search%"))->order_by_desc("id")->find_array();
	echo '
	<div id="search_annoucement" >
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Events</h3>
  </div>
  <div class="panel-body" style="height:300px;overflow:auto;">';
    foreach($listData as $v) {
				$by_who = getSingleEmployee($v['created_by']);
			 $b_w="public";
			 if(!empty($by_who)) {
					$b_w = $by_who->fullname; 
			 }
                    
		?>
        <div class="content">
		<h4 class="title"><a href="javascript:void()"><?php echo $v['title'];?></a></h4>
		<div class="postinfo">Posted On: <?php echo date_format(date_create($v['updated_date']),'m-d-y G:i A'); ?> By: <?php echo $b_w; ?></div>
		<div class="postbody">
                    <?php echo substr(strip_tags($v['body_text']),0,250); ?> 
                </div>
	  </div>
        <?php		
		}
	  
	
echo '  </div>
</div></div>';
	}
	
}

function search_widget_faq($search=""){
	
	$listData = ORM::for_table("faq")
	//->where_like(array("title"=>"%$search%","body_text"=>"%$search%"))
	->where_any_is(array(
                array("title" =>"%$search%"),
                array("body_text" =>"%$search%")),'like')
	->order_by_desc("id")->find_array();
	if(!empty($listData)) {
	echo '
	<div id="search_annoucement" >
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">FAQs</h3>
  </div>
  <div class="panel-body" style="height:300px;overflow:auto;">';
    foreach($listData as $v) {
				$by_who = getSingleDepartment($v['department']);
			 $b_w="public";
			 if(!empty($by_who)) {
					$b_w = $by_who->department_name; 
			 }
                    
		?>
    
      
      
      <div class="panel-group collapse" id="myFaq<?php echo $v['id']; ?>" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
          Posted in : <strong><a href="department.php?dep_id=<?php echo $v['department'];?>"><?php echo $b_w; ?></a></strong>
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a data-toggle="collapse" class="accordion-toggle" data-parent="#myFaq<?php echo $v['id']; ?>" href="#collapseOne<?php echo $v['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
                  <?php echo $v['title'];?>  </a></h4>
                  
               
              
            </div>
            <div id="collapseOne<?php echo $v['id']; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <?php echo $v['body_text']; ?>
                 
                  
              </div>
            </div>
          </div>
        </div>
      
        <?php			
		}
echo '  </div>
</div></div>';
	}
	
}

function search_widget_document($search=""){
	$listData = ORM::for_table("file_folder")->where_like(array("title"=>"%$search%"))->where_not_equal(array('department'=>'22'))->order_by_desc("id")->find_array();
	if(!empty($listData)) {
	echo '
	<div id="search_annoucement" >
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Policies and Documents</h3>
  </div>
  <div class="panel-body" style="min-height:300px;overflow:auto;">';
    foreach($listData as $v) {
		 $path = strtolower(str_replace(" ","",$v['path']));
				$by_who = getSingleEmployee($v['created_by']);
			 $b_w="public";
			 if(!empty($by_who)) {
					$b_w = $by_who->fullname; 
			 }
                    
		?>
        <div class="content">
		<h4 class="title"><a href="javascript:void()"><?php echo $v['title'];?></a></h4>
		<div class="postinfo">Posted On: <?php echo date_format(date_create($v['updated_date']),'m-d-y G:i A'); ?> By: <?php echo $b_w; ?></div>
		<div class="postbody">
                    <a href="forcedownload.php?file=<?php echo $path; ?>">Download</a>
                </div>
	  </div>
        <?php		
		}
	  
	
echo '  </div>
</div></div>';
	}
	
}


function view_branchresources($username=NULL) {
	if($username==NULL) {
		return ORM::for_table('employee')->find_array();	
	}else {
		return ORM::for_table('employee')->where(array('username' => $username,'bm_resources'=>"BM"))->find_array();
	}
}
function edit_branchresources($username=NULL) {
	if($username==NULL) {
		return ORM::for_table('employee')->find_array();	
	}else {
		return ORM::for_table('employee')->where(array('username' => $username,'bm_resources'=>"CM"))->find_array();
	}
}

function nfm_executives($username=NULL) {
	if($username==NULL) {
		return ORM::for_table('employee')->find_array();	
	}else {
		return ORM::for_table('employee')->where(array('username' => $username,'manager_type'=>"ex"))->find_array();
	}
}
function nfm_managers($username=NULL) {
	if($username==NULL) {
		return ORM::for_table('employee')->find_array();	
	}else {
		return ORM::for_table('employee')->where(array('username' => $username,'manager_type'=>"mn"))->find_array();
	}
}

function nfm_branch_managers($username=NULL) {
	if($username==NULL) {
		return ORM::for_table('employee')->find_array();	
	}else {
		return ORM::for_table('employee')->where(array('username' => $username,'manager_type'=>"bm"))->find_array();
	}
}

function listFlyerType($id=NULL) {
	return ORM::for_table("products")->distinct()->select('flyer_type')->where('p_type','flyer')->order_by_asc("folder_id")->find_array();	
}

function listProductByFlyber($flyer_type="") {
	 return ORM::for_table('products')
            ->table_alias("p1")
            ->select("p1.*")
            ->join("employee", array("p1.created_by",'=','p2.user_id'),'p2')
            ->where(array('p1.flyer_type' => $flyer_type))
            ->order_by_desc('p1.id')->find_array();	
}


//by suraj b
function search_widget_directory($search=""){
	
	$listData = ORM::for_table("employee")->where_like(array("fullname"=>"%$search%"))->order_by_desc("user_id")->find_array();
	if(!empty($listData)) {
	echo '
	<div id="search_directory" >
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Directory</h3>
  </div>
  <div class="panel-body" style="height:300px;overflow:auto;">';
    foreach($listData as $v) {
                    
		?>
        <div class="content">
		<h4 class="title"><?php echo $v['fullname'];?></h4>		
		<div class="postbody">
                    Position: <?php echo $v['pos'];?>
                </div>
                <div class="postbody">
                    Email:  <a href="mailto:<?php echo $v['email'];?>"><?php echo $v['email'];?></a>
                </div>
                <div class="postbody">
                    Phone: <?php echo $v['phone'];?>
                </div>
	  </div>
        <?php		
		}
	  
	
echo '  </div>
</div></div>';
	}
	
}

function AddVendorDocument($req_id=NULL,$doc_name=NULL,$path=NULL){
	date_default_timezone_set('America/New_York');
    $vendordoc = ORM::for_table('vendor_doc')->create();
    $vendordoc->request_id=$req_id;
    $vendordoc->document_name=$doc_name;
    $vendordoc->path =$path;
   	$vendordoc->date_added = date('Y-m-d H:i:s');
    $vendordoc->save();
    return $vendordoc->id();
    
}

/*weekly coprprate bulletin */
function listBulletin() {
	
		return ORM::for_table('weekly_corporate_bulletin')->order_by_desc('posted_on')->find_array();	
	
}
function getSingleBulletin($id=NULL){
    return ORM::for_table('weekly_corporate_bulletin')->where('id', $id)->find_one();
}
function AddBulletin($title=NULL,$changes_addressed=NULL,$body_text=NULL){
    $bulletin = ORM::for_table('weekly_corporate_bulletin')->create();
    $bulletin->title = $title;
	$bulletin->changes_addressed = $changes_addressed;
    $bulletin->body_text = $body_text;
    $bulletin->set_expr('posted_on', 'NOW()');
    $bulletin->created_by = $_SESSION["userdetails"]["user_id"];
   // $bulletin->department = $department;
    $bulletin->save();
    return $bulletin->id();
}
function UpdateBulletin($id=NULL,$title=NULL,$changes_addressed=NULL,$body_text=NULL){
    $bulletin = ORM::for_table('weekly_corporate_bulletin')->find_one($id);
    $bulletin->set(array(
        'title' => $title,
        'body_text'  => $body_text,
		'changes_addressed'  => $changes_addressed
    ));
    $bulletin->save();    
}
/*weekly coprprate bulletin  END */


function listNFMShoutouts($search="",$limit=""){
    $allData=NULL;
    
    //$sql="SELECT `p1`.*, `p2`.`department_name` FROM `employee` `p1` LEFT OUTER JOIN `department` `p2` ON `p1`.`department` = `p2`.`id` WHERE 1=1  ";
	$sql="SELECT * from nfm_shoutout WHERE 1=1  ";
  //  $sql=" select * from nfm_shoutout  order by submitted_date desc limit $limit ";
    if($search!="") {
        $sql.=" AND your_name like '$search%' OR name_of_nominee like '$search%' or badge like  '$search%' ";
    }
	$sql .= " order by submitted_date desc  limit $limit ";
   
    $allData=ORM::for_table('nfm_shoutout')->raw_query($sql)->find_array();
    
    
    return $allData;
}

function listApprovedShoutouts($limit=""){
    $allData=NULL;
    
    //$sql="SELECT `p1`.*, `p2`.`department_name` FROM `employee` `p1` LEFT OUTER JOIN `department` `p2` ON `p1`.`department` = `p2`.`id` WHERE 1=1  ";
	$sql="SELECT * from nfm_shoutout WHERE 1=1  ";
 
	$sql .= " and status = 'Y' order by submitted_date desc  limit $limit ";
   
    $allData=ORM::for_table('nfm_shoutout')->raw_query($sql)->find_array();
    
    
    return $allData;
}

function getBadge($badge=NULL){
    switch($badge){
        case "Silverman Award":
            return "<img src='images/silverman-award.jpg' alt='Sliverman Award' />";
            break;
        case "Epic Leader":
             return "<img src='images/epic-leader.jpg' alt='Epic Leader' />";
            break;
        case "Dream Team":
             return "<img src='images/dream-team.jpg' alt='Dream Team' />";
            break;
        case "Medal of Awesomeness":
             return "<img src='images/medal-of-awesomeness.jpg' alt='Medal of Awesomeness' />";
            break;
        case "Outstanding Customer Service":
             return "<img src='images/outstanding-customer-service.jpg' alt='Outstanding Customer Service' />";
            break;
        case "High 5":
            return "<img src='images/high-5.jpg' alt='High 5' />";
            break;
        case "Working with You Is a Treat":
             return "<img src='images/working-with-you-is-a-treat.jpg' alt='Working with You Is a Treat' />";
            break;
        case "Bright Idea":
             return "<img src='images/bright-idea.jpg' alt='Bright Idea' />";
            break;
        default:
            return "";
            break;
        
    }
}


?>