<?php
$heading    = get_field('faq_heading') ?: __('FAQ', 'twentytwentyfive-child');
$icon_style = get_field('icon_style') ?: 'plus_minus';
$items      = get_field('faq_items');
$block_id   = 'faq-accordion-' . esc_attr($block['id']);

if ($items): ?>
  <section
    id="<?php echo $block_id; ?>"
    class="faq-accordion-block"
    data-icon="<?php echo esc_attr($icon_style); ?>">
    <h2 class="faq-accordion-heading"><?php echo esc_html($heading); ?></h2>
    <?php foreach ($items as $i => $item):
      $q   = $item['question'];
      $a   = $item['answer'];
      $num = $i + 1;
    ?>
      <div class="faq-item">
        <button
          class="faq-question"
          aria-expanded="false"
          aria-controls="<?php echo "faq-answer-$num"; ?>">
          <span class="faq-label">
            <span class="faq-number"><?php echo $num; ?>.</span>
            <span class="faq-text"><?php echo esc_html($q); ?></span>
          </span>
          <span class="faq-toggle">
            <span class="icon icon-plus">＋</span>
            <span class="icon icon-minus">⚊</span>
            <span class="icon icon-arrow">❮</span>
          </span>
        </button>

        <div
          id="<?php echo "faq-answer-$num"; ?>"
          class="faq-answer">
          <?php echo wp_kses_post($a); ?>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
<?php endif; ?>