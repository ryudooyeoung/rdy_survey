<!DOCTYPE html>
<meta charset="utf-8">
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body scroll=auto style="overflow-x:hidden">
    <h1>설문 작성</h1>
 


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

	$query = "select * from survey_list where id = $id";
	$result = mysqli_query($my_db, $query);

	$data = mysqli_fetch_array($result);

	
	?>

 
<div class="col-xs-12 col-md-12" style="padding:10px">


<form class="form-horizontal" role="form">

	<div class="form-group">
		<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">제목</label>
		<div class="col-lg-10 col-xs-10 ">
			<input type="text" class="form-control" id="subject" placeholder="제목을 입력하세요" value="<?=$data['subject']?>">
		</div>
	</div>


	<div class="form-group">
		<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">안내문</label>
		<div class="col-lg-10 col-xs-10 ">
			<textarea class="form-control" rows="3" id="intro"><?=$data['intro']?></textarea>
		</div>
	</div>

<?
	$query = "select * from survey_".$id."_question order by number";
	$result = mysqli_query($my_db, $query);

	$i=0;
	while($data = mysqli_fetch_array($result)){
 

		?>
		<div id="div_q<?=$data['number']?>">
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">질문<?=$data['number']?></label>
				<div class="col-lg-10 col-xs-10 ">
					<input type="text" class="form-control" id="q<?=$data['number']?>_question" placeholder="질문을 입력하세요" value="<?=$data['question']?>">
				</div>
			</div>
		<?
		//객관식
		if($data['type']==1){
			?>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label"></label>
				<div class="col-md-10 col-xs-10">

					<label class="radio-inline">
						<input name="option_<?=$data['number']?>" id="option_<?=$data['number']?>" type="radio" value="1" checked onclick="check(<?=$data['number']?>)"> 객관식
					</label>
					<label class="radio-inline">
						<input name="option_<?=$data['number']?>" id="option_<?=$data['number']?>" type="radio" value="2"  onclick="check(<?=$data['number']?>)"> 주관식
					</label>
				</div>
			</div>

			<div id="ex_<?=$data['number']?>" class="form-group">
				<?
					$str = explode("ㄲ",$data['exlist']);
					$str_c = count($str);

					for($j=0; $j<$str_c; $j++){

				?>
				<div id="ex_list<?=$data['number']?>">
					<label for="inputEmail1" class="col-lg-3 col-xs-3  control-label"></label>
					<div class="col-lg-8 col-xs-8 ">
						<input type="text" class="form-control" id="q<?=$data['number']?>_ex" placeholder="보기를 입력하세요" value="<?=$str[$j]?>">
					</div>
					<div class="col-lg-1 col-xs-1 ">
						<button type="button" id="delex_selected<?=$data['number']?>" onclick="delex_selected('<?=$data['number']?>')" class="btn btn-info pull-right" style="margin-bottom:10px">삭제</button>
					</div>
				</div>

				<?
					}
				?>

				<label id="q<?=$data['number']?>_addex" for="inputEmail1" class="col-lg-12 col-xs-12  control-label"></label>

				<div class="col-lg-12 col-xs-12">
					<button type="button" class="btn btn-primary pull-right" onclick="addex(<?=$data['number']?>)" style="margin:10px">보기 추가</button>
					<button type="button" class="btn btn-primary pull-right" onclick="delex(<?=$data['number']?>)" style="margin:10px">삭제</button>
				</div>
			</div>



			<div class="col-lg-12 col-xs-12"><button id="delq_selected<?=$data['number']?>" type="button" class="btn btn-warning pull-right" style="margin-bottom:10px" onclick="delq_selected('<?=$data['number']?>')">질문삭제</button></div>
			<hr width="100%">
			</div>
			<?
		}
		//주관식
		else{
 			?>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label"></label>
				<div class="col-md-10 col-xs-10">

					<label class="radio-inline">
						<input name="option_<?=$data['number']?>" id="option_<?=$data['number']?>" type="radio" value="1"  onclick="check(<?=$data['number']?>)"> 객관식
					</label>
					<label class="radio-inline">
						<input name="option_<?=$data['number']?>" id="option_<?=$data['number']?>" type="radio" value="2" checked onclick="check(<?=$data['number']?>)"> 주관식
					</label>
				</div>
			</div>

			<div id="ex_<?=$data['number']?>" class="form-group">
				<label id="q<?=$data['number']?>_addex" for="inputEmail1" class="col-lg-12 col-xs-12  control-label"></label>

				<div class="col-lg-12 col-xs-12">
					<button type="button" class="btn btn-primary pull-right" onclick="addex(<?=$data['number']?>)" style="margin:10px">보기 추가</button>
					<button type="button" class="btn btn-primary pull-right" onclick="delex(<?=$data['number']?>)" style="margin:10px">삭제</button>
				</div>
			</div>

			<script>
				$('#ex_<?=$data['number']?>').hide();
			</script>
			<div class="col-lg-12 col-xs-12"><button id="delq_selected<?=$data['number']?>" type="button" class="btn btn-warning pull-right" style="margin-bottom:10px" onclick="delq_selected('<?=$data['number']?>')">질문삭제</button></div>
			<hr width="100%">
			</div>
			<?
		}//end of else
	$i++;
	}//end of while
