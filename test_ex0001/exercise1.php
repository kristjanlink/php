<?php
  $depthCounter = 0;
  
  function getAllChildren($rowsArray, $nodeId, $depthCounter) {
	$depthCounter = $depthCounter + 1;
	foreach ($rowsArray as $reIteratedRow) {
		if ($reIteratedRow[1] == $nodeId) { //If the current parent_id matches the node_id being looked for
			echo str_repeat("-", $depthCounter) . " "; //Adds padding based on tree depth using the $depthCounter variable
			echo "$reIteratedRow[2]\n";
			getAllChildren($rowsArray, $reIteratedRow[0], $depthCounter);
		}
	}
  }
  
  $fileName = readline("Please enter filename: "); //Readline does not work in Windows CLI!
  $fileContents = file_get_contents($fileName);
  $rows = explode(PHP_EOL, $fileContents); //Split the file contents into an array where each row is an array element
  foreach ($rows as &$row) {
    $row = explode("|", $row); //Split each row into node_id, parent_id and node_name
  }
  unset($row); //Destroy the variable to reuse it in the next loop, otherwise the output will be wrong
  array_multisort($rows); //Orders the multi-dimensional array "$rows" by node_id
  foreach ($rows as $row) {
	  if ($row[1] == 0) { //If parent_id is 0 then it's a top-level parent
		  echo "$row[2]\n";
		  getAllChildren($rows, $row[0], $depthCounter); //Recursive function to find all children
	  }
  }
?>
