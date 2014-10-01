<?php
class Post 
{
	function getAllPosts()
	{
		global $dbh;
		$sth = $dbh->prepare("SELECT * FROM posts");
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
}