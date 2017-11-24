/*!
	folioGallery v3.0 - 2016-08-30
	(c) 2016 Harry Ghazanian - foliopages.com/php-jquery-ajax-photo-gallery-no-database
	This content is released under the http://www.opensource.org/licenses/mit-license.php MIT License.
*/
//$(function() {	
$(document).ready(function() {					   
					
	var folioGalleryDir = './'; // foliogallery folder relative path - absolute path like http://my_website.com/foliogallery may not work
	
	// find divs with class folioGallery and load album in it based on id
	$('.folioGallery').each(function(index, value) {								   
		
		this == value; //true
		var targetId = this.id; // id of div to load albums
		var targetDiv = '#'+this.id;
																
		if(targetId=='folioGallery') {
			var fullAlbum = 1;
			var showAlb = ''; // empty will show full gallery
		} else {
			var fullAlbum = 0;
			var showAlb = $(targetDiv).prop('title'); // title attribute of div - same as album folder
		}
		
		loadGallery(folioGalleryDir,targetId,showAlb,fullAlbum,targetId); // inital load
								
		// in gallery view, load album when thumb is clicked
		$(this).on('click', 'a.showAlb', function() {	
			var showAlb = $(this).prop('rel');
			loadGallery(folioGalleryDir,targetId,showAlb,fullAlbum,targetId);
			return false;
		});
								
		// refresh div content
		$(this).on('click', 'a.refresh', function() {
		   loadGallery(folioGalleryDir,targetId,'',fullAlbum,targetId);
		   return false;
		});	
			
		// next prev links	
		$(this).on('click', '.toright, .toleft', function() {
						
			var numThumbs = $(this).prop('rel');
			var thumbW = $(targetDiv+' .thumb').outerWidth(true); // thumb with including padding and margin
			var innerWrapW = numThumbs * thumbW;		
			var thumbWrap = $(targetDiv+' .thumbwrap');
			var thumbWrapW = thumbWrap.width();
			
			$(targetDiv+' .thumbwrap-inner').width(innerWrapW); // set thumbwrap-inner width based on # of thumbs	
			
			if(this.className == 'toright'){
				var pos = thumbWrap.scrollLeft() + thumbWrapW;
			} else {
				var pos = thumbWrap.scrollLeft() - thumbWrapW;				
			}
			thumbWrap.animate({ scrollLeft: '+'+pos }, 400);
			
			if(pos <= 0) { $(targetDiv+' .toleft').addClass('nolink'); } else { $(targetDiv+' .toleft').removeClass('nolink'); }
			if(pos >= (innerWrapW - thumbWrapW)) { $(targetDiv+' .toright').addClass('nolink'); } else { $(targetDiv+' .toright').removeClass('nolink'); }	
			
			return false;
			
		});	
			
	});
			
	// load image in overlay
	$(this).on('click', 'a.showimage', function() {
		
		var album = $(this).prop('rel');
		var image = $(this).prop('rev');
			
		$('#mainImage').html('')	
		$.ajax
		({
			type: 'POST',
			url: 'foliogallery-img.php',
			data: {
				alb: album,
				img: image
			},
			cache: false,
			success: function(dat)
			{
				$('#fgOverlay').html(dat).show();
			}
		});	
		
		$('#fgOverlay').show();
		$("#fgOverlay-close").slideDown(800);
		
		return false;
	
	});
	
	// image overlay close
	$(this).on('click', '#fgOverlay-close', function() {
		$("#fgOverlay").fadeOut(400).html('');
		return false;
	});
	
	// display thumb-container inside image overlay
	$(this).on('click', 'a.showThumbs', function() {
		
				
		if($("#thumb-container").is(":visible")) {
			localStorage.setItem('showthumbs', 0);
		} else {
			localStorage.setItem('showthumbs', 1);
		}
		
		$("#thumb-container").slideToggle("fast");
		
		return false;
		
	});	
	
	// display info container inside image overlay
	$(this).on('click', 'a.showInfo', function() {
	
		if($("#rightCol").is(":visible")) {
			localStorage.setItem('showinfo', 0);
		} else {
			localStorage.setItem('showinfo', 1);
		}
		
		$("#rightCol").height($(window).height() - 96);
		$("#rightCol").slideToggle("fast");
		
		return false;
	
	});
			
});

function loadGallery(folioGallerydir,targetId,album,fullalbum,targetid) {                    
	$.ajax
	({
		type: 'POST',
		url: folioGallerydir+'/foliogallery.php?album='+album,
		data: {
			album: album,
			fullalbum: fullalbum,
			targetid: targetid
		},
		cache: false,
		success: function(msg)
		{
			$('#'+targetId).html(msg).hide().show();
		}
	});
	return false;
}