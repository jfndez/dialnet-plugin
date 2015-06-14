<?php
/**
 * @package Dialnet Searcher
 * @version 0.1
 */
/*
Plugin Name: Dialnet Searcher
Description: Widget que inserta un buscador en Dialnet
Author: José Fernández
Version: 0.1
Author URI: http://www.jose-fernandez.com.es/
License: GPLv3
*/


// Creating the widget dialnet
class dialnet_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'dialnet_widget', 

// Widget name will appear in UI
__('Buscar en Dialnet', 'dialnet_widget_domain'), 

// Widget description
array( 'description' => __( 'Widget que inserta un buscador avanzado en Dialnet', 'dialnet_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// Content dialnet
$dialnetsearcher = '
			<form formtarget="_blank" role="search" method="get" id="searchform" action="http://dialnet.unirioja.es/buscar/documentos">
  				<select name="filtros.DOCUMENTAL_FACET_ENTIDAD" id="filtro" >
					<option selected disabled>B&uacute;squeda general</option>
					<option id="Artículo de revista"  value="artrev">Art&iacute;culo de revista</option>
					<option id="Artlib" value="artlib">Art&iacute;culo de libro</option>
					<option id="Tesis" value="tes">Tesis</option>
					<option id="Libro" value="lib">Libro</option>
  				</select>
			<br><input style="border-width:2px; width:200px" type="text" name="querysDismax.DOCUMENTAL_TODO" value="" id="query" placeholder="Buscar en Dialnet..." /><br>
			<input formtarget="_blank" type="submit" value="Buscar"/> 
			</form>	
	
	';

echo __( $dialnetsearcher , 'dialnet_widget_domain' );
}


// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Buscar en Dialnet', 'dialnet_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class dialnet_widget ends here

// Register and load the widget
function dialnet_load_widget() {
	register_widget( 'dialnet_widget' );
}
add_action( 'widgets_init', 'dialnet_load_widget' );

?>
