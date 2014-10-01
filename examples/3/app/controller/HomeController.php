<?php

class HomeController 
{
	function get()
	{
		$postModel = new Post(); 
		$posts = $postModel->getAllPosts();
		$view = new View("home.php");
		$view->with($posts)->render();
	}
}