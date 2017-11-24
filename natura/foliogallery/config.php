<?php
/***** gallery settings *****/
$mainFolder          = 'albums'; // main folder that holds albums - this folder resides on root directory of your domain
$no_thumb            = '<span class="noimg icon-camera"></span>';  // show this when no thumbnail exists 
$extensions          = array("jpg","png","gif","JPG","PNG","GIF"); // allowed extensions in photo gallery  
$thumb_width         = '325';   // used in thumnail creation - use .thumb class in CSS file to style thumbnails
$sort_albums_by_date = TRUE;    // TRUE will sort albums by creation date (most recent first), FALSE will sort albums by name 
$sort_images_by_date = FALSE;    // TRUE will sort thumbs by creation date (most recent first), FALSE will sort images by name 
$random_thumbs       = TRUE;    // TRUE will display random thumbnails, FALSE will display starting from the first image from thumbs folders
$show_captions       = FALSE;    // TRUE will display file names as captions on thumbs inside albums, FALSE will display no captions
$num_captions_chars  = '18';    // number of characters displayed for thumbnail captions
$showExiff           = FALSE;    // TRUE will display exiff info of image in image view
/***** end gallery settings *****/

/***** below are the PHP functions *****/

$url_end = '</a>';
$albums_in_maindir = scandir($mainFolder); // array of albums in main dir
$fullAlbum = (!empty($_REQUEST['fullalbum']) ? 1 : 0);

// sanitize string
function sanitize($string)
{
	$string = htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
	return $string;
}

// encode string to
function encodeto($string)
{
	$string = mb_convert_encoding(trim($string), 'UTF-8', 'HTML-ENTITIES');
	return $string;
}

// if extension is allowed
function allowed_ext($file, $extensions)
{
	$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	if (in_array($ext, $extensions))
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
} 
 
// function to create thumbnails from images
function make_thumb($folder,$file,$dest,$thumb_width)
{

	$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	
	switch($ext)
	{
		case "jpg":
		$source_image = imagecreatefromjpeg($folder.'/'.$file);
		break;
		
		case "jpeg":
		$source_image = imagecreatefromjpeg($folder.'/'.$file);
		break;
		
		case "png":
		$source_image = imagecreatefrompng($folder.'/'.$file);
		break;
		
		case "gif":
		$source_image = imagecreatefromgif($folder.'/'.$file);
		break;
	}	
	
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	if($width < $thumb_width) // if original image is smaller don't resize it
	{
		$thumb_width = $width;
		$thumb_height = $height;
	}
	else
	{
		$thumb_height = floor($height*($thumb_width/$width));
	}
	
	$virtual_image = imagecreatetruecolor($thumb_width,$thumb_height);
	
	if($ext == "gif" or $ext == "png") // preserve transparency
	{
		imagecolortransparent($virtual_image, imagecolorallocatealpha($virtual_image, 0, 0, 0, 127));
		imagealphablending($virtual_image, false);
		imagesavealpha($virtual_image, true);
    }
	
	imagecopyresampled($virtual_image,$source_image,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
	
	switch($ext)
	{
	    case 'jpg': imagejpeg($virtual_image, $dest,80); break;
		case 'jpeg': imagejpeg($virtual_image, $dest,80); break;
		case 'gif': imagegif($virtual_image, $dest); break;
		case 'png': imagepng($virtual_image, $dest); break;
    }

	imagedestroy($virtual_image); 
	imagedestroy($source_image);
	
}

// return array sorted by date or name
function sort_array(&$array,$dir,$sort_by_date) { // array argument must be passed as reference
	
	if($sort_by_date)
	{
		foreach ($array as $key=>$item) 
		{
			$stat_items = stat($dir .'/'. $item);
			$item_time[$key] = $stat_items['ctime'];
		}
		return array_multisort($item_time, SORT_DESC, $array); 
	}	
	else
	{
		return usort($array, 'strnatcasecmp');
	}	

}

// get album and image descriptions
function itemDescription($album, $file='')
{
	if(file_exists($album.'/descriptions.txt'))
	{
		$lines_array = file($album.'/descriptions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 
		if($lines_array)
		{
			if($file == '')
			{
				$album_line = explode(';', $lines_array[0]); 
				return (!empty($album_line[0]) && $album_line[0] == 'album' ? $album_line[1] : '');
			}
			else
			{
				foreach($lines_array as $img_line)
				{	
					if(!empty($img_line)) {
						$img_desc = explode(';', $img_line);	
						if($img_desc[0] == $file) { return $img_desc[1]; }
					}
				}
			}	
		}
		else
		{
			return '';
		}
	}	
}

// return first part of url
function url_start($album, $file, $class='showimage', $target='') {
	
	$file_parts = pathinfo($file);
	$file_name = $file_parts['filename']; // filename without extension
	$prefix = explode('-', $file_name);
	
	switch($prefix[0])
	{
		case "utube":
		$video_id = $prefix[1];
		$url_start = '<a href="http://www.youtube.com/embed/'.$video_id.'?rel=0&amp;wmode=transparent" rel="'.$album.'" rev="'.$file.'" title="" class="'.$class.'" '.$target.'>';
		break;
		
		case "vimeo":
		$video_id = $prefix[1];
		$url_start = '<a href="http://player.vimeo.com/video/'.$video_id.'?rel=0&amp;wmode=transparent" rel="'.$album.'" rev="'.$file.'" title="" class="'.$class.'" '.$target.'>';
		break;
		
		default:
		$url_start = '<a href="'.$album.'/'.$file.'" rel="'.$album.'" rev="'.$file.'" title="" class="'.$class.'" '.$target.'>';
		break;	
	}
	
	return $url_start;
	
}
?>