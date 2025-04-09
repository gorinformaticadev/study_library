<?php
/*
*
*   arquivo: views/admin/libraries/simple_add_video.php
*   descrição: Este arquivo contém a view para adicionar ou editar um vídeo na biblioteca de estudos.
*   Ele utiliza as funções do CodeIgniter para gerar o formulário e interagir com o banco de dados.
*
*/
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php init_head(); ?>

<style type="text/css">
    /* Estilos para a exibição dos links de vídeo */
    .vl_video_link {
        position: relative;
        display: initial;
    }

    .vl_video_link a {
        border: 1px dotted #b3b3b3;
        display: inline-block;
        padding: 18px 54px;
        border-radius: 6px;
        position: relative;
        padding-bottom: 35px;
    }

    .d_l_btn {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        text-align: center;
        margin-bottom: 0;
        border-top: 1px solid #e1e1e1;
        padding-top: 5px;
        background-color: #e3e8ee;
        font-size: 11px;
    }

    .d_l_btn i {}

    .vl_video_link h5 {
        font-size: 20px;
    }

    .vl_video_link h5 i {}

    .vl_video_link span {
        position: absolute;
        right: 0;
        z-index: 999999;
        padding: 5px 9px;
        font-size: 10px;
        color: red;
        cursor: pointer;
    }

    .vl_video_link p {
        position: absolute;
        right: 0;
        z-index: 999999;
        padding: 5px 9px;
        font-size: 10px;
        color: #4f709b;
        cursor: pointer;
    }

    p._delete_thumb {
        display: inherit;
        color: red;
    }
