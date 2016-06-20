1.akronim
<?php
/**
 * Dazzling functions and definitions
 *
 * @package dazzling
 */
# Funkcja dodająca atrybut lightbox dla obrazka i wspolna grupę obrazków dla ID artykulu
    function lightbox_data($link) {
        global $post;
        return str_replace('<a href', '<a data-lightbox="second['.$post->ID.']" href', $link);
    }


    # Funkcja dodająca klasę dla obrazka i styli CSS
    function thumbnail_class($link) {
        global $post;
        return str_replace('<img width', '<img class="thumbnail" width', $link);
    }


    # Funkcja poszukujaca selektorow wlasnych w tekscie i rozbijajaca go na poszczegolne elementy z formatowaniem
    # 1 - zawartosc posta
    # 2 - ID artykulu
    # 3 - prefix klasy dla sekcji
    # 4 - ilosc wyswietlanych elementow danego posta 0 - wszystkie
    # 5 - wlączenie lub wylaczenie shortcodow i obrazków
    function get_explode_post($content,$id,$klasa,$count_element=0,$shortcode_display=true)
    {
        # Sprawdzenie czy maja być wyswietlane shortcody i obrazki
        if($shortcode_display) {
            # Wyswietl obrazek wyrozniajacy jesli w poscie nie ma shortcodów
            if( ! has_shortcode( $content, 'gallery' ) ) {
                #Sprawdzenie czy istnieje obrazek wyrozniajacy.
                if(function_exists('has_post_thumbnail') && has_post_thumbnail( $id )) {
                     # wstawienie obrazka o okreslonej rozdzielczosci
                     # the_post_thumbnail( 'thumbnail' );       // Miniatura (default 150px x 150px max)
                     # the_post_thumbnail( 'medium' );          // Mała rozdzielczość (domyślnie 300px x 300px max)
                     # the_post_thumbnail( 'large' );           // Duza rozdzielczość  (domyślnie 640px x 640px max)
                     # the_post_thumbnail( 'full' );            // Pełna rozdzielcozść (Orginalny obrazek taki jak uploadowany)
                     $obrazekMediumArray =  wp_get_attachment_image_src( get_post_thumbnail_id( $id ),'medium',false );
                     $obrazekMediumUrl =  $obrazekMediumArray[0];
                     $obrazekLargeArray =  wp_get_attachment_image_src( get_post_thumbnail_id( $id ),'large',false );
                     $obrazekLargeUrl =  $obrazekLargeArray[0];
                     echo '
                         <a href="'.$obrazekLargeUrl.'" data-lightbox="roadtrip'.( $id ).'">
                         <img class="thumbnail" src="'.$obrazekMediumUrl.'" />
                         </a>';
                }else{
                   # Obrazek zastepczy gdy brak obrazka wyrozniajacego i galerii
                   echo '
                         <a href="'.get_option('upload_path').'/mebel01-1024-683.jpg" data-lightbox="roadtrip'.( $id ).'">
                         <img class="thumbnail" src="'.get_option('upload_path').'/mebel01-300-200.jpg" />
                         </a>';
                }
            # Jesli galeria jest dostepna wyswietl galerie
            }else{


            # Dodanie filtra dla do_shortcode() dodającego wpis data-lightbox
            add_filter('wp_get_attachment_link', 'lightbox_data');
            # Dodanie filtra dodającego clasę class="thumbnail" do obrazka galerii
            add_filter('wp_get_attachment_link', 'thumbnail_class');
            #Funckja zwracająca w tablicy $matches[0][x] wszystkie zdefiniowane shortcode w danym poscie.
            # Pobranie wszystkich zarejestrowanych shortcode w wordpress
            $pattern = get_shortcode_regex();
            # Zdefiniowanie tablicy
            $matches = array();
            # Zapisanie do tablicy wszystkich spełniających warunki shortcode
            preg_match_all("/$pattern/s", get_the_content(), $matches);

            }
        }
        #Rozbicie ciagu znaczników na poszczegolne elementy
        $post_element = explode("|",$content);
        $i = 0;
        foreach($post_element as $id => $elements) {
            if(($elements == "gd" || $elements == "galeriad" || $elements == "galeriaduza") && $shortcode_display) {
                $post_array[$i][0]="gd";
                $post_array[$i][1]=str_replace('&nbsp;','',$post_element[$i-1]);
                $post_array[$i][2]=substr_count($post_element[$i-1],'&nbsp;');
            }
            if($elements == "o" || $elements == "opis") {
                $post_array[$i][0]="o";
                $post_array[$i][1]=str_replace('&nbsp;','',$post_element[$i-1]);
                $post_array[$i][2]=substr_count($post_element[$i-1],'&nbsp;');
            }
            if($elements == "w" || $elements == "wyroznienie" || $elements == "wyróżnienie") {
                $post_array[$i][0]="w";
                $post_array[$i][1]=str_replace('&nbsp;','',$post_element[$i-1]);
                $post_array[$i][2]=substr_count($post_element[$i-1],'&nbsp;');
            }
            if($elements == "t" || $elements == "tekst") {
                $post_array[$i][0]="t";
                $post_array[$i][1]=str_replace('&nbsp;','',$post_element[$i-1]);
                $post_array[$i][2]=substr_count($post_element[$i-1],'&nbsp;');
            }
            if(($elements == "gm" || $elements == "galeriam" || $elements == "galeriamala") && $shortcode_display) {
                $post_array[$i][0]="gm";
                $post_array[$i][1]=str_replace('&nbsp;','',$post_element[$i-1]);
                $post_array[$i][2]=substr_count($post_element[$i-1],'&nbsp;');
            }
            $i++;
        }
        #Licznik shortcodow w petli
        $g_count = 0;
        #Licznik wyświetlonych elelemntow
        $p_count = 0;
        foreach($post_array as $elements_array){
                if($elements_array[0] == 'o'){
                    if($shortcode_display) {for($j = 1; $j<=$elements_array[2];$j++) echo "<br />";}
                    echo '<span class="'.$klasa.'-opis">'.$elements_array[1].'</span><br/>';
                }
                if($elements_array[0] == 'w') {
                    if($shortcode_display) {for($j = 1; $j<=$elements_array[2];$j++) echo "<br />";}
                    echo '<span class="'.$klasa.'-wyr">'.$elements_array[1].'</span><br/>';
                }
                if($elements_array[0] == 't') {
                    if($shortcode_display) {for($j = 1; $j<=$elements_array[2];$j++) echo "<br />";}
                    echo '<span class="'.$klasa.'-tekst">'.$elements_array[1].'</span><br/>';
                }
                if($elements_array[0] == 'gd' && $shortcode_display){
                    if($shortcode_display) {for($j = 1; $j<=$elements_array[2];$j++) echo "<br />";}
                    echo do_shortcode(str_replace(
                                '[gallery ids',
                                '[gallery itemtag="li" icontag="ul" captiontag="p" size="medium" link="file" ids',
                                $matches[0][$g_count]
                                ));
                    $g_count++;
                    }
                if($elements_array[0] == 'gm' && $shortcode_display) {
                    if($shortcode_display) {for($j = 1; $j<=$elements_array[2];$j++) echo "<br />";}
                    echo do_shortcode(str_replace(
                                '[gallery ids',
                                '[gallery itemtag="li" captiontag="p" icontag="p" size="thumbnail" link="file" ids',
                                $matches[0][$g_count]
                                ));
                    $g_count++;
                    }
                $p_count++;
                if($p_count >= $count_element && $count_element > 0) break;
            }
    }

    # Funkcja przeszukuje post pod katem shorcodow i zwraca galerie lub obrazek wyrózniający
    # 1 - zawartosc posta
    # 2 - ID artykulu
    # 3 - prefix klasy dla sekcji
    # 4 - ilosc wyswietlanych shortcodów galerii posta 0 - wszystkie
    # 5 - wlączenie lub wylaczenie shortcodow i obrazków
    function get_explode_shortcodes($content,$id,$klasa,$count_element=0,$shortcode_display=true)
    {
        # Sprawdzenie czy maja być wyswietlane shortcody i obrazki
        if($shortcode_display) {
            # Wyswietl obrazek wyrozniajacy jesli w poscie nie ma shortcodów
            if( ! has_shortcode( $content, 'gallery' ) ) {
                #Sprawdzenie czy istnieje obrazek wyrozniajacy.
                if(function_exists('has_post_thumbnail') && has_post_thumbnail( $id )) {
                     # wstawienie obrazka o okreslonej rozdzielczosci
                     # the_post_thumbnail( 'thumbnail' );       // Miniatura (default 150px x 150px max)
                     # the_post_thumbnail( 'medium' );          // Mała rozdzielczość (domyślnie 300px x 300px max)
                     # the_post_thumbnail( 'large' );           // Duza rozdzielczość  (domyślnie 640px x 640px max)
                     # the_post_thumbnail( 'full' );            // Pełna rozdzielcozść (Orginalny obrazek taki jak uploadowany)
                     $obrazekMediumArray =  wp_get_attachment_image_src( get_post_thumbnail_id( $id ),'medium',false );
                     $obrazekMediumUrl =  $obrazekMediumArray[0];
                     $obrazekLargeArray =  wp_get_attachment_image_src( get_post_thumbnail_id( $id ),'large',false );
                     $obrazekLargeUrl =  $obrazekLargeArray[0];
                     echo '
                         <a href="'.$obrazekLargeUrl.'" data-lightbox="roadtrip'.( $id ).'">
                         <img class="thumbnail" src="'.$obrazekMediumUrl.'" />
                         </a>';
                }else{
                   # Obrazek zastepczy gdy brak obrazka wyrozniajacego i galerii
                   /*
                    echo '
                         <a href="'.get_option('upload_path').'/mebel01-1024-683.jpg" data-lightbox="roadtrip'.( $id ).'">
                         <img class="thumbnail" src="'.get_option('upload_path').'/mebel01-300-200.jpg" />
                         </a>';
                    */
                    echo '';
                }
            # Jesli galeria jest dostepna wyswietl galerie
            }else{


            # Dodanie filtra dla do_shortcode() dodającego wpis data-lightbox
            add_filter('wp_get_attachment_link', 'lightbox_data');
            # Dodanie filtra dodającego clasę class="thumbnail" do obrazka galerii
            add_filter('wp_get_attachment_link', 'thumbnail_class');
            #Funckja zwracająca w tablicy $matches[0][x] wszystkie zdefiniowane shortcode w danym poscie.
            # Pobranie wszystkich zarejestrowanych shortcode w wordpress
            $pattern = get_shortcode_regex();
            # Zdefiniowanie tablicy
            $matches = array();
            # Zapisanie do tablicy wszystkich spełniających warunki shortcode
            preg_match_all("/$pattern/s", get_the_content(), $matches);
            #Licznik shortcodow w petli
            $g_count = 0;
            # Wyswietlanie galerii
            foreach($matches[0] as $elements_array){

                echo do_shortcode(str_replace(
                            '[gallery ids',
                            '[gallery itemtag="li" icontag="ul" captiontag="p" size="medium" link="file" ids',
                            $matches[0][$g_count]
                            ));
                if($g_count >= $count_element && $count_element > 0) break;
                $g_count++;
                }

            }
        }


    }

