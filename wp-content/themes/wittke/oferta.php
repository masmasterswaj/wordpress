<?php

    # Strona oferty dla index.php
    # Plik zawiera kontekst oferty strony

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    # Sprawdzenie czy dane przeszly GET'em związane ze stroną główną - paginacja strony oferty
    $oferta = isset( $_GET['oferta'] ) ? (int) $_GET['oferta'] : 1;
    # Argumenty do zapytania - #paged1 - zmienna zdefiniowana dla danej petli
    $args = array(
        'category_name' => 'oferta',
        'paged'          => $oferta,
        'posts_per_page' => 12,
        'order' => 'ASC'
    );
    ?>
    <div id="oferta-strona">
        <h2>Oferta produktów</h2>
        <p class="ofertaText">
            Ponieżej znajdują się wszystkie nasze produkty. Wybierz ten jedyny dla siebie i skontaktuj się z nami.
        </p>
        <?php
        //wp_reset_query();
        # Zdefiniowanie nowego zapytania
        $strona = new WP_Query($args);
        # Zmienna dla class wygladu poszczegolnych elementow pod banerem
        $classID = 1;
        if( $strona -> have_posts()) :
            # Petla zapytan o posty z zapytania
            while ($strona -> have_posts()) : $strona -> the_post();

                # Sprawdzenie czy jest obraz dla danego elementu oferty
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
                <div class="oferta-obiekt">
                        <a href="<?php the_permalink(); ?>" class="podbanerLink">
                        <div class ="oferta-img" style="background-image:url(<?php echo $podbanerUrl;?>)"></div>
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
                <?php
                //get_template_part( 'content', get_post_format() );

            # Koniec petli LOOP dla danego zapytania
            endwhile;
            ?>
            <div class="koniec-tresci"></div><!-- Clear: Both dla dlugosci strony -->
            <?php
            # Ustawienia dla parametru GET paginacji strony
            $pag_args1 = array(
                'format'  => '?oferta=%#%',
                'current' => $oferta,
                'total'   => $strona->max_num_pages
                //'add_args' => array( 'paged2' => $paged2 )
            );
            # Wyswietlenie linków paginacji strony
             ?>
            <!-- Paginacja strony ------------------------->
            <div class="paginacja">
            <?php
            echo paginate_links( $pag_args1 );
            ?>
            </div>
            <?php

        else :
            # Alternatywa dla nie znalezionego artykułu lub danych wynikających z GET
            get_template_part( 'content', 'none' );
        endif;
        ?>
        <div class="koniec-tresci"></div><!-- Clear: Both dla dlugosci strony -->
    </div> <!-- Zakonczenie strony oferty -->
