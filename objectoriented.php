<?php
/*
****************************************************************
* This program of Object Oriuented Php code demonstrates 
* an implementation of a Hash Table
****************************************************************
*
* First instantiate  the HashTable object which builds
* a fixed array to use as the hash table

* In this case the constructor also loads string data into the
* hash table. The string itself is used for hash key generation. 
*
* Noite: In some use cases after Php Ver. 7 standard arrays perform 
* just as well See function hashTable() for use of a standard array; 
*/
$ht = new HashTable();
/*
* Now we add some key value pairs to the hash table with a pulic method
*/
$ht->addEntry('9775551212','Bob Collins');
$ht->addEntry('8888','Ed Eight');
$ht->addEntry('7777','Steve Seven');

/*
* Below are a set of tests
* 2 Find a value in the table by its Key
* 2 look for a string in a stored entry value
*/
$key = 'Bob Collins';
echo "Test 1, Find a Key in Hash Table. Key: ".$key."\n";
echo "Find Key: ".$key." Returned: ".$ht->findKey($key)."\n\n";

$key = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
echo "Test 2, Find a Key in Hash Table. Key: ".$key."\n";
echo "Find Key: ".$key." Returned: ".$ht->findKey($key)."\n\n";

$key = 'Lorem';
echo "Test 3, Find a String in Hash Table. String: ".$key."\n";
echo "Find String: ".$key." Returned: ".$ht->findString($key)."\n\n";

$key = '9775551212';
echo "Test 4, Find a String in Hash Table. String: ".$key."\n";
echo "Find String: ".$key." Returned: ".$ht->findString($key)."\n\n";

/*
* ----- functions used to implement the hash table below
*       are in the class below
*/

class HashTable {
    public $hashTable;

    public function __construct(){
        /*
        *     Allocate a fixed array and fill it with dummy data   
        */    
        $this->hashTable = new SplFixedArray(255);
        foreach($this->dummyData() as $line) {
            $this->addEntry($line);
        }
    }


    public function findString($string) {
        /*
        *  Return a stored values which contain search string
        */
            $found = "";
            foreach ($this->hashTable as $hashedKey => $entry) {
        
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
        
        


    public function findKey($key) {
    /*
    *  Return a stored value based on a key search
    */
        $hashedKey = $this->hashKey($key);
        $entry = $this->hashTable[$hashedKey];
    
        if(empty($entry)) {
            return "No Value for ".$key;
        } elseif(is_array($entry)) {
            $return = "";
            foreach ($entry as $item) {
                if (is_array($item)) {
                  //  print_r($item);
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

    public function addEntry($strng,$eKey=Null) {
        /*
        * Add an entry to the hash table. 
        * Key Value pairs are preserved
        * Values without keys are stored using a hash key derieved
        * from the value 
        */    
            $hKey = $this->hashKey(empty($eKey)?$strng:$eKey);
            $data = empty($eKey)?$strng:array($eKey => $strng);
        
            if($this->hashTable[$hKey] == Null) {
                $this->hashTable[$hKey] = array($data);       
            } else {
                $entries = $this->hashTable[$hKey];
                $entries[] = $data;
                $this->hashTable[$hKey] = $entries;  
            }
        
            return true;
        
        }       
    
    private function hashKey($string) {
        /*
        * Return a Hash key based on the ASCII value of a chracter
        * in an MD5 has of a key string
        */    
            return ord(substr(md5($string),5,1));
        
        }

    private function dummyData(){
        /*
        * This function returns an array of string based on the 
        * period seporator
        */
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
        
}




