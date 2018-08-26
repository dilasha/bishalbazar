<?php
	session_start();	
	session_destroy();
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/index.php'</script>";
?>