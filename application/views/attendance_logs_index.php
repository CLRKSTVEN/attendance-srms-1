<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<?php
// ---------------- Helpers ----------------
if (!function_exists('h')) {
  function h($val){ return htmlspecialchars((string)($val ?? ''), ENT_QUOTES, 'UTF-8'); }
}
function fmt_time_ampm($ts){
  if (empty($ts)) return '';
  $t = strtotime($ts);
  if ($t === false) return h($ts);
  return date('g:i A', $t); // e.g., 5:37 PM (no date)
}
$generatedDate = date('M d, Y');
?>

<body class="bg-light">
<style>
/***** Minimal, clean, professional *****/
:root{
  --ink:#0f172a; --muted:#64748b; --line:#e2e8f0; --soft:#f8fafc; --brand:#2563eb;
}
.page-title{font-weight:800;color:var(--ink)}
.subtle-hr{border:0;height:2px;background:linear-gradient(90deg,var(--brand),#60a5fa);opacity:.35;border-radius:999px;margin:8px 0 14px}

.card-clean{border:1px solid var(--line);border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 6px 16px rgba(15,23,42,.05)}
.card-clean .card-header{background:var(--soft);border-bottom:1px solid var(--line)}

#studentSearch{max-width:240px}

.table{margin-bottom:0}
.table thead th{position:sticky;top:0;background:#f9fbff;border-bottom:1px solid var(--line);font-weight:700}
.table td,.table th{vertical-align:middle;font-size:13px}
.table-hover tbody tr:hover{background:#fbfdff}
.pill{display:inline-block;padding:.16rem .5rem;border-radius:999px;font-size:.72rem;font-weight:700;background:#e0f2fe;color:#075985;border:1px solid #bae6fd}

.group-row td{background:#e2ecfd;font-weight:700;color:var(--ink);font-size:13px}
.group-row .group-label{display:flex;align-items:center;gap:.5rem}
.group-row .group-label i{color:var(--brand)}

/* keep layout simple on mobile without card-ification */
@media (max-width: 767.98px){
  .toolbar{width:100%;margin-top:.5rem}
  .table-responsive{overflow-x:auto}
}

</style>

<div id="wrapper">
  <?php include('includes/top-nav-bar.php'); ?>
  <?php include('includes/sidebar.php'); ?>

  <div class="content-page">
    <div class="content">
      <div class="container-fluid">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
          <h4 class="page-title mb-2 mb-md-0">Attendance Logs</h4>
          <div class="d-flex gap-2 align-items-center">
            <input id="studentSearch" type="text" class="form-control form-control-sm mr-2" placeholder="Search Student #">
            <button id="openFilters" class="btn btn-primary btn-sm">
              <i class="bi bi-funnel mr-1"></i> Select Activity
            </button>
          </div>
        </div>
        <hr class="subtle-hr" />

        <!-- Context chips (compact) -->
        <?php if (!empty($activity_id) || !empty($section) || !empty($year_level) || !empty($date) || !empty($session)): ?>
          <div class="mb-2 small text-muted">
            <?php
              $actTitle = '';
              if (!empty($activity_id)) {
                foreach ($activities as $a) { if ((int)$a->activity_id === (int)$activity_id) { $actTitle = (string)$a->title; break; } }
              }
            ?>
            <?php if (!empty($activity_id)): ?>
              <span class="badge badge-light border mr-1"><i class="mdi mdi-flag-outline mr-1"></i><?= h($actTitle) ?></span>
            <?php endif; ?>
            <?php if (!empty($section)): ?>
              <span class="badge badge-light border mr-1"><i class="mdi mdi-account-group-outline mr-1"></i>Section: <?= h($section) ?></span>
            <?php endif; ?>
            <?php if (!empty($year_level)): ?>
              <span class="badge badge-light border mr-1"><i class="mdi mdi-school-outline mr-1"></i>Year: <?= h($year_level) ?></span>
            <?php endif; ?>
            <?php if (!empty($date)): ?>
              <span class="badge badge-light border mr-1"><i class="mdi mdi-calendar-range mr-1"></i>Date: <?= h($date) ?></span>
            <?php endif; ?>
            <?php if (!empty($session)): ?>
              <span class="badge badge-light border"><i class="mdi mdi-timetable mr-1"></i>Session: <?= strtoupper(h($session)) ?></span>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Results -->
        <div class="row mt-2">
          <div class="col-12">
            <?php if (!empty($activity_id)): ?>
              <?php if (!empty($rows)): ?>

                <?php if (!empty($filter_note)): ?>
                  <div class="alert alert-warning mb-2"><?= h($filter_note) ?></div>
                <?php endif; ?>

                <div class="card-clean">
                  <div class="card-header d-flex align-items-center justify-content-between py-2 px-3">
                    <div class="font-weight-600">Results <span class="badge badge-primary ml-1"><?= count($rows) ?></span></div>
                    <div class="toolbar">
                      <a class="btn btn-outline-success btn-sm" href="<?= site_url('AttendanceLogs/export_csv/'.(int)$activity_id.'?'.http_build_query(['section'=>$section,'year_level'=>$year_level,'date'=>$date,'session'=>$session])) ?>">
                        <i class="bi bi-file-earmark-spreadsheet"></i> CSV
                      </a>
                      <a class="btn btn-outline-secondary btn-sm" target="_blank" href="<?= site_url('AttendanceLogs/activity/'.(int)$activity_id.'?'.http_build_query(['section'=>$section,'year_level'=>$year_level,'date'=>$date,'session'=>$session])) ?>">
                        <i class="bi bi-printer"></i> Print
                      </a>
                    </div>
                  </div>

                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-bordered mb-0" id="logsTable">
                        <thead>
                          <tr>
                            <th style="min-width:110px;">Student #</th>
                            <th style="min-width:200px;">Name</th>
                            <th>Section</th>
                            <th>Session</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Duration (min)</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Checked-In By</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($rows as $r):
                            $mins = ($r->checked_out_at && $r->checked_in_at)
                              ? max(0, (int) round((strtotime($r->checked_out_at) - strtotime($r->checked_in_at))/60))
                              : null; ?>
                            <tr>
                              <td><?= h($r->student_number) ?></td>
                              <td><?= h($r->student_name) ?></td>
                              <td><?= h($r->section) ?></td>
                              <td><span class="pill"><?= strtoupper(h($r->session)) ?></span></td>
                              <td><?= h(fmt_time_ampm($r->checked_in_at)) ?></td>
                              <td><?= h(fmt_time_ampm($r->checked_out_at)) ?></td>
                              <td><?= $mins ?></td>
                              <td><?= h($r->course) ?></td>
                              <td><?= h($r->YearLevel) ?></td>
                              <td><?= h($r->checked_in_by) ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              <?php else: ?>
                <div class="alert alert-info">No logs matched your filters.</div>
              <?php endif; ?>
            <?php else: ?>
              <div class="alert alert-secondary">Tap <strong>Select Activity</strong>, pick an <strong>Activity</strong>, then <strong>View</strong>.</div>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- FILTER MODAL -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius:12px;overflow:hidden">
      <div class="modal-header">
        <h5 class="modal-title">Attendance Logs</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
      </div>

      <form method="get">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label class="small text-muted">Activity</label>
              <select name="activity_id" class="form-control select2" required>
                <option value="">Select an activity</option>
                <?php foreach ($activities as $a): ?>
                  <option value="<?= (int)$a->activity_id ?>" <?= ((int)($activity_id ?? 0) === (int)$a->activity_id ? 'selected' : '') ?>><?= h($a->title) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label class="small text-muted">Section</label>
              <select name="section" class="form-control select2" data-placeholder="All sections">
                <option value="">All sections</option>
                <?php if (!empty($sections)): foreach ($sections as $s):
                    $sec = trim((string)($s->section ?? '')); if ($sec==='') continue;
                    $year = trim((string)($s->year_level ?? ''));
                    $course = trim((string)($s->course_code ?? ''));
                    $labelParts = array_filter([$course, $year, $sec], function($v){ return $v !== ''; });
                    $label = implode(' • ', $labelParts) ?: $sec;
                    $selected = (($section ?? '') === $sec) ? 'selected' : '';
                ?>
                  <option value="<?= h($sec) ?>" data-year="<?= h($year) ?>" data-course="<?= h($course) ?>" <?= $selected ?>><?= h($label) ?></option>
                <?php endforeach; endif; ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="small text-muted">Year Level</label>
              <select name="year_level" class="form-control select2" data-placeholder="All year levels">
                <option value="">All year levels</option>
                <?php if (!empty($year_levels)): foreach ($year_levels as $yl): $lvl = (string)($yl->year_level ?? ''); if ($lvl==='') continue; ?>
                  <option value="<?= h($lvl) ?>" <?= (($year_level ?? '') === $lvl ? 'selected' : '') ?>><?= h($lvl) ?></option>
                <?php endforeach; endif; ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label class="small text-muted">Date</label>
              <input type="date" name="date" value="<?= h($date ?? '') ?>" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label class="small text-muted">Session</label>
              <select name="session" class="form-control">
                <option value="">All</option>
                <option value="am"  <?= (($session ?? '')==='am' ? 'selected' : '') ?>>AM</option>
                <option value="pm"  <?= (($session ?? '')==='pm' ? 'selected' : '') ?>>PM</option>
                <option value="eve" <?= (($session ?? '')==='eve' ? 'selected' : '') ?>>EVE</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="<?= site_url('AttendanceLogs') ?>" class="btn btn-light">Clear</a>
          <button type="submit" class="btn btn-primary">View</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('includes/themecustomizer.php'); ?>

<!-- Assets -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>

<script>
$(function(){
  var $table = $('#logsTable');
  var $filterModal = $('#filterModal');
  var $sectionSelect = $filterModal.find('select[name="section"]');
  var $yearSelect = $filterModal.find('select[name="year_level"]');
  var originalSectionOptions = $sectionSelect.find('option').clone();

  // DataTable (minimal UI), hide global search, use our Student # search only
  var dt = $table.DataTable({
    pageLength: 25,
    responsive: false,   // sticky headers behave nicer
    autoWidth: false,
    ordering: true,
    orderFixed: [[2,'asc']],
    order: [[2,'asc'],[4,'desc']], // Section asc then Check-In desc
    searching: true,
    lengthChange: false,
    info: false,
    scrollX: false,
    dom: 'lrtip'         // hide the built-in global search
  });

  // Section grouping
  dt.on('draw', function(){
    var api = dt.api();
    var rows = api.rows({ page: 'current' }).nodes();
    var last = null;
    var colCount = api.columns().nodes().length;

    $('#logsTable tbody tr.group-row').remove();

    api.column(2, { page: 'current' }).data().each(function(section, i){
      section = section || 'Unassigned';
      if (last !== section) {
        $(rows).eq(i).before(
          '<tr class="group-row"><td colspan="' + colCount + '"><span class="group-label"><i class="bi bi-people-fill"></i>Section: ' + $('<div>').text(section).html() + '</span></td></tr>'
        );
        last = section;
      }
    });
  });
  dt.draw();

  // Student # search: column 0 only
  $('#studentSearch').on('keyup change', function(){
    dt.column(0).search(this.value).draw();
  });

  function refreshSectionOptions(year) {
    var current = $sectionSelect.val();
    var hasSelect2 = $sectionSelect.hasClass('select2-hidden-accessible');

    $sectionSelect.find('option').remove();
    originalSectionOptions.each(function(){
      var $opt = $(this).clone();
      var optVal = ($opt.val() || '').toString();
      var optYear = ($opt.data('year') || '').toString();

      if (optVal === '' || !year || optYear === '' || optYear === year) {
        $sectionSelect.append($opt);
      }
    });

    if (current) {
      var hasValue = false;
      $sectionSelect.find('option').each(function(){
        if ($(this).val() === current) { hasValue = true; return false; }
      });
      if (hasValue) {
        $sectionSelect.val(current);
      } else if (year) {
        $sectionSelect.val('');
      }
    } else if (year) {
      $sectionSelect.val('');
    }

    if (hasSelect2) {
      $sectionSelect.trigger('change.select2');
    }
  }

  // align sections immediately if filters pre-selected
  refreshSectionOptions($yearSelect.val());

  // Filters modal
  $('#openFilters').on('click', function(){ $filterModal.modal('show'); });
  $filterModal.on('shown.bs.modal', function(){
    $(this).find('.select2').select2({ width:'100%' });
    // ensure select options are aligned with current year selection
    refreshSectionOptions($yearSelect.val());
  });

  $yearSelect.on('change', function(){
    refreshSectionOptions($(this).val());
  });

});
</script>

</body>
</html>
