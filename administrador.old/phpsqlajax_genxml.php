<?php 
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require("../phpsqlinfo_dbinfo.php"); 

function parseToXML($htmlStr)  
{  
$xmlStr=str_replace('<','&lt;',$htmlStr);  
$xmlStr=str_replace('>','&gt;',$xmlStr);  
$xmlStr=str_replace('"','&quot;',$xmlStr);  
$xmlStr=str_replace("'",'&#39;',$xmlStr);  
$xmlStr=str_replace("&",'&amp;',$xmlStr);  
return $xmlStr;  
}

// Select all the rows in the colaboracao table 
$query = "SELECT * FROM colaboracao WHERE 1"; 
$result = mysql_query($query); 
if (!$result) { 
  die('Invalid query: ' . mysql_error()); 
}

// Start XML file, echo parent node
echo '<colaboracao>'; 

// Iterate through the rows, printing XML nodes for each 
while ($row = @mysql_fetch_assoc($result)){ 
  // ADD TO XML DOCUMENT NODE 
  echo '<marker '; 
  echo 'codColaboracao="' . parseToXML($row['codColaboracao']) . '" ';  
  echo 'numLatitude="' . $row['numLatitude'] . '" '; 
  echo 'numLongitude="' . $row['numLongitude'] . '" ';
  echo 'codTipoEvento_ID="' . $row['codTipoEvento'] . '" ';
  echo 'tipoStatus="' . parseToXML($row['tipoStatus']) . '" '; 
  echo '/>'; 
} 
 
// End XML file 
echo '</colaboracao>'; 

 
?>