<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Video Library Module
Description: Video Library For Training 
Version: 1.0.2
Author: Zonvoir
Author URI: https://zonvoir.com/
Requires at least: 2.3.*
*/
if (!defined('MODULE_VIDEO_LIBRARY')) {
    define('MODULE_VIDEO_LIBRARY', basename(__DIR__));
}
define('VIDEO_LIBRARY_UPLOADS_FOLDER', FCPATH . 'uploads/video_library' . '/');
define('VIDEO_LIBRARY_DISCUSSIONS_ATTACHMENT_FOLDER', FCPATH . 'uploads/video_library/discussions/attachment' . '/');
// Google API configuration 
$drive_id = get_option('vl_google_client_id');
$drive_secret = get_option('vl_google_client_secret');
$drive_url = get_option('vl_google_client_redirect_uri');
define('GOOGLE_CLIENT_ID', $drive_id);
define('GOOGLE_CLIENT_SECRET', $drive_secret);
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/drive');
define('REDIRECT_URI', $drive_url);
$CI = &get_instance();
$CI->load->helper(MODULE_VIDEO_LIBRARY . '/video_library');
/**
 * Register activation module hook
 */
register_activation_hook(MODULE_VIDEO_LIBRARY, 'video_library_module_activation_hook');

function video_library_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
register_language_files(MODULE_VIDEO_LIBRARY, [MODULE_VIDEO_LIBRARY]);
/**
 * Register uninstall module hook
 */
register_uninstall_hook(MODULE_VIDEO_LIBRARY, 'video_library_module_uninstall_hook');

function video_library_module_uninstall_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/uninstall.php');
}
hooks()->add_action('admin_init', 'video_library_module_init_menu_items');
function video_library_module_init_menu_items() {
    if (is_admin()) {
        $CI = &get_instance();

        // Menu principal
        $CI->app_menu->add_sidebar_menu_item('video_library', [
            'slug'     => 'video_library',
            'name'     => _l('vl_menu'), // Nome principal exibido no menu
            'position' => 3,
            'icon'     => 'fa fa-photo-film', // Ícone moderno para biblioteca multimídia
        ]);

        // Submenu: Cursos
        $CI->app_menu->add_sidebar_children_item('video_library', [
            'slug'     => 'video_library_courses',
            'name'     => _l('vl_courses_submenu'),
            'href'     => admin_url('video_library/courses'),
            'position' => 1,
            'icon'     => 'fa fa-graduation-cap', // Ícone para cursos
        ]);

        // Submenu: Módulos
        $CI->app_menu->add_sidebar_children_item('video_library', [
            'slug'     => 'video_library_modules',
            'name'     => _l('vl_modules_submenu'),
            'href'     => admin_url('video_library/modules'),
            'position' => 2,
            'icon'     => 'fa fa-puzzle-piece', // Ícone para módulos
        ]);

        // Submenu: Aulas
        $CI->app_menu->add_sidebar_children_item('video_library', [
            'slug'     => 'video_library_lessons',
            'name'     => _l('vl_lessons_submenu'),
            'href'     => admin_url('video_library/lessons'),
            'position' => 3,
            'icon'     => 'fa fa-chalkboard-teacher', // Ícone para aulas
        ]);

        // Submenu: Matrículas
        $CI->app_menu->add_sidebar_children_item('video_library', [
            'slug'     => 'video_library_enrollments',
            'name'     => _l('vl_enrollments_submenu'),
            'href'     => admin_url('video_library/video_thumbnail'),
            'position' => 4,
            'icon'     => 'fa fa-user-check', // Ícone para matrículas
        ]);

        // Submenu: Progresso
        $CI->app_menu->add_sidebar_children_item('video_library', [
            'slug'     => 'video_library_progress',
            'name'     => _l('vl_progress_submenu'),
            'href'     => admin_url('video_library/progress'),
            'position' => 5,
            'icon'     => 'fa fa-chart-line', // Ícone para progresso
        ]);

        // Submenu: Certificados
        $CI->app_menu->add_sidebar_children_item('video_library', [
            'slug'     => 'video_library_certificates',
            'name'     => _l('vl_certificates_submenu'),
            'href'     => admin_url('video_library/certificates'),
            'position' => 6,
            'icon'     => 'fa fa-certificate', // Ícone para certificados
        ]);
    }
}

hooks()->add_filter('get_upload_path_by_type', 'video_library_get_upload_path_by_type', 10, 2);
function video_library_get_upload_path_by_type($path, $type)
{
    if ($type == 'video_library') {
        $path = VIDEO_LIBRARY_UPLOADS_FOLDER;
    }
    return $path;
}
hooks()->add_action('app_customers_head', 'video_library_customer_project_tabs');
function video_library_customer_project_tabs()
{
    $CI = &get_instance();
    if (is_client_logged_in() && ($CI->uri->segment(2) == 'projects' || $CI->uri->segment(2) == 'project')) {
        $project_id = $CI->uri->segment(3); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                var node = '<li role="presentation" class="project_tab_video_library"><a data-group="project_video_library" href="<?php echo site_url('video_library/client/project/' . $project_id); ?>?group=video_library" role="tab"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo _l('vl_video_library'); ?> </a></li>';
                $('.nav-tabs').append(node);
            });
        </script>
    <?php }
    ?>
<?php
}
