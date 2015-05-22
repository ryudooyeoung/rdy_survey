
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



	$id = $_POST['id'];
	$result =  URLDecode( $_POST['result']);

 

	$qstr = explode("&", $result);
	$q_c = count($qstr);



	$query = "insert into survey_".$id."_answer values(";
	for($k=0; $k< $q_c; $k++){
 
		$str = explode("=", $qstr[$k]);
		$val = $str[1];
 
		$query .= "'". $val . "'";

		if($k==$q_c-1){
			$query .= ")";
		}
		else{
			$query .= ",";
		}
	}
 

	mysqli_query($my_db, $query);

	$my_db->close();


	echo "설문조사 완료";
	//리스트에 추가

	//
?>