<?php
# #############################################################
# NAGLOWEK DLA MOTYWU MACCOM IT PARTNER
# (C) 2016
#
# #############################################################

# WLACZENIE KOMUNIKATOW O BLEDACH
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

# Sprawdzenie czy dane przeszly GET'em związane dowolną stroną includowaną do wordpressa
$strona = isset( $_GET['strona'] ) ? (int) $_GET['strona'] : 0;
$p = isset( $_GET['p'] ) ? (int) $_GET['p'] : 0;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery-2.1.4.min.js"></script>
<?php
    # wylaczenie ladowania sie slidera dla okreslonych stron includowanych
    if($strona != 1 && $p == 0):
?>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jssor.slider.mini.js"></script>
<?php endif; ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/js/icon/style.css" />
<?php wp_head(); ?>
<link rel='stylesheet' id='lightbox-layout-css'  href='<?php bloginfo('template_directory');?>/css/lightbox.css' type='text/css' media='all' />
<link rel='stylesheet' id='maccom-layout-css'  href='<?php bloginfo('template_directory');?>/css/stylemaccom.css' type='text/css' media='all' />


</head>

<body <?php body_class(); ?> onload="mapaStart()">
<script>
    jQuery(document).ready(function($){
        var zdjecia = new Array('01.jpg','02.jpg','03.jpg','04.jpg',
                                '05.jpg','06.jpg','07.jpg','08.jpg',
                                '09.jpg','10.jpg');

        <?php
            # wylaczenie ladowania sie slidera dla okreslonych stron includowanych
            if($strona != 1 && $p == 0):
        ?>
        // Funkcje zwiazane z dlugoscia okna przegladarki -------------------------------------------------------------
        //Tablica dlugosci dla okna

            var winWidth = new Array();
            winWidth[0] = [767,5000,550];
            winWidth[1] = [250,766,550];
            //winWidth[2] = [300,639,430];
            var stylArray = ['style1000.css','style600.css','style300.css'];

        //Funckja określająca długość okna przeglądarki
            function windowWidth(){
                var dlugosc = window.innerWidth||document.body.clientWidth;
                return dlugosc;
                }
        //Funkcja wybierajaca numer zakresu rozdzielczości
            function nrWidth(){
                for(i=0;i<winWidth.length;i++){
                    if(windowWidth() >= winWidth[i][0] && windowWidth() <= winWidth[i][1])
                        return i;
                    }
                }
        //Sprawdzanie czy zostalazmieniona wielkosc okna przegladarki
            var dlugosc = windowWidth();
            function checkWidth()
                {
                var newDlugosc = windowWidth();
                if(dlugosc != newDlugosc) {
                    dlugosc = windowWidth();
                }
                //wywolanie funkcji z interwalem czasowym w celu sprawdzenia czy wielkosc sie zmienila
                setTimeout(function(){checkWidth()},100);
                }
            checkWidth();
        //Funkcja dla JSSOR SLIDER ------------------------------------------------------------------------------------
        var jssor_1_options = {
              $AutoPlay: true,
              $AutoPlaySteps: 1,
              $SlideDuration: 1000,
              $SlideWidth: 300,
              $SlideSpacing: 40,
              $Cols: 3,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $Steps: 1
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $SpacingX: 1,
                $SpacingY: 1
              }
            };
        var jssor_2_options = {
              $AutoPlay: true,
              $AutoPlaySteps: 2,
              $SlideDuration: 1000,
              $SlideWidth: 200,
              $SlideSpacing: 3,
              $Cols: 2,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $Steps: 2
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $SpacingX: 1,
                $SpacingY: 1
              }
            };


            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);


            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            var dlIndex = nrWidth();

            function ScaleSlider() {
                 var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 809);
                    //refSize = 900;
                    //jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 500);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end

        <?php endif; ?>
        // Skrypt obslugujące ruchome menu strony ---------------------------------------------------------------------
        $('.menu').addClass('original')
          .clone()
          .insertAfter('.menu')
          .addClass('cloned')
          .css({
               'position':'fixed',
               'top':'0',
               'margin-top':'0',
               'margin-left':'-58px',
               'z-index':'1500',
               'background':'#402526',
               'boxShadow':'0px 5px 6px 0px rgba(0, 0, 0, 0.5)'
              })
         .removeClass('original').hide();

        scrollIntervalID = setInterval(stickIt, 10);


        function stickIt() {

          var orgElementPos = $('.original').offset();
          orgElementTop = orgElementPos.top;

          if ($(window).scrollTop()-83 >= (orgElementTop)) {
            // scrolled past the original position; now only show the cloned, sticky element.

            // Cloned element should always have same left position and width as original element.
            orgElement = $('.original');
            coordsOrgElement = orgElement.offset();
            leftOrgElement = coordsOrgElement.left;
            widthOrgElement = orgElement.css('width');
            $('.cloned')
                .css('margin-left','0px')
                .css('top',-100)
                .css('width','100%')
                .css('background','#402526')
                .show();
            $('.original').css('visibility','hidden');
          } else {
            // not scrolled past the menu; only show the original menu.
            $('.cloned').hide();
            $('.original').css('visibility','visible');
          }
        }
    });
    </script>
