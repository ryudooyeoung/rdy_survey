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
 
<div class="col-xs-12 col-md-12" style="padding:10px">

<form class="form-horizontal" role="form">

<div class="form-group">
	<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">제목</label>
	<div class="col-lg-10 col-xs-10 ">
		<input type="text" class="form-control" id="subject" placeholder="제목을 입력하세요">
	</div>
</div>


<div class="form-group">
	<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">안내문</label>
	<div class="col-lg-10 col-xs-10 ">
		<textarea class="form-control" rows="3" id="intro"></textarea>
	</div>
</div>


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
					<input name="option_1" id="option_1" type="radio" value="1" checked onclick="check(1)"> 객관식
				</label>
				<label class="radio-inline">
					<input name="option_1" id="option_1" type="radio" value="2"  onclick="check(1)"> 주관식
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
			<button type="button" class="btn btn-primary btn-lg" onclick="send_result()">OK</button>
		</div>
	</div>

	<input type=hidden name="survey_info" id="survey_info" value="">
</form>

</div>

<script>
 

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
			'</div>'+
			'<label id="q'+id+'_addex" for="inputEmail1" class="col-lg-12 col-xs-12  control-label"></label>'+
			'<div class="col-lg-12 col-xs-12">'+
				'<button type="button" class="btn btn-primary pull-right" onclick="delex('+(id)+')" style="margin:10px">삭제</button>'+
				'<button type="button" class="btn btn-primary pull-right" onclick="addex('+(id)+')" style="margin:10px">보기 추가</button>'+
			'</div>'+
		'</div>'+
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

	//문제의 개수를 구함
	qcount = $('[id$="_question"]').length;
	str="";

	//제목을 가져오는부분
	str += $('#subject').val();
	str += "ㅃ";

	//안내문
	str += $('#intro').val();
	str += "ㅃ";

	//문제번호
	for(i=0; i<qcount ; i++){
		//문제를 구한후 'ㅉ'으로 나눔
		str += i +"ㅉ";

		//해당 문제의 질문 구하는 부분
		str += $('[id$="_question"]:nth('+i+')').val();
		str += "ㄸ";

		/*excount =  $('[id$="'+(i+1)+'_ex"]').length;
		for(j=0; j<excount ; j++){
			
			str += $('[id$="'+(i+1)+'_ex"]:nth('+j+')').val();
			if(j!=excount-1)
				str += "ㄲ";
		}*/

		if($('[id^="option_'+(i+1)+'"]').length>0){
			
			flag = $(':radio[name="option_'+(i+1)+'"]:checked').val();

			if(flag==1){
				excount =  $('[id$="'+(i+1)+'_ex"]').length;
				for(j=0; j<excount ; j++){
					
					str += $('[id$="'+(i+1)+'_ex"]:nth('+j+')').val();
					if(j!=excount-1)
					str += "ㄲ";
				}
			}

		}


		if(i!=qcount-1)
		str +="ㅆ";
	}

	$('#survey_info').val(str);

 

	$.ajax({
		type: "POST",
		url: "survey_add.php",
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

	//alert(str);

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