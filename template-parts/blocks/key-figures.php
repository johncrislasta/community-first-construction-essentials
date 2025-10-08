<?php
$year1 = get_field('year_1');
$year2 = get_field('year_2');

$homes_sourced = get_field('homes_sourced');
$home_renos = get_field('home_renos');
$home_sets = get_field('home_sets');

$completed_projects = get_field('completed_projects');
$value_created = get_field('value_created');
?>

<section id="key-figures" class="key-figures-block" style="background-color:#222; color:#fff; padding:2rem;">
  <div class="chart-container" style="display:flex; flex-wrap:wrap; gap:2rem;">
    <div class="chart" style="flex:1 1 60%;">
      <p><strong>Legend:</strong> <span style="color:#f90;">● <?= $year1; ?></span> <span style="color:#fbc87a;">● <?= $year2; ?></span></p>
      <?php

      $bars = [
	      'Homes Sourced' => $homes_sourced,
	      'Home Renos' => $home_renos,
	      'Home Sets' => $home_sets,
      ];

      // Find maximum value across all bars/years for proportional scaling
      $max = 0;
      foreach ($bars as $vals) {
        $v1 = isset($vals['y1']) ? (float)$vals['y1'] : 0;
        $v2 = isset($vals['y2']) ? (float)$vals['y2'] : 0;
        if ($v1 > $max) { $max = $v1; }
        if ($v2 > $max) { $max = $v2; }
      }
       foreach ($bars as $label => $values): ?>
         <div style="margin-bottom:1rem;">
           <div style="margin-bottom:0.25rem;"><?= $label; ?></div>
          <?php
            $val1 = isset($values['y1']) ? (float)$values['y1'] : 0;
            $val2 = isset($values['y2']) ? (float)$values['y2'] : 0;
            $w1 = $max > 0 ? ($val1 / $max) * 100 : 0;
            $w2 = $max > 0 ? ($val2 / $max) * 100 : 0;
          ?>
           <div style="display:flex; align-items:center; gap:0.5rem;">
             <div class="kf-bar kf-bar-y1" data-target-width="<?= round($w1, 2); ?>" style="background-color:#f90; width:0%; height:40px; border-radius:5px; transition:width 900ms ease;"></div>
             <small><span class="kf-count" data-count-to="<?= $val1; ?>"><?= $val1; ?></span></small>
           </div>
           <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.25rem;">
             <div class="kf-bar kf-bar-y2" data-target-width="<?= round($w2, 2); ?>" style="background-color:#fbc87a; width:0%; height:40px; border-radius:5px; transition:width 900ms ease;"></div>
             <small><span class="kf-count" data-count-to="<?= $val2; ?>"><?= $val2; ?></span></small>
           </div>
         </div>
       <?php endforeach; ?>

    </div>
    <div class="stats" style="flex:1 1 35%;">
      <h3 style="text-align:center; margin-bottom:1rem;">CFC Progress YTD</h3>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; text-align:center;">
        <h4><?= $year1; ?></h4>
        <h4><?= $year2; ?></h4>
        <div style="background:#f90;color:#000;">
          <p>Completed Projects</p>
          <h2 style="font-weight:bold;"><span class="kf-count" data-count-to="<?= isset($completed_projects['y1']) ? (float)$completed_projects['y1'] : 0; ?>"><?= $completed_projects['y1']; ?></span></h2>
        </div>
        <div style="background:#fbc87a;color:#000;">
          <p>Completed Projects</p>
          <h2 style="font-weight:bold;"><span class="kf-count" data-count-to="<?= isset($completed_projects['y2']) ? (float)$completed_projects['y2'] : 0; ?>"><?= $completed_projects['y2']; ?></span></h2>
        </div>
        <div style="background:#f90;color:#000;">
          <p>Value Created</p>
          <h2 style="font-weight:bold;"><span class="kf-count" data-count-to="<?= isset($value_created['y1']) && is_numeric($value_created['y1']) ? (float)$value_created['y1'] : 0; ?>"><?= $value_created['y1']; ?></span></h2>
        </div>
        <div style="background:#fbc87a;color:#000;">
          <p>Value Created</p>
          <h2 style="font-weight:bold;"><span class="kf-count" data-count-to="<?= isset($value_created['y2']) && is_numeric($value_created['y2']) ? (float)$value_created['y2'] : 0; ?>"><?= $value_created['y2']; ?></span></h2>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
(function(){
  const section = document.getElementById('key-figures');
  if (!section || 'IntersectionObserver' in window === false) {
    // Fallback: immediately set widths without animation
    section?.querySelectorAll('.kf-bar').forEach(bar => {
      const w = parseFloat(bar.getAttribute('data-target-width') || '0');
      bar.style.width = w + '%';
    });
    return;
  }

  let animated = false;
  const animateCounts = (root) => {
    const els = root.querySelectorAll('.kf-count');
    els.forEach(el => {
      if (el.dataset.animated) return;
      const target = parseFloat(el.getAttribute('data-count-to'));
      if (isNaN(target)) { // non-numeric: do nothing, just mark as shown
        el.dataset.animated = '1';
        return;
      }
      const startTime = performance.now();
      const duration = 1200; // ms
      const decimals = Number.isInteger(target) ? 0 : 2;
      const startVal = 0;
      const step = (now) => {
        const p = Math.min(1, (now - startTime) / duration);
        const eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
        const curr = startVal + (target - startVal) * eased;
        el.textContent = curr.toFixed(decimals);
        if (p < 1) requestAnimationFrame(step);
        else { el.textContent = target.toFixed(decimals); el.dataset.animated = '1'; }
      };
      requestAnimationFrame(step);
    });
  };

  const animateBars = (root) => {
    root.querySelectorAll('.kf-bar').forEach(bar => {
      if (bar.dataset.animated) return;
      const w = parseFloat(bar.getAttribute('data-target-width') || '0');
      // trigger layout then set width for transition
      bar.getBoundingClientRect();
      bar.style.width = w + '%';
      bar.dataset.animated = '1';
    });
  };

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !animated) {
        animated = true;
        animateBars(section);
        animateCounts(section);
        io.disconnect();
      }
    });
  }, { root: null, rootMargin: '0px', threshold: 0.2 });

  io.observe(section);
})();
</script>
