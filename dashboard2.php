<html>

<head>
	<title>Dashboard</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:left; padding-left:10px; vertical-align:top;} 
		h3 {padding-top: 20px; font-weight: bold; text-decoration: underline;}
	</style>
	
<script type='text/javascript'>
	var $=function(id){
		return document.getElementById(id);
	}
	var stateClickHandler =function(){
		if(window.XMLHttpRequest){
			var xmlHttp=new XMLHttpRequest();
		}else{
			var xmlHttp=new ActiveXObject('Microsoft','XMLHttp');
		}
		
		var area=$('area').options[$('area').selectedIndex].value;
		//$('state').setAttribute("onchange", 'showCommentListForArea(this.value)');  //[works to pull all]
		
		xmlHttp.open('GET','ajax/getSection.php?area='+area,true);
		xmlHttp.send();
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				var response=JSON.parse(xmlHttp.responseText);
				
				//remove earlier section id
				if($('section')){$('form').removeChild($('section'));}
				
				//create new section id and append to form
				var section = document.createElement('select');
				section.setAttribute('id','section');
				section.setAttribute('name','section');
				$('form').appendChild(section);
				section.setAttribute("onchange", 'showCommentListForSection(this.value)');

				//populate options in section id
				for(var key in response) {
					var option = document.createElement('option'); 
					var optionValue=response[key];
					option.setAttribute('value',key);
					option.innerHTML=optionValue;
					$('section').appendChild(option);
				}
				
				showCommentListForSection(str);
			}
		}
	}
	window.onload=function(){
		$('area').onchange=stateClickHandler;
	}
	function showCommentListForSection(str) {
		  if (str=="") {
			document.getElementById("commentList").innerHTML="";
			return;
		  } 
		  
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("commentList").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","ajax/getCommentListForSection.php?q="+str,true);
		  xmlhttp.send();
	}
	function showCommentListForArea(str) {
		  if (str=="") {
			document.getElementById("commentList").innerHTML="";
			return;
		  } 
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("commentList").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","ajax/getCommentListForArea.php?q="+str,true);
		  xmlhttp.send();
	}
</script>
	
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/dashboard2.php -->

<br /> <h2> Dashboard </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<!-- Start: Get Area Records -->
<?php
	// Get Current List of Areas
	$sql_areaList = "SELECT area_id,area_name FROM area WHERE area_activeFlag=1";
	$results_areaList = mysqli_query($link,$sql_areaList);
	echo (!$results_areaList?die(mysqli_error($link)."<br />$sql_areaList"):"");
	
	while(list($area_id,$area_name) = mysqli_fetch_array($results_areaList)){
		$input_area[$area_id] = $area_name; 
	}
	$areaList = array_unique($input_area);
	
?>
<!--  End: Get Area Records -->


<!-- Start: Select Area > Select Dependent Sections -->
<br /> <h3>Select Area and Section</h3> <hr />


<?php
	// Link Back to Admin Menu
	$queryString = getCurrentQueryString($commonProjectGETRoute); 
	echo "<br /><a href='$base_url/admin/default.php$queryString[0]'>Go to: Admin Menu</a><br /><br />";

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// AJAX - Pick Area Selection
	echo "<form id='form' method='get' action=''>";
		echo "<select id='area' name='area' >";
			echo "<option value='0' disabled selected>- Select Area -</option>";
			foreach($areaList as $areaId => $areaValue){
				echo "<option value='$areaId'>$areaValue</option>";
			}
		echo "</select>";
	echo "</form>";
   
	
	echo "<div id='commentList'>";
	echo "</div>";

?>
<!-- End: Select Area > Select Dependent Sections  -->


</body>
</html>