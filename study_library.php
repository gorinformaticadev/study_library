<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Study Library Module
Description: Modulo para aulas
Version: 0.9
Author: GOR Informatica
Author URI: https://gorinformatica.com.br
Requires at least: 2.3.*
*/

// Verifica se a constante MODULE_study_library já está definida para evitar redefinições
if (!defined('MODULE_study_library')) {
    define('MODULE_study_library', basename(__DIR__)); // Define a constante com o nome do diretório do módulo
}

// Define o diretório para uploads do módulo Study Library
define('study_library_UPLOADS_FOLDER', FCPATH . 'uploads/study_library' . '/');
// Define o diretório para anexos de discussões do Study Library
define('study_library_DISCUSSIONS_ATTACHMENT_FOLDER', FCPATH . 'uploads/study_library/discussions/attachment' . '/');

// Configurações da API do Google Drive
$drive_id = get_option('vl_google_client_id'); // Obtém o ID do cliente Google Drive das opções
$drive_secret = get_option('vl_google_client_secret'); // Obtém o segredo do cliente Google Drive das opções
$drive_url = get_option('vl_google_client_redirect_uri'); // Obtém o URI de redirecionamento do cliente Google Drive das opções

// Define constantes para as configurações da API do Google Drive
define('GOOGLE_CLIENT_ID', $drive_id);
define('GOOGLE_CLIENT_SECRET', $drive_secret);
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/drive');
define('REDIRECT_URI', $drive_url);

$CI = &get_instance(); // Obtém a instância do CodeIgniter
$CI->load->helper(MODULE_study_library . '/study_library'); // Carrega o helper do módulo Study Library

/**
 * Hook de ativação do módulo
 * Registra a função study_library_module_activation_hook para ser executada na ativação do módulo
 */
register_activation_hook(MODULE_study_library, 'study_library_module_activation_hook');

/**
 * Função de ativação do módulo
 * Executa a instalação do módulo
 */
function study_library_module_activation_hook()
{
    $CI = &get_instance(); // Obtém a instância do CodeIgniter
    require_once(__DIR__ . '/install.php'); // Inclui o arquivo de instalação do módulo
}

register_language_files(MODULE_study_library, [MODULE_study_library]); // Registra os arquivos de idioma do módulo

/**
 * Hook de desinstalação do módulo
 * Registra a função study_library_module_uninstall_hook para ser executada na desinstalação do módulo
 */
register_uninstall_hook(MODULE_study_library, 'study_library_module_uninstall_hook');

/**
 * Função de desinstalação do módulo
 * Executa a desinstalação do módulo
 */
function study_library_module_uninstall_hook()
{
    $CI = &get_instance(); // Obtém a instância do CodeIgniter
    require_once(__DIR__ . '/uninstall.php'); // Inclui o arquivo de desinstalação do módulo
}

/**
 * Hook admin_init
 * Adiciona itens de menu do módulo na área administrativa
 */
hooks()->add_action('admin_init', 'study_library_module_init_menu_items');

/**
 * Função para inicializar os itens de menu do módulo
 * Adiciona um link rápido e itens de menu de configuração e sidebar
 */
