<div class="modal fade" id="add_library_categeory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Category</h4>
      </div>
      <?php echo form_open('admin/study_library/add_owner_operator_data',array('id'=>'category_form')); ?> 
           
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
            <?php echo render_input('add_category','Add category'); ?>
          </div>   
          <div class="col-md-4">
            <div class="form-group">
              <button type="button" onclick="add_categeory_form();" class="btn btn-primary" style="margin-top: 25px;">Save </button>
            </div>
          </div>   
        </div>
    </div>
     <div class="form-group">
        <label for="category_image"><?php echo _l('vl_category_image'); ?></label>
        <input type="file" name="category_image" id="category_image" class="form-control">
    </div>
    <div class="form-group">
        <img id="category_image_preview" src="#" alt="Imagem da Categoria" style="max-width:200px; display:none;">
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>
<script>
    document.getElementById("category_image").addEventListener("change", function() {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById("category_image_preview").src = e.target.result;
            document.getElementById("category_image_preview").style.display = "block";
        }

        reader.readAsDataURL(this.files[0]);
    });
</script>
