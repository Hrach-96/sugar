<?php

if (!function_exists('image_compress')) {

	function image_compress($source, $destination, $quality, $width = 1000) {
		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') {
			$img = imagecreatefromjpeg($source);
		} elseif ($info['mime'] == 'image/gif') {
			$img = imagecreatefromgif($source);
		} elseif ($info['mime'] == 'image/png') {
			$img = imagecreatefrompng($source);
		}

		$thumbWidth = $width;

		// Create the thumbnail
		$width = imagesx($img);
		$height = imagesy($img);

		// calculate thumbnail size
		// $new_width = $thumbWidth;
		// $new_height = floor($height * ( $thumbWidth / $width ));
		$new_width = $width;
		$new_height = $height;

		// create a new temporary image
		$tmp_img = imagecreatetruecolor($new_width, $new_height);

		// copy and resize old image into new image
		imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		// save thumbnail into a file
		imagejpeg($tmp_img, $destination, $quality);

		return $destination;
	}

}

if (!function_exists('image_compress_thumbnail')) {

	function image_compress_thumbnail($source, $destination, $quality, $width = 252) {
		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') {
			$img = imagecreatefromjpeg($source);
		} elseif ($info['mime'] == 'image/gif') {
			$img = imagecreatefromgif($source);
		} elseif ($info['mime'] == 'image/png') {
			$img = imagecreatefrompng($source);
		}

		$thumbWidth = $width;

		// Create the thumbnail
		$width = imagesx($img);
		$height = imagesy($img);

		// calculate thumbnail size
		$new_width = 800;
		$new_height = 800;

		// create a new temporary image
		$tmp_img = imagecreatetruecolor($new_width, $new_height);

		// copy and resize old image into new image
		imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		// save thumbnail into a file
		imagejpeg($tmp_img, $destination, $quality);

		return $destination;
	}

}
