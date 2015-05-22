
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



	$survey_info = $_POST['survey_info'];

	//echo $survey_info . "<br><br>";


// 제목 ㅃ 안내문 ㅃ 문제번호 ㅉ 질문 ㄸ 보기1 ㄲ 보기2 ㅆ

	$str = explode("ㅃ", $survey_info);

	$subject = $str[0];
	$intro = $str[1];

	//echo "subject : " .$subject . "<br>";
	//echo "intro : ". $intro . "<br>";
 


	//설문조사 중복 여부 검사
	$query = "select id from survey_list where subject like '$subject'";
	$result = mysqli_query($my_db, $query);
	$data = mysqli_fetch_array($result);

	if($data!=null){
		echo "이름 중복입니다. 다른이름을 사용하세요";
	}//end of if
	else{

		//문제들을 나눔
		$infos = $str[2];

		//ㅆ으로 문제를 나눔	
		$questions = explode("ㅆ", $infos);
		//문제의 개수
		$question_c = count($questions);

		//echo "count : ". count($questions) . "<br><br><br>";


		//설문리스트에 추가//
		$query = "insert into survey_list(subject, intro, date) values('$subject', '$intro','".date("Y-m-d",time())."')";
		mysqli_query($my_db, $query);

		//새로만든 설문조사의 id를 가져옴
		$query = "select id from survey_list where subject like '$subject'";
		$result = mysqli_query($my_db, $query);

		while($data = mysqli_fetch_array($result)){
			$id = $data['id'];
		}

		//id를 기준으로 새로운 설문조사의 질문과 보기를 저장
		$query = "create table survey_".$id."_question( number int, question varchar(255), exlist varchar(255), type int );";
		mysqli_query($my_db, $query);

  
		for($i=0; $i<$question_c; $i++){
			//문제의 번호와 질문,보기를 나눔
			$qn =  explode("ㅉ", $questions[$i]);
			$question_n = $qn[0];
 
			//질문
			$q = explode("ㄸ",$qn[1]);
			$question = $q[0];

			//보기
			//echo "number".$question_n . " : ". $question ."<br>";
			$question_ex = $q[1];

			$type;
			//주관식(0), 객관식(1)인지 나눔
			if($question_ex==""){
				$type=0;
			}
			else{
				$type=1;
			}
 

			$query = "insert into survey_".$id."_question values($question_n,'$question','$question_ex',$type)";
			mysqli_query($my_db, $query);
			//echo $question_ex . "<br><br>";

			//answer 테이블 작성
			if($i==0){
				//id를 기준으로 새로운 설문조사의 질문과 보기를 저장
				$query = "create table survey_".$id."_answer( q".$question_n." int );";
				mysqli_query($my_db, $query);
			}
			else{
				if($type==1){
					//id를 기준으로 새로운 설문조사의 질문과 보기를 저장
					$query = "alter table survey_".$id."_answer add (q".$question_n." int );";
					mysqli_query($my_db, $query);
				}
				else{
					//id를 기준으로 새로운 설문조사의 질문과 보기를 저장
					$query = "alter table survey_".$id."_answer add (q".$question_n." varchar(255) );";
					mysqli_query($my_db, $query);
				}
			}
		}

 
		echo "추가 되었습니다.";
	}//end of else
 
	$my_db->close();



	//리스트에 추가

	//
?>