function  strip_shortcode_gallery( $content ) {
    preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
    if ( ! empty( $matches ) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'gallery' === $shortcode[2] ) {
                $pos = strpos( $content, $shortcode[0] );
                if ($pos !== false)
                    return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
            }
        }
    }
    return $content;
}

function pw_content_with_gallery_list() {

  global $post;

  // Make sure the post has a gallery in it
  if( ! has_shortcode( $post->post_content, 'gallery' ) )
    return $content;
  // Retrieve the first gallery in the post
  $gallery = get_post_gallery_images( $post );

  $image_list = '<ul class="slideshow">';

  // Loop through each image in each gallery
  foreach( $gallery as $image_url ) {
    $image_list .= '<li>' . '<img src="' . $image_url . '">' . '</li>';
  }
  $image_list .= '</ul>';

  // Append our image list to the content of our post
  $content = strip_shortcode_gallery(get_the_content());
  $content = $image_list . $content;
  return $content;
}
# usuniecie shortcodes z kontekstu
function remove_shortcode_from_index( $content ) {
  if ( is_home() ) {
    $content = strip_shortcodes( $content );
  }
  return $content;
}
# Funkcja rozbijajaca ciąg tekstowy z użyciem okreslonego znaku jako końca wiersza.
# Funkcja przypisuje poszczególnym składnikom poszczególne style $style(index)
# Zmienna $count wskazuje ile indeksów z rozbitego ciągu chcemy zobaczyć.
function get_explode_content ($content,$cStart,$cStop,$style,$separator){
    $content = str_replace('&nbsp;',' ',$content);
    $contentArray = explode($separator,$content);
    $contentReturn = '';
    for($i = $cStart; $i<=$cStop; $i++ )
    {
        $contentReturn .= '<span class="'.$style.$i.'">'.$contentArray[$i].'</span><br/>';
    }
    return $contentReturn;
}
# Funkcja zwracajaca fragment wpisu oraz ustalająca link do dalczej częsci ----------------------------------------------------------------
# Parametrem jest ilość słów do wyświetlenia
# Nalezy ostylować przycisk wiecej  - button-wiecej
function get_excerpt($limit ,$id){
      # Pobranie linka do danego artykułu
      $permalink = get_permalink($id);
      # utworzenie tablicy słów danego wpisu z limitem
      $excerpt = explode(' ', get_the_content(), $limit);
      # usunięcie wielokrotności kropek na końcu skrócenia
      $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
      # jezeli ilość słów dalej jest dluższa od limitu usuwamy ostatni element i dodajemy link do artykułu
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt);
        # Usuniecie tagów HTML z tekstu wpisu
        $excerpt = strip_tags($excerpt);
        # dodanie linku do artykułu
        $excerpt .='...';
      } else {
        # Jesli dlugosc artykulu ma mniej slow niz limit zwracamy calosc bez linka
        $excerpt = implode(" ",$excerpt);
        # Usuniecie tagów HTML z tekstu wpisu
        $excerpt = strip_tags($excerpt);
      }
      # usuwamy wszystkie shorcode np. ([gallery id="123" size="medium"]) z kodu wyświetlajać tylko sam tekst
      $excerpt = strip_shortcodes($excerpt);
      return $excerpt;
    }
