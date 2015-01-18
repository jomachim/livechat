<?php

function display_remote_html($url){
	$response = wp_remote_get($url);
    $body = wp_remote_retrieve_body($response);
    echo $body;
}

function is_online($url){
    $response = wp_remote_get($url);
    $code=wp_remote_retrieve_response_code($response);
    if($code==""){
        $img='<img src="'.plugin_dir_url( __FILE__ ) .'offline.png" width="16" height="16"/>';
        echo $img;
        return false;
    }else{
        $img='<img src="'.plugin_dir_url( __FILE__ ) .'online.png" width="16" height="16"/>';
        echo $img;
        return true;
    }
    
}


