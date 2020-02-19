<?php

namespace App\Http\Middleware\Psmid;

use Closure;

class Csvconverte
{
    public $file;
    protected $enclosure;
    protected $array;
    protected $item;
    protected $key;
    protected $string;
    protected $csv_string;
    protected $delimiters;
    protected $delimiter;
    protected $count;
    protected $lines;
    protected $line;
    protected $head;
    protected $csv;
    protected $codifica;
    protected $num;
    protected $csv_en;
    protected $csv_it;
    protected $i;

    




    //public $enclosure;
   
    public function __construct($file) {
        $this->file = $file;
       
    } 

    private function utf8_converter($array) {
        
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }
    // para saber qual a codificação do arquivo
    private function codificacao($string) {
        return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
    }
    
    //declarando a função identificar delimitadores

    private function detect_delimiter($csv_string) {
        $delimiters = array(';' => 0,"\t" => 0,"|" => 0);
        foreach ($delimiters as $delimiter => &$count) {
            $count = substr_count($csv_string,$delimiter);
            }
        return array_search(max($delimiters), $delimiters);
    }

    //declarando a função para carregar o CSV
    //function import_csv_to_array($file,$enclosure = '"') {
    public function getimport_csv_to_array() { 
        $file = $this->file; 
        $enclosure = '"'; 
        
        $csv_string = file_get_contents($file);
        //$delimiter = detect_delimiter($csv_string);
        $delimiter = $this->detect_delimiter($csv_string);
        $lines = explode("\n", $csv_string);
        $head = str_getcsv(array_shift($lines),$delimiter,$enclosure);
        $head = $this->utf8_converter($head);  
        $array = array();
        foreach ($lines as $line) {
            if(empty($line)) {
            continue;
            }
        $csv = $line;
        $codifica = $this->codificacao($csv);
        $csv = explode(';',$csv);
        if($codifica !== 'UTF-8') {
            $num = count($csv);
            $csv_en = array();
            for($i = 0; $i < $num; $i++){
                $csv_it = $this->utf8_encode($csv[$i]);
                array_push($csv_en,$csv_it);
                }
            $csv = $csv_en;
            }    
        // Combine the header and the lines data
        $array[] = array_combine( $head, $csv );  
        }
         
    return $array;
    } 
    /*
    public function getarray(){
        $this->array = $array;
        dd($array);
    } */
}
