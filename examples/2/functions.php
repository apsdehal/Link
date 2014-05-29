<?php
function Home(){
	echo 'Welcome to Home';
	echo '<form method="post" action="/posts">';
	echo '<input type="text" name="name" placeholder="Enter your name">';
	echo '<input type="submit" value="Submit">';
	echo '</form>';
}

function Post( $id ){
	if(isset($_POST['name'])){
		echo 'Hello ' . $_POST['name'];
	} else {
		if(isset($id))
			echo "Hello, You have directly come to post no. " . $id;
		else{
			echo "Hello welcome to a post Home<br/>";
			echo '<a href="'. Link::route('Home') . '">Click here to go back to home</a>';
		}

	}
}