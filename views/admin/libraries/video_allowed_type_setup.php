<?php
/*
*
*   arquivo: views/admin/libraries/video_allowed_type_setup.php
*   descrição: Este arquivo contém a view para configurar os tipos de arquivos de vídeo permitidos no sistema.
*   Permite ao administrador definir quais extensões de arquivo são aceitas para upload.
*
*/
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">  <?php echo _l('vl_allowed_type'); ?></h4>
                        <hr class="hr-panel-heading" />
                        <?php
                        /*
                        *   get_option('vl_allowed_type'): Recupera a opção 'vl_allowed_type' do banco de dados, que contém os tipos de arquivos permitidos.
                        */
                        $vl_allowed_type = get_option('vl_allowed_type');
                        /*
                        *   form_open_multipart: Cria a tag <form> para o formulário de configuração dos tipos de arquivos permitidos.
                        *   $this->uri->uri_string(): URL para onde o formulário será submetido (a própria página).
                        *   array('id' => 'allowed_type'): Array de atributos para a tag <form>, definindo o ID do formulário.
                        *   form_open_multipart é usado para formulários que contêm uploads de arquivos.
                        */
                        echo form_open_multipart($this->uri->uri_string(), array('id' => 'allowed_type'));
                        ?>
                        <?php
                        /*
                        *   render_input: Renderiza um campo de input no formulário.
                        *   'vl_allowed_type': Nome do campo.
                        *   _l('vl_allowed_file_type'): Label do campo (traduzido).
                        *   $vl_allowed_type: Valor do campo (tipos de arquivos permitidos recuperados do banco de dados).
                        *   '': Tipo do campo (text por padrão).
                        *   ['placeholder' => _l('vl_allowed_file_type_name')]: Array de atributos para o campo, definindo o placeholder (traduzido).
                        */
                        echo render_input('vl_allowed_type', _l('vl_allowed_file_type'), $vl_allowed_type, '', ['placeholder' => _l('vl_allowed_file_type_name')]);
                
                        ?>
                        <button type="submit" class="btn btn-info pull-right save_vl_btn" data-><?php echo _l('submit'); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    /*
    *   validate_form: Função JavaScript para validar o formulário.
    *   Verifica se o campo 'vl_allowed_type' está preenchido.
    */
    function validate_form() {
        <?php if (!isset($video) && empty($video)) { ?>
            appValidateForm($('#allowed_type'), {
                vl_allowed_type: 'required',   
            });
        <?php } else { ?>
            appValidateForm($('#allowed_type'), {
                vl_allowed_type: 'required',
            });
        <?php } ?>
    }
    $(function() {
        /*
        *   Evento de clique no botão 'save_vl_btn'.
        *   Ao clicar, a função validate_form é chamada para validar o formulário.
        *   Se a validação for bem-sucedida, o formulário é submetido.
        */
        $('body').on('click', 'button.save_vl_btn', function() {
           validate_form();
            $('form#allowed_type').submit();
        });
    }); 
</script>
</body>

</html>
