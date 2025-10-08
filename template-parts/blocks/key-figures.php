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
  <h2 style="text-transform:uppercase; letter-spacing:2px;">Key Figures</h2>
  <div class="chart-container" style="display:flex; flex-wrap:wrap; gap:2rem; margin-top:2rem;">
    <div class="chart" style="flex:1 1 60%;">
      <p><strong>Legend:</strong> <span style="color:#f90;">● <?= $year1; ?></span> <span style="color:#fbc87a;">● <?= $year2; ?></span></p>
      <?php
      $bars = [
        'Homes Sourced' => $homes_sourced,
        'Home Renos' => $home_renos,
        'Home Sets' => $home_sets,
      ];
      foreach ($bars as $label => $values): ?>
        <div style="margin-bottom:1rem;">
          <div style="margin-bottom:0.25rem;"><?= $label; ?></div>
          <div style="display:flex; align-items:center; gap:0.5rem;">
            <div style="background-color:#f90; width:<?= $values['y1']; ?>%; height:20px; border-radius:5px;"></div>
            <small><?= $values['y1']; ?></small>
          </div>
          <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.25rem;">
            <div style="background-color:#fbc87a; width:<?= $values['y2']; ?>%; height:20px; border-radius:5px;"></div>
            <small><?= $values['y2']; ?></small>
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
