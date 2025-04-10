<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Study Library Module
Description: Modulo para aulas
Version: 1.0.3
Author: GOR Informatica
Author URI: https://gorinformatica.com.br
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
function study_library_module_init_menu_items()
{
    $CI = &get_instance();
    $CI->app->add_quick_actions_link([
        'name'       => _l('vl_study_library'),
        'url'        => 'study_library',
        'permission' => 'study_library',
        'position'   => 52,
    ]);
    if (is_admin()) {
        // The first paremeter is the parent menu ID/Slug
        $CI->app_menu->add_setup_menu_item('Video_lib_setup', [
            'collapse' => true,
            'name' => _l('Study Library'),
            'position' => 10,
        ]);
        $CI->app_menu->add_setup_children_item('Video_lib_setup', [
            'slug' => 'video_lib_setup-groups',
            'name' => _l('Google Drive'),
            'href' => admin_url('study_library/video_drive_setup'),
            'position' => 5,
        ]);
        $CI->app_menu->add_setup_children_item('Video_lib_setup', [
            'slug' => 'Video_lib_setup-groups_type',
            'name' => _l('vl_allowed_file_type'),
            'href' => admin_url('study_library/video_allowed_type_setup'),
            'position' => 10,
        ]);
        $CI->app_menu->add_setup_children_item('Video_lib_setup', [
            'slug' => 'Video_lib_setup-groups_type',
            'name' => _l('vl_thumbnail'),
            'href' => admin_url('study_library/video_thumbnail'),
            'position' => 10,
        ]);
    }
    if (has_permission('study_library', '', 'view_own') || has_permission('study_library', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('study_library', [
            'slug'     => 'study_library',
            'name'     => _l('vl_menu'),
            'position' => 10,
            'icon'     => 'fa fa-video-camera'
        ]);
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_dashboard',
            'name'     => _l('vl_videos_submenu'),
            'href'     => admin_url('study_library/index'),
            'position' => 1,
        ]);
        $CI->app_menu->add_sidebar_children_item('study_library', [
            'slug'     => 'study_library_categeories',
            'name'     => _l('vl_categories_submenu'),
            'href'     => admin_url('study_library/category'),
            'position' => 2,
        ]);
        $CI->app_tabs->add_project_tab('study_library', [
            'name'                      => _l('vl_study_library'),
            'icon'                      => 'fa fa-video-camera',
            'view'                      => 'study_library/admin/libraries/project_videos',
            'position'                  => 40,
        ]);
    }
    $capabilities = [];
    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete')
    ];
    register_staff_capabilities(MODULE_study_library, $capabilities, _l('vl_study_library'));
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
