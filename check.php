<?php

// Informacje o rozkodowaniu numeru pesel znalazłem na stronie:
// https://www.infor.pl/prawo/gmina/dowod-osobisty/262172,Co-mozna-wyczytac-z-numeru-PESEL.html


$pesel = $_POST['pesel']; //pobranie wartosci z formularza html
//$pesel = 25280755754; // przykladowy pesel do sprawdzenia

//funkcja pobierająca pojedynczą cyfrę z numeru pesel indeksowaną od jeden

function GetPESEL($id, $pesel)
{
	$indeks = 11 - $id; // sprawia, że indeksuje od lewej strony rosnąco
	$pesel_id = floor($pesel / pow(10,$indeks));
	$result = $pesel_id % 10;
	return $result;
}

// pobranie cyfr z numeru pesel do tablicy w celu optymalizacji kodu
for($i=1 ; $i<12 ; $i++)
{
  $id[$i] = GetPESEL($i,$pesel);
}


//cyfra o id 10(cyfry 0, 2, 4, 6, 8 oznaczają płeć żeńską. Z kolei cyfry 1, 3, 5, 7, 9 oznaczają płeć męską)

if ($id[10] % 2 == 0)
{
	$sex = "kobieta";
} else {
$sex = "mezczyzna";
}


//okreslanie roku urodzenia
$year_pesel = floor($pesel / pow(10,9));
$month_pesel = $id[3].$id[4];

if ($month_pesel >= 21) 
{
	$month = $month_pesel - 20; // redukuje roznice w miesiacach dla ludzi urodzonych po 1999 roku
	$year = $year_pesel + 2000; // oblicza rok urodzenia
} else
{
	$month = $month_pesel;
	$year = $year_pesel + 1900; //
}


	




// walidacja numeru pesel
$check_sum = 1*$id[1] + 3*$id[2] + 7*$id[3] + 9*$id[4] + 1*$id[5] + 3*$id[6] + 7*$id[7] + 9*$id[8] + 1*$id[9] + 3*$id[10];

$check = 10 - ($check_sum % 10);

if ($check == $id[11]) 
{
	$check_result = " PESEL jest prawidlowy ";
} else
{
	$check_result = " PESEL jest nieprawidlowy ";
}


echo "Walidacja : " .$check_result;
echo "<br> Rok urodzenia : " .$year;
echo "<br> Miesiac urodzenia : " .$month;
echo "<br> Dzien urodzenia : " .$id[5].$id[6];
echo "<br> Plec : " .$sex;




?>