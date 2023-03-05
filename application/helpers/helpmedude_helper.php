<?php

function thick($x,$y){
	
	if($x===$y){
		return "v";
	}else{
		return "";
	}
	
}

function DateNull($dateParam, $date){
	$dDate = strtotime($date);
	if($dDate == false){
		return '';
	}else{
		return date($dateParam, $dDate);
	}
		
}

// function nvl(@$phar, $ret = ''){
	// if (is_array($phar) or ($phar instanceof Traversable)){
		// return 'ERROR: this variable is ARRAY !!';
	// }
	// return (isset($phar) == false ? $phar : $ret);
// }

if (!function_exists('NVL')){
    function NVL(&$var, $default = "")
    {
		if (is_array($var) or ($var instanceof Traversable)){
			return 'ERROR: this variable is ARRAY !!';
		}
        return isset($var) ? $var
                           : $default;
    }
}

if (!function_exists('dataReturn')){
    function dataReturn($var, &$data)
    {
		while (current($var[0])) {
			$text = key($var[0]);
			
			$data[$text] = $var[0]->$text;
			
			next($var[0]);
		}
		
    return $data;
    }
}

if (!function_exists('mPdfCreate')){
 function mPdfCreate($data, $viewName, $createName) {
	$obj =& get_instance();
        $html = $obj->load->view('cetak/' . $viewName, $data, true);

        $obj->pdf->pdf_create($html, $createName, true);
    }
}
?>