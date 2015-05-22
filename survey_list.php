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
    <h1>survey list</h1>


	<table class="table table-striped">
  
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

 
	//설문조사 중복 여부 검사
	$query = "select * from survey_list";
	$result = mysqli_query($my_db, $query);

	while($data = mysqli_fetch_array($result)){
		?>

		<tr>
			<td align="center" width="50%"><a href="survey.php?id=<?=$data['id']?>"><?= $data['subject'] ?></a></td> 
			<td> <?=$data['date']?></td> 
			<td><a href="survey_view.php?id=<?=$data['id']?>"> 통계 </a></td> 
			<td><a href="survey_edit_form.php?id=<?=$data['id']?>"> 수정 </a></td> 
			<!--td><a href="survey_del.php?id=<?=$data['id']?>"> 삭제 </a></td-->
		</tr>

		<?
	}

 
	$my_db->close();

 
?>
	

	</table>

		<button type="button" class="btn btn-primary btn-lg" onclick="new_survey()" style="margin-left:10px">새 설문</button>

	<script>
		function new_survey(){
			location.href="survey_add_form.php";
		}
	</script>
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>