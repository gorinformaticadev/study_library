<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Classe Client
 *
 * Esta classe estende ClientsController e é responsável por exibir a biblioteca de estudos para clientes.
 */
class Client extends ClientsController
{
    /**
     * Método construtor da classe.
     *
     * Carrega o model 'study_library_modal'.
     */
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        // Carrega o model 'study_library_modal'.
        $this->load->model('study_library_modal');
    }

    /**
     * Método project
     *
     * Exibe a página de um projeto específico.
     *
     * @param int $id ID do projeto.
     */
    public function project($id)
    {
        // Busca os dados do projeto com o ID fornecido e o ID do cliente logado.
        $project = $this->projects_model->get($id, [
            'clientid' => get_client_user_id(),
        ]);

        // Se o projeto não for encontrado, exibe um erro 404.
        if (!$project) {
            show_404();
        }
        $data['project'] = $project;
        $data['project']->settings->available_features = unserialize($data['project']->settings->available_features);

        $data['title'] = $data['project']->name;
        $data['project_status'] = get_project_status_by_id($data['project']->status);
        if (!$this->input->get('group')) {
            $group = 'project_overview';
        } else {
            $group = $this->input->get('group');
        }
        $data['group']    = $group;
        $data['currency'] = $this->projects_model->get_currency($id);
        $data['members']  = $this->projects_model->get_project_members($id);
        // Busca as categorias de vídeo para exibir na página.
        $data['categories']  = $this->study_library_modal->show_category();
        $this->data($data);
        $this->view('client/project');
        $this->layout();
    }
    /**
     * Método video_grid
     *
     * Exibe um grid de vídeos.
     */
    public function video_grid()
    {
        $data = [];
        $video_id = !empty($this->input->post('video_id')) ? $this->input->post('video_id') : 0;
        $data['video_id'] = $video_id;
        if (!empty($this->input->post('cats'))) {
            $cats = json_decode($this->input->post('cats'));
            $data['cats'] = $cats;
        }
        $this->data($data);
        $this->view('client/grid');
        $this->disableNavigation();
        $this->disableSubMenu();
        echo $this->layout();
    }
    /**
     * Método search_category_data
     *
     * Busca vídeos por título e categoria.
     */
    public function search_category_data()
    {
        $post_data['categories'] = $this->input->post('categories');
        $post_data['title'] = $this->input->post('title');
        $result = $this->study_library_modal->search_title_category($post_data);
        $data = '<div class="row">';
        foreach ($result as $data_show) {
            $data .= ' <div class="col-md-4">
        <div class="v_o_wr">
        <div class="wrap_video_cl">';
            $data .= '<h1>' . $data_show['title'] . '</h1>';
            $data .= '<a class="player_btn" data-fancybox href="#myVideo_' . $data_show['id'] . '">';
            $data .= '<span>
        <img src="' . base_url('modules/study_library/assets/image/youtube_thumb.png') . '" alt="img not found"/>
        </span>
        </a>';
            $data .= '<div class="card">';
            $data .= '<video width="640" height="320" controls id="myVideo_' . $data_show['id'] . '" style="display:none;">';
            $data .= '<source src="' . $data_show['upload_type'] == 'file' ? base_url() . 'uploads/study_library/' . $data_show['upload_video'] : $data_show['upload_video'] . '" type="video/mp4">';
            $data .= '</video>
        </div>
        </div>';
            $discussion_count = video_discussion_count($data_show['video_id']);
            $data .= ' <div class="video_cat">';
            $data .= ' <p>' . $data_show['description'] . '</p>';
            $data .= '</div>
        </div>
        </div>';
        }
        $data .= '</div>';
        if (count($result) > 0) {
            echo $data;
        } else {
            echo '<h2 style="text-align:center;margin-top:10px;margin-bottom:10px;">Record Not Found</h2>';
        }
    }
    /**
     * Método get_video_comments
     *
     * Obtém os comentários de um vídeo.
     *
     * @param int $id ID do vídeo.
     * @param string $type Tipo de comentário.
     */
    public function get_video_comments($id, $type)
    {
        echo json_encode($this->study_library_modal->get_video_comments($id, $type));
    }
    /**
     * Método add_discussion_comment
     *
     * Adiciona um comentário a um vídeo.
     *
     * @param int $video_id ID do vídeo.
     * @param string $type Tipo de comentário.
     */
    public function add_discussion_comment($video_id, $type)
    {
        echo json_encode($this->study_library_modal->add_discussion_comment(
            $this->input->post(null, false),
            $video_id,
            $type
        ));
        exit;
    }

    /**
     * Método update_discussion_comment
     *
     * Atualiza um comentário de um vídeo.
     */
    public function update_discussion_comment()
    {
        echo json_encode($this->study_library_modal->update_discussion_comment($this->input->post(null, false)));
    }
    /**
     * Método delete_discussion_comment
     *
     * Deleta um comentário de um vídeo.
     *
     * @param int $id ID do comentário.
     */
    public function delete_discussion_comment($id)
    {
        echo json_encode($this->study_library_modal->delete_discussion_comment($id));
    }
}
