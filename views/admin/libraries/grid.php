<?php
/**
 * @param string BASEPATH  or exit('No direct script access allowed');
 * @param string $thumbnail_image thumbnail image
 */
defined('BASEPATH') or exit('No direct script access allowed');

 // Obtém a imagem em miniatura das opções
 $thumbnail_image = get_option('thumbnail_image'); 

// Obtém a instância do CodeIgniter
$CI     = & get_instance();

// Obtém os valores de paginação da requisição POST
$start  = intval($CI->input->post('start'));
$length = intval($CI->input->post('length'));
$draw   = intval($CI->input->post('draw'));

// Obtém o array de IDs de categorias da requisição POST
$cat_ids_arr = $CI->input->post('cat_ids_arr');

// Define as colunas da tabela
$aColumns = [
  db_prefix().'upload_video.id as video_id',
  db_prefix().'upload_video.title as title',
  db_prefix().'upload_video.upload_video as upload_video',
  db_prefix().'video_category.category as video_category',
  db_prefix().'upload_video.description as description',
  db_prefix().'upload_video.upload_type as upload_type',
];

// Define a coluna de índice
$sIndexColumn = 'id';

// Define a tabela principal
$sTable       = db_prefix() . 'upload_video';

// Define o JOIN com a tabela de categorias
$join = [
  'LEFT JOIN ' . db_prefix() . 'video_category ON ' . db_prefix() . 'video_category.id = ' . db_prefix() . 'upload_video.category'
];

// Define a cláusula WHERE
$where = [];
if(!empty($cat_ids_arr)) {
  array_push($where, 'AND '.db_prefix().'video_category.id IN ('.$cat_ids_arr.')');
}
if($CI->input->post('project_id')){
 array_push($where, 'AND '.db_prefix().'upload_video.project_id='.$CI->input->post('project_id')); 
}

// Prepara a query para o grid da biblioteca de estudos
$result = prepare_grid_query_for_study_library($aColumns, $sIndexColumn, $sTable, $join, $where);

// Obtém os resultados da query
$output  = $result['output'];
$rResult = $result['rResult'];

// Calcula os valores para a paginação
$prevPage = (($draw - 1) < 0) ? 0 : ($draw-1);
$nextPage = $draw + 1;
$nxtStart = ($start +1 ) * $length;
$prevStart = ($start -1 ) * $length;

// Carrega a biblioteca de paginação do CodeIgniter
$this->load->library('pagination');

// Configura a paginação
$config['base_url'] = admin_url('study_library/');
$config['total_rows'] = $output['iTotalDisplayRecords'];
$config['per_page'] = $length;
$config['use_page_numbers'] = TRUE;
$config['full_tag_open'] = "<ul class='pagination pagination-sm pull-right' style='position:relative; top:-25px;'>";
$config['full_tag_close'] ="</ul>";
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='javascript:;'>";
$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
$config['next_tag_open'] = "<li>";
$config['next_tagl_close'] = "</li>";
$config['prev_tag_open'] = "<li>";
$config['prev_tagl_close'] = "</li>";
$config['first_tag_open'] = "<li>";
$config['first_tagl_close'] = "</li>";
$config['last_tag_open'] = "<li>";
$config['last_tagl_close'] = "</li>";
$config['attributes'] = array('class' => 'paginate');
$config["uri_segment"] = 4;

// Inicializa a paginação
$this->pagination->initialize($config);
?>
<style type="text/css">
  .idea_ra span{padding: 6px 12px;color: white;font-weight: 400;font-size: 15px; border-radius: 2px;}
</style>
<!-- Div principal que contém o grid de vídeos -->
<div id="vl-grid-view" class="container-fluid">
  <div class="row">
    <?php
    // Verifica se existem registros para exibir
    if($output['iTotalDisplayRecords'] > 0){
      // Loop através dos resultados
      foreach ($rResult as $aRow) {
         $val=get_upload_thumbnail($aRow['video_id']);
         if(isset($val) && !empty($val->upload_video_thumbnail))
         {
          $tp = base_url().'uploads/study_library/'. $val->upload_video_thumbnail;
         }elseif($thumbnail_image){
          
          $tp =  base_url().'uploads/company/'. $thumbnail_image;
         }else{
          
          $tp =  base_url().'modules/study_library/assets/image/grid_back.png';
         }
         
        $hrefAttr = admin_url('study_library/add_video/' . $aRow['video_id']);
        ?>
        <!-- Coluna para cada vídeo -->
        <div class="col-md-4">
          <div class="v_o_wr">
            <!-- Container do vídeo com imagem de fundo -->
            <div class="wrap_video_cl" style="background-image: url(<?php echo $tp ?>);">
              <!-- Ações de edição e exclusão -->
              <div class="actn_edit">
                <?php  if (has_permission('study_library', '', 'delete')) { ?>
                  <div class="wrap_actn_b">
                    <a class="trash_btn_c _delete" href="<?php echo admin_url('study_library/delete_video/'.$aRow['video_id']);?>">
                      <span>
                        <i class="fa fa-trash-o" aria-hidden="true"></i> </span> delete 
                      </a>
                    </div>
                  <?php } ?>
                  <?php if(has_permission('study_library', '', 'edit')){ ?>
                    <div class="wrap_actn_b">
                      <a class="pencil_btn_c" href="<?php echo admin_url('study_library/add_video/'.$aRow['video_id']);?>">
                        <span>
                         <i class="fa fa-pencil" aria-hidden="true"></i></span> edit
                       </a>

                     </div>
                   <?php } ?>
                 </div>
                 <!-- Título do vídeo -->
                 <h1><?= $aRow['title']?></h1>
                 <?php if($aRow['upload_type'] == 'file'){ ?>
                 <!-- Player para vídeos do tipo "file" -->
                 <a class="player_btn" data-fancybox href="#myVideo_<?php echo $aRow['video_id'] ?>">
                  <span>
                    <img src="<?php echo base_url('modules/study_library/assets/image/youtube_thumb.png'); ?>" alt="img not found"/>
                  </span>
                </a>
                <div class="card">
                  <video width="640" height="320" controls id="myVideo_<?php echo $aRow['video_id'] ?>" style="display:none;">
                    <source src="<?= base_url().'uploads/study_library/'. $aRow['upload_video'];?>" type="video/mp4">
                    </video>
                  </div>
                <?php }else{ ?>
                  <!-- Player para vídeos de outros tipos -->
                  <a class="player_btn" data-fancybox href="<?php echo base_url().'uploads/study_library/'.$aRow['upload_video'] ?>">
                  <span>
                    <img src="<?php echo base_url('modules/study_library/assets/image/youtube_thumb.png'); ?>" alt="img not found"/>
                  </span>
                </a>
                <?php } ?>
                </div>
                <!-- Categoria e descrição do vídeo -->
                <div class="video_cat">
                  <p><?php 
                  $discussion_count = video_discussion_count($aRow['video_id']);
                  echo  $aRow['description']
                ?></p>
                <a href="javascript:void(0)" class="discussion_link" data-id="<?php echo $aRow['video_id'] ?>"><i class="fa fa-comment"></i><?php echo $discussion_count; ?></a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <?php 
    } else { ?>
      <!-- Mensagem caso não encontre vídeos -->
      <div class="col-md-12">
        <div class="cardbox text-center dataTables_empty" style="border: none">
          <p><?= _l('no_entries_found');?></p>
        </div>
      </div>
    <?php } ?>
  </div>
  <!-- Paginação -->
  <div class="row">
    <div style='margin-top: 10px;' id='pagination'>
      <?php echo $this->pagination->create_links(); ?>
    </div>
  </div>
