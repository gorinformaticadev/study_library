<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div class="clearfix">
              <h4 class="pull-left"><?php echo _l('vl_courses_submenu'); ?></h4>
              <a href="#" class="btn btn-info pull-right" data-toggle="modal" data-target="#addCourseModal">
                <i class="fa fa-plus"></i> <?php echo _l('vl_add_course'); ?>
              </a>
            </div>
            <hr>
            <table class="table table-courses">
              <thead>
                <tr>
                  <th><?php echo _l('ID'); ?></th>
                  <th><?php echo _l('vl_course_name'); ?></th>
                  <th><?php echo _l('vl_course_description'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($courses as $course) { ?>
                  <tr>
                    <td><?php echo $course['id']; ?></td>
                    <td><?php echo $course['name']; ?></td>
                    <td><?php echo $course['description']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

            <!-- Modal para adicionar curso -->
            <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form action="#" method="post">
                    <div class="modal-header">
                      <h4 class="modal-title"><?php echo _l('vl_add_course'); ?></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label><?php echo _l('vl_course_name'); ?></label>
                        <input type="text" name="name" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label><?php echo _l('vl_course_description'); ?></label>
                        <textarea name="description" class="form-control"></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                      <button type="submit" class="btn btn-info"><?php echo _l('Salvar'); ?></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /Modal -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
