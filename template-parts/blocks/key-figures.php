<?php
$year1 = get_field('year_1');
$year2 = get_field('year_2');

$homes_sourced = get_field('homes_sourced');
$home_renos = get_field('home_renos');
$home_sets = get_field('home_sets');

$completed_projects = get_field('completed_projects');
$value_created = get_field('value_created');

$bars = [
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

// Round of max value to the tens
$max = ceil($max / 10) * 10;
$interval = $max / 6;
?>
<style>
  .chart-plot-area {
    position: relative;

    &:before {
      content: "0";
      position: absolute;
      bottom: -1.5em;
      left: 0;
      font-size: 0.7em;
      transform: translateX(-50%);
    }
    > div {
      position: relative;
      &:before {
        content: attr(data-plot-line-label);
        position: absolute;
        bottom: -1.5em;
        right: 0;
        font-size: 0.7em;
        transform: translateX(50%);
      }
    }
  }

  .kf-bar {
    position: relative;
  }

  .kf-label {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8em;
    padding-right: 12px;
  }

  .chart-legend {
    justify-content: center;
    gap: 30px;
    > div {
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 10px;

      .legend-circle {
        width: 16px;
        height: 16px;
        display: inline-block;
        border-radius: 16px;
      }
    }
  }
</style>
<section id="key-figures" class="key-figures-block" style="background-color:#222; color:#fff; padding:2rem;">
  <div class="chart-container" style="display:flex; gap:2rem;">
    <div class="chart" style="display:grid;grid-template-columns: auto repeat(6, 1fr);grid-template-rows: 50px repeat(2, 85px) 100px 85px;width:100%;row-gap:4px;">
      <div class="chart-legend" style="grid-column-start:1;grid-column-end:8;display:flex;">
        <div>
          <span class="legend-circle" style="background: var(--color-primary)"></span>
          <?php echo $year1 ?>
        </div>
        <div>
          <span class="legend-circle" style="background: #fbc87a"></span>
          <?php echo $year2 ?>
        </div>
      </div>
      <div class="chart-plot-area" style="border-left: 1px solid #34362f;grid-column-start:2;grid-column-end:8;grid-row-start:2;grid-row-end:6;display:flex;">
        <?php for($i=1; $i<=6; $i++) { ?>
        <div style="border-right: 1px solid #34362f; width: 100%;" data-plot-line-label="<?= $interval * $i; ?>"></div>
        <?php } ?>
      </div>

      <div class="kf-label" style="grid-column-start:1;grid-column-end:2;grid-row-start:2;grid-row-end:4;">Home Renos</div>
      <?php
        $val1 = isset($home_renos['y1']) ? (float)$home_renos['y1'] : 0;
        $val2 = isset($home_renos['y2']) ? (float)$home_renos['y2'] : 0;
        $w1 = $max > 0 ? ($val1 / $max) * 100 : 0;
        $w2 = $max > 0 ? ($val2 / $max) * 100 : 0;
      ?>
      <div style="display:flex; align-items:center; gap:0.5rem; grid-column-start:2;grid-column-end:8;grid-row-start:2;grid-row-end:3;">
        <div class="kf-bar kf-bar-y1" data-target-width="<?= round($w1, 2); ?>" style="background-color:var(--color-primary); width:0%; height:85px; border-radius:5px; transition:width 900ms ease;display:flex;align-items:center;justify-content:end;">
          <strong style="display:inline-block;padding-right:20px"><span class="kf-count" data-count-to="<?= $val1; ?>"><?= $val1; ?></span></strong>
        </div>
      </div>
      <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.25rem; grid-column-start:2;grid-column-end:8;grid-row-start:3;grid-row-end:4;">
        <div class="kf-bar kf-bar-y2" data-target-width="<?= round($w2, 2); ?>" style="background-color:#fbc87a; width:0%; height:85px; border-radius:5px; transition:width 900ms ease;display:flex;align-items:center;justify-content:end;">
          <strong style="display:inline-block;padding-right:20px"><span class="kf-count" data-count-to="<?= $val2; ?>"><?= $val2; ?></span></strong>
        </div>
      </div>

      <div class="kf-label" style="grid-column-start:1;grid-column-end:2;grid-row-start:4;grid-row-end:6;display: flex;">Home Sets</div>
      <?php
        $val1 = isset($home_sets['y1']) ? (float)$home_sets['y1'] : 0;
        $val2 = isset($home_sets['y2']) ? (float)$home_sets['y2'] : 0;
        $w1 = $max > 0 ? ($val1 / $max) * 100 : 0;
        $w2 = $max > 0 ? ($val2 / $max) * 100 : 0;
      ?>
      <div style="display:flex; align-items:end; gap:0.5rem; grid-column-start:2;grid-column-end:8;grid-row-start:4;grid-row-end:5;">
        <div class="kf-bar kf-bar-y1" data-target-width="<?= round($w1, 2); ?>" style="background-color:var(--color-primary); width:0%; height:85px; border-radius:5px; transition:width 900ms ease;display:flex;align-items:center;justify-content:end;">
          <strong style="display:inline-block;padding-right:20px"><span class="kf-count" data-count-to="<?= $val1; ?>"><?= $val1; ?></span></strong>
        </div>
      </div>
      <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.25rem; grid-column-start:2;grid-column-end:8;grid-row-start:5;grid-row-end:6;">
        <div class="kf-bar kf-bar-y2" data-target-width="<?= round($w2, 2); ?>" style="background-color:#fbc87a; width:0%; height:85px; border-radius:5px; transition:width 900ms ease;display:flex;align-items:center;justify-content:end;">
          <strong style="display:inline-block;padding-right:20px"><span class="kf-count" data-count-to="<?= $val2; ?>"><?= $val2; ?></span></strong>
        </div>
      </div>
    </div>
    <div class="stats" style="flex:1 1 300px;">
      <h3 style="text-align:center; margin-bottom:1rem;">CFC Progress YTD</h3>
      <div style="display:grid; grid-template-columns:1fr; text-align:center;">
        <h4><?= $year1; ?></h4>
        <div style="background:var(--color-primary);color:#000;">
          <p>Completed Projects</p>
          <h2 style="font-weight:bold;"><span class="kf-count" data-count-to="<?= isset($completed_projects['y1']) ? (float)$completed_projects['y1'] : 0; ?>"><?= $completed_projects['y1']; ?></span></h2>
        </div>
        <h4><?= $year2; ?></h4>
        <div style="background:#fbc87a;color:#000;">
          <p>Completed Projects</p>
          <h2 style="font-weight:bold;"><span class="kf-count" data-count-to="<?= isset($completed_projects['y2']) ? (float)$completed_projects['y2'] : 0; ?>"><?= $completed_projects['y2']; ?></span></h2>
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

  const parseCountSpec = (text, attrVal) => {
    // Prefer numeric data-count-to if provided and valid
    if (attrVal !== null && attrVal !== undefined && attrVal !== '' && !isNaN(parseFloat(attrVal))) {
      const n = parseFloat(attrVal);
      return { prefix: '', target: n, suffix: '', decimals: Number.isInteger(n) ? 0 : 2 };
    }
    const raw = (text || '').toString().trim();
    // Matches optional currency symbol, number (with optional decimals), optional K/M/B suffix
    const m = raw.match(/^([\$€£])?\s*([0-9]{1,3}(?:,[0-9]{3})*|[0-9]+)(?:\.([0-9]+))?\s*([KMB])?$/i);
    if (!m) return null;
    const prefix = m[1] || '';
    const intPart = (m[2] || '').replace(/,/g, '');
    const decPart = m[3] || '';
    const suffix = (m[4] || '').toUpperCase();
    const hasDecimal = decPart.length > 0;
    const num = parseFloat(intPart + (hasDecimal ? '.' + decPart : '')) || 0;
    return { prefix, target: num, suffix, decimals: hasDecimal ? decPart.length : 0 };
  };

  const animateCounts = (root) => {
    const els = root.querySelectorAll('.kf-count');
    els.forEach(el => {
      if (el.dataset.animated) return;
      const attrVal = el.getAttribute('data-count-to');
      const spec = parseCountSpec(el.textContent, attrVal);
      if (!spec) { el.dataset.animated = '1'; return; }
      const { prefix, target, suffix, decimals } = spec;
      const startTime = performance.now();
      const duration = 1200; // ms
      const startVal = 0;
      const step = (now) => {
        const p = Math.min(1, (now - startTime) / duration);
        const eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
        const curr = startVal + (target - startVal) * eased;
        el.textContent = `${prefix}${curr.toFixed(decimals)}${suffix}`;
        if (p < 1) requestAnimationFrame(step);
        else { el.textContent = `${prefix}${target.toFixed(decimals)}${suffix}`; el.dataset.animated = '1'; }
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
