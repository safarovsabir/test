<?

$servername = "localhost";
$database = "u1590615_default";
$username = "*****";
$password = "*****";


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = mysqli_connect($servername, $username, $password, $database);


mysqli_set_charset($conn, "utf8");

if (!$conn) {
		  die("Connection failed: " . mysqli_connect_error());
		  
		   exit();
	}

// Разворачиваем БД
function creating_bd($conn){
	
	$search_sql_post = mysqli_query($conn,"SHOW TABLES LIKE 'post'");
	
	
    if($search_sql_post->num_rows == 0){
	
		$sql_post = mysqli_multi_query($conn,"
		
		CREATE TABLE  `u1590615_default`.`post` (`userId` INT NOT NULL ,`id` INT NOT NULL ,`title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,`body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (  `id` ));
		
		ALTER TABLE `u1590615_default`.`post` ADD INDEX( `id`);
		
		");
		
		mysqli_next_result($conn);
		
		$search_sql_comment = mysqli_query($conn,"SHOW TABLES LIKE 'comment'");
	

		if($search_sql_comment->num_rows == 0){

			$sql_comment = mysqli_multi_query($conn,"
		
			CREATE TABLE  `u1590615_default`.`comment` (`postId` INT NOT NULL ,`id` INT NOT NULL ,`name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,`email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,`body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (  `id` ));
			
			ALTER TABLE `u1590615_default`.`comment` ADD INDEX( `postId`);
			
			");
	
			mysqli_next_result($conn);
			
			$communications_sql = mysqli_query($conn,"select * from information_schema.REFERENTIAL_CONSTRAINTS WHERE TABLE_NAME = 'post'");
			
			
			if($communications_sql != NULL){
				
				$communications_sql = mysqli_fetch_array($communications_sql);
			
			}


			if($communications_sql[10] != "comment" || $communications_sql == NULL){
				
				$sql_connection = mysqli_query($conn,"ALTER TABLE `comment` ADD FOREIGN KEY (`postId`) REFERENCES `post`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");

			}
			
		}
		
	}
	
}

//Преверяем дубли и наполняем бд (посты)
function completion_post($conn, $userId, $id, $title, $body){
	
	$search_sql = mysqli_query($conn,"SELECT `userId`, `id`, `title`, `body` FROM `post` WHERE `userId`= $userId AND `id`= $id AND `title` = '$title' AND `body` = '$body'");
	
	if($search_sql->num_rows == 0){
		
		$completion_sql = mysqli_query($conn,"   INSERT INTO post  (userId,id,title,body)  VALUES  ($userId, $id, '$title', '$body')");
		
	}	
}


//Преверяем дубли и наполняем бд (комментарии)
function completion_comment($conn, $postId, $id, $name, $email, $body){
		
		$search_sql = mysqli_query($conn,"SELECT `postId`, `id` FROM `comment` WHERE `postId`= $postId AND `id`= $id");
		
		if($search_sql->num_rows == 0){
			
			$completion_sql = mysqli_query($conn,"   INSERT INTO comment  (postId,id,name,email,body)  VALUES  ($postId, $id, '$name', '$email', '$body')");
			
		}
}

//Кол-во загруженных и количество полученных разные вещи :)
function quantity_sql($conn, $table){
		
		$quantity = mysqli_query($conn,"SELECT * FROM $table");
		
		$quantity_rows = mysqli_num_rows($quantity);
		
		return $quantity_rows;
		
		
}

//Находим комментарии и заголовки к ним
function search_sql($conn, $search){
		
		$search = mysqli_query($conn,"SELECT post.title, comment.body FROM comment INNER JOIN post ON post.id = comment.postId WHERE comment.body LIKE '%$search%'");
		
		
		
		$search = mysqli_fetch_all($search, MYSQLI_ASSOC);
		
		if(count($search) == 0){
			
			$search = "Пусто";
			
		}
		
		return $search;

}
