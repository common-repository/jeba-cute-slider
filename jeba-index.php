<?php
/*
Plugin Name: Jeba Cute Slider
Plugin URI: http://prowpexpert.com/jeba-cute-slider
Description: This is Jeba cute wordpress slider plugin really looking awesome sliding. Everyone can use the cute slider plugin easily like other wordpress plugin. Here everyone can slide image from post, page or other custom post. Also can use slide from every category. By using [jeba_slider] shortcode use the slider every where post, page and template.
Author: Md Jahed
Version: 1.0
Author URI: http://prowpexpert.com/
*/
function jeba_wp_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'jeba_wp_latest_jquery');

function plugin_function_jeba() {
    wp_enqueue_script( 'jeba-js', plugins_url( '/js/jssor.core.js', __FILE__ ), true);
    wp_enqueue_script( 'jeba-cute-js', plugins_url( '/js/jssor.slider.js', __FILE__ ), true);
    wp_enqueue_script( 'jebacute-js', plugins_url( '/js/jssor.utils.js', __FILE__ ), true);
    wp_enqueue_style( 'jeba-css', plugins_url( '/js/jeba_style.css', __FILE__ ));
}

add_action('init','plugin_function_jeba');
function jeba_script_function () {?>
	<script type="text/javascript">
		jssor_slider1_starter = function (containerId) {
            var options = {
                $AutoPlay: true,
                $AutoPlaySteps: 1,
                $AutoPlayInterval: 4000,
                $PauseOnHover: 1,
                $ArrowKeyNavigation: true,
                $SlideDuration: 500,
                $MinDragOffsetToSlide: 20,
                $SlideSpacing: 5,
                $DisplayPieces: 1,
                $ParkingPosition: 0,
                $UISearchMode: 1,
                $PlayOrientation: 1,
                $DragOrientation: 3,
                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,
                    $ChanceToShow: 2,

                    $Loop: 2,
                    $AutoCenter: 3,
                    $Lanes: 1,
                    $SpacingX: 4,
                    $SpacingY: 4,
                    $DisplayPieces: 4,
                    $ParkingPosition: 0,
                    $Orientation: 2,
                    $DisableDrag: false 
                }
            };

            var jssor_slider1 = new $JssorSlider$(containerId, options);
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    var sliderWidth = parentWidth;
                    sliderWidth = Math.min(sliderWidth, 810);

                    jssor_slider1.$SetScaleWidth(sliderWidth);
                }
                else
                    $JssorUtils$.$Delay(ScaleSlider, 30);
            }

            ScaleSlider();
            $JssorUtils$.$AddEvent(window, "load", ScaleSlider);


            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $JssorUtils$.$OnWindowResize(window, ScaleSlider);
            }
        };
	</script>
	

<?php
}
add_action('wp_head','jeba_script_function');

function jeba_slider_shortcode($atts){
	extract( shortcode_atts( array(
		'category' => '',
		'post_type' => 'jeba-items',
		'count' => '5',
	), $atts) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => $post_type, 'category_name' => $category)
        );		
		
		$plugins_url = plugins_url();
		
	$list = '    <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 810px; height: 300px; background: #000; overflow: hidden; ">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(' . plugins_url( 'js/loading.gif' , __FILE__ ) . ') no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 600px; height: 300px;
            overflow: hidden;">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$jeba_img_large = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large-portfolio' );
		$jeba_img_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb-portfolio' );
		
		$list .= '
		
			<div>
                <img u="image" src="'.$jeba_img_large[0].'" />
                <div u="thumb">
                    <img class="i" src="'.$jeba_img_thumb[0].'" /><div class="t">'.get_the_title().'</div>
                    <div class="c">'.get_the_excerpt().'</div>
                </div>
            </div>
		
		';        
	endwhile;
	$list.= '</div>
        
        <!-- ThumbnailNavigator Skin Begin -->
        <div u="thumbnavigator" class="jssort11" style="position: absolute; width: 200px; height: 300px; left:605px; top:0px;">
            <!-- Thumbnail Item Skin Begin -->
            
            <div u="slides" style="cursor: move;">
                <div u="prototype" class="p" style="position: absolute; width: 200px; height: 69px; top: 0; left: 0;">
                    <thumbnailtemplate style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></thumbnailtemplate>
                </div>
            </div>
        </div>
    </div>';
	wp_reset_query();
	return $list;
}
add_shortcode('jeba_slider', 'jeba_slider_shortcode');



add_action( 'init', 'jeba_siler_custom_post' );
function jeba_siler_custom_post() {

	register_post_type( 'jeba-items',
		array(
			'labels' => array(
				'name' => __( 'JebaSliders' ),
				'singular_name' => __( 'JebaSlider' )
			),
			'public' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'jeba-slider'),
			'taxonomies' => array('category', 'post_tag') 
		)
	);	
	}

function jeba_plugin_function () {?>
        <script type="text/javascript">
                jssor_slider1_starter('slider1_container');  
        </script>
		
<?php
}


 
// Hooks your functions into the correct filters
function jeba_add_mce_button() {
// check user permissions
if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
return;
}
// check if WYSIWYG is enabled
if ( 'true' == get_user_option( 'rich_editing' ) ) {
add_filter( 'mce_external_plugins', 'jeba_add_tinymce_plugin' );
add_filter( 'mce_buttons', 'jeba_register_mce_button' );
}
}
add_action('admin_head', 'jeba_add_mce_button');
 
// Declare script for new button
function jeba_add_tinymce_plugin( $plugin_array ) {
$plugin_array['jeba_slider_button'] = plugins_url('/js/tinymce-button.js', __FILE__ );
return $plugin_array;
}
 
// Register new button in the editor
function jeba_register_mce_button( $buttons ) {
array_push( $buttons, 'jeba_slider_button' );
return $buttons;
}




add_action('wp_footer','jeba_plugin_function');

add_theme_support( 'post-thumbnails', array( 'post', 'jeba-items' ) );

add_image_size( 'large-portfolio', 600, 300, true );
add_image_size( 'thumb-portfolio', 60, 35, true );
?>