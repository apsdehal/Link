<?php

class PostController 
{
	function get($id) 
	{
		if ( !isset($id) || empty($id) ) {
			header("Location: /");
		}
		$postModel = new Post();
		$results = $postModel->getPostById($id);
		$view = new View("post.php");
		$view->with($results)->render();
	}

	function post() 
	{
		$postModel = new Post();
		$result = $postModel->createPost();
		if ( $result ) {
			header("Location: /" . $result);
		} else {
			header("Location: /");
		}
	}
}