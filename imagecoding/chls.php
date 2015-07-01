<!DOCTYPE html>
<html>
<?php
function countjpgfiles($dir){
	$res=count(glob($dir."/*.jpg"));
    $ffs = scandir($dir);
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            if(is_dir($dir.'/'.$ff)) $res=$res+ countjpgfiles($dir.'/'.$ff);
        }
    }
   return $res;}
   
function diskto($folderlist)
   {
	$res;
	foreach ( $folderlist as $ff)
		{
		$res[end(explode("/", $ff))]=countjpgfiles($ff);		
		}
	return $res;
   
   }

?>
<body>


 <?php #admin/restricted.php 
           // #####[make sure you put this code before any html output]#####

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
   
if(isset($_GET['log']) && ($_GET['log']=='out')){
        //if the user logged out, delete any SESSION variables
	session_destroy();
	
        //then redirect to login page
	header('location:index.php');}
if(isset($_GET['toexperiment']) && ($_GET['toexperiment']=='1')){
	header('location:experiment.php');}
if(isset($_GET['tosubject']) && ($_GET['tosubject']=='1')){
	header('location:subject.php');}
//end log out
if(isset($_GET['toobj']) && ($_GET['toobj']=='1')){
	header('location:obj.php');}

?> 
 <!-- RESTRICTED PAGE HTML GOES HERE -->
 <!-- add a LOGOUT link before the form -->
<form method="get" action="#">
  <p><button type="submit" name="log" value="out" style="position: absolute; top: 0; right: 0;"> log out</a></button> </p> 
  <p><button type="submit" name="toexperiment" value="1" style="position: absolute; top: 0; right: 500px;"> experiment</a></button> </p> 
  <p><button type="submit" name="tosubject" value="1" style="position: absolute; top: 0; right: 400px;"> subject</a></button> </p> 
      <p><button type="submit" name="toobj" value="1" style="position: absolute; top: 0; right: 600px;"> object</a></button> </p> 
 </form>
 

<?php
	if(isset($_GET['chl']) ){
		echo $_GET['chl'];
		$_SESSION['chl']=$_GET['chl'];
		header('location:files.php');
	}
	$dbc = mysqli_connect('localhost','root','multi123') or 
           die('could not connect: '. mysqli_connect_error());

	//select db
	mysqli_select_db($dbc, 'imagecoding') or die('no db connection');
	$userid=$_SESSION['userid'];
	$expid=$_SESSION['expid'];
	$subid=$_SESSION['sub'];
	$objid=$_SESSION['objid'];
	$objname=$_SESSION['objname'];
	//$tablename=strtoupper($tablename);
	
	
	
	
	
	//doing 
	$q="SELECT cha_id, COUNT(cha_id) FROM codingres where coderid='$userid' and exp_id='$expid' and obj_id='$objid' and sub_id='$subid' group by cha_id;" ;
	//echo $q;
	//$q="SELECT DISTINCT files FROM $tablename WHERE VIEWED=1; ";
	//step3: run the query and store result	
	$res = mysqli_query($dbc, $q);
	$rownum=0;
	$session2casenum=array_filter(glob('D:/webcodingdata/experiment_'.$_SESSION['expid'].'/'.$subid.'/cam*'), 'is_dir');
	$disksess=diskto($session2casenum);
	echo "<h3>$objname>experiment_$expid>$subid</h3>";
	if (!$res)
	{}
	else 
		{
		while ($row=mysqli_fetch_row($res))
			{
			$rownum+=1;
			$temp2=$disksess['cam0'.$row[0].'_frames_p'];
			$temp=$row[1]/$temp2;			

			echo "<p  style=\"color:gray;\"><a href=\"?chl=$row[0]\">cam0$row[0]_frames_p</a> <progress value=\"$temp\" max=\"1\" style=\"width: 500px\"></progress>$row[1]/$temp2</p>";
			unset($disksess['cam0'.$row[0].'_frames_p']);
			}
		while (list($key, $value) = each($disksess)) 
			{
			$keyint=(int)end(explode('cam', $key));
			echo "<p  style=\"color:gray;\"><a href=\"?chl=$keyint\">$key</a> <progress value=\"0\" max=\"1\" style=\"width: 500px\"></progress>0/$value</p>";
			}
		}
	echo "<br><br><br>";


?>
<p style="color: gray; position: fixed; bottom:10px;right:10px;">Design and created by Hao Lu, if you have any problems contact luha@indiana.edu</p>
</body>
</html>