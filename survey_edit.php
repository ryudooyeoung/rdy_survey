
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
	$survey_edit_info = $_POST['survey_info'];

	//echo $survey_edit_info . "<br><br>";


// 제목 ㅃ 안내문 ㅃ 문제번호 ㅉ 질문 ㄸ 보기1 ㄲ 보기2 ㅆ

	$str = explode("ㅃ", $survey_info);

	$subject = $str[0];
	$intro = $str[1];


		//설문리스트 제목, 인사말 업데이트
		$query = "update survey_list set subject='$subject' , intro='$intro' , date ='".date("Y-m-d",time())."' where id = '$id'";
		mysqli_query($my_db, $query);
 

		//문제들을 나눔
		$infos = $str[2];

		//ㅆ으로 문제를 나눔	
		$questions = explode("ㅆ", $infos);
		//문제의 개수
		$question_c = count($questions);

		//echo "count : ". count($questions) . "<br><br><br>";
 

		//기본의 문제 저장
		$query = "select * from survey_".$id."_question";
		$result = mysqli_query($my_db, $query);
		$origin_n = array();
		$origin_q = array();
		$origin_e = array();
		$origin_t = array();
		$l=0;
		while($data2 = mysqli_fetch_array($result)){
			$origin_n[$l]=$data2['number'];
			$origin_q[$l]=$data2['question'];
			$origin_e[$l]=$data2['exlist'];
			$origin_t[$l]=$data2['type'];
			


			echo $origin_n[$l] .$origin_q[$l] .$origin_e[$l] .$origin_t[$l] ." \n";

			$l++;
		}
 
 echo "\n\n";

		//새로운 문제개수를 저장
		$new_n = array();
		$new_q = array();
		$new_e = array();
		$new_t = array();
		for($i=0; $i<$question_c; $i++){
			//문제의 번호와 질문,보기를 나눔
			$qn =  explode("ㅉ", $questions[$i]);
			$question_n = $qn[0];
			$new_n[$i] = $question_n;


			//질문
			$q = explode("ㄸ",$qn[1]);
			$question = $q[0];
			$new_q[$i] = $question;

			//보기
			//echo "number".$question_n . " : ". $question ."<br>";
			$question_ex = $q[1];
			$new_e[$i] = $question_ex;


			$type;
			//주관식(0), 객관식(1)인지 나눔
			if($question_ex==""){
				$type=0;
			}
			else{
				$type=1;
			}

			$new_t[$i] = $type;


			echo $new_n[$i] .$new_q[$i] .$new_e[$i] .$new_t[$i] ." \n";

			/*echo "////";*/

		}
 
		echo "origin : " . count($origin_n) . "\n" ;
		echo "new_n : " . count($new_n) . "\n" ;

		
		for($i=0; $i<count($origin_n); $i++){
			if (!in_array($origin_n[$i], $new_n)) {
				//echo $origin_n[$i];
				//컬럼삭제
				//delete from survey_$id_question where number = $origin_n[$i];
				//alter table survey_$id_answer drop column q$origin_n[$i]

				$query = "delete from survey_".$id."_question where number =".$origin_n[$i];
				echo $query. "\n";
				$result = mysqli_query($my_db, $query);

				$query = "alter table survey_".$id."_answer drop column q".$origin_n[$i];
				echo $query. "\n";
				$result = mysqli_query($my_db, $query);
			}
			else if (in_array($origin_n[$i], $new_n)) {
				//update
				//update survey_$id_question set question = $new_q[$i] , exlist = $new_e[$i] ,type = $new_t[$i] where number= $origin_n[$i]

				$on = array_search($origin_n[$i], $new_n);

				$query = "update survey_".$id."_question set question = '$new_q[$on]' , exlist = '$new_e[$on]' ,type = $new_t[$on] where number= $origin_n[$on]";
				 echo $query. "\n";
				$result = mysqli_query($my_db, $query);
			}
		}




		for($i=0; $i<count($new_n); $i++){
			if (!in_array($new_n[$i], $origin_n)) {
 
				//컬럼추가
				//insert into survey_$id_question values('$new_n[$i]','$new_q[$i]','$new_e[$i]','$new_t[$i]');

				$query = "insert into survey_".$id."_question values('$new_n[$i]','$new_q[$i]','$new_e[$i]','$new_t[$i]')";
				 echo $query. "\n";
				$result = mysqli_query($my_db, $query);

				if($new_t[$i]==1){
				//alter table survey_$id_answer add column q$new_t[$i] int

				$query = "alter table survey_".$id."_answer add column q$new_n[$i] int";
				$result = mysqli_query($my_db, $query);
				}
				else{
				//alter table survey_$id_answer add column q$new_t[$i] varchar(255)
				$query = "alter table survey_".$id."_answer add column q$new_n[$i] varchar(255)";
				$result = mysqli_query($my_db, $query);
				}

				 echo $query. "\n";
			}
		}
 


	/*	//설문리스트에 추가//
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
 */
	$my_db->close();




?>