<!--
	folioGallery v3.0 - 2016-08-30
	(c) 2016 Harry Ghazanian - foliopages.com/php-jquery-ajax-photo-gallery-no-database
	This content is released under the http://www.opensource.org/licenses/mit-license.php MIT License.
-->
<?php 
include 'foliogallery/config.php'; 
$targetid = isset($_POST['targetid']) ? $_POST['targetid'] : '';
?>
<script>
// $(function() {
	
// 	var targetid = <?php echo $targetid; ?>;
// 	var pid = $(targetid).attr('id');
	
// 	var thumbWidth = $('#'+pid+' .thumb').outerWidth(true);
// 	var numThumbs = $('#'+pid+' .thumbwrap').attr('title');
// 	var wrapWidth = $(targetid).width();
// 	var innerWrapWidth = thumbWidth * numThumbs;
	
// 	if(innerWrapWidth <= wrapWidth) { $('#'+pid+' .toright').addClass('nolink'); }
// 	$('#'+pid+' .thumbwrap-inner').width(innerWrapWidth); // set inner wrap width
	
// });
// </script>

<div class="fg">

<?php
if (empty($_REQUEST['album'])) // if no album requested, show all albums
{		
	
	$albums = array_diff(scandir($mainFolder), array('..', '.'));
	$numAlbums = count($albums);
	 
	if($numAlbums == 0) 
	{
		echo '<div class="titlebar"><p>No albums posted</p></div>';
	}
	else
	{
		sort_array($albums,$mainFolder,$sort_albums_by_date); // rearrange array either by date or name ?>
	     
		<!-- <span class="title m4-left">Photo Gallery - <?php echo $numAlbums; ?> albums</span> -->
		
		<a href="#" class="toright" rel="<?php echo $numAlbums; ?>">Siguiente&nbsp; <span class="icon-right-dir"></span></a>
		<a href="#" class="toleft nolink" rel="<?php echo $numAlbums; ?>"><span class="icon-left-dir"></span> &nbsp;Atrás</a>
        	  
        <div class="clear"></div>
	  	 
		<div class="thumbwrap" title="<?php echo $numAlbums; ?>" onmouseover="this.title='';">
		<div class="thumbwrap-inner"> 
		<?php 
		for( $i=0; $i<=$numAlbums; $i++ )
		{				
			if(isset($albums[$i])) 
			{  
				$thumb_pool = glob($mainFolder.'/'.$albums[$i].'/thumbs/*{.'.implode(",", $extensions).'}', GLOB_BRACE);
				
				if (count($thumb_pool) == 0)
				{ 
					$album_thumb = $no_thumb;
				}
				else
				{	
					$album_thumb = ($random_thumbs ? $thumb_pool[array_rand($thumb_pool)] : $thumb_pool[0]); // display a random thumb or the 1st thumb	
					$album_thumb = '<img src="'.$album_thumb.'" alt="'.$albums[$i].'" />';				
				} ?>
			 		 			 
				<div class="thumb">
					<span class="animate-spin icon-spin2 rotator"></span>
					<a class="showAlb" rel="<?php echo $albums[$i]; ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?album=<?php echo urlencode($albums[$i]); ?>">
						<?php echo $album_thumb; ?> 
					</a>	
					<div class="caption"><?php echo substr($albums[$i],0,$num_captions_chars); ?></div>
				</div>
	
			<?php
			}
		}
		?>
		</div>
		</div>	

    <?php
	}

} 
else //display photos in album 
{

	$requested_album = sanitize($_REQUEST['album']); // xss prevention
	
	// check requested album against directory traverse
	if (!in_array($requested_album, $albums_in_maindir)) { ?>
        <span class="title m4-left">Photo Gallery &raquo; <a href="#" class="refresh">Index</a></span>
		<p></p>
		<?php die('Invalid Request');
	}
	
	$album = $mainFolder.'/'.$requested_album;
	$scanned_album = scandir($album);
	$files = array_diff($scanned_album, array('..', '.','thumbs','descriptions.txt'));
	$numFiles = count($files); ?>
	
	<?php if($fullAlbum==1) { ?>
		<span class="title m4-left"><a href="#" class="refresh">Index</a> &raquo;</span>
	<?php } ?>
	<span class="title m4-left"><?php echo $numFiles; ?> Fotos</span>
	   
	
	<?php
	if($numFiles == 0)
	{
		echo '<div class="clear"></div>There are no images in this album.';	
	}
	else	
	{			
		sort_array($files,$album,$sort_images_by_date); // rearrange array either by date or name		 			 
				
		if (!is_dir($album.'/thumbs')) 
		{
			mkdir($album.'/thumbs');
			chmod($album.'/thumbs', 0777);
			//chown($album.'/thumbs', 'apache'); 
		} ?>
		
		<a href="#" class="toright" rel="<?php echo $numFiles; ?>">Siguiente&nbsp; <span class="icon-right-dir"></span></a>
		<a href="#" class="toleft nolink" rel="<?php echo $numFiles; ?>"><span class="icon-left-dir"></span> &nbsp;Atrás</a>
		
		<div class="clear"></div> 	
		
		<div class="thumbwrap" title="<?php echo $numFiles; ?>" onmouseover="this.title='';">
		<div class="thumbwrap-inner">
		
			<?php
			for( $i=0; $i <= $numFiles; $i++ )
			{   
				if(isset($files[$i]) && is_file($album .'/'. $files[$i]))
				{   		    		
					$full_caption = (itemDescription($album, $files[$i]) ? itemDescription($album, $files[$i]) : $files[$i]); // image captions
					$num_chars = strlen($full_caption);
					$caption = ($num_chars > $num_captions_chars ? substr($full_caption,0,$num_captions_chars).'...' : $full_caption);
					$caption = encodeto($caption);
															
					if(allowed_ext($files[$i], $extensions)) 
					{  				  					   
						$thumb = $album.'/thumbs/'.$files[$i];
						if (!file_exists($thumb))
						{
							make_thumb($album,$files[$i],$thumb,$thumb_width); 
						} ?>	   
					   
						<div class="thumb">
							<?php echo url_start($album,$files[$i]); ?><img src="<?php echo $thumb; ?>" alt="<?php echo $files[$i]; ?>" /><?php echo $url_end; ?>
						
							<?php if($show_captions) { ?>
								<div class="caption">
									<div class="tooltip-container"><?php echo $caption; ?><span class="tooltip"><?php echo $full_caption; ?></span></div>
								</div>
							<?php } ?>
						</div> 
						
					<?php
					}
				
				} 
			
			} ?>
		
		</div>
		</div>
		
		<?php echo (file_exists($album.'/descriptions.txt') ? '<div class="description-wrapper">'.encodeto(itemDescription($album)).'</div>' : ''); //display album description
	  
	} // end if numFiles not 0

} ?>
</div>


<div id="fgOverlay"></div>
