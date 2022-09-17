<?php

function wsc_header_menu() {

    /*
    if(array_key_exists('submit_scripts_update', $_POST)){
       update_option('wsc_header', $_POST['wsc_header']);
       echo "Kaydedildi.";
    }
 
    $wsc_header = get_option('wsc_header', 'none');
    */

    $menu_items = [
        ['title' => 'ABOUT', 'uri' => 'about'],
        ['title' => 'SETTINGS', 'uri' => 'settings'],
        ['title' => 'PRO<span>!</span>', 'uri' => 'pro'],
    ];
	
    echo "<ul class=\"wsc_menu\">";
    
    foreach($menu_items as $item){
        echo "<li><a href=\"\">".$item['title']."</a></li>";
    }

    echo "</ul>";
}
