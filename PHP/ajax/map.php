<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

if (isset($_GET['x']) && isset($_GET['y'])) {
	header("Content-Type: image/jpeg");
	
	$map = ImageCreateFromJPEG("../assets/img/map.jpg");
	$mark = ImageCreateFromPNG("../assets/img/mark.png");
	$markSX = imagesx($mark);
	$markSY = imagesy($mark);
	
	$x = ($_GET['x'] + 6000/2) / 6000 * imagesx($map);
	$y = (-$_GET['y'] + 6000/2) / 6000 * imagesy($map);
	
	ImageCopy($map, $mark, $x - $markSX / 2, $y - $markSY / 2, 0, 0, $markSX, $markSY);
	imagejpeg($map);
}
?>