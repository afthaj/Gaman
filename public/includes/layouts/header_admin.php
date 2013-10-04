	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS -->
    <link href="../css/bootswatch-flatly/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/prettify.css" rel="stylesheet">
    <link href="../css/bootswatch-flatly/docs.css" rel="stylesheet">
    <link href="../css/bootswatch-flatly/gaman-styles.css" rel="stylesheet">

    <link href="../css/flexslider.css" rel="stylesheet" />
    <link href="../css/responsiveslides.css" rel="stylesheet" />
    
    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }
      
      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      #wrap > .container {
        padding-top: 60px;
      }
      .container .credit {
        margin: 20px 0;
      }

      code {
        font-size: 80%;
      }

    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../ico/favicon.ico">
    
    <script src="../js/jquery.js"></script>
    
    <script src="../js/bootstrap.js"></script>
    
    <!-- 
    <script src="js/bootstrap-affix.js"></script>
	<script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
	<script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    -->
    <script src="../js/typeahead.js"></script>
     
    <script src="../js/application.js"></script>
    <script src="../js/holder.js"></script>
    <script src="../js/html5shiv.js"></script>
    <script src="../js/prettify.js"></script>
    
    
    <!-- flexslider -->
    
    <script defer src="../js/jquery.flexslider.js"></script>
    <script type="text/javascript">
		$(window).load(function(){
	      $('.flexslider').flexslider({
	        animation: "slide",
	        start: function(slider){
	          $('body').removeClass('loading');
	        }
	      });
	    });
	</script>
	
	<!-- end flexslider -->
    
    <!-- responsive slides -->
    
    <script defer src="../js/responsiveslides.js"></script>
    <script>
    // You can also use "$(window).load(function() {"
    $(function () {

      /* Slideshow 4 */
      $("#responsive_slider").responsiveSlides({
        auto: false,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
      });

    });
  </script>
  
  <!-- end responsive slides -->