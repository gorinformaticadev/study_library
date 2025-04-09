<?php
/*
*
*   arquivo: views/admin/libraries/update_category.php
*   descrição: Este arquivo contém a view para atualizar uma categoria existente.
*   Ele inclui um formulário modal para editar o nome da categoria.
*
*/
?>
<div class="modal fade" id="edit_category_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Category</h4>
      </div>
      <?php
      /*
      *   form_open: Cria a tag <form> para o formulário de atualização da categoria.
      *   admin_url('study_library/update_category_data'): URL para onde o formulário será submetido.
      *   ['id'=>'update-category-form']: Array de atributos para a tag <form>, neste caso, define o ID do formulário.
      */
       echo form_open(admin_url('study_library/update_category_data') , ['id'=>'update-category-form']); ?>
        <div class="modal-body">
         <div class="card">
          <div class="card-body">
            <div id="response"> </div>
            <div class="row">
             <?php
             /*
             *   form_hidden: Cria um campo hidden no formulário.
             *   'video_id': Nome do campo.
             *   $edit_data[0]['id']: Valor do campo, neste caso, o ID da categoria a ser editada.
             */
              echo form_hidden('video_id', $edit_data[0]['id']); ?>
             <div class="col-md-8">
              <div class="form-group">
                <label for="category">Edit Category:</label>
                <input type="text" class="form-control" value="<?php echo $edit_data[0]['category']?>" name="category" id="category" placeholder="Enter Category" required />
              </div>
            </div>   
            <div class="col-md-4">
              <div class="form-group">
                <button type="button" onclick="update_categeory_form();" class="btn btn-primary" style="margin-top: 25px;">Save </button>
              </div>
            </div>   
          </div>

        </div>
      </div>
    </div>
  <?php echo form_close(); ?>
</div>
</div>