# Dodawanie obsługi miniaturek ------------------------------------------------------------------------------------------------------------
# Ten wpis pozwoli nam przypisywać do danego wpisu ikone wpisu.
if(function_exists('add_theme_support'))
  add_theme_support('post-thumbnails');
# ustawienia miniatury obrazka
# set_post_thumbnail_size( 50, 50, array( 'top', 'left')  ); // 50px x 50px - obrazek przycinany od górnej i lewej strony.
# set_post_thumbnail_size( 50, 50, array( 'center', 'center')  ); // 50px x 50px - obrazek wycinany ze srodka.
//set_post_thumbnail_size(200,125,true);
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
  $content_width = 730; /* pixels */
}

/**
 * Set the content width for full width pages with no sidebar.
 */
function dazzling_content_width() {
  if ( is_page_template( 'page-fullwidth.php' ) || is_page_template( 'front-page.php' ) ) {
    global $content_width;
    $content_width = 1110; /* pixels */
  }
}
add_action( 'template_redirect', 'dazzling_content_width' );

if ( ! function_exists( 'dazzling_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dazzling_setup() {

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on Dazzling, use a find and replace
   * to change 'dazzling' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'dazzling', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );

  add_image_size( 'dazzling-featured', 730, 410, true );
  add_image_size( 'tab-small', 60, 60 , true); // Small Thumbnail

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary'      => __( 'Primary Menu', 'dazzling' ),
    'footer-links' => __( 'Footer Links', 'dazzling' ) // secondary menu in footer
  ) );

  // Enable support for Post Formats.
  add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

  // Setup the WordPress core custom background feature.
  add_theme_support( 'custom-background', apply_filters( 'dazzling_custom_background_args', array(
    'default-color' => 'ffffff',
    'default-image' => '',
  ) ) );

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support( 'title-tag' );
}
endif; // dazzling_setup
add_action( 'after_setup_theme', 'dazzling_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function dazzling_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Sidebar', 'dazzling' ),
    'id'            => 'sidebar-1',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
  register_sidebar(array(
    'id'            => 'home-widget-1',
    'name'          => __( 'Homepage Widget 1', 'dazzling' ),
    'description'   => __( 'Displays on the Home Page', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'home-widget-2',
    'name'          =>  __( 'Homepage Widget 2', 'dazzling' ),
    'description'   => __( 'Displays on the Home Page', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'home-widget-3',
    'name'          =>  __( 'Homepage Widget 3', 'dazzling' ),
    'description'   =>  __( 'Displays on the Home Page', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'footer-widget-1',
    'name'          =>  __( 'Footer Widget 1', 'dazzling' ),
    'description'   =>  __( 'Used for footer widget area', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'footer-widget-2',
    'name'          =>  __( 'Footer Widget 2', 'dazzling' ),
    'description'   =>  __( 'Used for footer widget area', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'footer-widget-3',
    'name'          =>  __( 'Footer Widget 3', 'dazzling' ),
    'description'   =>  __( 'Used for footer widget area', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));


  register_widget( 'dazzling_social_widget' );
  register_widget( 'dazzling_popular_posts_widget' );
}
add_action( 'widgets_init', 'dazzling_widgets_init' );

include(get_template_directory() . "/inc/widgets/widget-popular-posts.php");
include(get_template_directory() . "/inc/widgets/widget-social.php");


/**
 * Enqueue scripts and styles.
 */
function dazzling_scripts() {

  wp_enqueue_style( 'dazzling-bootstrap', get_template_directory_uri() . '/inc/css/bootstrap.min.css' );

  wp_enqueue_style( 'dazzling-icons', get_template_directory_uri().'/inc/css/font-awesome.min.css' );

  #if( ( is_home() || is_front_page() ) && of_get_option('dazzling_slider_checkbox') == 1 ) {
    wp_enqueue_style( 'flexslider-css', get_template_directory_uri().'/inc/css/flexslider.css' );
  #}

  if ( class_exists( 'jigoshop' ) ) { // Jigoshop specific styles loaded only when plugin is installed
    wp_enqueue_style( 'jigoshop-css', get_template_directory_uri().'/inc/css/jigoshop.css' );
  }

  wp_enqueue_style( 'dazzling-style', get_stylesheet_uri() );

  wp_enqueue_script('dazzling-bootstrapjs', get_template_directory_uri().'/inc/js/bootstrap.min.js', array('jquery') );

  #if( ( is_home() || is_front_page() ) && of_get_option('dazzling_slider_checkbox') == 1 ) {
    wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/inc/js/flexslider.min.js', array('jquery'), '2.5.0', true );
  #}

  wp_enqueue_script( 'dazzling-main', get_template_directory_uri() . '/inc/js/main.js', array('jquery'), '1.5.4', true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'dazzling_scripts' );

/**
 * Add HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries
 */
function dazzling_ie_support_header() {
  echo '<!--[if lt IE 9]>'. "\n";
  echo '<script src="' . esc_url( get_template_directory_uri() . '/inc/js/html5shiv.min.js' ) . '"></script>'. "\n";
  echo '<script src="' . esc_url( get_template_directory_uri() . '/inc/js/respond.min.js' ) . '"></script>'. "\n";
  echo '<![endif]-->'. "\n";
}
add_action( 'wp_head', 'dazzling_ie_support_header', 11 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom nav walker
 */
require get_template_directory() . '/inc/navwalker.php';

if ( class_exists( 'woocommerce' ) ) {
/**
 * WooCommerce related functions
 */
require get_template_directory() . '/inc/woo-setup.php';
}

if ( class_exists( 'jigoshop' ) ) {
/**
 * Jigoshop related functions
 */
require get_template_directory() . '/inc/jigoshop-setup.php';
}

/**
 * Metabox file load
 */
require get_template_directory() . '/inc/metaboxes.php';

/**
 * Register Social Icon menu
 */
add_action( 'init', 'register_social_menu' );

function register_social_menu() {
  register_nav_menu( 'social-menu', _x( 'Social Menu', 'nav menu location', 'dazzling' ) );
}

/* Globals variables */
global $options_categories;
$options_categories = array();
$options_categories_obj = get_categories();
foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
}

global $site_layout;
$site_layout = array('side-pull-left' => esc_html__('Right Sidebar', 'dazzling'),'side-pull-right' => esc_html__('Left Sidebar', 'dazzling'),'no-sidebar' => esc_html__('No Sidebar', 'dazzling'),'full-width' => esc_html__('Full Width', 'dazzling'));

// Typography Options
global $typography_options;
$typography_options = array(
        'sizes' => array( '6px' => '6px','10px' => '10px','12px' => '12px','14px' => '14px','15px' => '15px','16px' => '16px','18px'=> '18px','20px' => '20px','24px' => '24px','28px' => '28px','32px' => '32px','36px' => '36px','42px' => '42px','48px' => '48px' ),
        'faces' => array(
                'arial'          => 'Arial,Helvetica,sans-serif',
                'verdana'        => 'Verdana,Geneva,sans-serif',
                'trebuchet'      => 'Trebuchet,Helvetica,sans-serif',
                'georgia'        => 'Georgia,serif',
                'times'          => 'Times New Roman,Times, serif',
                'tahoma'         => 'Tahoma,Geneva,sans-serif',
                'Open Sans'      => 'Open Sans,sans-serif',
                'palatino'       => 'Palatino,serif',
                'helvetica'      => 'Helvetica,Arial,sans-serif',
                'helvetica-neue' => 'Helvetica Neue,Helvetica,Arial,sans-serif'
        ),
        'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
        'color'  => true
);

// Typography Defaults
global $typography_defaults;
$typography_defaults = array(
        'size'  => '14px',
        'face'  => 'helvetica-neue',
        'style' => 'normal',
        'color' => '#6B6B6B'
);

/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */
if ( ! function_exists( 'of_get_option' ) ) :
function of_get_option( $name, $default = false ) {

  $option_name = '';
  // Get option settings from database
  $options = get_option( 'dazzling' );

  // Return specific option
  if ( isset( $options[$name] ) ) {
    return $options[$name];
  }

  return $default;
}
endif;
