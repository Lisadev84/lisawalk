 <?php
header('Content-Type: application/json; charset=utf-8');
$arr=array();
//Boucle sur tous les fichiers .gpx du dossier mymaps, on extrait le nom de fichier sans extension et transforme au format Json
foreach (glob("../mymaps/*.gpx") as $file) $arr[]=basename($file);
echo json_encode($arr);

?> 




