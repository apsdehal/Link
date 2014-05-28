<?php

class HomeController{
	
	function get(){
		View::make('home');
	}

	function post(){
		echo 'You have posted to Home Controller';
	}

}