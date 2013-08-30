<?php
	function GetTodaysQuote()
	{
		$day = date("d");
		$month = date("m");
		$year = date("Y"); 

		$sql = mysql_query("SELECT q.* FROM control AS c,quotation AS q WHERE c.month = '$month' AND c.day = '$day' AND c.year = '$year' AND q.id = c.control_num");
		$control = mysql_fetch_array($sql, MYSQL_ASSOC);
		return $control;
	}

	function Get_Rand()
	{
		$MaxID = mysql_query("SELECT MAX(id) FROM `quotation`");
		$MaxID = mysql_fetch_array($MaxID, MYSQL_BOTH);

		$MinID = mysql_query("SELECT MIN(id) FROM `quotation`");
		$MinID = mysql_fetch_array($MinID, MYSQL_BOTH);

		$MinID = $MinID[0];
		$MaxID = $MaxID[0];


		//Now we want something random between the id ranges!
		$random_id = mt_rand($MinID , $MaxID );

		$sql = mysql_query("SELECT q.* FROM quotation AS q WHERE q.id = $random_id");
		$random = mysql_fetch_array($sql, MYSQL_ASSOC);

		return $random;
	}

	function Get_Authors()
	{
		$authors = array();
		
		$sql = mysql_query("select distinct author FROM quotation");
		while($row =  mysql_fetch_array($sql, MYSQL_ASSOC)) {
			array_push($authors, $row);
		}
		
		return $authors;
	}

	$con = mysql_connect("localhost", "quotation", "r8yYZwLa") or die(mysql_error());
	mysql_select_db("quotation") or die(mysql_error());

	$mode = $_GET['m'];
	if ($mode == 'todays_quote') {
		header('Content-type: text/javascript');
	//	var_dump(GetTodaysQuote());
		echo json_encode(GetTodaysQuote());
	} else if($mode == 'rand') {
		header('Content-type: text/javascript');
		echo json_encode(Get_Rand());
	} else if($mode == 'authors') {
		header('Content-type: text/javascript');
		echo json_encode(Get_Authors());
		
	} else {
		echo "Invalid Command\n";
	}

	

?>
