<?php

class PostController{
	function get( $id ){
		if($id)
			echo 'You have come to post no.' . $id;
		else
			echo 'Hey, welcome to the posts';
	}

	function post(){
		View::make('post');
	}
}