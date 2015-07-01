<!DOCTYPE html>
<html>
<head>
<script src="//fb.me/react-0.8.0.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="js/json2.js"></script>
    <script type="text/javascript" src="js/colorpicker.js"></script>
    <link rel="stylesheet" type="text/css" href="js/themes.css" />
	
<script>
var imageWidth, imageHeight, imageRight, imageBottom,imageX , imageY;
var hasRec=false;
var codebefore=new Boolean(0);
function Coo(x1,y1,x2,y2){
        this.x1 = x1;
        this.y1 = y1;     
		this.x2 = x2;
        this.y2 = y2;   
    }
	

function reloadpage()
	{
	location.reload();
	}
function remove_all()
	{
	sessionStorage.removeItem('points');
	//header('Location:chls.php');
	top.location.reload();
	//window.location=window.location;
	//top.location.href=top.location.href
	//upDate();
	}
function show_submit(){
		var s= $.parseJSON(window.sessionStorage.getItem('points'));
		if (s.x1+s.y1+s.x2+s.y2!=0)
		{document.getElementById("sendtoDB").style.display='block';}
	}

/*
$(document).ready(function() {
	var paint;
	$('.box').mouseup(function(e){
		paint = false;
		});
	$('.box').mouseleave(function(e){
		paint = false;
		});
	$('.box').mousedown(function(e){
		if (e.button==2)
			{remove_last(20);}
		else {
			paint=true;
			var offset = $(this).offset();
			var point =new Coo(Math.round(e.clientX - offset.left),Math.round(e.clientY - offset.top));
			// if (localStorage.getItem("points")!=null) {
				// var points=JSON.parse(localStorage.getItem("points"));}
			// else 
				// {var points=new Array();}
			// points.push(point);
			// localStorage.setItem("points", JSON.stringify(points));
			if (window.sessionStorage.getItem('points')==null)
				{
				var points=new Array();;
				}
			else 
				{		
				var points =$.parseJSON(window.sessionStorage.getItem('points'));
				//document.write(Object.prototype.toString.call(points));
				}
			points.push(point);
			window.sessionStorage.setItem('points', JSON.stringify(points));
			//$('#position').text(point.x1+ ", " + point.y1);
			//$('#size').text(points.length);
			//document.write(JSON.stringify(points));
			//document.write(Object.prototype.toString.call($('xy').text('points',points)));
			//document.write(points);
			
			//draw dot !!!
			 var can = document.getElementById('canvas');
			 var ctx = can.getContext('2d');
			 var txtcoor="";
			 for (var i=0;i<points.length;i++)
				{
				//document.write(points[i].x+"---"+points[i].y + "<br>");
					ctx.fillStyle="red";
					ctx.fillRect(points[i].x-3,points[i].y-3,6,6);	
					txtcoor+=points[i].x.toString() +" "+ points[i].y.toString()+"\n";
				}
			document.getElementById("coors").value = txtcoor;
			show_submit(points);
			}
		});
  $('.box').mousemove(function(e) {
	if (paint){
		var offset = $(this).offset();
		var point =new Coo(Math.round(e.clientX - offset.left),Math.round(e.clientY - offset.top));
		// if (localStorage.getItem("points")!=null) {
			// var points=JSON.parse(localStorage.getItem("points"));}
		// else 
			// {var points=new Array();}
		// points.push(point);
		// localStorage.setItem("points", JSON.stringify(points));
		if (window.sessionStorage.getItem('points')==null)
			{
			var points=new Array();;
			}
		else 
			{		
			var points =$.parseJSON(window.sessionStorage.getItem('points'));
			//document.write(Object.prototype.toString.call(points));
			}
		points.push(point);
		window.sessionStorage.setItem('points', JSON.stringify(points));
		$('#position').text(point.x+ ", " + point.y);
		$('#size').text(points.length);
		//document.write(JSON.stringify(points));
		//document.write(Object.prototype.toString.call($('xy').text('points',points)));
		//document.write(points);
		
		//draw dot !!!
		 var can = document.getElementById('canvas');
		 var ctx = can.getContext('2d');
		 var txtcoor="";
		 for (var i=0;i<points.length;i++)
			{
			//document.write(points[i].x+"---"+points[i].y + "<br>");
				ctx.fillStyle="red";
				ctx.fillRect(points[i].x-3,points[i].y-3,6,6);	
				txtcoor+=points[i].x.toString() +" "+ points[i].y.toString()+"\n";
			}
		document.getElementById("coors").value = txtcoor;
		show_submit(points);
		}
  });
  
  
});



function upDate(){
	var can = document.getElementById('canvas');
	var ctx = can.getContext('2d');
	var img = new Image();
	img.onload = function(){
		can.width = img.width;
		can.height = img.height;
		ctx.drawImage(img, 0, 0, img.width, img.height);
		var points= $.parseJSON(window.sessionStorage.getItem('points'));
	// //document.write(Object.prototype.toString.call(points));
	// //document.write('-----'+points[0].x+'-------');
		for (var i=0;i<points.length;i++)
		{
		//document.write(points[i].x+"---"+points[i].y + "<br>");
			ctx.fillStyle="red";
			ctx.fillRect(points[i].x-3,points[i].y-3,6,6);	
		}
		show_submit(points);		
		$('#size').text(points.length);
	}};
*/



