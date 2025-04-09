<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
               <div class="panel-body">
               	<div class="row">
                   <div class="col-lg-12">
                      <div class="_buttons">
                         <a href="#" onclick="init_add_categeory();"class="btn mright5 btn-info pull-left display-block" >
                           <?php echo _l('vl_add_category'); ?>
                        </a>
                      </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <?php echo render_input('search_category', _l('Pesquisar Categoria')); ?>
                  </div>
               </div>
               <hr class="hr-panel-heading" />
               <div class="tab-content">
                  <div class="row" id="study_library-table">
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                       <?php
                       $table_data = array(
                        _l('#'),
                        _l('Category Name'),
                        _l('Action'),

                     );
                       render_datatable($table_data,'study_library');
                       ?>
                    </div>
                 </div>
              </div>
              <script id="hidden-columns-table-video-library" type="text/json">
               <?php echo get_staff_meta(get_staff_user_id(), 'hidden-columns-table-video-library'); ?>
            </script>
            <?php init_tail(); ?>
            <script>
               var Table = '';
               var date_t_value = (new Date()).toISOString().split('T')[0];
               $(function(){
                var serverParams = {};
                serverParams['search_category'] = $('input[name="search_category"]').val();
                $.each($('._hidden_inputs._filters input'),function(){
                   serverParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
                });
                initDataTable('.table-study_library', admin_url+'study_library/video_category_table', [0], [0], serverParams, [0, 'desc']);
                Table = $('.table-study_library').DataTable().columns([0]).visible(false);

                $('input[name="search_category"]').on('keyup', function(){
                  Table.search(this.value).draw();
                });
             });

          </script>
       </div>
       <div id="wrapper-modal"></div>
    </div>
 </div>
</div>
</div>
</div>
<script type="text/javascript">
   function delete_category(e) {
      var id = $(e).data('id');
      window.location.href = admin_url+"study_library/delete_category/"+id;
   }
</script>
