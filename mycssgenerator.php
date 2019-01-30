<?php
require 'imagecopy.php';
require 'redim_and_scan.php';
require 'createcss.php';


$DOC = end($argv);
$shortopt = "ri:s:o:p:";
$longopt = array("recursive", "output-image:", "output-style:", "padding:", "override-size:");
$option = getopt($shortopt, $longopt);
$namefilecss = "main";
$namefilesprite = "sprite";
$tailleOversize = 0;
$padding = 0;
$tempsprite;
$spritecss;
$temp = [];
$pattern = array(".png", ".jpeg", ".jpg", ".css");
$options = array("-r", "-i", "-s", "-o", "-p", "--recursive", "--output-image", "--output-style", "--padding", "--override-size");

// variables pour les noms de fonction selon les options passées en ligne de commande
$create_img = "my_create_png";
$scan = "my_scandir_perso";
$generatecss = "my_generate_css";


// Si le dossier n'en est pas un ou n'existe pas
if(file_exists($DOC) == false)
{
	echo "Il faut un dossier pour l'exécution du script.\n";
	return false;
}


//Pour le man
if($argv[1] == "help")
{ 
	echo "Il vous faut un dossier image en fin de ligne de commande. Sinon cela ne fonctionnera pas !
	Voici les options disponibles :
	-r OU --recursive : pour récupérer les images du dossier et des sous dossiers.
	---------------
	-i OU --output-image : pour donner un nom à votre image. Il n'est pas obligatoire de mettre le .png. Par défaut, celle-ci s'appellera sprite.png
	---------------
	-s OU --output-style : pour donner un nom à votre fihier css. Il n'est pas obligatoire de mettre le .css. Par défaut, celui-ci s'appellera main.css
	---------------
	-o OU --override-size : pour redimensionner vos images. Il suffit d'entrer un entier.
	---------------
	-p OU --padding : pour insérer une légère marge entre chaque image. Il suffit d'entrer un entier.\n";
	return false;
}

//Si tout va bien... Avec des options
if(file_exists($DOC) && $argv[1] != "help")
{
	for($i = 1; $i < $argc -1 ; $i++)
	{	
		if($argv[$i][0] == "-" && !in_array($argv[$i], $options))
		{
			echo $argv[$i] . " N'est pas une bonne option.
			En cas de souci, n'hésitez pas à consulter le man en tapant : php [nom du script] help [votre dossier]\n";
			return false;
		}
		else
		{ 
			switch($argv[$i])
			{
				case "-r":
				case '--recursive':
				$scan = "my_scandir_perso_recursive";
				continue;
// POUR LE NOM DE L'IMAGE

				case '-i':
				$namefilesprite = str_replace($pattern, "", $option['i']);
				continue;

				case '--output-image':
				$namefilesprite = str_replace($pattern, "", $option['output-image']);
				continue;

// POUR LE NOM DU FICHIER CSS 
				case '-s':
				$namefilecss = str_replace($pattern, "", $option['s']);
				continue;

				case '--output-style':
				$namefilecss = str_replace($pattern, "", $option['output-style']);;
				continue;

// POUR LE PADDING 
				case '-p':
				if(is_numeric(intval($option['p'])) == true && isset($option['p'])) 
				{ 
					$padding = $option['p'];
				}
				if(is_numeric($option['p']) == false)
				{
					echo $argv[$i] . " a besoin d'une valeur. Numérique, de préférence.
					En cas de souci, n'hésitez pas à consulter le man en tapant : php [nom du script] help [votre dossier]\n";
					return false;
				}		
				continue;

				case '--padding':
				if(is_numeric(intval($option['padding'])) == true && isset($option['padding'])) 
				{ 
					$padding = $option['padding'];
				}
				if(is_numeric($option['padding']) == false)
				{
					echo $argv[$i] . " a besoin d'une valeur. Numérique, de préférence.
					En cas de souci, n'hésitez pas à consulter le man en tapant : php [nom du script] help [votre dossier]\n";
					return false;
				}		
				continue;

// POUR LA REDIMENSION 
				case '-o': 
				if(is_numeric(intval($option['o'])) == true && isset($option['o'])) 
				{ 
					$tailleOversize = $option['o'];
					$create_img = "my_create_png_redim";
					$generatecss = "my_generate_css_redim";
				}
				if(is_numeric($option['o']) == false)
				{
					echo $argv[$i] . " a besoin d'une valeur. Numérique, de préférence.
					En cas de souci, n'hésitez pas à consulter le man en tapant : php [nom du script] help [votre dossier]\n";
					return false;
				}
				continue;

				case '--override-size': 
				if(is_numeric(intval($option['override-size'])) == true && isset($option['override-size'])) 
				{ 
					$tailleOversize = $option['override-size'];
					$create_img = "my_create_png_redim";
					$generatecss = "my_generate_css_redim";
				}
				if(is_numeric($option['override-size']) == false)
				{
					echo $argv[$i] . " a besoin d'une valeur. Numérique, de préférence.
					En cas de souci, n'hésitez pas à consulter le man en tapant : php [nom du script] help [votre dossier]\n";
					return false;
				}
				continue;
				
			}
		}
	}

	$temp = ($scan($DOC));
	$temp2 = $create_img($temp);
	$tempsprite = my_create_image_sprite($temp2);
	my_merge_image($temp2,$tempsprite);
	$generatecss($temp, $namefilecss.".css");
}  

// S'il n'y a que le dossier d'image
if($argv[1] == $DOC && file_exists($DOC))
{
	$temp = ($scan($DOC));
	$temp2 = $create_img($temp);
	$tempsprite = my_create_image_sprite($temp2);
	my_merge_image($temp2,$tempsprite);
	$generatecss($temp, $namefilecss.".css");
}

?>


