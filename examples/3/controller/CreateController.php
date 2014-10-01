<?php

class CreateController 
{
	function get() 
	{
		$view = new View("create.php");
		$view->render();
	}
}