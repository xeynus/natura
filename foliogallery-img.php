<?php 
include 'foliogallery/config.php';

$album = sanitize($_POST['alb']);
$image = sanitize($_POST['img']);
$album_name = explode('/', $album, 2);
$album_name = $album_name[1];

if (!in_array($album_name, $albums_in_maindir)) { die('Invalid Request'); } // check requested album against directory traverse
if (!file_exists($album.'/'.$image)) { die('No image exists in specified location'); } // check if image exists

$scanned_album = scandir($album);
$files = array_diff($scanned_album, array('..', '.','thumbs','descriptions.txt'));
sort_array($files,$album,$sort_images_by_date); // rearrange array either by date or name
$numFiles = count($files);

$file_parts = pathinfo($image);
$file_name = $file_parts['filename'];
$prefix = explode('-', $file_name);
?>
<script>
$(function() {
	// set height
	var windowHeight = $(window).height(); /* height of browser viewport */
	var tbOffset = $('#topbar').height() + $('#bottombar').height();
	var mainImageHeight = windowHeight - tbOffset; /* minus topbar and bottombar heights */
	
	$('#fgOverlay #mainImage').height(mainImageHeight);
	$('#fgOverlay #rightCol').height(mainImageHeight);
	
	if(localStorage.getItem('showthumbs') == 1) { $('#fgOverlay #thumb-container').show(); }
	if(localStorage.getItem('showinfo') == 1) {	$('#fgOverlay #rightCol').show(); }
	
});		
</script>

<div id="leftCol">
	
	<div id="topbar" class="topbar">
		<?php echo url_start($album, $image, 'zoomicon icon-camera', 'target="_blank"').$url_end; ?>
		<?php echo $album_name; ?>
		<a href="#" id="fgOverlay-close" class="icon-cancel-1"></a>
	</div>
	
	<div class="clear"></div>
		
	<div id="mainImage">
	
		<?php
		switch($prefix[0])
		{
			case "utube":
			$isImage = FALSE;
			$isVideo = TRUE;
			$video_id = $prefix[1];
			echo '<iframe width="100%" class="vidFrame" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe>';
			break;
			
			case "vimeo":
			$isImage = FALSE;
			$isVideo = TRUE;
			$video_id = $prefix[1];
			echo '<iframe width="100%" class="vidFrame" src="https://player.vimeo.com/video/'.$video_id .'?portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			break;
			
			default:
			$isImage = TRUE;
			$isVideo = FALSE;
			echo '<img class="imgFrame" src="'.$album.'/'.$image.'" alt="'.$image.'" />';
			break;	
		}	
		?>
		
		<div id="thumb-container">
			<div id="thumb-container-inner">
			<?php
				for( $i=0; $i <= $numFiles; $i++ )
				{   
					if(isset($files[$i]) && is_file($album .'/'. $files[$i]) && allowed_ext($files[$i], $extensions))
					{   		    	   		    																  					    											
						$thumbClass = ($files[$i] == $image ? ' selected' : '');
						echo '<div class="thumb'.$thumbClass.'">'.url_start($album, $files[$i]).'<img src="'.$album.'/thumbs/'.$files[$i].'" alt="'.$files[$i].'" />'.$url_end.'</div>';					
					}
				}
			?>
			</div>
		</div>
	
	</div>	

	<div class="clear"></div>
	
	<div id="bottombar" class="bottombar">
	
		<!-- <a href="#" class="showInfo icon-info-circled"></a> -->
		<a href="#" class="showThumbs icon-th-thumb-empty"></a>
		
		<div class="centerbox"> 
		<?php	
		for( $i=0; $i <= $numFiles; $i++ )
		{   
			if(isset($files[$i]) && is_file($album .'/'. $files[$i]))
			{   		    	   		    												
				if(allowed_ext($files[$i], $extensions) && $files[$i]===$image)
				{  				  					    											
					$p = ($i == 0 ? $numFiles-1 : $i-1);
					$n = ($i == $numFiles-1 ? 0 : $i+1);
					$nf = $i+1;	
						
					echo '<div class="bottombar">';	
						echo url_start($album, $files[$p], 'showimage icon-left-bold').$url_end;
						echo '<span class="itemnums">'.$nf.' de '.$numFiles.'</span>';
						echo url_start($album, $files[$n], 'showimage icon-right-bold').$url_end; 
					echo '</div>';
				}
				else
				{
					echo '';
				}					
			}
		}
		?>
		</div>
			
	</div>
	
</div>	

<div id="rightCol">	
	
	<p></p>
	
	<h3>Details</h3>
	
	<p></p>
	<hr />
	<p></p>
	
	<?php echo (itemDescription($album, $image) ? itemDescription($album, $image).'<p></p><hr /><p></p>' : ''); // image description if available ?>

	<span class="exifname">Album:</span> <?php echo $album_name; ?>

	<br />
	
	<?php
	if($isImage)
	{
		list($img_width_orig, $img_height_orig) = getimagesize($album.'/'.$image);
		$exif = @exif_read_data($album.'/'.$image, 'IFD0');
		$exif = @exif_read_data($album.'/'.$image, 0, true); 
		?>	
		
		<span class="exifname">Image:</span> <?php echo $image; ?>
	
		<br />
		
		<?php
		if($showExiff)
		{ ?>
			
			<span class="exifname">Artist:</span> <?php echo (isset($exif['IFD0']['Artist']) ? $exif['IFD0']['Artist'] : '-'); ?>
		
			<br />
			
			<span class="exifname">Dimensions:</span> <?php echo $img_width_orig; ?> x <?php echo $img_height_orig; ?>
		
			<br />
		
			<span class="exifname">Date Created:</span> <?php echo (isset($exif['EXIF']['DateTimeOriginal']) ? date('M d, Y', strtotime($exif['EXIF']['DateTimeOriginal'])) : '-'); ?>
			
			<br />
			
			<span class="exifname">Last Modified:</span> <?php echo (isset($exif['FILE']['FileDateTime']) ? date('M d, Y', $exif['FILE']['FileDateTime']) : '-'); ?>
			
			<br />
			
			<span class="exifname">File Size:</span> <?php echo (isset($exif['FILE']['FileSize']) ? number_format($exif['FILE']['FileSize']).'K' : '-'); ?>
			
			<br />
			
			<span class="exifname">Mime Type:</span> <?php echo (isset($exif['FILE']['MimeType']) ? $exif['FILE']['MimeType'] : '-'); ?>
			
			<br />
					
			<span class="exifname">Copyright:</span> <?php echo (isset($exif['COMPUTED']['Copyright']) ? $exif['COMPUTED']['Copyright'] : '-'); ?> 
			
			<br />
		
		<?php
		}
	} 
	?>
	
</div>
