<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <?php include('includes/top-nav-bar.php'); ?>
    <!-- end Topbar -->

    <!-- Left Sidebar Start -->
    <?php include('includes/sidebar.php'); ?>
    <!-- Left Sidebar End -->

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <?php
                    $flashMsgRaw = $this->session->flashdata('msg');
                    $flashSuccess = $this->session->flashdata('success');
                    $flashError = $this->session->flashdata('error');
                    $flashInfo = $this->session->flashdata('info');
                    $flashMsg = $flashMsgRaw ? strip_tags($flashMsgRaw) : null;
                ?>

                <!-- start page title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title-box">
                            <h4 class="page-title">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addSectionModal">
                                    Add Section
                                </button>
                                    <a href="<?= base_url('Page/admin'); ?>" class="btn btn-secondary"> Back </a>
                            </h4>

                      
                        

                            <div class="page-title-right">
                                <ol class="breadcrumb p-0 m-0"></ol>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="border:0; height:2px; background:linear-gradient(to right, #4285F4 60%, #FBBC05 80%, #34A853 100%); border-radius:1px; margin:20px 0;" />
                        </div>
                    </div>
                </div>

                <!-- start row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <h5 style="text-transform:uppercase"><strong>Manage Sections </strong>
                                            <br /><span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                        </h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Course</th>
                                                    <th>Year Level</th>
                                                    <th>Section</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($sections as $section): ?>
                                                    <?php
                                                        $courseCode = trim($section->CourseCode ?? '');
                                                        $courseDesc = trim($section->CourseDescription ?? '');
                                                        $courseLabel = $courseCode !== '' ? $courseCode : ($courseDesc !== '' ? $courseDesc : ($section->courseid ?? ''));
                                                        $courseExtra = ($courseDesc !== '' && strcasecmp($courseDesc, $courseLabel) !== 0) ? $courseDesc : '';
                                                        $sectionName = trim($section->section ?? '');
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= htmlspecialchars($courseLabel, ENT_QUOTES, 'UTF-8') ?>
                                                            <?php if ($courseExtra !== ''): ?>
                                                                <div class="text-muted small"><?= htmlspecialchars($courseExtra, ENT_QUOTES, 'UTF-8') ?></div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= htmlspecialchars($section->year_level, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?= htmlspecialchars($sectionName, ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td style="text-align:center;">
                                                            <a href="<?= base_url('Page/editSection/' . $section->id); ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i> Edit</a>
                                                            <a href="<?= base_url('Page/deleteSection/' . $section->id); ?>" class="btn btn-danger btn-sm section-delete-btn"
                                                               data-delete-url="<?= base_url('Page/deleteSection/' . $section->id); ?>"
                                                               data-section-name="<?= htmlspecialchars($sectionName !== '' ? $sectionName : $courseLabel, ENT_QUOTES, 'UTF-8'); ?>"><i class="mdi mdi-delete"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end container-fluid -->
        </div>
    </div>

    <!-- Modal for Add Section -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">Add Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?= base_url('Page/addSection'); ?>">
                        <div class="form-group">
                            <label for="courseid">Course</label>
                            <select name="courseid" class="form-control" required>
                                <option value="">Select Course</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course->courseid ?>"><?= $course->CourseCode . ' - ' . $course->CourseDescription ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level</label>
                            <select name="year_level" class="form-control select2" required>
                                <option value="">Select Year Level</option>
                                <?php if (!empty($yearLevels)): ?>
                                    <?php foreach ($yearLevels as $yearLevel): ?>
                                        <option value="<?= $yearLevel->year_level ?>"><?= $yearLevel->year_level ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <input type="text" name="section" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Section</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <?php include('includes/footer.php'); ?>
    <!-- end Footer -->

</div>

<!-- Vendor js -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

<script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

<script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

<script>
(function () {
    function showAlert(options) {
        if (!options) {
            return Promise.resolve();
        }
        if (window.Swal && typeof window.Swal.fire === 'function') {
            return window.Swal.fire(options);
        }
        if (options.text) {
            window.alert(options.text);
        }
        return Promise.resolve();
    }

    var flashData = {
        error: <?= json_encode($flashError ?? null); ?>,
        success: <?= json_encode($flashSuccess ?? null); ?>,
        info: <?= json_encode($flashInfo ?? null); ?>,
        legacy: <?= json_encode($flashMsg ?? null); ?>
    };

    var alertOptions = null;
    if (flashData.error) {
        alertOptions = {
            icon: 'error',
            title: 'Error',
            text: flashData.error,
            confirmButtonColor: '#348cd4'
        };
    } else if (flashData.success) {
        alertOptions = {
            icon: 'success',
            title: 'Success',
            text: flashData.success,
            confirmButtonColor: '#348cd4'
        };
    } else if (flashData.info) {
        alertOptions = {
            icon: 'info',
            title: 'Notice',
            text: flashData.info,
            confirmButtonColor: '#348cd4'
        };
    } else if (flashData.legacy) {
        alertOptions = {
            icon: 'info',
            title: 'Notice',
            text: flashData.legacy,
            confirmButtonColor: '#348cd4'
        };
    }

    if (alertOptions) {
        showAlert(alertOptions);
    }

    function closestByClass(element, className) {
        while (element && element !== document) {
            if (element.classList && element.classList.contains(className)) {
                return element;
            }
            element = element.parentNode;
        }
        return null;
    }

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest ? event.target.closest('.section-delete-btn') : closestByClass(event.target, 'section-delete-btn');
        if (!trigger) {
            return;
        }
        event.preventDefault();

        var deleteUrl = trigger.getAttribute('data-delete-url') || trigger.getAttribute('href');
        if (!deleteUrl) {
            return;
        }
        var sectionName = trigger.getAttribute('data-section-name') || 'this section';
        var message = 'Delete ' + sectionName + '? This cannot be undone.';

        if (window.Swal && typeof window.Swal.fire === 'function') {
            window.Swal.fire({
                title: 'Delete section?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f1556c',
                cancelButtonColor: '#6c757d'
            }).then(function (result) {
                var confirmed = false;
                if (result) {
                    if (typeof result.isConfirmed !== 'undefined') {
                        confirmed = result.isConfirmed;
                    } else if (typeof result.value !== 'undefined') {
                        confirmed = !!result.value;
                    } else if (result === true) {
                        confirmed = true;
                    }
                }
                if (confirmed) {
                    window.location.href = deleteUrl;
                }
            });
        } else if (window.confirm(message)) {
            window.location.href = deleteUrl;
        }
    });

    var addSectionForm = document.querySelector('#addSectionModal form');
    if (addSectionForm) {
        addSectionForm.addEventListener('submit', function (event) {
            if (addSectionForm.__submitting) {
                return;
            }
            event.preventDefault();

            var proceed = function () {
                addSectionForm.__submitting = true;
                addSectionForm.submit();
            };

            var confirmOptions = {
                title: 'Add section?',
                text: 'Please confirm you want to save this section.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#348cd4',
                cancelButtonColor: '#6c757d'
            };

            if (window.Swal && typeof window.Swal.fire === 'function') {
                window.Swal.fire(confirmOptions).then(function (result) {
                    var confirmed = false;
                    if (result) {
                        if (typeof result.isConfirmed !== 'undefined') {
                            confirmed = result.isConfirmed;
                        } else if (typeof result.value !== 'undefined') {
                            confirmed = !!result.value;
                        } else if (result === true) {
                            confirmed = true;
                        }
                    }
                    if (confirmed) {
                        proceed();
                    }
                });
            } else if (window.confirm(confirmOptions.text)) {
                proceed();
            }
        });
    }
})();
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

</body>
</html>
