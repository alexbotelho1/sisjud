<?php	
	$a = $_POST['parecer'];
	$fim = 0;
	while ($fim < strlen($a)) {		
		echo (substr($a, $fim, 1) . " " . ord(substr($a, $fim, 1)) . "<br>");
		$fim++;
	}	
?>