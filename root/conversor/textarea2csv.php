<?php 
class textarea_2_csv{
    var $arrLines;
    var $data;
    var $divider;
    function __construct($postedData){
        $this->arrLines = explode("\r\n",$postedData['xls']);
        $this->data = NULL;

    }
    // process the posted data
    function set_data(){
        if(is_array($this->arrLines)){
            if($this->divider == NULL) $this->set_divider(); // default divider setting if no other option is passed
            foreach($this->arrLines as $key=>$line){
                // if more than 1 field
                if(strpos($line, chr(9)) !== FALSE){
                    $arrFields = explode(',',$line);
                    foreach($arrFields as $c=>$val){
                        $this->data .= $val.$this->divider;
                    }
                    $this->data = str_replace(' ', '', $this->data);
                    $this->data = trim($this->data,$this->divider);
                    $this->data .= "\r\n";
                    
                }
                // if only 1 field
                else{
                    $arrFields = explode(chr(9),$line);
                    foreach($arrFields as $c=>$val){
                        $this->data .= $val.$this->divider;
                    }
                    $this->data = str_replace(' ', '', $this->data);
                    $this->data = trim($this->data,$this->divider);
                    $this->data .= "\r\n";
                    //$this->data .= $line."\r\n";
                }
            }       
        }
    }
    // saves the data as file or returns it back
    function save_data($write = false){
        $this->set_data();
        if(!$write == false){

            // write file (.txt if divider is tab)
            ($this->divider == chr(9)) ? $ext = '.txt' : $ext = '.csv';
            if(file_put_contents($write.$ext, $this->data)) echo('<h3>Dados salvos no arquivo: '.$write.$ext.'</h3>');
            return(NULL);
        }
        else{
            // return de data
            return($this->data);
        }

    }   
    // set the divider as default to a comma
    function set_divider($opt=','){
        $this->divider = $opt;
    }

}