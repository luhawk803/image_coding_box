
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

 <?php session_start();

 #admin/restricted.php 
           // #####[make sure you put this code before any html output]#####

// //starting the session

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
	header('location:index.php');
}//end log out
if(isset($_GET['toobj']) && ($_GET['toobj']=='1')){
	header('location:obj.php');}
?> 
 <!-- RESTRICTED PAGE HTML GOES HERE -->
 <!-- add a LOGOUT link before the form -->
<form method="get" action="#">
  <p><button type="submit" name="log" value="out" style="position: absolute; top: 0; right: 0;"> log out</a></button> </p> 
    <p><button type="submit" name="toobj" value="1" style="position: absolute; top: 0; right: 600px;"> object</a></button> </p> 
 </form>
 

<?php
	if(isset($_GET['expid']) ){
		echo $_GET['expid'];
		$_SESSION['expid']=$_GET['expid'];
		header('location:subject.php');
	}
	$dbc = mysqli_connect('localhost','root','multi123') or 
           die('could not connect: '. mysqli_connect_error());
	//select db
	mysqli_select_db($dbc, 'imagecoding') or die('no db connection');
	$tablename=$_SESSION['userid'];
	$objid=$_SESSION['objid'];
	$objname=$_SESSION['objname'];
	//$tablename=strtoupper($tablename);
	
	
	
	
	
	//doing 
	$q="SELECT exp_id, COUNT(exp_id) FROM codingres where coderid='$tablename' and obj_id='$objid' group by exp_id;" ;
	//echo $q;
	//$q="SELECT DISTINCT subject FROM $tablename WHERE VIEWED=1; ";
	//step3: run the query and store result	
	$res = mysqli_query($dbc, $q);
	$rownum=0;
	$spk2casenum=array_filter(glob('D:/webcodingdata/experiment_*'), 'is_dir');
	$diskspk=diskto($spk2casenum);
		echo "<h3>$objname</h3>";
	if (!$res)
	{}
	else 
		{
		while ($row=mysqli_fetch_row($res))
			{
			$rownum+=1;
			$temp2=$diskspk['experiment_'.$row[0]];
			$temp=$row[1]/$temp2;

			echo "<p  style=\"color:gray;\"><a href=\"?expid=$row[0]\">experiment_$row[0]</a> <progress value=\"$temp\" max=\"1\" style=\"width: 500px\"></progress>$row[1]/$temp2</p>";
			unset($diskspk['experiment_'.$row[0]]);
			}
		while (list($key, $value) = each($diskspk)) 
			{
			$keyint=(int)end(explode('experiment_', $key));
			echo "<p  style=\"color:gray;\"><a href=\"?expid=$keyint\">$key</a> <progress value=\"0\" max=\"1\" style=\"width: 500px\"></progress>0/$value</p>";
			}
		}
	echo "<br><br><br>";
	//echo $rownum;
	// //done
	// $q="SELECT DISTINCT FOLDER FROM $tablename WHERE VIEWED=1 AND (FOLDER) NOT IN (SELECT DISTINCT FOLDER FROM $tablename WHERE VIEWED=0);";
	// $res = mysqli_query($dbc, $q);
	// if (!$res)
	// {}
	// else 
		// {
		// while ($row=mysqli_fetch_row($res))
			// {echo "<p  style=\"color:green;\"><a href=\"?folder=$row[0]\">$row[0]</a>  done!</p>";}
		// }
	// //will do
	// $q="SELECT DISTINCT FOLDER FROM $tablename WHERE VIEWED=0 AND (FOLDER) NOT IN (SELECT DISTINCT FOLDER FROM $tablename WHERE VIEWED=1);";
	// $res = mysqli_query($dbc, $q);
	// if (!$res)
	// {}
	// else 
		// {
		// while ($row=mysqli_fetch_row($res))
			// {echo  "<p  style=\"color:red;\"><a href=\"?folder=$row[0]\">$row[0]</a>  will do</p>";}
		// }

?>
<p style="color: gray; position: fixed; bottom:10px;right:10px;">Design and created by Hao Lu, if you have any problems contact luha@indiana.edu</p>
</body>
</html>