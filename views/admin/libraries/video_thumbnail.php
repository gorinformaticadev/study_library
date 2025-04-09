<?php
/*
*
*   arquivo: views/admin/libraries/video_thumbnail.php
*   descrição: Este arquivo contém a view para configurar a imagem de miniatura (thumbnail) padrão para os vídeos na biblioteca de estudos.
*   Permite ao administrador fazer upload de uma nova imagem de thumbnail ou remover a imagem existente.
*
*/
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          <?php
          /*
          *   form_open_multipart: Cria a tag <form> para o formulário de upload da imagem de thumbnail.
          *   $this->uri->uri_string(''): URL para onde o formulário será submetido (a própria página).
          *   array('id' => 'study_library_thumbnail'): Array de atributos para a tag <form>, definindo o ID do formulário.
          *   form_open_multipart é usado porque o formulário contém um upload de arquivo.
          */
          echo form_open_multipart($this->uri->uri_string(''), array('id' => 'study_library_thumbnail',));?>
           <?php
           /*
           *   get_option('thumbnail_image'): Recupera o nome do arquivo da imagem de thumbnail do banco de dados.
           */
           $login_image = get_option('thumbnail_image'); ?>
          <?php if($login_image != ''){ ?>
			<div class="row">
				<div class="col-md-4">
                <?php echo _l('vl_thumbnail'); // Label para a imagem de thumbnail ?> <br/> <br/>
					<img src="<?php echo base_url('uploads/company/'.$login_image); ?>" class="img img-responsive" height="300" width="300">
				</div>
				<?php if(has_permission('settings','','delete')){ ?>
					<div class="col-md-8 text-left">
            <?php
            /*
            *   base_url('study_library/remove_thumbnail_image'): Cria a URL para a função que remove a imagem de thumbnail.
            *   data-toggle="tooltip": Ativa a tooltip do Bootstrap.
            *   title="<?php echo _l('remove_thumbnail_tooltip'); ?>": Define o texto da tooltip (traduzido).
            *   class="_delete text-danger": Define as classes CSS para o link (estilo de link de exclusão em vermelho).
            */
            ?>
						<a href="<?php echo base_url('study_library/remove_thumbnail_image'); ?>" data-toggle="tooltip" title="<?php echo _l('remove_thumbnail_tooltip'); ?>" class="_delete text-danger"><i class="fa fa-remove"></i></a>
					</div>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
		<?php } else { ?>
			<div class="form-group">
				<label for="company_logo" class="control-label"><?php echo _l('vl_thumbnail'); // Label para o campo de upload da imagem de thumbnail ?></label>
        <?php
        /*
        *   input type="file": Cria um campo de input para upload de arquivo.
        *   name="thumbnail_image": Define o nome do campo (usado para acessar o arquivo no servidor).
        *   class="form-control": Define a classe CSS para o campo (estilo do Bootstrap).
        *   data-toggle="tooltip": Ativa a tooltip do Bootstrap.
        *   title="<?php echo _l('settings_general_company_logo_tooltip'); ?>": Define o texto da tooltip (traduzido).
        */
        ?>
				<input type="file" name="thumbnail_image" class="form-control" value="" data-toggle="tooltip" title="<?php echo _l('settings_general_company_logo_tooltip'); ?>">
			</div>
		<?php } ?>
        <div class="btn-bottom-toolbar text-right">
          <?php
          /*
          *   button type="submit": Cria um botão de envio do formulário.
          *   class="btn btn-info": Define as classes CSS para o botão (estilo do Bootstrap).
          */
          ?>
                     <button type="submit" class="btn btn-info">Save</button>
                  </div>
            <?php echo form_close(); // Fecha o formulário ?>
            <!-- </form> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