</style>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php echo $title; ?></h4>
                        <hr class="hr-panel-heading" />
                        <?php
                        /*
                        *   form_open_multipart: Cria um formulário HTML que permite o envio de arquivos.
                        *   $this->uri->uri_string(): Retorna a URI da página atual.
                        *   array('id' => 'upload_video_form'): Define um array com atributos para o formulário, neste caso, o ID.
                        */
                        echo form_open_multipart($this->uri->uri_string(), array('id' => 'upload_video_form'));
                        /*
                        *   isset($video) ? $video->title : '': Verifica se a variável $video está definida e se possui um título, caso contrário, retorna uma string vazia.
                        *   render_input('title', _l('vl_video_title'), $value): Renderiza um campo de input do tipo texto.
                        *   'title': Nome do campo.
                        *   _l('vl_video_title'): Label do campo, traduzido para o idioma atual.
                        *   $value: Valor do campo.
                        */
                        $value = isset($video) ? $video->title : '';
                        echo render_input('title', _l('vl_video_title'), $value);
                        /*
                        *   isset($video) ? $video->category : '': Verifica se a variável $video está definida e se possui uma categoria, caso contrário, retorna uma string vazia.
                        *   isset($data_category) && !empty($data_category) ? $data_category : []: Verifica se a variável $data_category está definida e não está vazia, caso contrário, retorna um array vazio.
                        *   render_select('category', $data_category, array('id', 'category'), _l('vl_video_cate'), $selected): Renderiza um campo de select (dropdown).
                        *   'category': Nome do campo.
                        *   $data_category: Array com os dados para popular o select.
                        *   array('id', 'category'): Array que define os campos 'id' e 'category' como os valores e textos a serem exibidos no select.
                        *   _l('vl_video_cate'): Label do campo, traduzido para o idioma atual.
                        *   $selected: Valor selecionado.
                        */
                        $selected = isset($video) ? $video->category : '';
                        $data_category = isset($data_category) && !empty($data_category) ? $data_category : [];
                        echo render_select('category', $data_category, array('id', 'category'), _l('vl_video_cate'), $selected);
                        /*
                        *   isset($video->project_id) && !empty($video->project_id) ? $video->project_id : '': Verifica se a variável $video->project_id está definida e não está vazia, caso contrário, retorna uma string vazia.
                        *   render_select('project_id', $projects, array('id', 'name'), _l('vl_projects'), $selected): Renderiza um campo de select (dropdown) para selecionar o projeto.
                        *   'project_id': Nome do campo.
                        *   $projects: Array com os dados para popular o select.
                        *   array('id', 'name'): Array que define os campos 'id' e 'name' como os valores e textos a serem exibidos no select.
                        *   _l('vl_projects'): Label do campo, traduzido para o idioma atual.
                        *   $selected: Valor selecionado.
                        */
                        $selected = isset($video->project_id) && !empty($video->project_id) ? $video->project_id : '';
                        echo render_select('project_id', $projects, array('id', 'name'), _l('vl_projects'), $selected);
                        /*
                        *   isset($video) ? $video->upload_type : '': Verifica se a variável $video está definida e se possui um tipo de upload, caso contrário, retorna uma string vazia.
                        */
                        $valuee = isset($video) ? $video->upload_type : '';
                        ?>
                        <div class="form-group">
                            <label for="upload_type" class="control-label clearfix">
                                <?php echo _l('vl_ask_for_upload_file'); ?> </label>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" class="upload_type" id="upload-type-file" name="upload_type" value="file" <?php if ($valuee == 'file') : ?>checked<?php endif; ?> checked>
                                <label for="upload-type-file">
                                    <?php echo _l('vl_input_option1'); ?> </label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="upload-type-link" class="upload_type" name="upload_type" value="link" <?php if ($valuee == 'link') : ?>checked <?php endif; ?>>
                                <label for="upload-type-link">
                                    <?php echo _l('vl_input_option2'); ?> </label>
                            </div>
                        </div>
                        <?php
                        /*
                        *   render_input('upload_video_thumbnail', _l('vl_video_thumbnail'), '', 'file', [], [],): Renderiza um campo de input do tipo file para o thumbnail do vídeo.
                        *   'upload_video_thumbnail': Nome do campo.
                        *   _l('vl_video_thumbnail'): Label do campo, traduzido para o idioma atual.
                        *   '': Valor do campo.
                        *   'file': Tipo do campo.
                        *   [], []: Array de atributos e classes CSS.
                        */
                        echo render_input('upload_video_thumbnail', _l('vl_video_thumbnail'), '', 'file', [], [],);
                        /*
                        *   isset($video) && !empty($video->upload_video_thumbnail): Verifica se a variável $video está definida e se possui um thumbnail de vídeo, caso contrário, não exibe o link para download.
                        */
                        if (isset($video) && !empty($video->upload_video_thumbnail)) {
                            echo "<div class='form-group  vl_video_link'><a href='" . base_url() . 'uploads/study_library/' . $video->upload_video_thumbnail . "' download>
            <h5><i class='fa fa-image'></i></h5>
            <p class='d_l_btn'><i class='fa fa-download'></i> Download</p>
            </a> 
            <p class='_delete_thumb' ' data-id='" . $video->id . "'><i class='fa fa-times' data-id='" . $video->id . "'></i></p>
            </div>";
                        }
                        /*
                        *   render_input('link', _l('vl_link_url'), '', '',  ['placeholder' => _l('vl_link_url_placeholder')], [], 'hidden showl'): Renderiza um campo de input do tipo texto para o link do vídeo.
                        *   'link': Nome do campo.
                        *   _l('vl_link_url'): Label do campo, traduzido para o idioma atual.
                        *   '': Valor do campo.
                        *   '': Tipo do campo.
                        *   ['placeholder' => _l('vl_link_url_placeholder')]: Array de atributos, neste caso, o placeholder.
                        *   [], []: Array de classes CSS.
                        *   'hidden showl': Classes CSS para controlar a exibição do campo.
                        */
                        echo render_input('link', _l('vl_link_url'), '', '',  ['placeholder' => _l('vl_link_url_placeholder')], [], 'hidden showl');

                        /*
                        *   render_input('upload_video', _l('vl_video_file'), '', 'file', [], [], 'showf'): Renderiza um campo de input do tipo file para o vídeo.
                        *   'upload_video': Nome do campo.
                        *   _l('vl_video_file'): Label do campo, traduzido para o idioma atual.
                        *   '': Valor do campo.
                        *   'file': Tipo do campo.
                        *   [], []: Array de atributos e classes CSS.
                        *   'showf': Classe CSS para controlar a exibição do campo.
                        */
                        echo render_input('upload_video', _l('vl_video_file'), '', 'file', [], [], 'showf');
                        /*
                        *   isset($video) && !empty($video->upload_video): Verifica se a variável $video está definida e se possui um vídeo, caso contrário, não exibe o link para download.
                        */
                        if (isset($video) && !empty($video->upload_video)) {
                            echo "<div class='form-group vl_video_link'><a href='" . base_url() . 'uploads/study_library/' . $video->upload_video . "' download>
            <h5><i class='fa fa-video-camera'></i></h5>
            <p class='d_l_btn'><i class='fa fa-download'></i> Download</p>
            </a>
            <span class='_delete' data-id='" . $video->id . "'><i class='fa fa-times' data-id='" . $video->id . "'></i></span>
            </div>";
                        }
                        /*
                        *   render_textarea('description', _l('vl_video_description'), $value): Renderiza um campo de textarea para a descrição do vídeo.
                        *   'description': Nome do campo.
                        *   _l('vl_video_description'): Label do campo, traduzido para o idioma atual.
                        *   $value: Valor do campo.
                        */
                        $value = isset($video) ? $video->description : '';
                        echo render_textarea('description', _l('vl_video_description'), $value); ?>
                        <button type="submit" class="btn btn-info pull-right save_vl_btn" data-><?php echo _l('submit'); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
