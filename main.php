<?php



$hashTable = new SplFixedArray(255);
/*
* In some use cases after Php Ver. 7 standard arrays perform just as well 
* $hashTable = hashTable(); // build has table with stdanard  arry
*/

foreach(dummyData() as $line) {
    addEntry($hashTable,$line);
}

addEntry($hashTable,'9724629700','jim sproul');

// print_r($hashTable);

$key = 'jim sproul';
echo "Test 1, Find a Key in Hash Table. Key: ".$key."\n";
echo "Find Key: ".$key." Returned: ".findKey($hashTable, $key)."\n\n";

$key = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
echo "Test 2, Find a Key in Hash Table. Key: ".$key."\n";
echo "Find Key: ".$key." Returned: ".findKey($hashTable, $key)."\n\n";

$key = 'Lorem';
echo "Test 3, Find a String in Hash Table. String: ".$key."\n";
echo "Find String: ".$key." Returned: ".findString($hashTable, $key)."\n\n";

$key = '9724629700';
echo "Test 4, Find a String in Hash Table. String: ".$key."\n";
echo "Find String: ".$key." Returned: ".findString($hashTable, $key)."\n\n";

function findKey(&$hashT, $key) {

    $hashedKey = hashKey($key);
    $entry = $hashT[$hashedKey];

    if(empty($entry)) {
        return "No Value for ".$key;
    } elseif(is_array($entry)) {
        $return = "";
        foreach ($entry as $item) {
            if (is_array($item)) {
                $return .= $item[$key]." foudnd in bucket ".$hashedKey;
            } else {
                if ($key == $item) {
                    $return .= $item." foudnd in bucket ".$hashedKey;;                 
                };
            }
        }
        return $return;
    } 
    
}

function findString(&$hashT, $string) {
    $found = "";
    foreach ($hashT as $hashedKey => $entry) {

        if (is_array($entry)) {
            foreach ($entry as $item) {
                    if (is_array($item)) {
        
                        $bucketNumber = array_search($string, $item);
                        if ($bucketNumber) {
                              $found .= "\n".$string." foudnd in bucket:slot ".$hashedKey.":[".$bucketNumber."]\n";
                        } 
        
                    } elseif (stristr($item,$string)) {
        
                        $found .=  "\nFound in string ".$item." -- bucket ".$hashedKey."\n";               
        
                    }
            }

        }
    } 
    return $found;
}

function hashKey($string) {

    return ord(substr(md5($string),5,1));

}

function hashTable() {
    
    $size = 255;
    $arr = array();

    for($i=0;$i<$size;$i++) {
        $arr[] = null;
    }

    return $arr;

}

function addEntry(&$hT,$strng,$eKey=Null) {

 //   $newKey = empty($eKey)?$strng:$eKey;
    $hKey = hashKey(empty($eKey)?$strng:$eKey);
    $data = empty($eKey)?$strng:array($eKey => $strng);

    if($hT[$hKey] == Null) {
        $hT[$hKey] = array($data);       
    } else {
        $entries = $hT[$hKey];
        $entries[] = $data;
        $hT[$hKey] = $entries;  
    }

    return true;

}

function dummyData(){

     $loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
     Phasellus quis posuere urna. Integer dapibus augue id lorem vestibulum, 
     in ullamcorper elit vestibulum. Vivamus nisl mauris, dapibus at diam quis, 
     volutpat tempus odio. Integer porttitor scelerisque vehicula. Pellentesque 
     commodo tristique augue a elementum. Pellentesque bibendum feugiat odio 
     sodales hendrerit. Curabitur tortor diam, viverra quis odio vel, tempus 
     imperdiet nulla. Morbi cursus pretium orci, ac feugiat orci faucibus id. 
     Suspendisse sed porta risus, quis accumsan nulla. Phasellus ut leo est. 
     Mauris aliquet sem et nibh aliquet tincidunt. Curabitur auctor elementum 
     leo id malesuada. Duis blandit lacinia libero a sodales. Curabitur metus 
     ante, maximus ac pretium sed, vestibulum quis odio. Sed vestibulum enim 
     et lectus pellentesque dignissim. Cras vel metus dapibus, cursus 
     ligula eu, faucibus arcu. Aliquam sit amet ipsum gravida metus egestas 
     facilisis in nec nisi. Vivamus a ex efficitur, suscipit est non, 
     auctor justo. Vivamus sollicitudin orci libero, vitae placerat mi pretium 
     eu. Morbi dapibus eleifend vestibulum. Sed venenatis in tellus in consequat. 
     Proin vel magna sodales, euismod quam non, faucibus nisi. Etiam lobortis 
     commodo massa a consectetur. In ultrices tristique hendrerit. 
     Nunc leo nisl, aliquam eu aliquet sed, consectetur non diam. 
     Nullam nec justo et lacus mattis feugiat.Nullam non ultrices sem, 
     quis feugiat lorem. Vestibulum tempor odio a porttitor rutrum. 
     Vestibulum bibendum lobortis convallis. Proin tempor eros at nisl aliquet, 
     vel lacinia nulla porttitor. Donec semper ornare orci vel ultricies. 
     Cras lectus nisl, consectetur eget metus nec, luctus facilisis libero. 
     Cras ipsum libero, rhoncus in vulputate vitae, vehicula eu tellus. Proin 
     dignissim, mi ut viverra condimentum, lectus est condimentum mi, ut suscipit 
     felis sapien vitae nisi. Pellentesque habitant morbi tristique senectus et 
     netus et malesuada fames ac turpis egestas. Suspendisse eget leo at ex 
     scelerisque venenatis. Phasellus quis metus felis. Donec euismod varius 
     sodales. Vestibulum vel nisi ac ligula blandit commodo";

     return explode(".",$loremIpsum);

    }
