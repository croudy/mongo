<?php
$mysqli = new mysqli("ni", "toshiaki", "test", 'test' );
$mysqli->query("set names utf8");

$file_name = "sample.txt";
$label_1 = array( 'number', 'mail', 'name', 'date', 'id', 'body');
$label_2 = array( 'number', 'name', 'date', 'id', 'body');

$insert_sql = "insert into keitai (%s) values(%s)";
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
                $columns = implode(", ",array_keys($tmp));
                $escaped_values = array_map('addslashes', array_values($tmp));
                $quote_string = array_map('quote', array_values($escaped_values));
                $values  = implode(", ", $quote_string);
                $sql = sprintf($insert_sql, $columns, $values);
                $mysqli->query($sql);
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

function quote($value){
    return '"'. $value .'"';
}
