<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Video Library Module
Description: Video Library For Training 
Version: 1.0.2
Author: Zonvoir
Author URI: https://zonvoir.com/
Requires at least: 2.3.*
*/
if (!defined('MODULE_study_library')) {
    define('MODULE_study_library', basename(__DIR__));
}
define('study_library_UPLOADS_FOLDER', FCPATH . 'uploads/study_library' . '/');
define('study_library_DISCUSSIONS_ATTACHMENT_FOLDER', FCPATH . 'uploads/study_library/discussions/attachment' . '/');
// Google API configuration 
$drive_id = get_option('vl_google_client_id');
$drive_secret = get_option('vl_google_client_secret');
$drive_url = get_option('vl_google_client_redirect_uri');
define('GOOGLE_CLIENT_ID', $drive_id);
define('GOOGLE_CLIENT_SECRET', $drive_secret);
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/drive');
define('REDIRECT_URI', $drive_url);
$CI = &get_instance();
$CI->load->helper(MODULE_study_library . '/study_library');
/**
 * Register activation module hook
 */
register_activation_hook(MODULE_study_library, 'study_library_module_activation_hook');

function study_library_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
register_language_files(MODULE_study_library, [MODULE_study_library]);
/**
 * Register uninstall module hook
 */
register_uninstall_hook(MODULE_study_library, 'study_library_module_uninstall_hook');

function study_library_module_uninstall_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/uninstall.php');
}
hooks()->add_action('admin_init', 'study_library_module_init_menu_items');
function study_library_module_init_menu_items() {
    if (is_admin()) {
        $CI = &get_instance();

        // Menu principal
        $CI->app_menu->add_sidebar_menu_item('study_library', [
            'slug'     => 'study_library',
            'name'     => _l('vl_menu'), // Nome principal exibido no menu
            'position' => 3,
            'icon'     => 'fa fa-photo-film', // Ícone moderno para biblioteca multimídia
        ]);

        // Submenu: Cursos
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_courses',
            'name'     => _l('vl_courses_submenu'),
            'href'     => admin_url('study_library/courses'),
            'position' => 1,
            'icon'     => 'fa fa-graduation-cap', // Ícone para cursos
        ]);

        // Submenu: Módulos
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_modules',
            'name'     => _l('vl_modules_submenu'),
            'href'     => admin_url('study_library/modules'),
            'position' => 2,
            'icon'     => 'fa fa-puzzle-piece', // Ícone para módulos
        ]);

        // Submenu: Aulas
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_lessons',
            'name'     => _l('vl_lessons_submenu'),
            'href'     => admin_url('study_library/lessons'),
            'position' => 3,
            'icon'     => 'fa fa-chalkboard-teacher', // Ícone para aulas
        ]);

        // Submenu: Matrículas
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_enrollments',
            'name'     => _l('vl_enrollments_submenu'),
            'href'     => admin_url('study_library/video_thumbnail'),
            'position' => 4,
            'icon'     => 'fa fa-user-check', // Ícone para matrículas
        ]);

        // Submenu: Progresso
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_progress',
            'name'     => _l('vl_progress_submenu'),
            'href'     => admin_url('study_library/progress'),
            'position' => 5,
            'icon'     => 'fa fa-chart-line', // Ícone para progresso
        ]);

        // Submenu: Certificados
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_certificates',
            'name'     => _l('vl_certificates_submenu'),
            'href'     => admin_url('study_library/certificates'),
            'position' => 6,
            'icon'     => 'fa fa-certificate', // Ícone para certificados
        ]);
    }
}

hooks()->add_filter('get_upload_path_by_type', 'study_library_get_upload_path_by_type', 10, 2);
function study_library_get_upload_path_by_type($path, $type)
{
    if ($type == 'study_library') {
        $path = study_library_UPLOADS_FOLDER;
    }
    return $path;
}
hooks()->add_action('app_customers_head', 'study_library_customer_project_tabs');
function study_library_customer_project_tabs()
{
    $CI = &get_instance();
    if (is_client_logged_in() && ($CI->uri->segment(2) == 'projects' || $CI->uri->segment(2) == 'project')) {
        $project_id = $CI->uri->segment(3); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                var node = '<li role="presentation" class="project_tab_study_library"><a data-group="project_study_library" href="<?php echo site_url('study_library/client/project/' . $project_id); ?>?group=study_library" role="tab"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo _l('vl_study_library'); ?> </a></li>';
                $('.nav-tabs').append(node);
            });
        </script>
    <?php }
    ?>
<?php
}
