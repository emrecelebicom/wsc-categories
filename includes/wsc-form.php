<?php

function wsc_form()
{
    $content = '<form action="" method="post">';
    $content .= '<label for="wsc_header">Başlık</label><input type="text" id="wsc_header" name="wsc_header" value="'.$wsc_header.'" />';
    $content .= '<button type="submit" name="submit_scripts_update">Kaydet</button>';
    $content .= "</form>";

    echo $content;
}