<div id="page" class="hfeed site">

    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Naglowek strony internetowej -------------------------------------------------------------------------->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only"><?php _e( 'Toggle navigation', 'dazzling' ); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
            <!-- Logo w naglowku strony ------------------------------------------------------------------------------->
                <div id="logo">
                </div>
            <!-- Tytul strony internetowej ---------------------------------------------------------------------------->
                <div id="tytul">
                    <span class="tytultext1">MEBLE</span>
                    <span class="tytultext2">Waldemar</span>
                    <span class="tytultext2">Wittke</span>
                </div>
            <!-- Menu strony internetowej ----------------------------------------------------------------------------->
                <div class="menu">
                         <?php dazzling_header_menu(); ?>
                </div>
                <?php #if( get_header_image() != '' ) : ?>

				<?php #endif; // header image was removed ?>
			</div>

		</div>

	</nav><!-- Koniec elementow nawigacyjnych i tytulu strony -->
    <div class="top-section">
    <!-- Sekcja Slidera ----------------------------------------------------------------------------------------------->
    <?php dazzling_featured_slider(); ?>
    <?php dazzling_call_for_action(); ?>

    </div>
    <div class="container">
    <div class="row">

        <?php
        # Argumenty funkcji zapytania
        query_posts( 'category_name=podbaner&posts_per_page=3' );
        # Zmienna dla class wygladu poszczegolnych elementow pod banerem
        $classID = 1;
        if( have_posts()) :
        # Petla zapytan o posty z zapytania
        while (have_posts()) : the_post();
        # zdefiniowanie ID wpisu wyswietlanego aby mozna bylo go pominac w wyświetlanych wszystkich postów
        $wpis_ID = $post -> ID;
        # Sprawdzenie czy sa posty do wyswietlenia
        # Wyswietlanie postow dla kategorii podbaner
        ?>
        <a href="<?php the_permalink(); ?>" class="podbanerLink">
        <div class="col-md-4a kolumna<?php echo $classID; ?>">
          <h2><?php the_title(); ?></h2>
            <?php
                if(function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID)) {
                 # wstawienie obrazka o okreslonej rozdzielczosci
                 # the_post_thumbnail( 'thumbnail' );       // Miniatura (default 150px x 150px max)
                 # the_post_thumbnail( 'medium' );          // Mała rozdzielczość (domyślnie 300px x 300px max)
                 # the_post_thumbnail( 'large' );           // Duza rozdzielczość  (domyślnie 640px x 640px max)
                 # the_post_thumbnail( 'full' );            // Pełna rozdzielcozść (Orginalny obrazek taki jak uploadowany)
                 $podbanerArray =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'medium',false );
                 $podbanerUrl =  $podbanerArray[0];
                }
            ?>
            <div class="podbanerImg" style="background-image:url(<?php echo $podbanerUrl;?>)">
            </div>
            <div class="podbanerTresc">
                <?php
                # Wywolanie funkcji z function.php wyswietlajaca fragment tresci wpisu do okreslonej ilosci slow.
                echo get_excerpt(20,$post->ID);
                ?>
            </div>
            <p><a class="btn btn-default" href="<?php the_permalink(); ?>" role="button">Więcej &raquo;</a></p>
            <div class="podbanerClear"></div>
        </div>
        </a>
        <?php $classID++; ?>
        <?php #echo "Brak stron do wyswietlenia"; ?>

        <?php endwhile; ?>
        <?php endif ?>
        </div>
    </div>
    <!-- Sekcja elementow pod banerem w sytuacji jesli to jest strona glowna ------------------------------------------>

    <!-- Slider jssor OFERTA  ------------------------------------------------------------------------------------------>
    <!-- Sekcja elementow pod banerem w sytuacji jesli to jest strona glowna -->
     <?php
        # Wylaczenie Slidera oferty jeśli jest to strona z ofertą ...
        if($strona != 1 && $p == 0):
     ?>
     <section class="module parallax parallax-1">
      <div class="parallaxIn">
        <a href="?strona=1">
        <h2>Oferta</h2>
        <p class="ofertaText">
            Oto nasze niektóre produkty. Zapoznaj się z pełną ofertą naszych produktów, które przygotowaliśmy dla Ciebie.
        </p>
        </a>
        <div id="jssor_1" style="position: relative; margin: 0px 0px 0px 17px; auto; top: 0px; left: -25px; width: 1000px; height: 400px; overflow: hidden; visibility: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1000px; height: 350px; overflow: hidden;">


            <?php
            # Argumenty funkcji zapytania dla slidera oferty
            query_posts( 'category_name=oferta&posts_per_page=8&order=ASC' );

            if( have_posts()) :
            # Petla zapytan o posty z zapytania
            while (have_posts()) : the_post();
            # zdefiniowanie ID wpisu wyswietlanego aby mozna bylo go pominac w wyświetlanych wszystkich postów
            $wpis_ID = $post -> ID;
            # Sprawdzenie czy sa posty do wyswietlenia
            # Wyswietlanie postow dla kategorii podbaner
            ?>

                <?php
                    if(function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID)) {
                     # wstawienie obrazka o okreslonej rozdzielczosci
                     # the_post_thumbnail( 'thumbnail' );       // Miniatura (default 150px x 150px max)
                     # the_post_thumbnail( 'medium' );          // Mała rozdzielczość (domyślnie 300px x 300px max)
                     # the_post_thumbnail( 'large' );           // Duza rozdzielczość  (domyślnie 640px x 640px max)
                     # the_post_thumbnail( 'full' );            // Pełna rozdzielcozść (Orginalny obrazek taki jak uploadowany)
                     $podbanerArray =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'medium',false );
                     $podbanerUrl =  $podbanerArray[0];
                    }
                ?>

                <div style="display: none;" class="ofertaTxt">
                    <a href="<?php the_permalink(); ?>" class="podbanerLink">
                    <div class ="ofertaImg" style="background-image:url(<?php echo $podbanerUrl;?>)"></div>
                    </a>
                    <a href="<?php the_permalink(); ?>">
                    <h3><?php the_title(); ?></h3>
                    <?php
                        # Funkcja poszukujaca selektorow wlasnych w tekscie i rozbijajaca go na poszczegolne elementy z formatowaniem
                        # 1 - zawartosc posta
                        # 2 - ID artykulu
                        # 3 - prefix klasy dla sekcji
                        # 4 - ilosc wyswietlanych elementow danego posta 0 - wszystkie
                        # 5 - wlączenie lub wylaczenie shortcodow i obrazków
                        get_explode_post(get_the_content(),$post->ID,'parallax',3,false);
                    ?>
                    </a>
                </div>


            <?php endwhile; ?>
            <?php endif ?>


        </div>
        <!-- Bullet Navigator
        <div data-u="navigator" class="jssorb03" style="bottom:10px;right:10px;">
            <!-- bullet navigator item prototype
            <div data-u="prototype" style="width:21px;height:21px;">
                <div data-u="numbertemplate"></div>
            </div>
        </div>
        -->
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora03l" style="top:0px;left:-545px;width:55px;height:55px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora03r" style="top:200px;right:715px;width:55px;height:55px;" data-autocenter="2"></span>
        <a class="btn btn-default" href="?strona=1" role="button">Zobacz naszą ofertę »</a>
        </div>


    </div>
    </section><!-- Zakonczenie sekcji parallaxy -->
    <?php
        # Zakonczenie wyswietlania oferty jesli jest ona dostepna
        endif;
    ?>
    <?php
    # Zakonczenie sprawdzenia czy to koniec dla elementow naglowka strony
        #}
    ?>

        <div id="tresc">
        <?php
            # Zdefiniowanie zmiennej dla kolejnosci wyswietlanych postów
            if(!isset($_SESSION['enter_count'])) $_SESSION['enter_count'] = 0;
        ?>
