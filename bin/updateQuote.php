<?php

function Get_New_Quote()
{
	//Lets get me some Date!
	$day = date("d");
	$month = date("m");
	$year = date("Y"); 

	$date = date("m-d-Y");
	//echo "System Date: $month - $day - $year";



	//First we fetch the highest and lowest ids. (The Range)


	$MaxID = mysql_query("SELECT MAX(id) FROM `quotation`");
	$MaxID = mysql_fetch_array($MaxID, MYSQL_BOTH);

	$MinID = mysql_query("SELECT MIN(id) FROM `quotation`");
	$MinID = mysql_fetch_array($MinID, MYSQL_BOTH);

	$MinID = $MinID[0];
	$MaxID = $MaxID[0];
	echo "Max: $MaxID <br>";
	echo "Min: $MinID";


	//Now we want something random between the id ranges!
	$random = mt_rand($MinID , $MaxID );
	echo "Random ID is: $random";

	//REplaced on 7-20-10 original code is: $sql = mysql_query("SELECT 
	//control_num FROM control WHERE month = '$month'");
	$sql = mysql_query("SELECT control_num FROM control WHERE month = '$month' AND year='$year'");
	//Now store all values into an array.
	$num=mysql_numrows($sql);
	//Go through and store all of the rows in an array
	//echo "number is $num";

	$i=0;
	while ($i < $num) {

	$control_Array[$i] =mysql_result($sql,$i,"control_num");
	echo $control_Array[$i];
	$i++;
	}

	//Now that we have an array lets make sure random != that array.


	$j=0;
	while($j<$num)
	{

		//Lets see if we have any previous matches for this random # if so then re get the array.
		if($random == $control_Array[$j])
		{
			Get_New_Quote();
			// I believe we are becoming recursive here. (6-27-10) Add this break to prevent recursion.
			return 0;
			//This might break the site. Break from teh while loop
		} else { 
			//this means quote was accepted
		}

		$j++;

	}


	//alright this quote is legit Process it Biiiatch



	if (! mysql_query("INSERT INTO control (control_num,Month,Year,day) VALUES ('$random','$month','$year','$day')"))
	{
		die('Error on Query-- Quote Generation');
	}

}
//Connect Batman!

$con = mysql_connect("localhost", "quotation", "r8yYZwLa") or die(mysql_error());
mysql_select_db("quotation") or die(mysql_error());
echo "Connected Successfully to SQL Server\n";

$day = date("d");
$month = date("m");
$year = date("Y"); 

$date = date("m-d-Y");

$sql = mysql_query("SELECT * FROM site_data");

//I was too lazy to remove i from the query so I just set it to 0.
$i = 0;
$site_day = mysql_result($sql,$i,"day");
$site_month = mysql_result($sql,$i,"month");
$site_year = mysql_result($sql,$i,"year");
echo "Today's Date is $date, the site's date is $site_month - $site_day - $site_year\n";

if(($day == $site_day) && ($month == $site_month) && ($year == $site_year)){
	echo "The site is currently up to date. Not running any updates\n\n\n";

} else {
	echo "The site has not been updated with today's quotes.. preparing to update\n";
	Get_New_Quote();

	//update the table with the last update date.

	if (! mysql_query("UPDATE site_data SET month='$month', day='$day', year='$year'")) 
	 {
		 die(mysql_error());

	 }
	echo "Run Completed with an update\n\n\n";

}
?>