init_tail();
/*
*   get_option('vl_allowed_type'): Retorna o valor da opção 'vl_allowed_type' do banco de dados.
*   explode(',', get_option('vl_allowed_type')): Divide a string retornada pela função get_option em um array, utilizando a vírgula como separador.
*/
$vl_allowed_type = explode(',', get_option('vl_allowed_type'));
/*
*   array_map(function ($item) { return str_replace('.', '', $item); }, $vl_allowed_type): Aplica a função str_replace a cada elemento do array $vl_allowed_type.
*   str_replace('.', '', $item): Remove o ponto de cada elemento do array.
*/
$dotlessArray = array_map(function ($item) {
    return str_replace('.', '', $item);
}, $vl_allowed_type);
/*
*   implode('|', $dotlessArray): Concatena os elementos do array $dotlessArray em uma string, utilizando o caractere '|' como separador.
*/
$vl_conv_allowed_type = implode('|', $dotlessArray);
?>
<script>
    /*
    *   validate_form(): Função para validar o formulário.
    */
    function validate_form() {
        <?php if (!isset($video) && empty($video)) { ?>
            /*
            *   appValidateForm($('#upload_video_form'), { ... }): Aplica a validação ao formulário com ID 'upload_video_form'.
            *   { ... }: Objeto com as regras de validação para cada campo.
            */
            appValidateForm($('#upload_video_form'), {
                title: 'required',
                category: 'required',
                description: 'required',
                upload_video: {
                    required: {
                        depends: function(element) {
                            if ($('.upload_type') == 'file') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                    },
                    extension: "<?php echo "$vl_conv_allowed_type";  ?>",

                },
                upload_video_thumbnail: {
                    extension: "jpg|jpeg|gif|png|bmp",
                },
                link: {
                    required: {
                        depends: function(element) {
                            if ($('.upload_type') == 'link') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                    }
                }
            });
        <?php } else { ?>
            appValidateForm($('#upload_video_form'), {
                title: 'required',
                category: 'required',
                description: 'required',
                upload_video: {
                    required: {
                        depends: function(element) {
                            if ($('.upload_type') == 'file') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                    },
                    extension: "<?php echo "$vl_conv_allowed_type";  ?>",

                },
                upload_video_thumbnail: {
                    extension: "<?php echo "$vl_conv_allowed_type";  ?>",
                },
                link: {
                    required: {
                        depends: function(element) {
                            if ($('.upload_type') == 'link') {
                                return true;
                            } else {
                                return false;
                            }
                        },
                    }
                }
            });
        <?php } ?>
    }
    $(function() {
        $('body').on('click', 'button.save_vl_btn', function() {
            validate_form();
            $('form#upload_video_form').submit();
        });

    })
    $("body").on('click', '._delete_thumb', function(e) {
        if (confirm_delete()) {
            return true;
        }
        return false;
    });
    $(document).on('click', '.vl_video_link span', function(event) {
        var video_id = $(event.currentTarget).data('id');
        $.post(admin_url + "study_library/delete_video/" + video_id, function(resp) {
            resp = JSON.parse(resp);
            if (resp.status == 'success') {
                location.reload();
            }
            alert_float(resp.status, resp.message);
        });
    });
    var jFoo = <?php echo json_encode($valuee); ?>;
    if (jFoo == 'link') {
        $('.showf').hide();
        $('.showl').removeClass("hidden");
    }
    $(document).on('change', '.upload_type', function() {
        if (this.value == 'link') {
            $('.showf').hide();
            $('.showl').removeClass("hidden");
            $(".showl").css('display', 'block');
        }
        if (this.value == 'file') {
            $('.showl').hide();
            $('.showf').show();
        }
    });

    $(document).on('click', '.vl_video_link p', function(event) {
        var video_id = $(event.currentTarget).data('id');
        $.post(admin_url + "study_library/delete_thumbnail_video/" + video_id, function(resp) {
            resp = JSON.parse(resp);
            if (resp.status == 'success') {
                location.reload();
            }
            // alert_float(resp.status, resp.message);
        });
    });
</script>
</body>

</html>
