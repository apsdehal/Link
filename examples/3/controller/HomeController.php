<?php

class HomeController 
{
	function get()
	{
		$postModel = new Post(); 
		$posts = $postModel->getAllPosts();
		View::render("home.php", $posts);
	}
}