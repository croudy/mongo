<?php
$mongo = new Mongo("ni:27017");
$db = $mongo->ban;
$collection = $db->keitai;

$file_name = "sample.txt";
$label_1 = array( 'number', 'mail', 'name', 'date', 'id', 'body');
$label_2 = array( 'number', 'name', 'date', 'id', 'body');
if(is_file($file_name)){ 
    $text = fopen($file_name,'r'); 
    for($line = 1; !feof($text); $line++){ 
        $lines = fgets($text);
        if($lines){
            $label = $label_1;
            preg_match('~<dt>([0-9]+) ：<a href="mailto:([a-zA-Z0-9]+)"><b>(.*)</b></a>：(.*) ID:(.*)<dd> (.*)<br><br>~', $lines, $matches);
            if( empty($matches) ){
                $label = $label_2;
                preg_match('~<dt>([0-9]+) ：<font color=green><b>(.*)</b></font>：(.*) ID:(.*)<dd> (.*)<br><br>~', $lines, $matches);
            }
            array_shift($matches);
            $tmp = array();
            foreach( $matches as $key => $value ){
                $tmp[$label[$key]] = $value;

                if( $label[$key] == 'body' ){
                    $value = preg_replace("/<br>/", "\n", $value);
                    $tmp[$label[$key]] = $value;
                }
            }
            if( !empty($tmp) ){
                $collection->insert($tmp);
            }
        }
    }
    /*
    $res = $collection->find();
    foreach( $res as $doc ){
        print_r($doc);
    }
    */
    fclose($text);
}
?>
