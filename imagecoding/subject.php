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
//end log out
if(isset($_GET['toobj']) && ($_GET['toobj']=='1')){
	header('location:obj.php');}

?> 
 <!-- RESTRICTED PAGE HTML GOES HERE -->
 <!-- add a LOGOUT link before the form -->
<form method="get" action="#">
  <p><button type="submit" name="log" value="out" style="position: absolute; top: 0; right: 0;"> log out</a></button> </p> 
  <p><button type="submit" name="toexperiment" value="1" style="position: absolute; top: 0; right: 500px;"> experiment</a></button> </p> 
      <p><button type="submit" name="toobj" value="1" style="position: absolute; top: 0; right: 600px;"> object</a></button> </p> 
 </form>
 

<?php
	if(isset($_GET['sub']) ){
		echo $_GET['sub'];
		$_SESSION['sub']=$_GET['sub'];
		header('location:chls.php');
	}
	$dbc = mysqli_connect('localhost','root','multi123') or 
           die('could not connect: '. mysqli_connect_error());

	//select db
	mysqli_select_db($dbc, 'imagecoding') or die('no db connection');
	$userid=$_SESSION['userid'];
	$expid=$_SESSION['expid'];
	$objid=$_SESSION['objid'];
	$objname=$_SESSION['objname'];
	//$tablename=strtoupper($tablename);
	
	
	
	
	
	//doing 
	$q="SELECT sub_id, COUNT(sub_id) FROM codingres where coderid='$userid' and exp_id='$expid' and obj_id='$objid'  group by sub_id;" ;
	//echo $q;
	//$q="SELECT DISTINCT files FROM $tablename WHERE VIEWED=1; ";
	//step3: run the query and store result	
	$res = mysqli_query($dbc, $q);
	$rownum=0;
	$session2casenum=array_filter(glob('D:/webcodingdata/experiment_'.$_SESSION['expid'].'/*'), 'is_dir');
	$disksess=diskto($session2casenum);
	echo "<h3>$objname>experiment_$expid</h3>";
	if (!$res)
	{}
	else 
		{
		while ($row=mysqli_fetch_row($res))
			{
			$rownum+=1;
			$temp=$row[1]/$disksess[$row[0]];			
			echo "<p  style=\"color:gray;\"><a href=\"?sub=$row[0]\">$row[0]</a> <progress value=\"$temp\" max=\"1\" style=\"width: 500px\"></progress>$row[1]/{$disksess[$row[0]]}</p>";
			unset($disksess[$row[0]]);
			}
		while (list($key, $value) = each($disksess)) 
			{echo "<p  style=\"color:gray;\"><a href=\"?sub=$key\">$key</a> <progress value=\"0\" max=\"1\" style=\"width: 500px\"></progress>0/$value</p>";
			}
		}
	echo "<br><br><br>";


?>
<p style="color: gray; position: fixed; bottom:10px;right:10px;">Design and created by Hao Lu, if you have any problems contact luha@indiana.edu</p>
</body>
</html>