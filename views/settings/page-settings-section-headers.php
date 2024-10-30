<?php if ( 'lv_section-basic' == $section['id'] ) : ?>
  <div class="lv-auth">
    <a href="#" class="button" id="livevote-auth">
      <span class="dashicons dashicons-admin-network"></span>
      Authenticate with Live Vote <?php if (!empty($settings['basic']['publisher-id'])) echo(' <b>(Connected)</b>'); ?>
    </a>
  </div>


<?php elseif ( 'lv_section-advanced' == $section['id'] ) : ?>


<?php endif; ?>