</script>
<style type="text/css">
canvas.box{
cursor:url("/redcross2.cur"), auto;

}
</style>
</head>
<body>


 <?php #admin/restricted.php 
           // #####[mak.e sure you put this code before any html output]#####

// //starting the session
 session_start();
 echo "Hi ",$_SESSION['username'];
//checking if a log SESSION VARIABLE has been set
  if( !isset($_SESSION['log']) || ($_SESSION['log'] != 'in') ){
        // //if the user is not allowed, display a message and a link to go back to login page
	echo "You are not allowed.";
	echo '<a href="index.php">back to login page</a>';

        // //then abort the script
	 exit();
 }
   ####  CODE FOR LOG OUT #### 
if(isset($_POST['logout'])){
        //if the user logged out, delete any SESSION variables
	session_destroy();
	echo "<script>window.location = 'index.php'</script>";
	die();
	}
if(isset($_POST['experiment']) ){
	// echo '<script >', 'window.sessionStorage.clear();;', '</script>';
	//header('Location:http://www.google.com');
	header('Location:experiment.php');
	}
if(isset($_POST['subject'])){
	// echo '<script >', 'window.sessionStorage.clear();', '</script>';
	header('Location:subject.php');}
	
if(isset($_POST['obj'])){
	// echo '<script >', 'window.sessionStorage.clear();', '</script>';
	header('Location:obj.php');}
if(isset($_POST['chls'])){
	// echo '<script >', 'window.sessionStorage.clear();', '</script>';
	header('Location:chls.php');}
	
if(isset($_POST['files'])){
	// echo '<script >', 'window.sessionStorage.clear();', '</script>';
	header('Location:files.php');}
	
//get the value from previous session
$userid=$_SESSION['userid'];
$expid=$_SESSION['expid'];
$subid=$_SESSION['sub'];
$chaid=$_SESSION['chl'];
$objid=$_SESSION['objid'];
$objname=$_SESSION['objname'];
$case=$_SESSION['case'];

$caselist=$_SESSION['caselist'];
$caselist_s=$_SESSION['caselist_s'];
$caselist_e=$_SESSION['caselist_e'];


$minnum=$_SESSION['mincase'];
$maxnum=$_SESSION['maxcase'];
$dbc = mysqli_connect('localhost','root','multi123') or die('could not connect: '. mysqli_connect_error());
//select db
mysqli_select_db($dbc, 'imagecoding') or die('no db connection');
$q="select x1,y1,x2,y2 from imagecoding.codingres where coderid='$userid' and exp_id='$expid' and sub_id='$subid' and obj_id='$objid' and cha_id='$chaid' and img_id='$case';";
echo "<br>";
 //echo $q;
$res = mysqli_query($dbc, $q);	
$row=mysqli_fetch_row($res);
$doneflag=0;

if (isset($_POST['reset']))
	{
	echo 	'<script type="text/javascript">','sessionStorage.removeItem(\'points\');','</script>';
	$temp=$row[0];
	$q="delete from imagecoding.codingres where coderid='$userid' and exp_id='$expid' and sub_id='$subid' 
and obj_id='$objid' and cha_id='$chaid' and img_id='$case';;";
	$res = mysqli_query($dbc, $q);	
	$row=mysqli_fetch_row($res);	
	//echo '<script type="text/javascript">', 'remove_all();', '</script>';
	//header('location:case.php');
	}

if ($row[2]!=NULL)
	{
	// $doneflag=$row[0];	
	$x1=$row[0];
	$y1=$row[1];
	$x2=$row[2];
	$y2=$row[3];
	echo "<h1 style=\"color: green; position: absolute; top: 500px; left: 800px;\">Already in database<h1>";
	//echo $x1,$x2;
	echo '<script type="text/javascript">';
	echo "codebefore=true;";
	echo "var p=new Coo($x1,$y1,$x2,$y2);";
	echo 'window.sessionStorage.setItem(\'points\', JSON.stringify(p));';
	// echo "window.sessionStorage.setItem(\'x1\', $x1);";
	// echo "window.sessionStorage.setItem(\'y1\', $y1);";
	// echo "window.sessionStorage.setItem(\'x2\', $x2);",;
	// echo "window.sessionStorage.setItem(\'y2\', $y2);";
	echo '</script>';
	}

