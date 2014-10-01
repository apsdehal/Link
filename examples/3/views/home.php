<!DOCTYPE html>
<html>
<head>
	<title>Home - Blog</title>
</head>
<body>
<?php 
	foreach( $res in $result ) {
?>
	<div>
		<a href="/posts/<?=$res['id']?>"><?php$row['title']?></a>
	</div>
<?php
	}
??>
</body>
</html>