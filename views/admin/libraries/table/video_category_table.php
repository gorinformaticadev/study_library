<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->ci->db->query("SET sql_mode = ''");
$aColumns = [
    'id',
    'category',
    '1',
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'video_category';

$where  = [];
$filter = [];
$join = [];
$result =   data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    db_prefix().'video_category.id',
    db_prefix().'video_category.category',
    
]);
$output  = $result['output'];
$rResult = $result['rResult'];

// Initialize cards container
$output['aaData'] = '<div class="row cards-container">';

foreach ($rResult as $aRow) {
    $card = '<div class="col-md-4 col-sm-6">';
    $card .= '<div class="card">';
    $card .= '<div class="card-body">';
    $card .= '<h5 class="card-title">'.$aRow['category'].'</h5>';
    $card .= '<p class="card-text">ID: '.$aRow['id'].'</p>';
    
    $edit_delete_link = '';
    if (has_permission('study_library', '', 'edit')) { 
        $edit_delete_link .= '<a href="javascript:void(0);" class="btn btn-sm btn-primary" onclick="edit_category(this);" data-id="'.$aRow['id'].'">Edit</a> '; 
    }
    if (has_permission('study_library', '', 'delete')) { 
        $edit_delete_link .= '<a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="delete_category(this);" data-id="'.$aRow['id'].'">Delete</a>';
    }
    
    $card .= '<div class="card-actions">'.$edit_delete_link.'</div>';
    $card .= '</div></div></div>';
    
    $output['aaData'] .= $card;
}

// Close cards container
$output['aaData'] .= '</div>';

// You'll also need to add some CSS to make the cards look good
$output['css'] = '
<style>
.cards-container {
    margin: 20px 0;
}
.card {
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.card-body {
    padding: 15px;
}
.card-title {
    margin-bottom: 15px;
    font-size: 1.1rem;
}
.card-actions {
    margin-top: 15px;
}
</style>
';