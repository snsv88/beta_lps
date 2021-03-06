<script type="text/javascript">
var isTouch = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0));
//alert(isTouch);
var $grid;
$(document).ready(function(){
		$grid = $('.iso-container');
        $grid.isotope({
    			itemSelector:<?php echo ((PAGE_NAME == 'PROFILE' || ( isset($mode) && $mode === 'rankuser')) ? "modeClass" : "'.item'"  )?>,
    			layoutMode:'masonry',
    			transformsEnabled: false,
    			//animationEngine: 'jquery',modeMasonry
    			masonry:{columnWidth:<?php echo ((PAGE_NAME == 'PROFILE' ||  (isset($mode) && $mode === 'rankuser')) ? "modeMasonry" : "200"  )?>, gutter:15}
    	 });
    });
    function TimeUTC(foto, no)
    {   
        var server_end = foto * 1000;
        var server_now = <?php echo(time()); ?> * 1000;
        var client_now = new Date().getTime();
        var end = server_end - server_now + client_now;
        
        return end;
    }
    //questa funzione fa un resize del popup in base all'altezza del contenuto dell'iframe caricato...
    //TO DO controllare su safari
    function resizeMagnific()
    {
    	//console.log('before iframe is added to DOM');
    	//controllo se l'iframe si � caricato
        this.content.find('iframe').on('load', function() {
            /*new ResizeSensor(jQuery('.iframe_height'), function() {
                console.log('myelement has been resized');
            });*/            
            //aggiungo l'id all' iframe
            $('iframe').attr('id','iframe');	
            //console.log($( window ).height());
            //recupero la sua altezza e la metto fissa all'iframe
            document.getElementById('iframe').style.height = ($( window ).height()-80)+ 'px'; 
            //document.getElementById('iframe').contentWindow.document.body.offsetHeight + 'px';		
            //console.log('iframe loaded');
            //console.log($('iframe'));
            
        });
    }
         
     /*
     *  GESTIONE COUNTDOWN
     */
     	    
    function update()
    {     
        $('[data-countdown]').each(function() {
            //var nextYear = moment.tz($(this).data('countdown'), "America/Los_Angeles");
            var dataUtc = TimeUTC($(this).attr( "title" ),$(this).attr( "now" ));
            /*
            console.log($(this));
            console.log($(this).data('countdown'));
            console.log($(this).attr( "title" ));
            console.log($(this).attr( "now" ));
            console.log(dataUtc);
            
            dataUtc; //
            */
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, {elapse: false})
              .on('update.countdown', function(event) {
                    
                    var format = '%H:%M:%S';
                    if(event.offset.days > 0) 
                    {
                        format = '%-d d%!d ' + format;
                    }
                    
                    if(event.offset.weeks > 0) 
                    {
                        format = '%-w w%!w ' + format;
                    }
                    
                    if(window.location.pathname== "/photo.php")
                    {                    
                        $(this).html('<img src="/images/orologio.png" width="16" height="16" alt=""/> '+event.strftime(format));                    
                    }
                    else
                    {
                        $(this).html(event.strftime(format));
                    }
                    
                    $grid.isotope({ sortBy: 'date-item' }).isotope('layout');
                    
                  })
              .on('finish.countdown', function(event) {
                    $(this).html('This photo has expired!');                
                    $grid.isotope( 'remove', $(this).parent().parent() ).isotope('layout');
              });
        });
    }
      
     /*
     *  FINE GESTIONE COUNTDOWN
     */
    
    // INIZIO DOCUMENT READY
    $(document).ready(function() {
        
    	/*------- GESTIONE blocchi masory inzio ----------*/
        
        var instance = jQuery("img.lazy").Lazy({chainable: false});
            
        var ias = jQuery.ias({
          container:  '.iso-container',
          item:       <?php echo ((PAGE_NAME == 'PROFILE') ? "modeClass" : "'.item'"  )?>,
          pagination: '#pagination',
          next:       '.next',
          delay: 200
        });
        
        // Add a loader image which is displayed during loading
        ias.extension(new IASSpinnerExtension());
            
        // Add a text when there are no more pages left to load
        <?php if(PAGE_NAME != 'PROFILE') { ?> ias.extension(new IASNoneLeftExtension({ html: '<span style="position: absolute;bottom: 0;margin-left: 50%;margin-right: 50%;color:#6bb8f1;">---</span>' })); <?php } ?> 
        //({text: "You reached the end"}));
        //html: '<img src="/images/end_content.png" style="position: absolute;bottom: 0;margin-left: 50%;margin-right: 50%;" />'
        ias.on('render', function(items) {
          $(items).css({ opacity: 0 });
        });
        
        ias.on('rendered', function(items) {
            
          $('.iso-container').isotope( 'insert', items );
          
          $(items).css({ opacity: 1 });
          
            jQuery("img.lazy").lazy({
                bind: "event",
                delay: 400
            });
          
            update();
            <?php if(PAGE_NAME == 'PROFILE') {  echo "AutoHeightProfili();"; } ?>
        });
         
        <?php if(PAGE_NAME == 'PROFILE') { echo "AutoHeightProfili();";} ?>
        update();   
        		 	
    	/*------- GESTIONE blocchi masory fine ----------*/
            
        /****  GESTIONE MAGNIFIC POPUP *****/
        
        $('#popup_term').magnificPopup({
            type: 'iframe',
            closeBtnInside:true
        });	
        
        
        //, .register, .dettaglio-photo, .box-cerca
        $('.add-photo').magnificPopup({
    		type: 'iframe',
    		alignTop: true,
            showCloseBtn: false,
    		callbacks: {
                close: function(){
                    //var didConfirm = confirm("Are you sure?");
                    /*
                    if(didConfirm ==false){
                        return false;
                    }
                    */
                    var magnificPopup = $.magnificPopup.instance,
                    cur = magnificPopup.st.el;
                    //console.log(cur.attr('href'));
                    //console.log(this);
                    
                    //if(cur.attr('href') == "/register.php"){ parent.location.reload(true);  }
                },
    			//callback che prima di appendere l'iframe chiama una funzione
            	beforeAppend: resizeMagnific
        	}
            
    		//overflowY: 'scroll' // as we know that popup content is tall we set scroll overflow by default to avoid jump
    	});	
        /*	
        $(".add-photo, .box-cerca, .dettaglio-photo, .register").magnificPopup({
            type: 'iframe',
            showCloseBtn: false,
            //type: 'ajax',
            alignTop: false,
            overflowY: 'scroll',
            fixedContentPos: true, mainClass: 'mfp-no-margins mfp-with-zoom',
                   
            //closeBtnInside:true
        });	*/		              
        
        
        /****  GESTIONE MAGNIFIC POPUP *****/
                    
        /****  GESTIONE FANCYBOX   ****/
    	//console.log($(window).width());
    	//console.log($(window).height());
        /*	$(".add-photo, .box-cerca, .dettaglio-photo, .register").fancybox({ */
        $(".dettaglio-photo").fancybox({
    		type        : 'iframe',
            scrolling   : 'no',
            helpers: {
                overlay: {
                    locked: true         
                }
            },
    		//autoSize    :  true,
            height      : '100%',
    		closeBtn    : false,
    		iframe : {
    		   scrolling : 'no'
    		}
                          
    	 });
         
    	$(".register").fancybox({
    		type        : 'iframe',
            scrolling   : 'no',
            helpers: {
                overlay: {
                    locked: true         
                }
            },
    		autoSize    :  false,
    		padding     : '0', //'1',
    		margin      : '0', //'2',
    		autoScale   : false,
            aspectRatio : false,
            width       : '100%',
            height      : '100%',
    		closeBtn    : false,
    		iframe : {
    		   scrolling : 'no'
    		},
            afterClose: function(){
                if(this.href == "/register.php"){ parent.location.reload(true);  }
                //console.log(this.href); // == "/register.php")
            } 
                          
    	 });
                    
    	$('.button-chiudi').click(function()
        {    	
            try
            {
                jQuery.magnificPopup.close()
                //parent.jQuery.fancybox.close();
            }
            catch(err)
            {
                parent.$('#fancybox-overlay').hide();
                parent.$('#fancybox-wrap').hide();
            }
        });
        /**** FINE GESTIONE FANCYBOX   ****/
    	/* gestione scroll top */
       $('#scroll-top').click(function(){
        	$('html, body').animate({scrollTop:$('.second-container').position().top}, 1000);
        
        });
    	/* gestione scroll top */
        <?php if(PAGE_NAME == 'INDEX'){ ?>
           	/****  GESTIONE SLIDER ORIZZONTALE   ****/	
            //$('.cont-slider').flexslider({
            $('#sliderhome').flexslider({
        		animation: "slide",
        		animationLoop: true,
        		directionNav: true,
        		controlNav: false,
        		itemWidth: 0,
        		itemMargin : 0,
                smoothHeight: true,
        		
         		controlsContainer: ".flex-container",
                  start: function(slider) {
                    $('.total-slides').text(slider.count);
        						$('.current-slide').text(slider.currentSlide + 1);
                  },
                  after: function(slider) {
                    $('.current-slide').text(slider.currentSlide + 1);
                  }		
        		});
        	/**** FINE  GESTIONE SLIDER ORIZZONTALE   ****/
        <?php } ?>
	    /****  GESTIONE BOX LOGIN   ****/
        $('.box-login-home').click(function() {
            //$('#sliderhome').pause();
            <?php if(PAGE_NAME == 'INDEX'){ ?> /*$('#sliderhome').pause();*/ <?php } ?>
            var options = {};
            $('.content-form-login').toggle();//.toggle( 'blind', options, 800 ); //.slideToggle(500,"linear");
    
        });
		
	    /**** FINE GESTIONE BOX LOGIN   ****/
        	
        
        if(!isTouch)
        {
            /* gestione hide and show all'hover blocchi*/
            $("body").on("mouseover mouseout", "div", function(e){
            
                $('.item').hover(function() {
                    $(this).find(".img-zoom").addClass('transition');
                			$(this).find(".search-hover").show();
                			$(this).find(".box-date-hour").show();
                			$(this).find(".name-profile-photo").show();
                			
                
                }, function() {
                    $(this).find(".img-zoom").removeClass('transition');
                			$(this).find(".search-hover").hide();
                			$(this).find(".box-date-hour").show();//.hide();
                			$(this).find(".name-profile-photo").show();//.hide();
                			$('.search-hover').animate({rotate: '0deg', scale: '1'}, 400);
                });
            });
            /* gestione hide and show all'hover blocchi*/
        }
        
        $('.add-hour, .esagono-abs').click(function(){            
            AddTime(this);
        });
    	/* click su + ore, rotazione img zoom a scomparsa*/
    		   		
    		
        /* show and hide box cerca, aggiungi foto e dettaglio immagine*/
       $('#search').click(function(){
    				$('.container-cerca').show();
    		 });
       $('.search-hover').click(function(){
    				$('.container-dett-img').show();
    				$('.container-dett-img').load('photo.php?id='+this.alt);
    		 });
       $('.notify_link').click(function(){                
    				$('.container-dett-img').show();
    				$('.container-dett-img').load(this.href);
                    return false;
	   });
       
    	/* show and hide box cerca, aggiungi foto e dettaglio immagine*/
    	
        
    	/*------- GESTIONE add photo and scroll top ----------*/
        var sec_cont = $(".second-container");
        if(sec_cont !== undefined && sec_cont.offset() !== undefined)
        {
        	var pos_header=sec_cont.offset().top + 60 ;
            $(document).scroll(function(){
        		
        				if($(document).scrollTop()>=pos_header)
        				{
        					$(".box-scroll-and-add").show(500);
        				}
        				else
        				{
        					$(".box-scroll-and-add").hide(500);
        				}
        			
        		});
         }    
    	/*------- GESTIONE add photo and scroll top ----------*/
        	
        /* GESTIONE NOTIFICHE */
            $('#notify_icon').click(function() {
                $('.tendina-notifiche').toggle( 200, function() {
                    // Animation complete.
                });
            });
            $('#user_icon').click(function() {
                $('.tendina-profilo-log-out').toggle( 200, function() {
                    // Animation complete.
                });
            });
            
        /* FINE GESTIONE NOTIFICHE */
    	
    	
    	});
    // FINE DOCUMENT READY
    	    
        function myAlert(text)
        {
            $.fancybox({
                'autoScale': true,
                'transitionIn': 'elastic',
                'transitionOut': 'elastic',
                'speedIn': 500,
                'speedOut': 300,
                'autoDimensions': true,
                'centerOnScroll': true,
                'content': '<html><head><link rel="stylesheet" type="text/css" href="css/style.css"></head><body><div class="descr-txt" style="background-color: white;padding: 30px;border-radius: 10px;">'+text+'</div></body></html>'
            });
        }		
    	/* click su + ore, rotazione img zoom a scomparsa*/
        //function AddTime($ctx)
        var AddTime = function($ctx)
        {
            
    	   $('.search-hover').animate({rotate: '360deg', scale: '0'}, 400);
           var id_photo = $ctx.id;
           //var id_div_photo = id_photo.join("_");
           var id_image = $ctx.id.split("_").pop();
           var time     = id_photo.slice(0, id_photo.indexOf("_"));
           //console.log(id_photo);
           
           //console.log(id_image);
           //console.log(id_photo.slice(0, id_photo.indexOf("_")));
    	   $('#'+id_photo).animate({rotate: '360deg', scale: '0'}, 400);
    	   $('#'+id_photo).animate({rotate: '360deg', scale: '1'}, 400);
           //console.log($('#'+id_photo).text().trim());
           $.ajax({url: "include/addTime.php?id="+id_image+"&time="+time, success: function(result){
            console.log(result);
            var results = jQuery.parseJSON(result)
                if(results.esito != '1')
                {
                    //tutto ok
                    $('#counter_'+id_image).effect( "shake" );
                    $('#counter_'+id_image).countdown('stop');
                    $('#counter_'+id_image).countdown(results.date);
                    $('#counter_'+id_image).prop('title',results.time);
                    //console.log(results.time);
                    //console.log(results.date);
                    //console.log('#counter_'+id_image+' data-countdown '+$('#counter_'+id_image).attr('data-countdown'));
                    $('#counter_'+id_image).attr('data-countdown',results.date);
                    $('#counter_'+id_image).countdown('start'); 
                    $('#'+id_image).effect( "shake" );               
                    //update();
                    //console.log('#counter_'+id_photo);
                    //myAlert("Thank you for your time!");
                }
                else
                {
                    //$('.esagono-abs').effect( "shake" );   
                    $('#'+id_photo).effect( "shake" );
                    $('.piu-ore').attr('color','red');  //.css('color: rgb(255, 0, 0);');
                    //console.log('ERRORE');             
                    //console.log('id_photo'+id_photo);
                    if(results.error == '0')
                    {
                        myAlert("You can vote again this picture in 24 hours");
                        //myAlert("Potrai rivotare la foto tra 24 ore");
                    }
                    else if(results.error == '1')
                    {
                        myAlert("You can not vote for your own photos!");
                        //myAlert("Non puoi votare la tua stessa foto!");
                    }
                    else if(results.error == '2')
                    {
                        myAlert("You need to login to Lapsic!");
                        //myAlert("Devi prima accedere a Lapsic!");
                    }
                    else if(results.error == 'generic')
                    {
                        myAlert("Ooops! something is wrong , try again later!");
                    }
                }
            }});
           
        }
        
    /* GESTIONE APERTURA CHIUSURA BOX Generico*/
    function tog_box(id)
    {
    	if ($('#'+id).css('display')==('block'))
    		{
    			$('.').slideUp(800);
    			$('#'+id).slideUp(800);
    			
    		}
    		else
    		{
    			$('.').slideUp(800);
    			$('#'+id).slideDown(800);
    		}
    }
    /* GESTIONE APERTURA CHIUSURA BOX Generico*/
</script>