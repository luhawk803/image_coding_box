<!DOCTYPE html>
<html>
<script>

sessionStorage.clear();

</script>
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
function getjpgnum($files)
	{
	$res;
	foreach ( $files as $ff)
		{
		$res[]=(int)(end(explode("img_", $ff)));		
		}
	sort($res);
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
if(isset($_GET['experiment']) && ($_GET['experiment']=='1')){
	header('location:experiment.php');}
	if(isset($_GET['tosubject']) && ($_GET['tosubject']=='1')){
	header('location:subject.php');}
//end log out
if(isset($_GET['tochannel']) && ($_GET['tochannel']=='1')){
	header('location:chls.php');}
	if(isset($_GET['toobj']) && ($_GET['toobj']=='1')){
	header('location:obj.php');}
?> 
 <!-- RESTRICTED PAGE HTML GOES HERE -->
 <!-- add a LOGOUT link before the form -->
<form method="get" action="#">
  <p><button type="submit" name="log" value="out" style="position: absolute; top: 0; right: 0;"> log out</a></button> </p> 
  <p><button type="submit" name="experiment" value="1" style="position: absolute; top: 0; right: 500px;"> experiment</a></button> </p> 
   <p><button type="submit" name="tosubject" value="1" style="position: absolute; top: 0; right: 400px;"> subject</a></button> </p> 
  <p><button type="submit" name="tochannel" value="1" style="position: absolute; top: 0; right: 300px;"> channel</a></button> </p> 
      <p><button type="submit" name="toobj" value="1" style="position: absolute; top: 0; right: 600px;"> object</a></button> </p> 
 </form>
 

<?php
	if(isset($_GET['case']) ){
		//echo $_GET['case'];
		$_SESSION['case']=$_GET['case'];
		$disksess=$_SESSION['caselist'];
		$caselist_s=array();
		$caselist_e=array();
		foreach ($disksess as $i)
			{
			if ($i<$_GET['case'])
				{array_push($caselist_s,$i);}
			elseif ($i>$_GET['case'])
				{array_unshift($caselist_e,$i);}
			}
		$_SESSION['caselist_e']=$caselist_e;
		$_SESSION['caselist_s']=$caselist_s;
		header('location:case.php');
	}
	$dbc = mysqli_connect('localhost','root','multi123') or 
           die('could not connect: '. mysqli_connect_error());

	//select db
	mysqli_select_db($dbc, 'imagecoding') or die('no db connection');
	$userid=$_SESSION['userid'];
	$expid=$_SESSION['expid'];
	$subid=$_SESSION['sub'];
	$chaid=$_SESSION['chl'];
	$objid=$_SESSION['objid'];
	$objname=$_SESSION['objname'];
	//$tablename=strtoupper($tablename);
	
	


	//doing 
	$q="SELECT img_id FROM codingres where coderid='$userid' and exp_id='$expid' and obj_id='$objid' and sub_id='$subid' and cha_id=$chaid;" ;
	//echo $q;
	//$q="SELECT DISTINCT files FROM $tablename WHERE VIEWED=1; ";
	//step3: run the query and store result	

	
	$res = mysqli_query($dbc, $q);
	
	$rownum=0;
	$jpgfiles=array_filter(glob('D:/webcodingdata/experiment_'.$expid.'/'.$subid.'/cam0'.$chaid.'_frames_p/img_*.jpg'));
	if (count($jpgfiles)==0)
		{
		$jpgfiles=array_filter(glob('D:/webcodingdata/experiment_'.$expid.'/'.$subid.'/cam0'.$chaid.'_frames_p/*.jpg'));
		$_SESSION['no_img_']=1;
		}
	else 
		{$_SESSION['no_img_']=0;}
	$disksess=getjpgnum($jpgfiles);

echo "<h3>$objname>experiment_$expid>$subid>cam0$chaid _frame_p</h3>";
	if (!$res)
	{}
	else 
		{echo "<p>";
		$had_jpgs;
		while ($row=mysqli_fetch_row($res))
			{	
			$had_jpgs[]=((int) $row[0]);
			//echo "<p  style=\"color:gray;\"><a href=\"?sess=$row[0]\">$row[0]</a> <progress value=\"$temp\" max=\"1\" style=\"width: 500px\"></progress>$row[1]/{$disksess[$row[0]]}</p>";
			//unset($disksess[$row[0]]);
			}
		foreach ( $disksess as $ii) 
			{
			if (in_array($ii,$had_jpgs))
				{$flag='red';}
			else 
				{$flag='green';}			
			$temp=str_pad($ii, 4, '0', STR_PAD_LEFT);
			echo "<a href=\"?case=$ii\" ><button><p style=\"color:$flag;\">$temp</p></button></a> &nbsp&nbsp&nbsp";
			}
		$_SESSION['mincase']=min($disksess);
		$_SESSION['maxcase']=end($disksess);
		$_SESSION['caselist']=$disksess;
		
		}
	echo "</p><br><br><br>";


?>
<p style="color: gray; position: fixed; bottom:10px;right:10px;">Design and created by Hao Lu, if you have any problems contact luha@indiana.edu</p>
</body>
</html>