<?php
/*
*
*   arquivo: views/admin/libraries/update_video.php
*   descrição: Este arquivo contém a view para atualizar um vídeo existente.
*   Ele inclui um formulário para editar o título, categoria, vídeo e descrição do vídeo.
*
*/
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php init_head(); ?>
<div id="wrapper">
 <div class="content">
     <div class="panel_s">
         <div class="panel-body">
            <div class="wrap_form_new_cl " style=" max-width: 60%; margin: 0 auto; border: 1px solid #e3e8ee;padding: 24px;  border-radius: 10px; background-color: #e3e8ee;margin-top: 25px;"> 
             <?php
             /*
             *   form_open: Cria a tag <form> para o formulário de atualização do vídeo.
             *   admin_url('study_library/update_video'): URL para onde o formulário será submetido.
             *   array('id'=>'update_owner_operator_form','enctype'=>'multipart/form-data'): Array de atributos para a tag <form>,
             *   neste caso, define o ID do formulário e o tipo de codificação para envio de arquivos.
             */
              echo form_open('admin/study_library/update_video',array('id'=>'update_owner_operator_form','enctype'=>'multipart/form-data')); ?>  
             <div class="row">
                <div class="form-group col-lg-12">  
                  <?php if ($this->session->flashdata('msg')) { ?>
                     <div class="alert alert-success"> <?= $this->session->flashdata('msg') ?> </div>
                 <?php } ?>
                 <?php
                 /*
                 *   form_hidden: Cria um campo hidden no formulário.
                 *   'video_id': Nome do campo.
                 *   $data_video->id: Valor do campo, neste caso, o ID do vídeo a ser editado.
                 */
                  echo form_hidden('video_id', $data_video->id); ?>
                 <label for="title" class="form-label ">Title</label>  
                 <input type="text" class="form-control " id="title" name="title" placeholder="Enter Ttile" value="<?php echo $data_video->video_title ?>" autocomplete required >  
                 <span style="color:red;">  <?php echo form_error('title'); ?></span>
             </div> 
             <div class="form-group col-md-12">  
                <div class="form-group">
                    <?php
                    $selected = '';
                    if(isset($data_video) && !empty($data_video)){
                      $selected = $data_video->id;
                  }
                  /*
                  *   render_select: Renderiza um campo select (dropdown) no formulário.
                  *   'category': Nome do campo.
                  *   $data_category: Array com os dados das categorias.
                  *   array('id','category'): Array com os campos 'id' e 'category' para popular o dropdown.
                  *   'Category': Label do campo.
                  *   $selected: Valor selecionado no dropdown.
                  */
                  echo render_select( 'category',$data_category,array('id','category'),'Category',$selected);
                  ?>
                  
              </div>
              <span style="color:red;">  <?php echo form_error('category'); ?></span>
          </div>  
          <div class="form-group col-md-12">  
             <label for="upload_video" class="form-label">Upload Video</label>  
             <input type="file" class="form-control" id="upload_video" name="upload_video">
             <video controls style="height:80px;">
                <source src="<?= base_url().'uploads/upload_video/'. $data_video->upload_video;?>" type="video/mp4" >
                </video>
                <span style="color:red;">  <?php echo form_error('upload_video'); ?></span>  
            </div> 
            <div class="form-group col-lg-12">  
             <label for="desc" class="form-label ">Description</label>  
             <textarea name="desc" class="form-control"><?php echo $data_video->description ?></textarea>  
             <span style="color:red;">  <?php echo form_error('title'); ?></span>
         </div> 
         <div class="form-group col-lg-4">  
            <button type="submit" class=" btn btn-primary padding-top">Submit</button>    
        </div>
        <?php echo form_close(); ?>

    </div>
</div>  


</div>


</div>
</div>
<?php init_tail(); ?>
