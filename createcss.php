<?php

//Creation du fichier CSS

function my_generate_css($images, $output)
{
    global $namefilecss;
    global $spritecss;
    global $padding;
    $width = 0; 
    $tablecss = "";
    fopen($namefilecss.".css", "w+");
    $cleansprite = pathinfo('fond.png');
    $namesprite = str_replace(".", "", $cleansprite['filename']);
    $css = ".sprite 
    {
        background-image: url(".$namesprite.".png);
        background-repeat: no-repeat;
        display: block;
    }";
    
    foreach ($images as $img)
    {
        $clearName = pathinfo($img);
        $imgName = str_replace(".", "", $clearName['filename']);
        $info = getimagesize("$img");
        $tablecss .= ".".$imgName . " {
            width: ".$info[0]."px;
            height: ".$info[1]."px;
            padding:".$padding."px;
            background-position: ". $width."px 0px;
        }\n\n";
        $width += $info[0];
    }
    $contentcss = $css. "\n\n". $tablecss;
    file_put_contents($output, $contentcss);
}
//----------- CSS avec redim ----------------
function my_generate_css_redim($images, $output)
{
    global $namefilecss;
    global $spritecss;
    global $padding;
    global $tailleOversize;
    $width = 0; 
    $tablecss = "";
    fopen($namefilecss.".css", "w+");
    $cleansprite = pathinfo('fond.png');
    $namesprite = str_replace(".", "", $cleansprite['filename']);
    $css = "
    .sprite     {
        background-image: url(".$namesprite.".png); 
        background-repeat: no-repeat;
        display: block;
    }";
    
    foreach ($images as $img)
    {
        $clearName = pathinfo($img);
        $imgName = str_replace(".", "", $clearName['filename']);
        $tablecss .= ".".$imgName . " {
            width: ".$tailleOversize."px; 
            height: ".$tailleOversize."px;
            padding:".$padding."px;
            background-position: ". $width."px 0px;
        }\n\n";
        $width += $info[0];
    }
    $contentcss = $css. "\n\n". $tablecss;
    file_put_contents($output, $contentcss);
}
?>
