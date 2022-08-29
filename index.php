<?

ini_set('display_errors',1);
error_reporting(E_ALL);

	require_once('bd_index.php');
	require_once('fun_index.php');
	
	creating_bd($conn);
	
	completion($conn);
	
	$count_arr_bd = count_bd($conn);
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
    	$search_comment = $_POST['random'];
		
	}

	if(isset ($search_comment)){
		
		$search = search_sql($conn, $search_comment);
		
	}

	
?>

<!DOCTYPE html>
<html lang="ru">

<head>
<link rel="shortcut icon" href="#">
	<link rel="stylesheet" href="css/style.css">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="jquery.js"></script>
</head>

<body>
	<div class="wrapper">
		<main>
			<div class="container">
				<div class="container_box">
					<div class="box">

						<p><? echo "Загружено - ".$count_arr_bd[0]." постов и ".$count_arr_bd[1]." комментариев";?></p>
						<? echo("<script>console.log('PHP: "."Загружено - ".$count_arr_bd[0]." постов и ".$count_arr_bd[1]." комментариев"."');</script>"); ?>
					</div>
				</div>
				<form action="index.php" id="form" method="POST" class="form" autocomplete="off" enctype="multipart/form-data">
					<div class="main">
						<div class="ment">
							<div>
							<input name="theme" type="hidden">
							<p>Поиск по базе</p>
								<input required name="random" class="inp" id="number" type="text" min="3" placeholder="Минимум 3 символа">
							</div>
							</div>
							<div class="bottom">
									<button class="btn">Поиск</button>
									<script type="text/javascript">


									let btn = document.querySelector('.btn');
									let inp = document.querySelector('.inp');

									btn.setAttribute('disabled', true);

									// Проверка длины строки
									inp.oninput = function(){ 
										let val = inp.value;
										if (val.length < 3){
									  btn.setAttribute('disabled', true);
									}else{
									  btn.removeAttribute('disabled');
									}
									};
									</script>
							</div>
						<p class = "search"><? 
						
						if(isset ($search)){
							
						
						
							if(is_array($search)){
								
							echo "<table class=\"table_com\"><tr><th>Запись</th><th>Комментарий</th></tr>";
							
								foreach ($search as $item) {
									
									echo("<tr><td>{$item['title']}</td><td>{$item['body']}</td></tr>");
									
									}	
									
								
								
							}else{
								
								echo "<table class=\"table_com\"><tr><th>$search</th></tr>";
								
							}
						}
						?></p>
						</div>	
					</div>
				</form>
			</div>
		</main>
	</div>
	

 
</body>
</html>
