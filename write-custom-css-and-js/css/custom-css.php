<?php
header("Content-type: text/css");
$custom_css = get_option('wccj_settings');
$custom_css = wp_kses( $custom_css['wccj_main_custom_style'], array( '\'', '\"' ) );
$custom_css = str_replace ( '&gt;' , '>' , $custom_css );
echo $custom_css;
?>