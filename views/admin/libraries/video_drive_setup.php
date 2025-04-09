<?php
/*
*
*   arquivo: views/admin/libraries/video_Drive_setup.php
*   descrição: Este arquivo contém a view para configurar as opções de integração com o Google Drive.
*   Permite ao administrador definir se os vídeos serão armazenados no Google Drive e configurar as credenciais de acesso.
*
*/
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"> <?php echo _l('vl_client_heading'); // Título do painel ?></h4>
                        <hr class="hr-panel-heading" />
                        <?php
                        /*
                        *   get_option('vl_google_client_id'): Recupera o ID do cliente Google Drive do banco de dados.
                        */
                        $drive_id = get_option('vl_google_client_id');
                        /*
                        *   get_option('vl_google_client_secret'): Recupera o segredo do cliente Google Drive do banco de dados.
                        */
                        $drive_secret = get_option('vl_google_client_secret');
                        /*
                        *   get_option('vl_google_client_redirect_uri'): Recupera o URI de redirecionamento do cliente Google Drive do banco de dados.
                        */
                        $drive_url = get_option('vl_google_client_redirect_uri');
                        /*
                        *   get_option('is_vl_google_drive'): Verifica se a integração com o Google Drive está habilitada.
                        */
                        $drive_check = get_option('is_vl_google_drive');
                        /*
                        *   form_open_multipart: Cria a tag <form> para o formulário de configuração do Google Drive.
                        *   $this->uri->uri_string(): URL para onde o formulário será submetido (a própria página).
                        *   array('id' => 'upload_video_form'): Array de atributos para a tag <form>, definindo o ID do formulário.
                        *   form_open_multipart é usado para formulários que contêm uploads de arquivos.
                        */
                        echo form_open_multipart($this->uri->uri_string(), array('id' => 'upload_video_form'));
                        ?>
                        <div class="form-group">
                            <label for="upload_type" class="control-label clearfix">
                                <?php echo _l('vl_ask_for_upload_gdrive'); // Label para a opção de upload no Google Drive ?> </label>
                            <div class="radio radio-primary radio-inline">
                                 /*
                                *   input type="radio": Cria um botão de rádio para habilitar o upload no Google Drive.
                                *   class="upload_type": Classe CSS para o botão de rádio.
                                *   id="upload-type-file": ID do botão de rádio.
                                *   name="drivecheck": Nome do grupo de botões de rádio.
                                *   value="yes": Valor do botão de rádio (habilitar Google Drive).
                                *   <?php if ($drive_check == 'yes') : ?>checked<?php endif; ?>: Marca o botão de rádio como selecionado se a integração com o Google Drive estiver habilitada.
                                */
                                <input type="radio" class="upload_type" id="upload-type-file" name="drivecheck" value="yes" <?php if ($drive_check == 'yes') : ?>checked<?php endif; ?>>
                                <label for="upload-type-file">
                                    <?php echo _l('vl_input_yes'); // Label para a opção "Sim" ?> </label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                /*
                                *   input type="radio": Cria um botão de rádio para desabilitar o upload no Google Drive.
                                *   class="upload_type": Classe CSS para o botão de rádio.
                                *   id="upload-type-link": ID do botão de rádio.
                                *   name="drivecheck": Nome do grupo de botões de rádio.
                                *   value="no": Valor do botão de rádio (desabilitar Google Drive).
                                *   <?php if ($drive_check == 'no') : ?>checked<?php endif; ?>: Marca o botão de rádio como selecionado se a integração com o Google Drive estiver desabilitada.
                                */
                                <input type="radio" id="upload-type-link" class="upload_type" name="drivecheck" value="no" <?php if ($drive_check == 'no') : ?>checked<?php endif; ?>>
                                <label for="upload-type-link">
                                    <?php echo _l('vl_input_no'); // Label para a opção "Não" ?> </label>
                            </div>
                        </div>
                        <?php
                        /*
                        *   render_input: Renderiza um campo de input no formulário.
                        *   'driveid': Nome do campo.
                        *   _l('vl_client_id'): Label do campo (traduzido).
                        *   $drive_id: Valor do campo (ID do cliente Google Drive recuperado do banco de dados).
                        *   '': Tipo do campo (text por padrão).
                        *   ['placeholder' => _l('vl_client_id_placeholder')]: Array de atributos para o campo, definindo o placeholder (traduzido).
                        */
                        echo render_input('driveid', _l('vl_client_id'), $drive_id, '', ['placeholder' => _l('vl_client_id_placeholder')]);
                        /*
                        *   render_input: Renderiza um campo de input no formulário.
                        *   'drivesecret': Nome do campo.
                        *   _l('vl_client_secret'): Label do campo (traduzido).
                        *   $drive_secret: Valor do campo (segredo do cliente Google Drive recuperado do banco de dados).
                        *   '': Tipo do campo (text por padrão).
                        *   ['placeholder' => _l('vl_drivesecret_placeholder')]: Array de atributos para o campo, definindo o placeholder (traduzido).
                        */
                        echo render_input('drivesecret', _l('vl_client_secret'), $drive_secret, '', ['placeholder' => _l('vl_drivesecret_placeholder')]);
                        /*
                        *   render_textarea: Renderiza um campo de textarea no formulário.
                        *   'driveurl': Nome do campo.
                        *   _l('vl_client_uri'): Label do campo (traduzido).
                        *   $drive_url: Valor do campo (URI de redirecionamento do cliente Google Drive recuperado do banco de dados).
                        *   ['placeholder' => _l('vl_driveurl_placeholder')]: Array de atributos para o campo, definindo o placeholder (traduzido).
                        *   [], '': Opções adicionais para o textarea (vazias neste caso).
                        */
                        echo render_textarea('driveurl', _l('vl_client_uri'), $drive_url, ['placeholder' => _l('vl_driveurl_placeholder')],  [], '');
                        ?>
                        <button type="submit" class="btn btn-info pull-right save_vl_btn" data-><?php echo _l('submit'); // Label do botão "Salvar" ?></button>
                        <?php echo form_close(); // Fecha o formulário ?>
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
    *   Verifica se os campos 'drivecheck', 'driveid', 'drivesecret' e 'driveurl' estão preenchidos.
    */
    function validate_form() {
        <?php if (!isset($video) && empty($video)) { ?>
            appValidateForm($('#upload_video_form'), {
                drivecheck: 'required',
                driveid: 'required',
                drivesecret: 'required',
                driveurl: 'required'
            });
        <?php } else { ?>
            appValidateForm($('#upload_video_form'), {
                drivecheck: 'required',
                driveid: 'required',
                drivesecret: 'required',
                driveurl: 'required'
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
            $('form#upload_video_form').submit();
        });
    });
</script>
</body>

</html>
