
<?php

/**
 * @author upi
 * @copyright 2016
 */

function noDokumen(){
$nodok="FRM-GMR-08-01-01, Rev.0";
return $nodok;

}

function get_month_list(){
	  $bulan = array( "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"
	  				);
	  return $bulan;
}
function hariIni($hari2){
 //$hari2=date("w");
    Switch ($hari2){
    case 0 : $hari="Minggu";
    Break;
    case 1 : $hari="Senin";
    Break;
    case 2 : $hari="Selasa";
    Break;
    case 3 : $hari="Rabu";
    Break;
    case 4 : $hari="Kamis";
    Break;
    case 5 : $hari="Jumat";
    Break;
    case 6 : $hari="Sabtu";
    Break;
    }
    
    return $hari;
}

//$tglini=date('Y-m-d');



	function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}	

	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 
			
	function bulan($bulan)
{
Switch ($bulan){
    case 1 : $bulan="Januari";
        Break;
    case 2 : $bulan="Februari";
        Break;
    case 3 : $bulan="Maret";
        Break;
    case 4 : $bulan="April";
        Break;
    case 5 : $bulan="Mei";
        Break;
    case 6 : $bulan="Juni";
        Break;
    case 7 : $bulan="Juli";
        Break;
    case 8 : $bulan="Agustus";
        Break;
    case 9 : $bulan="September";
        Break;
    case 10 : $bulan="Oktober";
        Break;
    case 11 : $bulan="November";
        Break;
    case 12 : $bulan="Desember";
        Break;
    }
return $bulan;
}	
			
			
			
			
function rupiah($nominal){
    $rupiah =  number_format($nominal,0, ",",".");
    $rupiah = " "  . $rupiah . "";
	 return $rupiah;
	 } 

function rupiah1($nominal){
    $rupiah =  number_format($nominal,0, ",",".");
    $rupiah = ""  . $rupiah . "";
	 return $rupiah;
	 } 
	 
	 
function Terbilang($x)
{
  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  if ($x < 12)
	if($abil[$x] == "") return $abil[$x];
    else return $abil[$x]." ";
  elseif ($x < 20)
    return Terbilang($x - 10) . " Belas ";
  elseif ($x < 100)
    return Terbilang($x / 10) . " Puluh " . Terbilang($x % 10);
  elseif ($x < 200)
    return " Seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " Ratus " . Terbilang($x % 100);
  elseif ($x < 2000)
    return " Seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " Ribu " . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " Juta  " . Terbilang($x % 1000000);
}

function haritanggal($tgl){
$sepparator ='-';
        $parts = explode($sepparator, $tgl);
        $d = date("l", mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
 
        if ($d=='Monday'){
            return 'Senin';
        }elseif($d=='Tuesday'){
            return 'Selasa';
        }elseif($d=='Wednesday'){
            return 'Rabu';
        }elseif($d=='Thursday'){
            return 'Kamis';
        }elseif($d=='Friday'){
            return 'Jumat';
        }elseif($d=='Saturday'){
            return 'Sabtu';
        }elseif($d=='Sunday'){
            return 'Minggu';
        }else{
            return 'ERROR!';
        }
}


function bulanIndo($bulan){
	 switch ($bulan){
	  case 1 : 
	  $bulan="Januari";
	   break; case 2 : 
	   $bulan="Februari";
	    break; case 3 :
		 $bulan="Maret";
		  break; case 4 :
		   $bulan="April"; 
		   break; case 5 :
		    $bulan="Mei";
			break; case 6 : 
			$bulan="Juni"; 
			break; case 7 :
			 $bulan="Juli"; 
			 break; case 8 : 
			 $bulan="Agustus"; 
			 break; case 9 :
			 $bulan="September";
			  break; case 10 :
			   $bulan="Oktober"; 
			   break; case 11 : 
			   $bulan="November"; 
			   break; case 12 :
			    $bulan="Desember"; 
				break;
				 } return $bulan; 

}

?>