<div class="panel_s">
  <div class="panel-body">
    <h3 class="no-margin">Curso: <?php echo $course['name']; ?></h3>
    <p><?php echo $course['description']; ?></p>

    <?php if (!$this->study_model->is_user_enrolled(get_staff_user_id(), $course['id'])) : ?>
      <a href="<?php echo admin_url('study/enroll/' . $course['id']); ?>" class="btn btn-success">Inscreva-se</a>
    <?php else : ?>
      <div class="progress mtop20">
        <div id="course-progress-bar" class="progress-bar" role="progressbar" style="width:0%"></div>
      </div>
      <hr>

      <?php foreach ($modules as $module) : ?>
        <h4><?php echo $module['name']; ?></h4>
        <ul class="list-group">
          <?php foreach ($module['lessons'] as $lesson) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?php echo $lesson['title']; ?>
              <button class="btn btn-sm btn-outline-success mark-complete" data-id="<?php echo $lesson['id']; ?>">Concluir</button>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endforeach; ?>

      <a href="<?php echo admin_url('study/certificate/' . $course['id']); ?>" class="btn btn-info mtop20">Baixar Certificado</a>
    <?php endif; ?>
  </div>
</div>

<script>
$(function () {
  updateProgress();

  $('.mark-complete').on('click', function () {
    const lessonId = $(this).data('id');
    $.post(admin_url + 'study/mark_lesson/' + lessonId, function () {
      alert('Aula marcada como concluída!');
      updateProgress();
    });
  });

  function updateProgress() {
    $.get(admin_url + 'study/progress/' + <?php echo $course['id']; ?>, function (res) {
      const json = JSON.parse(res);
      $('#course-progress-bar').css('width', json.progress + '%').text(json.progress + '%');
    });
  }
});
</script>
