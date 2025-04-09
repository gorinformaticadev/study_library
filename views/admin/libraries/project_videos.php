<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Inclui o arquivo CSS para o fancybox (para visualização de vídeos) -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('modules/study_library/assets/css/jquery.fancybox.min.css')?>">
<!-- Inclui o arquivo CSS específico para o módulo study_library -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('modules/study_library/assets/css/study_library.css')?>">

<!-- Início do conteúdo principal -->
<div class="content">
  <div class="row">
   <div class="col-md-12">
     <div class="panel-body mbot10">
        <div class="row">
            <!-- Início da coluna para seleção de categoria -->
            <div class="col-md-6">
             <?php
             // Busca as categorias da biblioteca de estudos
             $categories = get_study_library_category();
             // Define as categorias, se existirem, senão define como um array vazio
             $data_category = isset($categories) && !empty($categories) ? $categories : [];
             // Renderiza um select para escolher as categorias (pode escolher múltiplas)
             echo render_select('category',$data_category,array('id','category'),'Category','',array('multiple'=>true));
             ?>
         </div>
         <!-- Fim da coluna para seleção de categoria -->
         <!-- Início da coluna para busca por título -->
         <div class="col-lg-6">
             <?php echo render_input('search',_l('Search Title'),'','',['onkeyup'=>'video_search_by_title(); return false;', 'placeholder'=>'search']); ?>
         </div>
         <!-- Fim da coluna para busca por título -->
     </div>
 </div>
 <!-- Início do painel para exibir a lista de vídeos -->
 <div class="panel-body">
     <!-- Div onde a lista de vídeos será exibida -->
     <div class="video_list_wrap" id="video_div"></div>
 </div>
 <!-- Fim do painel para exibir a lista de vídeos -->

<!-- Início do modal para exibir os comentários -->
<div id="modal-wrapper">
    <div class="modal fade" id="comments-modal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><?php echo _l('discussion'); ?></h4>
          </div>
          <div class="modal-body">
              <!-- Div onde os comentários do vídeo serão exibidos -->
              <div id="video-comments"></div>
          </div>
      </div>
  </div>
</div>
</div>
<!-- Fim do modal para exibir os comentários -->
</div>
</div>
</div>
</div>
</div>
<!-- Inclui os scripts JavaScript necessários -->
<?php 
$this->app_scripts->add('library-js', module_dir_url('study_library', '/assets/js/jquery.fancybox.min.js')); 
$this->app_scripts->add('library-project-js', module_dir_url('study_library', '/assets/js/project_library.js')); 
?>
