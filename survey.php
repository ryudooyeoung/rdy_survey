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

 
<div class="col-xs-12 col-md-12" style="padding:10px">

<form class="form-horizontal" role="form">


	<?
	$id = $_REQUEST['id'];

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

 

	$query = "select * from survey_list where id=$id";
	$result = mysqli_query($my_db, $query);

	$subject;
	$intro;
	while($data = mysqli_fetch_array($result)){
		 $subject = $data['subject'];
		 $intro = $data['intro'];
	}
 
	?>
		<center>
			<h1><?=$subject?></h1><br>
			<h3><span class="label label-success"><?=$intro?></span></h3><br>
		</center>
	<?
 

	$query = "select * from survey_".$id."_question order by number";
	$result = mysqli_query($my_db, $query);

	$n=1;
	while($data = mysqli_fetch_array($result)){
		?>

		<div class="form-group">
			<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label">질문<?=$n++?></label>
			<label for="inputEmail1" class="col-lg-10 col-xs-10  control-label" style="text-align:left">
				<?=$data['question']?>
			</label>
		
			<label for="inputEmail1" class="col-lg-2 col-xs-2  control-label"></label>
			<label for="inputEmail1" class="col-lg-9 col-xs-9 control-label" style="text-align:left">
				<?
					$exs = explode("ㄲ", $data['exlist']);
					$ex_c = count($exs);
					
					//객관식일 경우
					if($data['type']==1){
						for($i=0; $i<$ex_c; $i++){
							?>
								<label class="radio-inline">
									<input name="q<?=$data['number']?>" id="q<?=$data['number']?>" type="radio" value="<?=$i?>"><?=$exs[$i] ?>
								</label>
							<?
						}
					}
					//주관식일경우
					else{
							?>
								<input name="q<?=$data['number']?>" id="q<?=$data['number']?>" type="text" class="form-control" placeholder="">
								
							<?
					}
				?>
			</label>
		</div>
	<?
	}
	?>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="button" class="btn btn-primary btn-lg" onclick="send_submit()">Submit</button>
		</div>
	</div>

 
</form>

</div>



<script>

function send_submit(){
	str = $('form').serialize();

	$.ajax({
		type: "POST",
		url: "survey_client.php",
		data: { id :<?=$id?> , result : str}, 
		success: function(msg){
			alert(msg);
			//location.href='survey_list.php'
			self.opener = self;
			self.close();
		},
		error: function(){
			alert("failure");
		}
	});
}

 

</script>
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>