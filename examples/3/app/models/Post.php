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

	function getPostById()
	{
		$id = $_POST['id'];
		
		global $dbh;
		$sth = $dbh->prepare("SELECT * FROM posts WHERE id=:id");
		$sth->bindParam("id", $id);
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function createPost()
	{
		if( !isset($_POST['title']) || !isset($_POST['content'])) {
			return 0;
		}

		$title = $_POST['title'];
		$content = $_POST['content'];
		
		global $dbh;
		$sth = $dbh->prepare("INSERT INTO posts(title, content) VALUES(:title, :content)");
		$sth->bindParam("title", $title);
		$sth->bindParam("content", $content);
		$sth->execute();

		$sth = $dbh->prepare("SELECT id FROM posts ORDER BY id DESC");
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);

		return $result['id'];

	}
}