function test_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
	 $data=explode(",",$data);
     return $data;
}
if (isset($_POST['sendout']))	
	{
	$coors = test_input($_POST["coors"]);
	$x1=$coors[0]; 
	$y1=$coors[1];
	$x2=$coors[2];
	$y2=$coors[3];	
	echo '<script type="text/javascript">';
	echo "var p=new Coo($x1,$y1,$x2,$y2);";
	echo 'window.sessionStorage.setItem(\'points\', JSON.stringify(p));';
	echo '</script>';
	$q="delete from imagecoding.codingres where coderid='$userid' and exp_id='$expid' and sub_id='$subid' and obj_id='$objid' and cha_id='$chaid' and img_id='$case';;";
	$res = mysqli_query($dbc, $q);	
	$row=mysqli_fetch_row($res);	
	$q="INSERT INTO imagecoding.codingres (coderid, exp_id, sub_id, cha_id, obj_id, img_id,x1,y1,x2,y2) VALUE ('$userid','$expid','$subid','$chaid','$objid','$case','$x1','$y1','$x2','$y2');";
	//echo $q;
	//$q="select * from ultrasound.res ;";
	$res = mysqli_query($dbc, $q);	
	$row=mysqli_fetch_row($res);
	echo "<h1 style=\"color: green; position: absolute; top: 500px; left: 800px;\">Already in database<h1>";
	echo "<h1 style=\"color:Lime; position: absolute; bottom:0;left:0;\">PASS!$row[0]</h1>";
	//header('location:case.php');
		$_SESSION['case']=array_pop($caselist_e);
	array_push($caselist_s,$case);
	$_SESSION['caselist_e']=$caselist_e;
	$_SESSION['caselist_s']=$caselist_s;
	echo '<script type="text/javascript">', 'reloadpage();', '</script>';
	}	


	
if (isset($_POST['next']))	
	{	
	$_SESSION['case']=array_pop($caselist_e);
	array_push($caselist_s,$case);
	$_SESSION['caselist_e']=$caselist_e;
	$_SESSION['caselist_s']=$caselist_s;
	echo '<script type="text/javascript">', 'reloadpage();', '</script>';
	//header('location:case.php');
	}	
	
if (isset($_POST['previous']))	
	{	
	$_SESSION['case']=array_pop($caselist_s);
	array_push($caselist_e,$case);
	$_SESSION['caselist_e']=$caselist_e;
	$_SESSION['caselist_s']=$caselist_s;
	echo '<script type="text/javascript">', 'reloadpage();', '</script>';
		//header('location:case.php');
	}	
?> 



 <!-- RESTRICTED PAGE HTML GOES HERE -->
 <!-- add a LOGOUT link before the form -->

<form method="post" action="#">
	<p><button id= "logout" type="submit" name="logout" value="out" style="position: absolute; top: 0; right: 0;"> log out</button> </p> 
</form>
<form method="post" action="obj.php">
	<p><button id= "obj" type="submit" name="obj" style="position: absolute; top: 0; right: 600px;"> object</button> </p> 
</form>
<form method="post" action="experiment.php">
	<p><button id= "experiment" type="submit" name="experiment" style="position: absolute; top: 0; right: 500px;"> experiment</button> </p> 
</form>
<form method="post" action="subject.php">
	<p><button id= "subject" type="submit" name="subject" style="position: absolute; top: 0; right: 400px;"> subject</button> </p> 
</form>
<form method="post" action="chls.php">
	<p><button id= "chls" type="submit" name="chls" style="position: absolute; top: 0; right: 300px;"> channel</button> </p> 
</form>
<form method="post" action="files.php">
	<p><button id= "files" type="submit" name="files" style="position: absolute; top: 0; right: 200px;"> files</button> </p> 
</form>


<form method="post" action="#">
	<p><button type="submit" name="reset" style="width: 200px; height: 60px;position: absolute; top: 400px; left: 800px;"> reset_points</button> </p>
	<p><button id= "next" type="submit" name="next"  style="<?php if(count($caselist_e)==0) echo 'display:none;';?> position: absolute; bottom: 50px; right: 100px; width: 200px; height: 60px;font-size:20px;"> Next</button> </p> 
	<p><button id= "previous" type="submit" name="previous"  style="<?php if(count($caselist_s)==0) echo 'display:none;';?> position: absolute; bottom: 50px; right: 560px; width: 200px; height: 60px;font-size:20px;"> previous</button> </p> 

	<textarea id="coors" name="coors" rows="5" cols="40" style="display:none"></textarea>
   <br><br>
	<input id="sendtoDB" type="submit" name="sendout" value="Submit" style="display:none;width: 200px; height: 60px; position: absolute; bottom: 50px; right: 350px;font-size:20px;"> 
