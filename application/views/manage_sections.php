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
                <?php if ($this->session->flashdata('msg')): ?>
                    <?= $this->session->flashdata('msg'); ?>
                <?php endif; ?>

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
                                                        $courseLabel = trim(($section->CourseCode ?? '') . ' - ' . ($section->CourseDescription ?? ''));
                                                        if ($courseLabel === '-' || $courseLabel === ' - ') {
                                                            $courseLabel = $section->CourseCode ?? $section->CourseDescription ?? $section->courseid;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($courseLabel, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= $section->year_level ?></td>
                                                        <td><?= $section->section ?></td>
                                                        <td style="text-align:center;">
                                                            <a href="<?= base_url('Page/editSection/' . $section->id); ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i> Edit</a>
                                                            <a href="<?= base_url('Page/deleteSection/' . $section->id); ?>" onclick="return confirm('Are you sure you want to delete this section?');" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i> Delete</a>
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
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

</body>
</html>
