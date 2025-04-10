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
                         <a href="#" onclick="init_add_categeory();" class="btn mright5 btn-info pull-left display-block">
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
                  <div class="row" id="study_library-cards">
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                       <div class="row cards-container" id="categories-container">
                         <!-- Cards will be loaded here via AJAX -->
                       </div>
                    </div>
                 </div>
              </div>
           </div>
       </div>
    </div>
</div>
</div>
</div>

<div id="wrapper-modal"></div>

<?php init_tail(); ?>

<style>
.cards-container {
    margin: 20px -15px;
    display: flex;
    flex-wrap: wrap;
}
.category-card {
    width: 300px;
    margin: 0 15px 30px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 4px;
    border: 1px solid #eee;
    background: white;
}
.card-body {
    padding: 20px;
}
.card-title {
    margin: 0 0 10px 0;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
}
.card-id {
    color: #7d7d7d;
    font-size: 13px;
    margin-bottom: 15px;
}
.card-actions {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}
.no-categories {
    padding: 20px;
    text-align: center;
    color: #777;
}
</style>

<script>
$(function() {
    // Load categories via AJAX
    function loadCategories(search = '') {
        $.post(admin_url + 'study_library/video_category_table', {
            search_category: search
        }, function(response) {
            $('#categories-container').html(response.aaData);
        }, 'json');
    }

    // Initial load
    loadCategories();

    // Search functionality
    $('input[name="search_category"]').on('keyup', function() {
        loadCategories(this.value);
    });

    // Make sure cards are properly aligned
    $(window).on('resize', function() {
        $('.cards-container').masonry({
            itemSelector: '.category-card',
            columnWidth: 300,
            gutter: 30
        });
    });
});

function delete_category(e) {
    var id = $(e).data('id');
    window.location.href = admin_url+"study_library/delete_category/"+id;
}

// You might need to adjust your edit_category function to work with cards
function edit_category(e) {
    var id = $(e).data('id');
    $.post(admin_url + 'study_library/edit_category_data/' + id, function(response) {
        $('#wrapper-modal').html(response);
        $('#edit_category_data').modal('show');
        
        // Atualizar o preview da imagem ao carregar o modal
        if($('#category_image_preview').attr('src') !== '#') {
            $('#category_image_preview').show();
        }
    });
}
</script>