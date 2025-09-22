<article class="project-details">
  <h2><?php the_field('project_type'); ?></h2>
  <p><strong>Location:</strong> <?php the_field('location'); ?></p>
  <p><strong>Completed:</strong> <?php the_field('completion_date'); ?></p>

  <?php if ($before = get_field('before_image')) : ?>
    <figure><img src="<?php echo esc_url($before['url']); ?>" alt="Before"/></figure>
  <?php endif; ?>

  <?php if ($after = get_field('after_image')) : ?>
    <figure><img src="<?php echo esc_url($after['url']); ?>" alt="After"/></figure>
  <?php endif; ?>
</article>
