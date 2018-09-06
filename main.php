<?php

// Lit le fichier path dans une chaine
$file = file_get_contents('path.txt');

// Convertit string en array bidimensionnel
$mapArray = explode("\n", $file);
//var_dump($mapArray);

// Length $mapArray
$lengthRow = count($mapArray);
$lengthCol = strlen($mapArray[0]);

///////////////////////////////////////////////////////
//  Vérification des Rows
///////////////////////////////////////////////////////
function verifMap($mapArray, $lengthRow, $lengthCol) {
    // Length dernière ligne
    $lengthColLast = strlen($mapArray[$lengthRow-1]);

    // On vérifie si les 2 rows sont identiques
    if ($lengthColLast != $lengthCol) {
        return 0;
    }

    // On verifie si les rows sont constituées de # 
    $i=0;$j=0;
    while ($j < $lengthRow) {
        $i=0;
        while ($i < $lengthCol) {
            if(($mapArray[$j][$i]) != "#") {
                //echo "error à j : $j, i : $i \n";
                return 0;
            }
            $i++;
        }
        $j += $lengthRow - 1;
        //echo "$j \n";
    } 

    // On verifie si les cols sont constituées de # 
    $i=0;$j=0;
    while ($j < $lengthRow) {
        $i=0;
        while ($i < $lengthCol) {
            if(($mapArray[$j][$i]) != "#") {
                //echo "error à j : $j, i : $i \n";
                return 0;
            }
            $i += $lengthCol -1;
        }
        $j++;
        //echo "$j \n";
    } 
}

///////////////////////////////////////////////////////
//  Vérification de la présence des valeurs 0 et 1
///////////////////////////////////////////////////////
function valStartEnd($mapArray, $lengthRow, $lengthCol) {
    $i = 0; 
    $j = 0;
    $count0 = 0;
    $count1 = 0;
    while($j < $lengthRow) {
        $i = 0;
        while ($i < $lengthCol) {
            if( ($mapArray[$j][$i]) == "0" ) {
                $count0++;
                $pos0 = array($j,$i);
                //echo "count : $count0\n";
            } else if( ($mapArray[$j][$i]) == "1" ) {
                $count1++;
                $pos1 = array($j,$i);
                //echo "count : $count1\n";
            }
            $i++;
        }
        $j++;
    }
    if ($count0 != 1)
        return 0;
    if ($count1 != 1)
        return 0;

    $pos = array($pos0, $pos1);

    return $pos;
}

///////////////////////////////////////////////////////
//  Vérification de la faisabilité d'aller de 0 à 1
///////////////////////////////////////////////////////
function playOk($mapArray, $lengthRow, $lengthCol, $pos) {
    //echo "lengthRow $lengthRow   lengthCol $lengthCol".PHP_EOL;
    $i = 1;
    $j = 1;
    $snake = 1;

    while (($j < $lengthRow) AND ($i < $lengthCol)) {
    //while (($mapArray[$j][$i]) != "1") {


        //$sonarJ = ($lengthRow - 2) - $j;
        //$sonarI = ($lengthCol - 2) - $i;
        $turnRight = 0;

        $sJ = $j;
        $nbrTile = 0;
        while ($mapArray[$sJ+1][$i] != "#") {
            $nbrTile++;
            $sJ++;
        }

        //echo "nbrTile = $nbrTile".PHP_EOL;
        $sJ = $j;
        $finalJ = $nbrTile + $j;
        $countRight = 0;
        $c = 0;
        while ($c < $nbrTile) {
           
            if ( ($mapArray[$sJ+1][$i] != "#") && ($mapArray[$sJ+1][$i] != "1") && ($mapArray[$sJ+1][$i+1] == "#") && ($mapArray[$sJ+1][$i-1] == "#") ){
                $countRight++;
                //echo "sj = $sJ / c = $c / j = $j / countRight = $countRight / true".PHP_EOL;
            } else {
                //echo "sj = $sJ / c = $c / j = $j / countRight = $countRight / false".PHP_EOL;
            }
            $sJ++;
            $c++;
        }

        if ( ($countRight == $nbrTile) && ($nbrTile != 0) ){
            //echo "TurnRight : j = $j, i = $i".PHP_EOL;
            $turnRight = 1;
        }

        if ( (($snake % 2) == 0) || ($turnRight == 1) ){
            $turnRight = 0;
            if ( (($mapArray[$j][$i+1]) == "#") OR (($mapArray[$j][$i+1]) == ".")){
                if ( (($mapArray[$j+1][$i]) == "#") OR (($mapArray[$j+1][$i]) == ".")){
                    if ( (($mapArray[$j-1][$i]) == "#") OR (($mapArray[$j-1][$i]) == ".")){
                        if ( (($mapArray[$j][$i-1]) == "#") OR (($mapArray[$j][$i-1]) == ".")){         
                            //echo "chemin impossible A !!!".PHP_EOL;
                            return;
                        }
                        else {
                            $i--;
                            //echo "0A\n";
                            //echo "j=$j et i=$i\n";
                            $snake++;
                        }
                    }
                    else {
                        $j--;
                        //echo "1\n";
                        //echo "j=$j et i=$i\n";
                        $snake++;
                    }
                } else {
                    $j++;
                    //echo "2\n";
                    //echo "j=$j et i=$i\n";
                    $snake++;
                }
            } 
            else {
                $i++;
                //echo "3\n";
                //echo "j=$j et i=$i\n";
                $snake++;
            }
        } 
        else {
            if ( (($mapArray[$j+1][$i]) == "#") OR (($mapArray[$j+1][$i]) == ".")){
                if ( (($mapArray[$j][$i+1]) == "#") OR (($mapArray[$j][$i+1])  == ".")){
                    if ( (($mapArray[$j-1][$i]) == "#") OR (($mapArray[$j-1][$i]) == ".")){
                        if ( (($mapArray[$j][$i-1]) == "#") OR (($mapArray[$j][$i-1]) == ".")){
                            //echo "chemin impossible B !!!".PHP_EOL;
                            return;
                        }
                        else {
                            $i--;
                            //echo "0B\n";
                            //echo "j=$j et i=$i\n";
                            $snake++;
                        }
                    }
                    else {
                        $j--;
                        //echo "4\n";
                        //echo "j=$j et i=$i\n";
                        $snake++;
                    }
                } else {
                    $i++;
                    //echo "5\n";
                    //echo "j=$j et i=$i\n";
                    $snake++;
                }
            } 
            else {
                $j++;
                //echo "6\n";
                //echo "j=$j et i=$i\n";
                $snake++;
            }
        }

        if (($mapArray[$j][$i]) == "1") {
            $display = implode("\n", $mapArray);
            echo $display.PHP_EOL;
            return;
        } 
        else if (($mapArray[$j][$i]) != "#") {
            $mapArray[$j][$i] = ".";
        }
        else {
            //echo "error";
            return;
        }
    }
}

// Vérification des contours en # et de la forme rectangle
if ((verifMap($mapArray, $lengthRow, $lengthCol)) === 0) {
    echo "Erreur dans le contour du rectangle !".PHP_EOL;
}
// Vérification de la présence des valeurs 0 et 1
if ((valStartEnd($mapArray, $lengthRow, $lengthCol)) === 0) {
    echo "Erreur dans la présence d'un 0 et/ou d'un 1 !".PHP_EOL;
}
// Vérification de la faisabilité d'aller de 0 à 1
$pos = valStartEnd($mapArray, $lengthRow, $lengthCol);
//var_dump($pos);
playOk($mapArray, $lengthRow, $lengthCol, $pos);


