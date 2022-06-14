<?
$cpt = 5000;
if(file_exists($fichier)) {
   $inF = fopen($fichier,"r");
   $cpt = intval(trim(fgets($inF, 4096))) + 1; 
   fclose($inF); 
}

$inF = fopen($fichier,"w");
fputs($inF,$cpt."\n"); 
fclose($inF);
?>