?>
	
<?
	$query = "select * from survey_".$id."_question";
	$result = mysqli_query($my_db, $query);

	$i=0;
	while($data = mysqli_fetch_array($result)){
		if($i<$data['number']){ $i=$data['number']; }
	}
?>

	<div id="addq" class="form-group">
		<div class="col-lg-12 col-xs-12">
			<button id="btn_addq" type="button" class="btn btn-danger pull-right" onclick="addq(<?=$i+1?>)">질문 추가</button>
			<button id="btn_delq" type="button" class="btn btn-danger pull-right" onclick="delq(<?=$i?>)">질문 삭제</button>
		</div>
	</div>

	
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="button" class="btn btn-primary btn-lg" onclick="send_result()">OK</button>
		</div>
	</div>

	<input type=hidden name="survey_info" id="survey_info" value="">
	<input type=hidden name="id" id="id" value="<?=$id?>">
</form>
</div>
<br><br>




<!--
<div class="col-xs-12 col-md-12" style="padding:10px">
<form class="form-horizontal" role="form">


	<div id="div_q1">
		<div class="form-group">
			<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">질문1</label>
			<div class="col-lg-10 col-xs-10 ">
				<input type="text" class="form-control" id="q1_question" placeholder="질문을 입력하세요">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label"></label>
			<div class="col-md-10 col-xs-10">

				<label class="radio-inline">
					<input name="option_" id="option_" type="radio" value="1" checked onclick="check(1)"> 객관식
				</label>
				<label class="radio-inline">
					<input name="option_" id="option_" type="radio" value="2"  onclick="check(1)"> 주관식
				</label>
			</div>
		</div>

		<div id="ex_1" class="form-group">
			<div id="ex_list1">
				<label for="inputEmail1" class="col-lg-3 col-xs-3  control-label"></label>
				<div class="col-lg-8 col-xs-8 ">
					<input type="text" class="form-control" id="q1_ex" placeholder="보기를 입력하세요">
				</div>
			</div>

			<label id="q1_addex" for="inputEmail1" class="col-lg-12 col-xs-12  control-label"></label>

			<div class="col-lg-12 col-xs-12">
				<button type="button" class="btn btn-primary pull-right" onclick="addex(1)" style="margin:10px">보기 추가</button>
				<button type="button" class="btn btn-primary pull-right" onclick="delex(1)" style="margin:10px">삭제</button>


			</div>
		</div>

		<hr width="100%">
	</div>

	
	
	<div id="addq" class="form-group">
		<div class="col-lg-12 col-xs-12">
			<button id="btn_addq" type="button" class="btn btn-danger pull-right" onclick="addq(2)">질문 추가</button>
			<button id="btn_delq" type="button" class="btn btn-danger pull-right" onclick="delq(2)">질문 삭제</button>
		</div>
	</div>




 
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="button" class="btn btn-primary btn-lg" onclick="send_result()">Large button</button>
		</div>
	</div>

	<input type=hidden name="survey_info" id="survey_info" value="">
</form>

</div>

-->

<script>
 //질문삭제
/*
$('[id$="selected"]').click(function(){
   $(this).parent().parent().closest("div").remove();
});
*/

function delq_selected(id){
 
	$('#delq_selected'+id).parent().parent().closest("div").remove();
}

function delex_selected(id){
 
	$('#delex_selected'+id).parent().parent().closest("div").remove();
}
//보기삭제
/*$('[id^="delex"]').click(function(){
   $(this).parent().closest("div").remove();
});*/


function check(id){
 
	if($('input:radio[name=option_'+id+']:checked').val() == "1"){
		$('#ex_'+id).show();
    }
	else if($('input:radio[name=option_'+id+']:checked').val() == "2"){
		$('#ex_'+id).hide();
	}
}


function delex(id){
	//$('#ex_list'+id).fadeOut();

	//$('#ex_list'+id).find('div[id^="#ex_list"]:last').remove();

	$('[id^="ex_list'+id+'"]:last').remove();
}

function addex(id){
	$('#q'+id+'_addex').before(
	'<div id="ex_list'+id+'">'+
		'<label for="inputEmail1" class="col-lg-3 col-xs-3  control-label"></label>'+
		'<div class="col-lg-8 col-xs-8 ">'+
			'<input type="text" class="form-control" id="q'+id+'_ex" placeholder="보기를 입력하세요">'+
		'</div>'+
		
		'<div class="col-lg-1 col-xs-1 ">'+
			'<button type="button" id="delex_selected'+id+'" onclick="delex_selected('+id+')"class="btn btn-info pull-right" style="margin-bottom:10px">삭제</button>'+
		'</div>'+
	'</div>');
}


