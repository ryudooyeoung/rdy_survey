
<?

	// 공통연결부분
	$host = "localhost";
	$user = "ruydoo0711";
	$pw = "fbendud89";
	$db = "ruydoo0711";
	$my_db = new mysqli($host,$user,$pw,$db);
	mysqli_query($my_db,"set names utf8");
	if ( mysqli_connect_errno() ) {
	echo mysqli_connect_error();
	exit;
	}



	$id = $_REQUEST['id'];
 
 
	$query = "drop table survey_".$id."_answer";
	mysqli_query($my_db, $query);

	$query = "drop table survey_".$id."_question";
	mysqli_query($my_db, $query); 

	$query = "delete from survey_list where id=".$id;
	mysqli_query($my_db, $query);
	

	$my_db->close();

	
?>
	<script>

		location.href="survey_list.php";
	</script>