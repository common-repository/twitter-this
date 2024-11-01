<?php

// Twitter This
//
// Copyright (c) 2007 Andres Scheffer
// http://www.artux.com.ar
//
// This is an add-on for WordPress
// http://wordpress.org/
//
// **********************************************************************
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
//( at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// ERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
// Online: http://www.gnu.org/licenses/gpl.txt

// *****************************************************************

/*
Plugin Name: Twitter This 
Plugin URI: http://www.artux.com.ar/wordpress/plugins/
Description: Mejor que compartir es compartir con Twitter, Twitter This.
Version: 1.0
Author: Andres Artux Scheffer
Author URI: http://www.artux.com.ar/

*/

@define('TTWP_SHOWICON', true);
//Combiar TTWP_SHOWICON a false para poder poner el icono manualmente en el loop.


////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
////////////No Necesitas Editar esta Parte/////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

   
           
       add_filter('the_content', 'tt_display_hook');
       add_filter('the_excerpt', 'tt_display_hook');
                	
    function tt_display_hook($content='') {		
                    
       $doit = false;
        if (is_feed()) {
             $doit = false;
            }
        else if (TTWP_SHOWICON) {
              $doit = true;
            }
                    
        if ($doit) {
              $content .= twitter_this();
            }
                
         return $content;
                
      }
     



	function twitter_this() {
		
    	$tt_url= '' . get_bloginfo('siteurl') . '/wp-content/plugins/twitter-this';
    	$html = "";	
    	global $wp_query; 
    	$post = $wp_query->post;
    	$id = $post->ID;
    	$permalink = get_permalink($post->ID);
    	$title = $post->post_title;
    	
        $html .= "<div class=\"twitter-this\">";
    	$html .= "<a class=\"showform\" href=\"javascript:none('$id')\" id=\"a$id\" onclick=\"mosform('$id');\" title=\"Compartelo con Twitter\">Twitter This</a>\n";
    	$html .= "<div id=\"form$id\" style=\"display:none\">\n";
    	$html .= "<form class=\"formtwit\" id=\"myForm$id\" action=\"$tt_url/post_to_twitter.php\" method=\"get\">\n";
    	$html .= "Usuario: <input class=\"ttinput\" type=\"text\" name=\"usser\" />\n ";
        $html .= "Password: <input class=\"ttinput\" type=\"password\" name=\"pass\" />\n ";
        $html .= "<input type=\"hidden\" name=\"title\" value=\"$title\" />\n ";
        $html .= "<input type=\"hidden\" name=\"permalink\" value=\"$permalink\" />\n ";
        $html .= "<input type=\"submit\" value=\"&raquo;\" />\n ";
        $html .= "<img id=\"loader$id\" src=\"$tt_url/ajax-loader.gif\" alt=\"cargando...\" />\n ";
    	$html .= "</form></div></div>";
    
    	return $html;
    }
    	
    	
	function tt_add() {
		echo '<link type="text/css" href="' . get_bloginfo('siteurl') . '/wp-content/plugins/twitter-this/tt_style.css" rel="stylesheet" />' . "\n";
		echo '<script src="' . get_bloginfo('siteurl') . '/wp-content/plugins/twitter-this/jquery.js" type="text/javascript"></script>' . "\n";
		echo '<script src="' . get_bloginfo('siteurl') . '/wp-content/plugins/twitter-this/formtwit.js" type="text/javascript"></script>' . "\n";
		echo '<script src="' . get_bloginfo('siteurl') . '/wp-content/plugins/twitter-this/tt_effects.js" type="text/javascript"></script>' . "\n";
	}

	add_action('wp_head', 'tt_add');
    	
?>