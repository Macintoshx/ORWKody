<?php // kod wykorzystywany w kontrolerze API (wersja demonstracyjna, testowa),
// Zawarte klasy, np. AppWeather, to modele wygenerowane z bazy danych przy uzyciu Gii
// Jest to czesc implementacji REST API z dozwolona jedynie operacja GET (tylko pobieranie danych)
public function actionIndex($start = 0, $from = "", $to = "", $pretty = false, $chart = false)
{
	$command = AppWeather::find();

	$command->where("ID >= $start");

	if ($from != "")
	{
		if ($this->checkIsAValidDate($from))
		{
			$dat = new DateTime($from);
			$startD = $dat->format("Y-m-d H:i:s");
			if ($to == "")
			{
				$dat->add(new \DateInterval('P1D'));
				$stopD = $dat->format("Y-m-d H:i:s");
			}
			else
			{
				$dat = new DateTime($to);
				$stopD = $dat->format("Y-m-d H:i:s");
			}
			$command->andWhere(['and', "Date>='$startD'", "Date<='$stopD'"]);
		}
		else
		{
			//error
		}
	}
	if ($to != "" && $from == "")
	{
		if ($this->checkIsAValidDate($to))
		{
			$dat = new DateTime($to);
			$stopD = $dat->format("Y-m-d H:i:s");
			$command->andWhere("Date<='$stopD'");
		}
		else
		{
			//error
		}
	}

	$command = $command->all();

	$arr = [];

	if(!$chart)
	{
		foreach ($command as $var)
		{
			$ar = [];
			$ar['ID'] = $var['ID'];
			$ar['Date'] = $var['Date'];
			$ar['Value'] = $var['Value'];
			$arr[] = $ar;
		}
		$this->setHeader(200);
		if($pretty)
		{
			echo json_encode($arr, JSON_PRETTY_PRINT);
		}
		else
		{
			echo json_encode($arr);
		}
	}
	else
	{
		$arr = [];
		foreach($command as $var)
		{
			$ar = [];
			$ar[] = (new \DateTime($var["Date"]))->getTimestamp()*1000;
			$ar[] = (float)$var['Value'];
			$arr[] = $ar;
		}
		$this->setHeader(200);
		if($pretty)
		{
			echo json_encode($arr, JSON_PRETTY_PRINT);
		}
		else
		{
			echo json_encode($arr);
		}
	}



}