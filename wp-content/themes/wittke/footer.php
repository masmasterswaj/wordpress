<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dazzling
 7,10,8
 */
?>
           <div class="koniec-tresci"></div><!-- Clear: Both dla dlugosci strony -->
        </div><!-- koniec tresci -->
    <!-- Mapa i punkt i skrypt i parametry klorów -->
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script>
        var mapa; // obiekt globalny
        function mapaStart()
        {
            // tworzymy mapę drogowa
            var wspolrzedne = new google.maps.LatLng(52.3889587,17.0938629);
            var dymek = new google.maps.InfoWindow(); // zmienna globalna
            var opcjeMapy = {
                zoom: 17,
                center: wspolrzedne,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //definiowanie kolorow na mapie
            var szareDrogi = [
              //inwersja mapy na ciemna z HUE w okreslonym kolorze
              {
                "elementType": "geometry",
                "stylers": [
                  { "invert_lightness": true },
                  { "hue": "#311818" }
                ]
              },
              //kolor tekstu ulic
              {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                  { "color": "#c6afaa" }
                ]
              },
              //kolor obramowanie dla napisow ulic
              {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                  { "hue": "#ff0000" },
                  { "color": "#291818" }
                ]
              },
              //kolor obramowania dla punktow POI
              {
                "featureType": "poi",
                "elementType": "labels.text.stroke",
                "stylers": [
                  { "hue": "#ff0000" },
                  { "color": "#291818" }
                ]
              },
              //kolor tekstu POI
              {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [
                  { "color": "#c6afaa" }
                ]
              },
            ];
            mapa = new google.maps.Map(document.getElementById("mapka"), opcjeMapy);


            // stworzenie markera
            dymek.setContent('Meble Waldemar Wittke');
            var punkt  = new google.maps.LatLng(52.3889587,17.0938629);
            var opcjeMarkera =
            {
                position: punkt,
                map: mapa,
                title: "Meble Waldemar Wittke"
            }
            var marker = new google.maps.Marker(opcjeMarkera);

            //kolory na mapie
            var styledMapOptions = {
              map: mapa,
              name: "Mapa"
            }
            var chilledMapType =  new google.maps.StyledMapType(szareDrogi,styledMapOptions);
            mapa.mapTypes.set('Mapa', chilledMapType);
            mapa.setMapTypeId('Mapa');

            mapa.setOptions({styles: szareDrogi});
            //dymek.setPosition(new google.maps.LatLng(52.3889587,17.0938629));
            //dymek.open(mapa);
        }
    </script>
    <!-- Obszar dla calego naglowka -->
	<footer id="footer-area">

		<div class="footer-inner">
            <div class="footer-kolumna1">

                <!-- Lewa 1 Kolumna dla kontak -->
                <h3 class="widgettitle">Jak się z nami skontaktować</h3>
                <!-- Kontakt -->
                <div id="footer-kontakt">
                   <div class="icon icon-home">
                       <span class="kontakt">ul. Średzka 90, 62-020 Swarzędz</span>
                   </div>
                   <div class="icon icon-phone">
                       <span class="kontakt">602124144</span>
                   </div>
                   <div class="icon icon-envelop">
                       <span class="kontakt">biuro@meble-wittke.pl</span>
                   </div>
                </div>
            </div><!-- koniec footer-kolumna1  -->

            <!-- Srodkowa 2 Kolumna dla ostatnich wpisów z kategorii strona, oferta i materialy -->
            <div class="footer-kolumna2">
                <h3 class="widgettitle">Najnowsze ofery i wpisy</h3>
                <div class="najnowsze">
                <?php
                    # Argumenty funkcji zapytania
                    query_posts( 'category_name=oferta,strona&showposts=5' );

                    if( have_posts()) :
                    # Petla zapytan o posty z zapytania
                    while (have_posts()) : the_post();
                    # zdefiniowanie ID wpisu wyswietlanego aby mozna bylo go pominac w wyświetlanych wszystkich postów
                    $wpis_ID = $post -> ID;
                    # Sprawdzenie czy sa posty do wyswietlenia
                    # Wyswietlanie postow dla kategorii podbaner
                    ?>
                    <div class="icon icon-files-empty">
                       <span class="wpisy"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif ?>
                <?php #wp_get_archives('type=postbypost&limit=5&category_name=podbaner'); ?>
            </div><!-- koniec footer-kolumna2  -->

            <?php
            function custom_tag_cloud_widget($args) {
                $args['number'] = 0; //adding a 0 will display all tags
                $args['largest'] = 16; //largest tag
                $args['smallest'] = 16; //smallest tag
                $args['unit'] = 'px'; //tag font unit
                $args['format'] = 'flat'; //ul with a class of wp-tag-cloud
                $args['include'] = '#';
                $args['exclude'] = array(20, 80, 92); //exclude tags by ID
                return $args;
            }
            add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );
            ?>
            <!-- Prawa 3 Kolumna dla wyszukiwarki i ikon social - sidebar footer -->

                <div class="footer-kolumna3">
                    <?php
                        # Sidebar dla footer - lewa kolumna
                        get_sidebar( 'footer' );
                    ?>

                </div><!-- koniec footer-kolumna3  -->
                <div class="koniec-tresci"></div>
            </div><!-- Koniec wewnetrznej czesci footera  -->
        </footer><!-- koniec wewnetrznej czsci footer'a -->
        <!-- Mapa lokalizacji  -->
        <div id="mapka" style="width: 100%; height: 300px; border: 1px solid black; background: #1c0e0e;">
        </div>
        <div id="maccom">
            <img src="<?php bloginfo('template_directory');?>/images/maccomm.png" />
            <strong>MacCOM IT Partner</strong> (C) 2016 (R) All Right Reserved
        </div>
    </div><!-- Koniec całej tresci strony #page -->

<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/lightbox.js"></script>
</body>
</html>
