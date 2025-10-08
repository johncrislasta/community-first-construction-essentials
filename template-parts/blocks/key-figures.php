<?php
$year1 = get_field('year_1');
$year2 = get_field('year_2');

$homes_sourced = get_field('homes_sourced');
$home_renos = get_field('home_renos');
$home_sets = get_field('home_sets');

$completed_projects = get_field('completed_projects');
$value_created = get_field('value_created');
?>

<section class="key-figures-block" style="background-color:#222; color:#fff; padding:2rem;">
  <div class="chart-container" style="display:flex; flex-wrap:wrap; gap:2rem;">
    <div class="chart" style="flex:1 1 60%;">
      <p><strong>Legend:</strong> <span style="color:#f90;">● <?= $year1; ?></span> <span style="color:#fbc87a;">● <?= $year2; ?></span></p>
      <?php
      
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
             <div style="background-color:#f90; width:<?= round($w1, 2); ?>%; height:40px; border-radius:5px;"></div>
             <small><?= $val1; ?></small>
           </div>
           <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.25rem;">
             <div style="background-color:#fbc87a; width:<?= round($w2, 2); ?>%; height:40px; border-radius:5px;"></div>
             <small><?= $val2; ?></small>
           </div>
         </div>
       <?php endforeach; ?>

    <div class="stats" style="flex:1 1 35%;">
      <h3 style="text-align:center; margin-bottom:1rem;">CFC Progress YTD</h3>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; text-align:center;">
        <h4><?= $year1; ?></h4>
        <h4><?= $year2; ?></h4>
        <div style="background:#f90;color:#000;">
          <p>Completed Projects</p>
          <h2 style="font-weight:bold;"><?= $completed_projects['y1']; ?></h2>
        </div>
        <div style="background:#fbc87a;color:#000;">
          <p>Completed Projects</p>
          <h2 style="font-weight:bold;"><?= $completed_projects['y2']; ?></h2>
        </div>
        <div style="background:#f90;color:#000;">
          <p>Value Created</p>
          <h2 style="font-weight:bold;"><?= $value_created['y1']; ?></h2>
        </div>
        <div style="background:#fbc87a;color:#000;">
          <p>Value Created</p>
          <h2 style="font-weight:bold;"><?= $value_created['y2']; ?></h2>
        </div>
      </div>
    </div>
  </div>
</section>
