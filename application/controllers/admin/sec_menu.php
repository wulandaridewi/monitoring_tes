<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sec_menu extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('home_m');
        $this->load->model('global_m');
        $this->load->model('admin/sec_menu_m');
    }

    public function index() {
        if ($this->auth->is_logged_in() == false) {
            $this->login();
        } else {
            $data['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));


            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'global/index', $data);
        }
    }

    function home() {
        //echo "string";
        $menuId              = $this->home_m->get_menu_id('admin/sec_menu/home');
        $data['menu_id']     = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_header'] = $menuId[0]->menu_header;
        $data['menu_icon']   = $menuId[0]->menu_icon;
        $data['menu_name']   = $menuId[0]->menu_name;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
      
        if (isset($_POST["btnModalSaveMenuRoot"])) {
            $this->saveMenuRoot();
        } elseif (isset($_POST["btnModalEditMenuRoot"])) {
            $this->editMenuRoot();
        } elseif (isset($_POST["btnModalDeleteMenuRoot"])) {
            $this->deleteMenuRoot();
        } elseif (isset($_POST["btnModalSaveMenu"])) {
            $this->saveMenu();
        } elseif (isset($_POST["btnModalEditMenu"])) {
            $this->editMenu();
        } elseif (isset($_POST["btnModalDeleteMenu"])) {
            $this->deleteMenu();
        } else {
              
            $data['multilevel'] = $this->user_m->get_data(0,$this->session->userdata('usergroup'));
            $data['menu_all']   = $this->user_m->get_menu_all(0);

            $this->template->set('title', 'home');
            $this->template->load('default_template/template9', 'admin/sec_menu_v', $data);
        }
    }

    function getDescMenu() {
        $idMenu = $this->input->post('idMenu', TRUE);
        $rows   = $this->sec_menu_m->getDescMenu($idMenu);
        if ($rows) {
            foreach ($rows as $row)
            $header    = $row->menu_header;
            $urutan    = $row->menu_seq;
            $menu_icon = $row->menu_icon;
            $array = array(
                'baris'     => 1,
                'header'    => $header,
                'urutan'    => $urutan,
                'menu_icon' => $menu_icon
            );
        } else {
            $array = array('baris' => 0);
        }

        $this->output->set_output(json_encode($array));
    }

    function saveMenuRoot() {
        $nameMenuRoot    = trim($this->input->post('nameMenuRoot'));
        $squenceMenuRoot = trim($this->input->post('squenceMenuRoot'));

        $table = "sec_menu"; 
        $fieldID = "menu_id";
        $getID  = $this->global_m->getIdMaxInt($table,$fieldID);
        //$getID = $this->home_m->getIdMax();
//        die($getID);
        $data = array(
            'menu_id' => $getID,
            'menu_name' => $nameMenuRoot,
            'menu_uri' => '#',
            'menu_header'=>'',
            'parent' => 0,
            'menu_allowed' => '',
            'menu_seq' => $squenceMenuRoot,
            'lvl' => 1,
        );
//        print_r($data);
//        die();
        $model = $this->sec_menu_m->insert_menu_m($data);
        if ($model) {
            $this->session->set_flashdata('successRoot', 'Success Insert Menu Root !');
            redirect('admin/sec_menu/home');
        } else {
            $this->session->set_flashdata('errorRoot', 'Error Insert Menu Root !');
            redirect('admin/sec_menu/home');
        }
    }

    function editMenuRoot() {
        $idRootMenu      = trim($this->input->post('idRootMenu'));
        $nameMenuRoot    = trim($this->input->post('nameMenuRoot'));
        $squenceMenuRoot = trim($this->input->post('squenceMenuRoot'));
        $data = array(
            'menu_id'   => $idRootMenu,
            'menu_name' => $nameMenuRoot,
            'menu_seq'  => $squenceMenuRoot
        );
        $model = $this->sec_menu_m->update_menu_m($idRootMenu, $data);
        if ($model) {
            $this->session->set_flashdata('successRoot', ' Success Edit Menu Root !!');
            redirect('admin/sec_menu/home');
        } else {
            $this->session->set_flashdata('errorRoot', ' Error Edit Menu Root !');
            redirect('admin/sec_menu/home');
        }
    }

    function deleteMenuRoot() {
        $idRootMenu = trim($this->input->post('idRootMenu'));
        $data = array(
            'menu_id' => $idRootMenu,
        );
        $modelCek = $this->sec_menu_m->cek_menuChild_m($idRootMenu);
        if ($modelCek == 0) {
            $model = $this->sec_menu_m->delete_menu_m($idRootMenu, $data);
            if ($model) {
                $this->session->set_flashdata('successRoot', ' Success Delete Menu Root !');
                redirect('admin/sec_menu/home');
            } else {
                $this->session->set_flashdata('errorRoot', ' Error Delete Menu Root !');
                redirect('admin/sec_menu/home');
            }
        } else {
            $this->session->set_flashdata('errorRoot', ' Error Delete Menu Root tres!');
            redirect('admin/sec_menu/home');
        }
    }

    function saveMenu() {
        $idParent    = trim($this->input->post('idParent'));
        $nameMenu    = trim($this->input->post('nameMenu'));
        $uriMenu     = trim($this->input->post('uriMenu'));
        $headerMenu  = trim($this->input->post('headerMenu'));
        $squenceMenu = trim($this->input->post('squenceMenu'));
        $iconMenu    = trim($this->input->post('iconMenu'));

        $table   = "sec_menu"; 
        $fieldID = "menu_id";
        $idmax   = $this->global_m->getIdMaxInt($table,$fieldID);  
        $data = array(
            'menu_id'      => $idmax,
            'menu_name'    => $nameMenu,
            'menu_uri'     => $uriMenu,
            'menu_header'  => $headerMenu,
            'parent'       => $idParent,
            'menu_allowed' => '',
            'menu_seq'     => $squenceMenu,
            'lvl'          => 1,
            'menu_icon'    => $iconMenu,
        );
        //print_r($data); die();
        $model = $this->sec_menu_m->insert_menu_m($data);
        if ($model) {
            $this->session->set_flashdata('successMenu', ' Success Insert Menu !');
            redirect('admin/sec_menu/home');
        } else {
            $this->session->set_flashdata('errorMenu', ' Error Insert Menu  !');
            redirect('admin/sec_menu/home');
        }
    }

    function editMenu() {
        $idParent    = trim($this->input->post('idParent'));
        $idMenu      = trim($this->input->post('idMenu'));
        $nameMenu    = trim($this->input->post('nameMenu'));
        $uriMenu     = trim($this->input->post('uriMenu'));
        $headerMenu  = trim($this->input->post('headerMenu'));
        $squenceMenu = trim($this->input->post('squenceMenu'));
        $iconMenu    = trim($this->input->post('iconMenu'));

        $data = array(
            'menu_name'   => $nameMenu,
            'menu_uri'    => $uriMenu,
            'parent'      => $idParent,
            'menu_header' => $headerMenu,
            'menu_seq'    => $squenceMenu,
            'menu_icon'    => $iconMenu,
        );
        $model = $this->sec_menu_m->update_menu_m($idMenu, $data);
        if ($model) {
            $this->session->set_flashdata('successMenu', ' Success Edit Menu !');
            redirect('admin/sec_menu/home');
        } else {
            $this->session->set_flashdata('errorMenu', ' Error Edit Menu !');
            redirect('admin/sec_menu/home');
        }
    }

    function deleteMenu() {
        $idMenu = trim($this->input->post('idMenu'));
        $data = array(
            'menu_id' => $idMenu,
        );

        $modelCek = $this->sec_menu_m->cek_menuChild_m($idMenu);
        if ($modelCek == 0) {
            $model = $this->sec_menu_m->delete_menu_m($idMenu, $data);
            if ($model) {
                $this->session->set_flashdata('successMenu', ' Success Delete Menu !');
                redirect('admin/sec_menu/home');
            } else {
                $this->session->set_flashdata('errorMenu', ' Error Delete Menu !');
                redirect('admin/sec_menu/home');
            }
        } else {
            $this->session->set_flashdata('errorMenu', 'Error Delete Menu, Root Menu Have Child !');
            redirect('admin/sec_menu/home');
        }
    }
}

/* End of file sec_menu_user.php */
/* Location: ./application/controllers/sec_menu_user.php */