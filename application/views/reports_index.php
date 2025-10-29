<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
$reportSectionOptions = [
    ['id' => 'by_yearlevel', 'label' => 'Students by Year Level'],
    ['id' => 'by_course', 'label' => 'Students by Course'],
    ['id' => 'sections_per_course', 'label' => 'Sections per Course'],
    ['id' => 'by_section', 'label' => 'Students by Section'],
    ['id' => 'events', 'label' => 'Events'],
    ['id' => 'attendance', 'label' => 'Recent Attendance'],
];
?>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid section-gutters">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between mb-2">
                                <div>
                                    <h4 class="page-title mb-1">Reports & Insights</h4>
                                </div>
                                <div class="btn-group no-print">
                                    <button type="button" id="exportBtn" class="btn btn-outline-secondary btn-sm">
                                        <i class="mdi mdi-file-delimited"></i> Export CSV
                                    </button>
                                    <button type="button" id="printBtn" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-printer"></i> Print
                                    </button>
                                </div>
                            </div>
                            <hr style="border:0;height:2px;background:linear-gradient(to right,#4285F4 60%,#FBBC05 80%,#34A853 100%);border-radius:1px;margin:10px 0 16px" />
                        </div>
                    </div>
                    <div class="row" id="section-kpis" data-print-id="kpis">
                        <div class="col-md-3 mb-3">
                            <div class="card kpi p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">Total Courses</div>
                                        <div class="display-5 lh-1 kpi-number kpi-blue"><?= count($by_course) ?></div>
                                    </div>
                                    <div class="icon bg-soft-primary"><i class="mdi mdi-school"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card kpi p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">Total Sections</div>
                                        <div class="display-5 lh-1 kpi-number kpi-green">
                                            <?php $totalSections = array_sum(array_map(function ($r) {
                                                return (int)$r->sections;
                                            }, $sections_count));
                                            echo $totalSections; ?>
                                        </div>
                                    </div>
                                    <div class="icon bg-soft-primary"><i class="mdi mdi-door-open"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card kpi p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">Total Students (unique)</div>
                                        <div class="display-5 lh-1 kpi-number kpi-amber">
                                            <?php $sum = array_sum(array_map(function ($r) {
                                                return (int)$r->total;
                                            }, $by_course));
                                            echo $sum; ?>
                                        </div>
                                    </div>
                                    <div class="icon bg-soft-warning"><i class="mdi mdi-account-group"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card kpi p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">Events / Scans</div>
                                        <div class="h5 mb-0">
                                            <span class="count-badge count-blue"><?= (int)$events_total ?></span>
                                            <span class="mx-1 text-muted">/</span>
                                            <span class="count-badge count-cyan"><?= (int)$event_scans ?></span>
                                        </div>
                                    </div>
                                    <div class="icon bg-soft-info"><i class="mdi mdi-calendar-check"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="reportsAccordion" class="accordion">
                        <div class="card mb-3 section-card" id="section-yearlevel" data-print-id="by_yearlevel">
                            <div class="card-header py-2 px-3" id="headYearLevel">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed section-toggle no-print" type="button" data-target="#collapseYearLevel">
                                        <i class="mdi mdi-chevron-right mr-1"></i> Students by Year Level
                                    </button>
                                    <span class="only-print h6">Students by Year Level</span>
                                </h6>
                            </div>
                            <div id="collapseYearLevel" class="collapse" aria-labelledby="headYearLevel">
                                <div class="card-body p-0 px-md-3">
                                    <table class="table table-sm mb-0 table-tight">
                                        <thead>
                                            <tr>
                                                <th>Year Level</th>
                                                <th class="text-right">Students</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($by_yearlevel as $r): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($r->YearLevel ?: '—') ?></td>
                                                    <td class="text-right"><span class="count-badge count-amber"><?= (int)$r->total ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 section-card" id="section-course" data-print-id="by_course">
                            <div class="card-header py-2 px-3" id="headCourse">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed section-toggle no-print" type="button" data-target="#collapseCourse">
                                        <i class="mdi mdi-chevron-right mr-1"></i> Students by Course
                                    </button>
                                    <span class="only-print h6">Students by Course</span>
                                </h6>
                            </div>
                            <div id="collapseCourse" class="collapse" aria-labelledby="headCourse">
                                <div class="card-body p-0 px-md-3">
                                    <table class="table table-sm mb-0 table-tight">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th class="text-right">Students</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($by_course as $r): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($r->Course ?: '—') ?></td>
                                                    <td class="text-right"><span class="count-badge count-blue"><?= (int)$r->total ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 section-card" id="section-sections" data-print-id="sections_per_course">
                            <div class="card-header py-2 px-3" id="headSectionsCount">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed section-toggle no-print" type="button" data-target="#collapseSectionsCount">
                                        <i class="mdi mdi-chevron-right mr-1"></i> Number of Sections per Course
                                    </button>
                                    <span class="only-print h6">Number of Sections per Course</span>
                                </h6>
                            </div>
                            <div id="collapseSectionsCount" class="collapse" aria-labelledby="headSectionsCount">
                                <div class="card-body p-0 px-md-3">
                                    <table class="table table-sm mb-0 table-tight">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th class="text-right">Sections</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sections_count as $r): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($r->Course ?: '—') ?></td>
                                                    <td class="text-right"><span class="count-badge count-green"><?= (int)$r->sections ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 section-card" id="section-bysection" data-print-id="by_section">
                            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between" id="headBySection">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed section-toggle no-print" type="button" data-target="#collapseBySection">
                                        <i class="mdi mdi-chevron-right mr-1"></i> Students by Section
                                    </button>
                                    <span class="only-print h6">Students by Section</span>
                                </h6>
                            </div>
                            <div id="collapseBySection" class="collapse" aria-labelledby="headBySection">
                                <div class="card-body p-0 px-md-3">
                                    <div class="table-responsive">
                                        <table id="bySectionTable" class="table table-striped table-sm mb-0 table-tight">
                                            <thead>
                                                <tr>
                                                    <th>Course</th>
                                                    <th>Year Level</th>
                                                    <th>Section</th>
                                                    <th class="text-right">Students</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($by_section as $r): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($r->Course ?: '—') ?></td>
                                                        <td><?= htmlspecialchars($r->YearLevel ?: '—') ?></td>
                                                        <td><?= htmlspecialchars($r->Section ?: '—') ?></td>
                                                        <td class="text-right"><span class="count-badge count-purple"><?= (int)$r->total ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 section-card" id="section-events" data-print-id="events">
                            <div class="card-header py-2 px-3" id="headEvents">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed section-toggle no-print" type="button" data-target="#collapseEvents">
                                        <i class="mdi mdi-chevron-right mr-1"></i> Events & Attendance (latest)
                                    </button>
                                    <span class="only-print h6">Events & Attendance (latest)</span>
                                </h6>
                            </div>
                            <div id="collapseEvents" class="collapse" aria-labelledby="headEvents">
                                <div class="card-body p-0 px-md-3">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm mb-0 table-tight">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Date</th>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th>Program</th>
                                                    <th class="text-right">Scan Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($events_summary as $ev): ?>
                                                    <?php
                                                    $dateText = (!empty($ev->activity_date) && $ev->activity_date !== '0000-00-00')
                                                        ? date('M d, Y', strtotime($ev->activity_date))
                                                        : (!empty($ev->start_at) ? date('M d, Y', strtotime($ev->start_at)) : '—');

                                                    $rawStart = $ev->meta_start_time ?: ($ev->meta_start ?: $ev->start_at);
                                                    $rawEnd   = $ev->meta_end_time   ?: ($ev->meta_end   ?: $ev->end_at);

                                                    $fmt = function ($v) {
                                                        if (empty($v)) return '—';
                                                        $ts = strtotime($v);
                                                        return $ts ? date('h:i A', $ts) : '—';
                                                    };

                                                    $startText   = $fmt($rawStart);
                                                    $endText     = $fmt($rawEnd);
                                                    $programText = isset($ev->program) && $ev->program !== '' ? $ev->program : '—';
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($ev->title) ?></td>
                                                        <td><?= htmlspecialchars($dateText) ?></td>
                                                        <td><?= htmlspecialchars($startText) ?></td>
                                                        <td><?= htmlspecialchars($endText) ?></td>
                                                        <td><?= htmlspecialchars($programText) ?></td>
                                                        <td class="text-right"><span class="count-badge count-cyan"><?= (int)$ev->scans ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <?php if (empty($events_summary)): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted p-3">No events found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 section-card" id="section-attendance" data-print-id="attendance">
                            <div class="card-header py-2 px-3" id="headAttendance">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed section-toggle no-print" type="button" data-target="#collapseAttendance">
                                        <i class="mdi mdi-chevron-right mr-1"></i> Recent Attendance (latest 100)
                                    </button>
                                    <span class="only-print h6">Recent Attendance (latest 100)</span>
                                </h6>
                            </div>
                            <div id="collapseAttendance" class="collapse" aria-labelledby="headAttendance">
                                <div class="card-body p-0 px-md-3">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm mb-0 table-tight">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Course</th>
                                                    <th>Year / Section</th>
                                                    <th>Activity</th>
                                                    <th>Session</th>
                                                    <th>IN</th>
                                                    <th>OUT</th>
                                                    <th>Source</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($recent_attendance as $row):
                                                    $parts = array_filter([$row->FirstName ?? '', $row->MiddleName ?? '', $row->LastName ?? '']);
                                                    $fullName = trim(implode(' ', $parts));
                                                    $sessionMap = ['am' => 'Morning', 'pm' => 'Afternoon', 'eve' => 'Evening'];
                                                    $sessionLabel = $sessionMap[$row->session ?? ''] ?? ($row->session ?: '—');
                                                ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= htmlspecialchars($fullName ?: $row->student_number ?: '—') ?></td>
                                                        <td><?= htmlspecialchars($row->CourseName ?: '—') ?></td>
                                                        <td><?= htmlspecialchars(($row->yearLevel ?: '—') . ' / ' . ($row->section ?: '—')) ?></td>
                                                        <td><?= htmlspecialchars($row->activity_title ?: '—') ?></td>
                                                        <td><?= htmlspecialchars($sessionLabel) ?></td>
                                                        <td><?= !empty($row->checked_in_at)  ? htmlspecialchars(date('M d, Y h:i:s A', strtotime($row->checked_in_at)))  : '—' ?></td>
                                                        <td><?= !empty($row->checked_out_at) ? htmlspecialchars(date('M d, Y h:i:s A', strtotime($row->checked_out_at))) : '—' ?></td>
                                                        <td><span class="badge badge-light"><?= htmlspecialchars(strtoupper($row->source ?: '—')) ?></span></td>
                                                        <td><?= htmlspecialchars($row->remarks ?: '') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <?php if (empty($recent_attendance)): ?>
                                                    <tr>
                                                        <td colspan="10" class="text-center text-muted p-3">No attendance records.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/footer_plugins.php'); ?>

    <div class="modal fade no-print" id="actionPicker" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title">Print Options</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input picker-opt" id="optAll" checked>
                        <label class="custom-control-label" for="optAll"><strong>Include All</strong></label>
                    </div>
                    <hr>

                    <?php foreach ($reportSectionOptions as $index => $option): ?>
                        <?php $isLast = $index === count($reportSectionOptions) - 1; ?>
                        <div class="custom-control custom-checkbox<?= $isLast ? '' : ' mb-2'; ?>">
                            <input type="checkbox" class="custom-control-input picker-opt-item" id="opt-<?= $option['id']; ?>" data-target="<?= $option['id']; ?>" checked>
                            <label class="custom-control-label" for="opt-<?= $option['id']; ?>"><?= $option['label']; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmAction" class="btn btn-primary btn-sm" data-mode="print"><i class="mdi mdi-printer"></i> Print</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $(document).on('click', '.section-toggle', function(e) {
                e.preventDefault();
                var target = $(this).attr('data-target');
                if (target) $(target).collapse('toggle');
            });

            $('#reportsAccordion .collapse')
                .on('shown.bs.collapse', function() {
                    $(this).prev('.card-header').find('.mdi')
                        .removeClass('mdi-chevron-right').addClass('mdi-chevron-down');
                })
                .on('hidden.bs.collapse', function() {
                    $(this).prev('.card-header').find('.mdi')
                        .removeClass('mdi-chevron-down').addClass('mdi-chevron-right');
                });

            var bySectionInit = false;
            $('#collapseBySection').on('shown.bs.collapse', function() {
                if (!bySectionInit) {
                    $('#bySectionTable').DataTable({
                        searching: false,
                        paging: false,
                        info: false,
                        lengthChange: false,
                        order: [
                            [0, 'asc'],
                            [1, 'asc'],
                            [2, 'asc']
                        ],
                        autoWidth: false
                    });
                    bySectionInit = true;
                }
            });

            function setPickerMode(mode) {
                var $modal = $('#actionPicker');
                var $title = $modal.find('.modal-title');
                var $confirm = $('#confirmAction');

                if (mode === 'export') {
                    $title.text('Export Options');
                    $confirm
                        .data('mode', 'export')
                        .removeClass('btn-primary')
                        .addClass('btn-success')
                        .html('<i class="mdi mdi-file-delimited"></i> Export CSV');
                } else {
                    $title.text('Print Options');
                    $confirm
                        .data('mode', 'print')
                        .removeClass('btn-success')
                        .addClass('btn-primary')
                        .html('<i class="mdi mdi-printer"></i> Print');
                }
            }

            function getSelectedTargets() {
                return $('.picker-opt-item:checked').map(function() {
                    return $(this).data('target');
                }).get();
            }

            function getCellText($cell) {
                return $cell.text().replace(/\s+/g, ' ').trim();
            }

            function escapeCsv(value) {
                if (value == null) {
                    value = '';
                }
                value = value.toString();
                if (/[",\r\n]/.test(value)) {
                    value = '"' + value.replace(/"/g, '""') + '"';
                }
                return value;
            }

            function exportSectionsToCsv(sectionIds) {
                var rows = [];

                sectionIds.forEach(function(id) {
                    var $section = $('[data-print-id="' + id + '"]');
                    if (!$section.length) {
                        return;
                    }

                    var title = $section.find('.only-print').first().text().trim();
                    if (!title) {
                        var $toggle = $section.find('.section-toggle').first().clone();
                        $toggle.find('.mdi').remove();
                        title = $toggle.text().replace(/\s+/g, ' ').trim();
                    }
                    if (!title) {
                        title = id;
                    }

                    var $table = $section.find('table').first();
                    if (!$table.length) {
                        return;
                    }

                    if (rows.length) {
                        rows.push([]);
                    }
                    rows.push([title]);

                    var headers = $table.find('thead th').map(function() {
                        return getCellText($(this));
                    }).get();
                    if (headers.length) {
                        rows.push(headers);
                    }

                    $table.find('tbody tr').each(function() {
                        var $cells = $(this).find('td');
                        if (!$cells.length) {
                            return;
                        }
                        var row = $cells.map(function() {
                            return getCellText($(this));
                        }).get();
                        rows.push(row);
                    });
                });

                if (!rows.length) {
                    return;
                }

                var csvContent = rows.map(function(row) {
                    return row.map(escapeCsv).join(',');
                }).join('\r\n');

                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                var url = URL.createObjectURL(blob);

                var now = new Date();
                var pad = function(num) {
                    return num < 10 ? '0' + num : num;
                };
                var timestamp = [
                    now.getFullYear(),
                    pad(now.getMonth() + 1),
                    pad(now.getDate())
                ].join('') + '-' + [
                    pad(now.getHours()),
                    pad(now.getMinutes()),
                    pad(now.getSeconds())
                ].join('');

                var filename = 'reports-export-' + timestamp + '.csv';

                var link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', filename);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            }

            $('#printBtn').on('click', function() {
                setPickerMode('print');
                $('#optAll').prop('checked', true).trigger('change');
                $('#actionPicker').modal('show');
            });

            $('#exportBtn').on('click', function() {
                setPickerMode('export');
                $('#optAll').prop('checked', true).trigger('change');
                $('#actionPicker').modal('show');
            });

            $('#optAll').on('change', function() {
                var checked = $(this).is(':checked');
                $('.picker-opt-item').prop('checked', checked);
            });

            $(document).on('change', '.picker-opt-item', function() {
                var allOn = $('.picker-opt-item').length === $('.picker-opt-item:checked').length;
                $('#optAll').prop('checked', allOn);
            });

            $('#confirmAction').on('click', function() {
                var mode = $(this).data('mode');
                var selected = getSelectedTargets();

                if (!selected.length) {
                    alert('Please select at least one section.');
                    return;
                }

                $('#actionPicker').modal('hide');

                if (mode === 'export') {
                    exportSectionsToCsv(selected);
                    return;
                }

                var all = $('[data-print-id]').map(function() {
                    return $(this).data('print-id');
                }).get();

                all.forEach(function(id) {
                    $('[data-print-id="' + id + '"]').addClass('print-hide');
                });

                selected.forEach(function(id) {
                    $('[data-print-id="' + id + '"]').removeClass('print-hide');
                });

                selected.forEach(function(id) {
                    var card = $('[data-print-id="' + id + '"]');
                    card.find('.collapse').collapse('show');
                });

                window.print();

                setTimeout(function() {
                    $('[data-print-id]').removeClass('print-hide');
                }, 500);
            });
        });
    </script>

    <style>
        .section-gutters {
            padding-left: .5rem;
            padding-right: .5rem;
        }

        .page-title-box .page-title {
            color: #111827 !important;
        }

        @media (min-width:768px) {
            .section-gutters {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        @media (min-width:1200px) {
            .section-gutters {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }
        }

        .section-card .card-body {
            padding-left: .25rem;
            padding-right: .25rem;
        }

        @media (min-width:768px) {
            .section-card .card-body {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        .kpi {
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 100%);
            box-shadow: 0 6px 18px rgba(36, 59, 83, .08);
        }

        .kpi .icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 28px;
        }

        .kpi-number {
            font-weight: 700;
            letter-spacing: .2px;
        }

        .kpi-blue {
            color: #2563eb;
        }

        .kpi-green {
            color: #059669;
        }

        .kpi-amber {
            color: #b45309;
        }

        .bg-soft-primary {
            background: rgba(37, 99, 235, .08);
            color: #2563eb
        }

        .bg-soft-success {
            background: rgba(16, 185, 129, .10);
            color: #10b981
        }

        .bg-soft-warning {
            background: rgba(251, 191, 36, .10);
            color: #f59e0b
        }

        .bg-soft-info {
            background: rgba(14, 165, 233, .10);
            color: #0ea5e9
        }

        .count-badge {
            display: inline-block;
            min-width: 36px;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .9rem;
            text-align: center;
            line-height: 1;
            letter-spacing: .2px;
            background: #eef2ff;
            color: #3730a3;
        }

        .count-blue {
            background: #e0ecff;
            color: #1d4ed8;
        }

        .count-green {
            background: #dcfce7;
            color: #166534;
        }

        .count-amber {
            background: #fef3c7;
            color: #92400e;
        }

        .count-purple {
            background: #efe7ff;
            color: #6d28d9;
        }

        .count-cyan {
            background: #cffafe;
            color: #155e75;
        }

        .section-toggle {
            font-weight: 600;
        }

        .section-toggle:focus {
            box-shadow: none;
        }

        .card-header {
            background: #fff;
        }

        .card-header h6 {
            line-height: 1;
        }

        .accordion .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .accordion .card+.card {
            margin-top: .5rem;
        }

        .table-tight thead th {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0 !important;
            font-size: .82rem;
            color: #334155;
            vertical-align: middle;
        }

        .table-tight tbody td {
            padding: .45rem .75rem;
            vertical-align: middle;
        }

        .print-hide {
            display: none !important;
        }

        .only-print {
            display: none;
        }

        @media print {

            html,
            body {
                background: #fff !important;
                color: #000 !important;
            }

            body * {
                color: #000 !important;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

            .content-page,
            .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
            }

            .card,
            .kpi {
                box-shadow: none !important;
            }

            .card {
                border: 1px solid #ddd;
                margin-bottom: .75rem;
            }

            .only-print {
                display: inline-block !important;
            }

            .btn,
            .badge {
                filter: grayscale(100%);
            }

            .accordion .collapse {
                display: block !important;
                height: auto !important;
            }

            .table-tight tbody td {
                padding: .35rem .6rem;
            }
        }

        .lh-1 {
            line-height: 1;
        }

        .display-5 {
            font-size: 2rem;
        }
    </style>
</body>

</html>