</form>

 <?php
	if ($_SESSION['no_img_']==1)
		{echo "<h3>$objname/experiment_$expid/$subid/cam_0$chaid _frame_p/$case.jpg</h3>";}
	else
		{echo "<h3>$objname/experiment_$expid/$subid/cam_0$chaid _frame_p/img_$case.jpg</h3>";}
	$imagefile="/codingdata/experiment_".$expid.'/'.$subid.'/cam0'.$chaid.'_frames_p/img_'.$case.".jpg";
 ?>
 <span style="newcursor">
 <canvas id="canvas" class="box" style="width: 640px; height: 480px;" >
 </canvas ></span>
 	<div id="color-picker" class="cp-default" style="position: absolute; top: 150px; left: 750px"></div>


 <script  type="text/javascript" >
	var can = document.getElementById('canvas');
	var ctx = can.getContext('2d');
	var img = new Image();
	img.onload = function(){
		can.width = img.width;
		can.height = img.height;
		// var s= $.parseJSON(window.sessionStorage.getItem('points'));
		  // imageX=s.x1;
		  // imageY=s.y1;
		 // imageRight=s.x2;
		  // imageBottom=s.y2;
		 // imageWidth=Math.abs(imageX,imageRight);
		 // imageHeight=Math.abs(imageY,imageBottom);
		//draw();
		ctx.drawImage(img, 0, 0, img.width, img.height);
	// //document.write(Object.prototype.toString.call(points));
	// //document.write('-----'+points[0].x+'-------');
		// for (var i=0;i<points.length;i++)
		// {
		// //document.write(points[i].x+"---"+points[i].y + "<br>");
			// ctx.fillStyle="red";
			// ctx.fillRect(points[i].x-3,points[i].y-3,6,6);	
		// }
		//ctx.rect(points.x1,points.y1,points.x2,points.y2);
		//show_submit(points);		
	}
	img.src = <?php echo json_encode($imagefile); ?>;


	//drwa data point
	
	//document.write("points above!!!");
	
	
</script> 
<p id="position"></p>
<script type="text/javascript" src="js/retangle.js"></script>

	<!---p><button type="button" name="back1" onclick="remove_last(10)" style="width: 200px; height: 60px;position: absolute; top: 100px; left: 850px;"> back_10</a></button> </p> 
	//<p><button type="button" name="back5" onclick="remove_last(20)" style="width: 200px; height: 60px;position: absolute; top: 250px; left: 850px;"> back_20</a></button> 
	</p---> 

    <script type="text/javascript">

	
		var colorarc;
		var cp=ColorPicker(
        document.getElementById('color-picker'),
        function(hex, hsv, rgb) {
          console.log(hsv.h, hsv.s, hsv.v);         // [0-359], [0-1], [0-1]
          console.log(rgb.r, rgb.g, rgb.b);         // [0-255], [0-255], [0-255]
          // if (window.sessionStorage.getItem('color')!=null)
			// {
			// var temp=$.parseJSON(window.sessionStorage.getItem('color'));
			// console.setHex(temp);
			// }
		  colorarc= hex;        // #HEX		  
		  //document.write(hex);
		  window.sessionStorage.setItem('color',JSON.stringify(colorarc));
		  draw();
        });	
		
		 if (window.sessionStorage.getItem('color')!=null)
			{
			var temp=$.parseJSON(window.sessionStorage.getItem('color'));
			//cp.setHex(temp);
			colorarc=temp;
			//draw();
			}
			
	// if (codebefore)
		// {
		// //imageWidth, imageHeight, imageRight, imageBottom;
		// var s= $.parseJSON(window.sessionStorage.getItem('points'));
		  // imageX=s.x1;
		  // imageY=s.y1;
		 // imageRight=s.x2;
		  // imageBottom=s.y2;
		 // imageWidth=Math.abs(imageX,imageRight);
		 // imageHeight=Math.abs(imageY,imageBottom);
		// document.write(window.sessionStorage.getItem('points'));
		// document.write(s.x1);
		// draw();
		// codebefore=false;
		// hasRec=true;
		// }
		// else
		// {
		// //imageWidth, imageHeight, imageRight, imageBottom;
		// var s= $.parseJSON(window.sessionStorage.getItem('points'));
		  // imageX=s.x1;
		  // imageY=s.y1;
		 // imageRight=s.x2;
		  // imageBottom=s.y2;
		 // imageWidth=Math.abs(imageX,imageRight);
		 // imageHeight=Math.abs(imageY,imageBottom);
		// document.write(window.sessionStorage.getItem('points'));
		// document.write(s.x1);
		// draw();
		// hasRec=true;
		// }
	
    </script>

	<script>
//document.write(window.sessionStorage.getItem('points'));

</script>
	


  <br>
  <p id="size"></p><br>
	



<p style="color: gray; position: fixed; bottom:10px;right:10px;">Design and created by Hao Lu, if you have any problems contact luha@indiana.edu</p>
</body>
</html>