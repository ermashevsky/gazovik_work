<?php
include "libs/FluentPDO/FluentPDO.php";
  $pdo = new PDO("mysql:dbname=GazovikDB", "root", "11235813");
  $fpdo = new FluentPDO($pdo);

function transCode($code){
    switch ($code) {
case I:
    return "Входящий";
case O:
    return "Исходящий";
case T:
    return "Входящий переведенный";
}
}

  $query = $fpdo->from('cdr')
            ->select('internal_number, call_date, call_time, duration, call_type, dst, src')
            ->where("call_type", array("I"))
            //->where("internal_number", "4100")
            ->orderBy('id DESC');

$output .= '{ "aaData": [';
$n = 1;
foreach($query as $row) {
    //print json_encode($row);
    //$arr[] = $row;
    $output .=  '["'.$n++.'","'.$row[internal_number].'","'.$row[call_date].'","'.$row[call_time].'","'.$row[duration].'","'.transCode($row[call_type]).'","'.$row[src].'","'.$row[dst].'"],';
}
$output = substr_replace($output ,"",-1);
$output .= '] }';
echo $output;

//echo json_encode($output, JSON_FORCE_OBJECT);
?>
