<?php

//------------- Fonction pour redimensionner les images -----------
function redimension($image)
{ 
    global $tailleOversize;

$imgredim = imagecreatetruecolor($tailleOversize, $tailleOversize); // On crée la miniature vide


imagecopyresampled($imgredim, $image, 0, 0, 0, 0, imagesx($imgredim), imagesy($imgredim), imagesx($image), imagesy($image));
imagesavealpha($imgredim, true);
$color = imagecolorallocatealpha($imgredim, 0, 0, 0, 127);
imagefill($imgredim, 0, 0, $color);
return $imgredim;
}

//---- Prendre toutes les images du dossier passer en paramètre ------
function my_scandir_perso($folder)
{
    $files = array();
    if($dir = opendir($folder))
    {
        $i = 0;
        while(false !== ($file = readdir($dir)))
        {
            if($file !== "." && $file !== "..")
            {
                if(is_file($folder."/".$file) && exif_imagetype($folder ."/".$file) == IMAGETYPE_PNG)
                {
                    $files[$i] = $folder ."/".$file;
                    $i++;
                }
            }
        }
        closedir($dir);
        return $files;
    }
    else 
    {
        return false;
    }
}

//-------------------- Recursive -----------------------

function my_scandir_perso_recursive($folder) 
{
    $files = array();
    $dir=opendir($folder);
    while($file = readdir($dir)) 
    {
        if($file == '.' || $file == '..') 
            continue;
        if(is_dir($folder.'/'.$file)) 
        {
            $files = array_merge($files, my_scandir_perso_recursive($folder.'/'.$file));
        } 
        else 
        {
            if(is_file($folder."/".$file) && exif_imagetype($folder ."/".$file) == IMAGETYPE_PNG)
            {
                $files[] = $folder.'/'.$file;
            }
        }
    }
    closedir($dir);
    return $files;
}

?>
