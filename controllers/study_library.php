<?php defined('BASEPATH') or exit('No direct script access allowed');

class Study_library extends AdminController
{
    /**
     * Método construtor
     * Carrega os models, helpers e assets necessários.
     */
    public function __construct()
    {
        parent::__construct();
        // Carrega o model 'study_library_modal'.
        $this->load->model('study_library_modal');
        // Carrega o helper 'study_library_helper'.
        $this->load->helper('study_library_helper');
        $this->app_scripts->add('library-js', module_dir_url('study_library', '/assets/js/study_library.js'));
        $this->load->library('GoogleDriveApi');
        // Google OAuth URL 
        $this->googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online';
    }
    /**
     * Método index
     * Exibe a página principal da biblioteca de estudos.
     */
    public function index()
    {
        $this->app_css->add('jquery-comments-css', base_url('assets/plugins/jquery-comments/css/jquery-comments.css'));

        $this->app_scripts->add('jquery-comments-js', base_url('assets/plugins/jquery-comments/js/jquery-comments.js'));
        $data['video_data_show'] = $this->study_library_modal->show_video();
        $data['data_category'] = $this->study_library_modal->show_category();
        $this->load->view('admin/libraries/study_library', $data);
    }
    /**
     * Método get_video_data
     * Carrega os dados dos vídeos para exibição.
     */
    public function get_video_data()
    {
        $data['data_category'] = $this->study_library_modal->show_category();
        $this->load->view('admin/libraries/add_video_data', $data);
    }
    /**
     * Método video_category_table
     * Retorna os dados da tabela de categorias de vídeo.
     */
    public function video_category_table()
    {
        $this->app->get_table_data(module_views_path('study_library', 'admin/libraries/table/video_category_table'));
    }

    /**
     * Método categeory
     * Exibe a página de categorias.
     */
    public function categeory()
    {
        $data['data_category'] = $this->study_library_modal->show_category();
        $this->load->view('admin/libraries/categeory', $data);
    }

    /**
     * Método add_video_categeory
     * Exibe a página para adicionar categorias de vídeo.
     */
    public function add_video_categeory()
    {
        $this->load->view('admin/libraries/add_categeory',);
    }

    /**
     * Método add_category_data
     * Adiciona os dados da categoria.
     */
    public function add_category_data()
    {
        $data = array(
            'category' => $this->input->post('add_category'),
        );
        if ($this->study_library_modal->add_category($data)) {
            echo true;
        } else {
            echo false;
        }
    }
    /**
     * Método update_category_data
     * Atualiza os dados da categoria.
     */
    public function update_category_data()
    {
        $data = $this->input->post();
        if ($this->study_library_modal->update_category_data($data)) {
            echo true;
        } else {
            echo false;
        }
    }

    /**
     * Método add_video
     * Adiciona um novo vídeo ou edita um vídeo existente.
     * @param string $id ID do vídeo (opcional).
     */
    public function add_video($id = '')
    {

        if (is_numeric($id) && has_permission('study_library', '', 'edit')) {
            if ($this->input->post()) {
                $post_data = $this->input->post();
                $this->study_library_modal->update_video($post_data, $id);
                if ($id) {
                    if (isset($_FILES['upload_video_thumbnail'])) {
                        handle_study_library_video_thumbnail_upload($id);
                    }
                    if (isset($_FILES['upload_video'])) {
                        handle_study_library_video_upload($id);
                    }
                    set_alert('success', _l('new_study_library_edited_alert'));
                    redirect(admin_url('study_library'));
                } else {
                    set_alert('danger', _l('new_study_library_update_failed_alert'));
                    redirect(admin_url('study_library'));
                }
            }
            $data['video'] = $this->study_library_modal->edit_video($id);
            $data['data_category'] = $this->study_library_modal->show_category();
            $data['title'] = _l('vl_edit_video');
        } else {
            if ($this->input->post()) {
                $post_data = $this->input->post();
                $id = $this->study_library_modal->upload_video($post_data);
                if ($id) {
                    if (isset($_FILES['upload_video_thumbnail'])) {
                        handle_study_library_video_thumbnail_upload($id);
                    }
                    $this->session->set_userdata('v_id', $id);
                    handle_study_library_video_upload($id);
                    if ($id) {
                        $filedataa = $this->study_library_modal->edit_video($id);
                        $val = get_option('is_vl_google_drive');
                        if ($filedataa->upload_type != 'link' && $val == 'yes') {
                            redirect($this->googleOauthURL);
                            $this->uploadFileGoogleDrive($id);
                        }
                    }
                    set_alert('success', _l('new_study_library_added_alert'));
                    redirect(admin_url('study_library'));
                } else {
                    set_alert('danger', _l('new_study_library_added_alert_failed'));
                    redirect(admin_url('study_library'));
                }
            }
            $data['data_category'] = $this->study_library_modal->show_category();
            $data['projects'] = $this->projects_model->get();
            $data['title'] = _l('vl_add_video');
        }
        $data['projects'] = $this->projects_model->get();
        $this->load->view('admin/libraries/simple_add_video', $data);
    }

    /**
     * Método search_category_data
     * Realiza a busca de vídeos por título e categoria.
     */
    public function search_category_data()
    {
        $post_data['categories'] = $this->input->post('categories');
        $post_data['title'] = $this->input->post('title');
        if($this->input->post('project_id')){
            $post_data['project_id'] = $this->input->post('project_id');
        }
        $result = $this->study_library_modal->search_title_category($post_data);
        $thumbnail_image = get_option('thumbnail_image'); 
        $data = '<div class="row">';
        foreach ($result as $data_show) {
            $val = get_upload_thumbnail($data_show['id']);
            if (isset($val) && !empty($val->upload_video_thumbnail)) {
                $tp = base_url() . 'uploads/study_library/' . $val->upload_video_thumbnail;
            } elseif ($thumbnail_image) {
                $tp =  base_url() . 'uploads/company/' . $thumbnail_image;
            } else {
                $tp =  base_url() . 'modules/study_library/assets/image/grid_back.png';
            }
            $hrefAttr = admin_url('study_library/add_video/' . $data_show['id']);
            $data .= ' <div class="col-md-4">
            <div class="v_o_wr">
            <div class="wrap_video_cl" style="background-image: url(' . $tp . ');">
            <div class="actn_edit">';
            if (has_permission('study_library', '', 'delete')) {
                $data .=  '<div class="wrap_actn_b"> <a class="trash_btn_c" href="' . admin_url('study_library/delete_video/') . $data_show['id'] . ' ">';
                $data .=  '<span>
                <i class="fa fa-trash-o" aria-hidden="true"></i> </span> delete 
                </a>
                </div>';
            }
            if (has_permission('study_library', '', 'edit')) {
                $data .= '<div class="wrap_actn_b">';
                $data .= '<a class="pencil_btn_c" href="' . admin_url('study_library/add_video/') . $data_show['id'] . '">';
                $data .= '<span>
                <i class="fa fa-pencil" aria-hidden="true"></i></span> edit
                </a>
                </div>';
            }
            $data .= '</div><h1>' . $data_show['title'] . '</h1>';
            if($aRow['upload_type'] == 'file'){
                $data .= '<a class="player_btn" data-fancybox href="#myVideo_' . $data_show['id'].'">';
                $data .= '<span>
?>
</final_file_content>

</final_file_content>
