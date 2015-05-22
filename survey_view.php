<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body>



<script id="bodybottom" src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
 
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">


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
	 
	 
		$query = "select * from survey_".$id."_question order by number";
		$result = mysqli_query($my_db, $query);

		$i=0;
		while($data = mysqli_fetch_array($result)){

		$number = $data['id'];
		$question = $data['question'];
		$exlist = $data['exlist'];


		$answers = array();

 

		//객관식일경우 차트를 만듬
		if($data['type']==1){

			$str = explode("ㄲ",$exlist);
			$str_c = count($str);//보기의 개수

			$query2 = "select * from survey_".$id."_answer";
			$result2 = mysqli_query($my_db, $query2);

			//보기에 해당하는 결과값을 불러오기위한 while
			while($data2 = mysqli_fetch_array($result2)){
				$answers[$data2[$i]]++;
			}

		?>

 
		$('body').append('<div id="container<?=$i?>" style="min-width: 310px; height: 300px; max-width: 600px; margin: 10px auto; border: 2px solid; "></div>');
			$('#container<?=$i?>').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: '<?=$question?>'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					type: 'pie',
					name: '<?=$question?>',
					data: [
					<?
									//보기를 출력하는 for
					for($j=0; $j<$str_c; $j++){
	
					 echo "['".$str[$j]."',".  ($answers[$j]/count($answers))*100 ."]" ;

					 if($j!=$str_c-1){
						echo ",";
					 }
 
					}

					?>
						//['Firefox',   33.3333],
						//['IE',      66.6666]
					]
				}]
			});
 
    


		<?

		
		}
		//주관식일경우 나열하기
		else{
			
			?>
				$('body').append('<div id="container<?=$i?>" style="min-width: 310px; height: 300px; max-width: 600px; margin: 10px auto;  border: 2px solid; "><center><h4><?=$question?><br></h4></center><div id="subcontainer<?=$i?>" style="height: 220px; overflow-y:auto;"><table id="p_answer" class="table table-striped"></table></div></div>');

			<?
			$query2 = "select * from survey_".$id."_answer";
			$result2 = mysqli_query($my_db, $query2);

			//보기에 해당하는 결과값을 불러오기위한 while
			while($data2 = mysqli_fetch_array($result2)){

				if($data2[$i]!=""){
			?>	
				//$('#subcontainer<?=$i?>').append('<?=$data2[$i]?><br>');
				$('#p_answer').append('<tr><td><?=$data2[$i]?></td></tr>');

			<?
				}
			}//end of while
			
		}
		
		$i++;
		}//end of while
	 
		$my_db->close(); 
	?>

</script>

	
	

	</body>


</html>