function addq(id){

	$('#addq').before(
	'<div id="div_q'+id+'">'+
		'<div class="form-group">'+
			'<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">질문'+id+'</label>'+
				'<div class="col-lg-10 col-xs-10 ">'+
					'<input type="text" class="form-control" id="q'+id+'_question" placeholder="질문을 입력하세요">'+
				'</div>'+
		'</div>'+
		'<div class="form-group">'+
			'<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label"></label>'+
			'<div class="col-md-10 col-xs-10">'+
				'<label class="radio-inline">'+
					'<input name="option_'+id+'" id="option_'+id+'" type="radio" value="1" checked onclick="check('+id+')"> 객관식'+
				'</label>'+
				'<label class="radio-inline">'+
					'<input name="option_'+id+'" id="option_'+id+'" type="radio" value="2" onclick="check('+id+')"> 주관식'+
				'</label>'+
			'</div>'+
		'</div>'+
		'<div id="ex_'+id+'" class="form-group">'+
			'<div id="ex_list'+id+'">'+
				'<label for="inputEmail1" class="col-lg-3 col-xs-3  control-label"></label>'+
				'<div class="col-lg-8 col-xs-8 ">'+
					'<input type="text" class="form-control" id="q'+id+'_ex" placeholder="보기를 입력하세요">'+
				'</div>'+
					'<div class="col-lg-1 col-xs-1 ">'+
						'<button type="button" id="delex_selected'+id+'" onclick="delex_selected('+id+')" class="btn btn-info pull-right" style="margin-bottom:10px">삭제</button>'+
					'</div>'+
			'</div>'+
			'<label id="q'+id+'_addex" for="inputEmail1" class="col-lg-12 col-xs-12  control-label"></label>'+
			'<div class="col-lg-12 col-xs-12">'+

				'<button type="button" class="btn btn-primary pull-right" onclick="addex('+(id)+')" style="margin:10px">보기 추가</button>'+
				'<button type="button" class="btn btn-primary pull-right" onclick="delex('+(id)+')" style="margin:10px">삭제</button>'+
			'</div>'+
		'</div>'+
		'<div class="col-lg-12 col-xs-12"><button id="delq_selected'+(id)+'" type="button" class="btn btn-warning pull-right" style="margin-bottom:10px" onclick="delq_selected('+(id)+')">질문삭제</button></div>'+
	'<hr width="100%">'+
	'</div>'
	);


	$('#btn_addq').attr('onclick', 'addq('+(id+1)+')');
 
	$('#btn_delq').attr('onclick', 'delq('+(id)+')');
 
    flag=0;

}


function delq(id){	
	$('#div_q'+id).remove();

	$('#btn_addq').attr('onclick', 'addq('+(id)+')');
 
	$('#btn_delq').attr('onclick', 'delq('+(id-1)+')');
}

function send_result(){
	qcount = $('[id$="_question"]').length;
	str="";

	str += $('#subject').val();

	str += "ㅃ";

	str += $('#intro').val();

	str += "ㅃ";


	arr = new Array();
	
	falgcount = $('[name^="option_"]').length;
	for(i=0, j=0; i<falgcount; i++){
		if( typeof $(':radio[name^="option_"]:nth('+i+'):checked').val()!="undefined"){
			 
			arr[j] = $(':radio[name^="option_"]:nth('+i+'):checked').attr('id').substring(7,8);
			j++;
		}
	}

 

	for(i=0; i<qcount ; i++){
		str += $('[id$="_question"]:nth('+i+')').attr('id').substring(2,1) +"ㅉ";
		str += $('[id$="_question"]:nth('+i+')').val();
		
		str += "ㄸ";


 
		flag = $(':radio[name="option_'+arr[i]+'"]:checked').val();
 

		if(flag==1){
			excount =  $('[id$="'+arr[i]+'_ex"]').length;
			for(j=0; j<excount ; j++){
				
				str += $('[id$="'+arr[i]+'_ex"]:nth('+j+')').val();
				if(j!=excount-1)
				str += "ㄲ";
			}
		}

 
		if(i!=qcount-1)
		str +="ㅆ";
	}

	$('#survey_info').val(str);
 
 

	$.ajax({
		type: "POST",
		url: "survey_edit.php",
		data: $('form').serialize(),
		success: function(msg){
			alert(msg);
			location.href='survey_list.php' 
		},
		error: function(){
			alert("failure");
		}
	});


	//document.survey_form.submit(); 

/*$("[속성^='값']").
속성이 특정 문자열로 시작되는 요소들을 선택합니다.

$("[title^='f']").
태그중에 title 속성의 값이 f로 시작하는 태그 요소들을 선택합니다.
<li title='first'>블라블라</li>

$("[속성$='값']").
속성이 특정 문자열로 끝나는 요소들을 선택합니다.

$("[속성*='값']").
속성이 특정 문자열을 포함하는 요소들을 선택합니다.

$("[title$='u']").
태그중에 title 속성의 값이 u를 포함하는 태그 요소들을 선택합니다.

<li title='fourth'>블라블라</li>

위 속성 셀렉터를 중복으로 사용할 수 있습니다.

title속성이 f 로 시작하고, u를 포함하는 요소를 선택하고 싶으면 아래와 같이 할 수 있습니다.

$("[title^='f'][title$='u']").

http://zzaps.tistory.com/67
*/
}
</script>




    <script src="//code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>