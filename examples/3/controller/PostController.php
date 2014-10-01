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
		View::render("post.php", $results);
	}

	function post() 
	{
		$postModel = new Post();
		$result = $postModel->createPost();
		return $result;
	}
}