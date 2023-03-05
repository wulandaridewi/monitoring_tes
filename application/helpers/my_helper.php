<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function print_recursive_list($data) {
    $str = "";
    foreach ($data as $list) {
        $subchild = print_recursive_list($list['child']);
        if ($subchild != '') {
            $str .= '<li>';
            $str.= '<a href="' . site_url($list["link"]) . '" id="id_a_menu_' . $list['id'] . '">';
            $str.= $list['nama'] . '<span class="arrow "></span></a>'; //anchor($list['link'],$list['nama']) //'<i class="icon-list"></i>&nbsp;' .
            $str .= '<ul class="sub-menu">';
            $subchild = print_recursive_list($list['child']);
            $str .= $subchild;
            $str .= '</ul>';
            $str .= '</li>';
        } else {
            $str .= '<li>';
            $str.= '<a href="' . site_url($list["link"]) . '" id="id_a_menu_' . $list['id'] . '">';
            $str.= $list['nama'] . '</a>'; //anchor($list['link'],$list['nama']) //'<i class="icon-list"></i>&nbsp;' .
            $subchild = print_recursive_list($list['child']);
            $str .= $subchild;
            $str .= '</li>';
        }
    }
    return $str;
}


function print_recursive_menu_all_li($data){
    $str = "";
    foreach($data as $list){
		$subchild = print_recursive_menu_all_li($list['child']);
		if ($subchild != '') {
                $str .= '<li id = "' . $list['id'] . "_" . $list['parent'] . '">';
                $str .= '<a href="" id = "a' . $list['id'] . "_" . $list['parent'] . '" >';
                $str .= $list['nama'] . '</a>'; //anchor($list['link'],$list['nama'])
                $str .= '<ul>';
                $subchild = print_recursive_menu_all_li($list['child']);
                $str .= $subchild;
                $str .= '</ul>';

                $str .= '</li>';
            } else {
                $str .= '<li id = "' . $list['id'] . "_" . $list['parent'] . '">';
                $str .= '<a href="" id = "a' . $list['id'] . "_" . $list['parent'] . '" >';
                $str .= $list['nama'] . '</a>'; //anchor($list['link'],$list['nama'])
                $subchild =print_recursive_menu_all_li($list['child']);
                $str .= $subchild;
                $str .= '</li>';
            }

    }
    return $str;
}
function konfigurasi_menu($data){
    $str = "";
    foreach($data as $list){
		$subchild = print_recursive_menu_all_li($list['child']);
		if($subchild != ''){
            $str .= '<li id = "'.$list['id'].'">'; //$str .= '<li id = "'.$list['id']."_".$list['parent'].'">';
			$str.= '<a href="" id = "a'.$list['id'].'" >'; 
			$str.=$list['nama'].'</a>';//anchor($list['link'],$list['nama'])
			$str .= '<ul>';
			$subchild = print_recursive_menu_all_li($list['child']);
			$str .= $subchild;
			$str .= '</ul>';
			
        	$str .= '</li>';
		}else{
			$str .= '<li id = "'.$list['id'].'">';
			$str.= '<a href="" id = "a'.$list['id'].'" >'; 
			$str.=$list['nama'].'</a>';//anchor($list['link'],$list['nama'])
			$subchild = print_recursive_menu_all_li($list['child']);
			$str .= $subchild;
        	$str .= '</li>';
		}

    }
    return $str;
}

function print_recursive_secMenuUser($data) {
    $str = "";
    foreach ($data as $list) {
        $subchild = print_recursive_secMenuUser($list['child']);
        if ($subchild != '') {
            $str .= '<li id = "' . $list['id'] . '">';
            $str.= '<a href="" id = "a' . $list['id'] . '" attrMenuUri = "' . $list['link'] . '">';
            $str.=$list['nama'] . '</a>'; //anchor($list['link'],$list['nama'])
            $str .= '<ul>';
            $subchild = print_recursive_secMenuUser($list['child']);
            $str .= $subchild;
            $str .= '</ul>';

            $str .= '</li>';
        } else {
            $str .= '<li id = "' . $list['id'] . '">';
            $str.= '<a href="" id = "a' . $list['id'] . '" attrMenuUri = "' . $list['link'] . '">';
            $str.=$list['nama'] . '</a>'; //anchor($list['link'],$list['nama'])
            $subchild = print_recursive_secMenuUser($list['child']);
            $str .= $subchild;
            $str .= '</li>';
        }
    }
    return $str;
}



function lap_rusunall($data) {
    $str = "";
    $i = 1;
    foreach ($data as $list) {

        if ($list['jml_row'] == 0) {

            $str .= '<tr>';
            $str .= '<td colspan="6" align="center">Tidak ada rusun di lantai ini.</td>';
            $str .= '</tr>';
        } else {
            $str .= '<tr>';
            $str .= '<td>' . $i . '</td>';
            $str .= '<td>' . $list['id_room'] . '</td>';
            $str .= '<td>' . $list['nama_room'] . '</td>';
            $str .= '<td>' . $list['no_kamar'] . '</td>';
            $str .= '<td>' . $list['nama_tipeharga'] . '</td>';
            $str .= '<td>' . $list['status_sewa'] . '</td>';
            $str .= '</tr>';
        }
        $i++;
    }
    return $str;
}

function lap($data) {
    $str = "";
    $i = 1;
    $jml100 = 0;
    $jml110 = 0;
    $jml200 = 0;
    $jml210 = 0;
    foreach ($data as $list) {

        if ($list['jml_row'] == 0) {

            $str .= '<tr>';
            $str .= '<td colspan="7" align="center">Storage ini belum ada histori keluar masuk produk.</td>';
            $str .= '</tr>';
        } else {
            $str .= '<tr>';
            $str .= '<td>' . $i . '</td>';
            $str .= '<td>' . $list['nama_produk'] . '</td>';
            $str .= '<td>' . $list['tgl_trans'] . '</td>';

            if ($list['kode_trans'] == '100') {
                $str .= '<td align="right">' . number_format($list['qty_kg'], 2) . '</td>';
                $str .= '<td></td>';
                $str .= '<td></td>';
                $str .= '<td></td>';
                $jml100 = $jml100 + $list['qty_kg'];
            } elseif ($list['kode_trans'] == '110') {
                $str .= '<td></td>';
                $str .= '<td align="right">' . number_format($list['qty_kg'], 2) . '</td>';
                $str .= '<td></td>';
                $str .= '<td></td>';
                $jml110 = $jml110 + $list['qty_kg'];
            } elseif ($list['kode_trans'] == '200') {
                $str .= '<td></td>';
                $str .= '<td></td>';
                $str .= '<td align="right">' . number_format($list['qty_kg'], 2) . '</td>';
                $str .= '<td></td>';
                $jml200 = $jml200 + $list['qty_kg'];
            } elseif ($list['kode_trans'] == '210') {
                $str .= '<td></td>';
                $str .= '<td></td>';
                $str .= '<td></td>';
                $str .= '<td align="right">' . number_format($list['qty_kg'], 2) . '</td>';
                $jml210 = $jml210 + $list['qty_kg'];
            }
            $str .= '</tr>';
        }
        $i++;
    }
    $str .= '<tr> <td colspan="3">Total</td>
                  <td align="right">' . number_format($jml100, 2) . '</td>
                  <td align="right">' . number_format($jml110, 2) . '</td>
                  <td align="right">' . number_format($jml200, 2) . '</td>
                  <td align="right">' . number_format($jml210, 2) . '</td>
             </tr>';
    return $str;
}
