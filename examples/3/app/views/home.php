<!DOCTYPE html>
<html>
<head>
	<title>Home - Blog</title>
</head>
<body>
<?php 
	foreach( $result as $res ) {
?>
	<div>
		<a href="/posts/<?= $res['id'] ?>"><?php $row['title'] ?></a>
	</div>
<?php
	}
?>
</body>
</html>