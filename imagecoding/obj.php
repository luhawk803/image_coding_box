
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

?> 
 <!-- RESTRICTED PAGE HTML GOES HERE -->
 <!-- add a LOGOUT link before the form -->
<form method="get" action="#">
  <p><button type="submit" name="log" value="out" style="position: absolute; top: 0; right: 0;"> log out</a></button> </p> 
 </form>
 <form action="#" method="get" >
If you want to add new object, put the name and submit it: <input type="text" name="addobj">
<input type="submit" onclick="return confirm('are you sure you want to add new object?')">
</form>
<br><br>

<?php
	if(isset($_GET['objid']) ){
		echo $_GET['objid'];
		$_SESSION['objid']=$_GET['objid'];
		$_SESSION['objname']=$_GET['objname'];
		header('location:experiment.php');
	}
	$dbc = mysqli_connect('localhost','root','multi123') or 
           die('could not connect: '. mysqli_connect_error());
	//select db
	mysqli_select_db($dbc, 'imagecoding') or die('no db connection');
	$tablename=$_SESSION['userid'];
	//$tablename=strtoupper($tablename);
	if (isset($_GET['addobj']))
		{
		$objname=$_GET['addobj'];
		$q="insert into imagecoding.obj (obj_name) value ('$objname');";
		$res = mysqli_query($dbc, $q);	
		$row=mysqli_fetch_row($res);
		unset($_GET['addobj']);
		}
	
	
	
	
	//doing 
	$q="SELECT * FROM obj;" ;
	//echo $q;
	//$q="SELECT DISTINCT subject FROM $tablename WHERE VIEWED=1; ";
	//step3: run the query and store result	
	$res = mysqli_query($dbc, $q);
	$rownum=0;
	$spk2casenum=array_filter(glob('D:/webcodingdata/experiment_*'), 'is_dir');
	$diskspk=diskto($spk2casenum);
	
	if (!$res)
	{}
	else 
		{
		while ($row=mysqli_fetch_row($res))
			{	
			echo "<a href=\"?objid=$row[1]&&objname=$row[0]\" ><button><p style=\"height:20px; width:70px;color:blue;\">$row[0]</p></button></a> &nbsp&nbsp&nbsp";
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