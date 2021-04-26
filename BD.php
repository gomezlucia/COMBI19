<?php
	function conectar(){
		$link = mysqli_connect ('localhost', 'root', '', 'base_combi19') or die ("error". mysqli_error ($link));
		mysqli_set_charset($link, 'utf8');
		return ($link);
		}
?>