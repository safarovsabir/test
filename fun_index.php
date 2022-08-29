<?

	function completion($conn){	
		
		$data = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/posts"), true);
		
			for($i = 0; $i < count($data); $i++){
			
				completion_post($conn, $data[$i]['userId'], $data[$i]['id'], $data[$i]['title'], $data[$i]['body']);

			}  
		
		

		$data = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/comments"), true);

			for($i = 0; $i < count($data); $i++){
				
				completion_comment($conn, $data[$i]['postId'], $data[$i]['id'], $data[$i]['name'], $data[$i]['email'], $data[$i]['body']);

			}
		
	}
	
	
	function count_bd($conn){	
		
		$count_bd_arr[0] = quantity_sql($conn, 'post');
		$count_bd_arr[1] = quantity_sql($conn, 'comment');
		
		return $count_bd_arr;
		
	}
	
	