function study_library_module_init_menu_items()
{
    $CI = &get_instance(); // Obtém a instância do CodeIgniter

    // Adiciona um link rápido para o módulo Study Library
    $CI->app->add_quick_actions_link([
        'name'       => _l('vl_study_library'), // Define o nome do link rápido
        'url'        => 'study_library', // Define a URL do link rápido
        'permission' => 'study_library', // Define a permissão necessária para ver o link rápido
        'position'   => 52, // Define a posição do link rápido
    ]);

    // Adiciona itens de menu de configuração se o usuário for administrador
    if (is_admin()) {
        // Adiciona um item de menu pai para o Study Library
        $CI->app_menu->add_setup_menu_item('Video_lib_setup', [
            'collapse' => true, // Define se o menu deve ser recolhido
            'name' => _l('Study Library'), // Define o nome do menu
            'position' => 10, // Define a posição do menu
        ]);

        // Adiciona um item de menu filho para a configuração do Google Drive
        $CI->app_menu->add_setup_children_item('Video_lib_setup', [
            'slug' => 'video_lib_setup-groups', // Define o slug do menu
            'name' => _l('Google Drive'), // Define o nome do menu
            'href' => admin_url('study_library/video_drive_setup'), // Define a URL do menu
            'position' => 5, // Define a posição do menu
        ]);

        // Adiciona um item de menu filho para a configuração de tipos de arquivo permitidos
        $CI->app_menu->add_setup_children_item('Video_lib_setup', [
            'slug' => 'Video_lib_setup-groups_type', // Define o slug do menu
            'name' => _l('vl_allowed_file_type'), // Define o nome do menu
            'href' => admin_url('study_library/video_allowed_type_setup'), // Define a URL do menu
            'position' => 10, // Define a posição do menu
        ]);

         // Adiciona um item de menu filho para a configuração de thumbnail
         $CI->app_menu->add_setup_children_item('Video_lib_setup', [
            'slug' => 'Video_lib_setup-groups_type', // Define o slug do menu
            'name' => _l('vl_thumbnail'), // Define o nome do menu
            'href' => admin_url('study_library/video_thumbnail'), // Define a URL do menu
            'position' => 10, // Define a posição do menu
        ]);
    }

    // Adiciona itens de menu na sidebar se o usuário tiver permissão para visualizar o módulo
    if (has_permission('study_library', '', 'view_own') || has_permission('study_library', '', 'view')) {
        // Adiciona um item de menu pai para o Study Library
        $CI->app_menu->add_sidebar_menu_item('study_library', [
            'slug'     => 'study_library', // Define o slug do menu
            'name'     => _l('vl_menu'), // Define o nome do menu
            'position' => 10, // Define a posição do menu
            'icon'     => 'fa fa-video-camera' // Define o ícone do menu
        ]);

        // Adiciona um item de menu filho para o dashboard do Study Library
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_dashboard', // Define o slug do menu
            'name'     => _l('vl_videos_submenu'), // Define o nome do menu
            'href'     => admin_url('study_library/index'), // Define a URL do menu
            'position' => 1, // Define a posição do menu
        ]);

        // Adiciona um item de menu filho para as categorias do Study Library
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_categeories', // Define o slug do menu
            'name'     => _l('vl_categories_submenu'), // Define o nome do menu
            'href'     => admin_url('study_library/categeory'), // Define a URL do menu
            'position' => 2, // Define a posição do menu
        ]);

        // Adiciona uma aba de projeto para o Study Library
        $CI->app_tabs->add_project_tab('study_library', [
            'name'                      => _l('vl_study_library'), // Define o nome da aba
            'icon'                      => 'fa fa-video-camera', // Define o ícone da aba
            'view'                      => 'study_library/admin/libraries/project_videos', // Define a view da aba
            'position'                  => 40, // Define a posição da aba
        ]);
    }

    // Define as capabilities (permissões) do módulo
    $capabilities = [];
    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')', // Permissão para visualizar
        'edit'   => _l('permission_edit'), // Permissão para editar
        'delete' => _l('permission_delete') // Permissão para deletar
    ];
    register_staff_capabilities(MODULE_study_library, $capabilities, _l('vl_study_library')); // Registra as capabilities
}

/**
 * Hook get_upload_path_by_type
 * Filtra o caminho de upload com base no tipo
 */
hooks()->add_filter('get_upload_path_by_type', 'study_library_get_upload_path_by_type', 10, 2);

/**
 * Função para obter o caminho de upload com base no tipo
 * Se o tipo for 'study_library', retorna o caminho de upload do módulo
 */
function study_library_get_upload_path_by_type($path, $type)
{
    if ($type == 'study_library') {
        $path = study_library_UPLOADS_FOLDER; // Define o caminho de upload para o módulo
    }
    return $path; // Retorna o caminho de upload
}

/**
 * Hook app_customers_head
 * Adiciona abas de projeto para clientes
 */
hooks()->add_action('app_customers_head', 'study_library_customer_project_tabs');

/**
 * Função para adicionar abas de projeto para clientes
 * Adiciona uma aba para o Study Library na página de projetos do cliente
 */
function study_library_customer_project_tabs()
{
    $CI = &get_instance(); // Obtém a instância do CodeIgniter

    // Verifica se o usuário está logado como cliente e se está na página de projetos
    if (is_client_logged_in() && ($CI->uri->segment(2) == 'projects' || $CI->uri->segment(2) == 'project')) {
        $project_id = $CI->uri->segment(3); // Obtém o ID do projeto
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                // Cria um novo nó HTML para a aba do Study Library
                var node = '<li role="presentation" class="project_tab_study_library"><a data-group="project_study_library" href="<?php echo site_url('study_library/client/project/' . $project_id); ?>?group=study_library" role="tab"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo _l('vl_study_library'); ?> </a></li>';
                $('.nav-tabs').append(node); // Adiciona o nó à lista de abas
            });
        </script>
    <?php }
    ?>
<?php
}
