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

$usser = $_GET['usser'];
$pass = $_GET['pass'];
$link = $_GET['permalink']; 
$title = $_GET['title'];


    if(function_exists(file_get_contents))
    {

     $abbrr_url =  file_get_contents("http://api.abbrr.com/api.php?out=link&url=" . $link);

    }else 
    {
        //Thanks to Horacio Bella http://granimpetu.com
        $api = "http://api.abbrr.com/api.php?url=";
        
        $apilink = "$api$link";
        
        // Read the XML file
        $xmldoc = domxml_open_file($apilink);
        $xpctx = $xmldoc->xpath_new_context();
        $result = xpath_eval($xpctx, 'link');
        foreach ($result->nodeset as $nodo) 
        {
        	$$abbrr_url = $nodo->get_content();
        }
    }

    $mensaje = $title.' '.$abbrr_url;



////////////////////////////////////////////////
/**********Posteando en Twitter****************/
function postToTwitter($username,$password,$message){

    $source = "twitterthis";
    $host = "http://twitter.com/statuses/update.xml?status=".urlencode(stripslashes(urldecode($message)))."&source=".$source;   
    $useragent="Twitter This http://www.artux.com.ar";
    
    $headers= array( 
    'X-Twitter-Client' =>  'Twitter This',
    'X-Twitter-Client-Version' =>  '1.0',
    'X-Twitter-Client-URL' => 'http://www.artux.com.ar/mytwitter/my-twitter.xml');


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);

   
    $result = curl_exec($ch);
    
    $resultArray = curl_getinfo($ch);

    curl_close($ch);


    if($resultArray['http_code'] == "200"){
        echo "Posteado en <a href=\"http://twitter.com/".$username."\">http://twitter.com/".$username."</a>";;
    } else {
        echo "Error en Twitter, intentelo luego";
    }
}

postToTwitter($usser,$pass,$mensaje);

?> 