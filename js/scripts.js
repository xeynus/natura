$(document).ready(function() {    
// Menús activos
	function menuActivos () {
	    if ($("body").is("#beneficios"))
	    {
	        $('.menu-beneficios').addClass("active");  
	    }

	    if ($("body").is("#bases"))
	    {
	        $('.menu-bases').addClass("active");  
	    }

	    if ($("body").is("#galeria"))
	    {
	        $('.menu-galeria').addClass("active");  
	    }

	    if ($("body").is("#contacto"))
	    {
	        $('.menu-contacto').addClass("active");  
	    }
	}

	menuActivos();

 // Cambiar el logo del menú
	var controller = new ScrollMagic.Controller();

	var scene = new ScrollMagic.Scene({triggerElement: "#trigger1"})
	    // trigger animation by adding a css class
	    .setClassToggle(".navbar-default", "fondo")
	    // .addIndicators({name: "1 - add a class"})
	    .addTo(controller);

	var scene = new ScrollMagic.Scene({triggerElement: "#trigger1"})
	    // trigger animation by adding a css class
	    .setClassToggle(".logo-fondo", "logo-fondo-out")
	    // .addIndicators({name: "1 - add a class"})
	    .addTo(controller);

// Botón Arriba
    $('.boton-arriba').localScroll({
        target:'body'
    });

// Formulario
	$('#contactForm').submit(function( event ) {
	      // console.log( "Handler for .submit() called." );
	      event.preventDefault();

	      var contact = $(this);
	      var method = 'POST';
	      var url = 'form.php'
	      var dataString = contact.serialize();

	      $.ajax({
	        type: method,
	        url : url,
	        data : dataString,
	        success : function(data){
	          console.log(data);
	          contact[0].reset();

	          if (data == 1) {
	            contact.addClass('hide-form');
	            $('#contactForm button').addClass('opac');
	            $('#contactForm svg').addClass('opac');
	            $("#contactForm button").addClass('false-click');

	            $('#retro').html('Gracias por tu mensaje, nos pondremos en contacto contigo a la brevedad.');
	          } else {
	            contact.addClass('hide-form');
	            $('#contactForm button').addClass('opac');
	            $('#contactForm svg').addClass('opac');

	            $('#retro').html('Hubo un problema, intenta mas tarde.');
	          }
	          $('#retro').show();
	          
	        }
	      })

	      .fail(function() {
	       });

	    });

	    $('#contactForm').keydown(function(e) {
	      if (e.keyCode == 13) {
	          $("#contactForm button").click();
	      }
	    });

	$(".navbar-toggle").click(function(){
        $(".navbar-default").toggleClass("fixed");
    });

 //    $("#campana").on('hidden.bs.modal', function (e) {
	//     $("#campana iframe").attr("src", $("#campana iframe").attr("src"));
	//     $("#campana iframe").attr("src", $("#campana iframe").attr("src").replace("autoplay=1", "autoplay=0"));
	// });

	$("#memorias").on('hidden.bs.modal', function (e) {
	    $("#memorias iframe").attr("src", $("#memorias iframe").attr("src"));
	});

	$("#richard").on('hidden.bs.modal', function (e) {
	    $("#richard iframe").attr("src", $("#richard iframe").attr("src"));
	});

	$("#jesus").on('hidden.bs.modal', function (e) {
	    $("#jesus iframe").attr("src", $("#jesus iframe").attr("src"));
	});

	$("#aide").on('hidden.bs.modal', function (e) {
	    $("#aide iframe").attr("src", $("#aide iframe").attr("src"));
	});

	$("#martha").on('hidden.bs.modal', function (e) {
	    $("#martha iframe").attr("src", $("#martha iframe").attr("src"));
	});

	$("#sorpresa").on('hidden.bs.modal', function (e) {
	    $("#sorpresa iframe").attr("src", $("#sorpresa iframe").attr("src"));
	});

	$( window ).load(function() {
		$(".loader").hide();
		$("body#galeria").removeClass("hide-overflow")
	});

	$(".lcd").hide();

	// $(".ganadores").click(function(){
	// 	$('.lcd').show();
	// 	$(".navbar-nav a").removeClass("ganadores");

	// 	$.getScript('js/pdf-4.js', function() {
	//   		// $("#content").html('Javascript is loaded successful!');
	//   		$('.lcd').hide();
	// 	});
	// });

	$("#but1").click(function() {
		$("#but2").removeClass("dale");
	});

	$(".dale").click(function() {
		$("#header").hide();
	});


	$('.ganadores').on('click', function(e){
	    $('.lcd').show();
		$(".navbar-nav a").removeClass("ganadores").off("click");

		$.getScript('js/pdf-4.js', function() {
	  		// $("#content").html('Javascript is loaded successful!');
	  		$('.lcd').hide();
		});
	});

});

$(window).load(function()
{
    $('#campana').modal('show');
    
});