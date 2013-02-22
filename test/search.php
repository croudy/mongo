<?php
ini_set( 'display_errors', 1 );

$label = array(
        'mode'   => "",
        'number' => "",
        'mail'   => "",
        'name'   => "",
        'date'   => "",
        'id'     => "",
        'body'   => "",
);
//var_dump($_REQUEST);

foreach( $label as $k => $v){
    //空じゃないならセットする
    if( !empty($_REQUEST[$k]) ){
        $label[$k] = $_REQUEST[$k];
    }
}
echo "<pre>";
echo "label:\n";
print_r($label);
echo "</pre>";

if( empty($label['mode']) ){
    display($label);
}

if( $label['mode'] == 'result' ){
    $where = array();
    foreach($label as $k => $v ){
        switch($k){
            case 'number':
            case 'mail':
            case 'name': 
            case 'date':
            case 'id':
                $where[] = array( $k => $v);
                break;

            case 'body':
                $where[] = array( 'body' => new MongoRegex("/$v/") );
                break;

            default:
                break;
        }
    }

    var_dump($where);
    exit;
    
    $mongo = new Mongo("ni:27017");
    $db = $mongo->ban;
    $collection = $db->keitai;

    $where = array( 'body' => new MongoRegex("/ソフトバンク/") );

       $result = $collection->find( $where );
       $i=0;
       foreach( $result as $doc ){
       var_dump($doc);
       }
     */
     display($label);
}

function display($label){
    $form = $label;
    include("template/index.html");
}
?>
