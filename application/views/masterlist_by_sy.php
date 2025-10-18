<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar --> <!-- ========== Left Sidebar Start ========== -->

        <!-- Lef Side bar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Masterlist By Semester <br />
                                    <span class="badge badge-primary mb-3"><?php echo $this->session->userdata('semester'); ?>, SY <?php echo $this->session->userdata('sy'); ?></span>
                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                                <hr style="border:0; height:2px; background:linear-gradient(to right, #4285F4 60%, #FBBC05 80%, #34A853 100%); border-radius:1px; margin:20px 0;" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="tech-companies-1" class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th data-priority="1">No.</th>
                                                    <th data-priority="1">Student No.</th>
                                                    <th>Student Name</th>
                                                    <th data-priority="1">Course</th>
                                                    <th data-priority="1">Major</th>
                                                    <th data-priority="1">Year Level</th>
                                                    <th data-priority="1">Sex</th>
                                                    <th data-priority="1">Civil Status</th>
                                                    <th data-priority="1">Birth Date</th>
                                                    <th data-priority="1">Address</th>
                                                    <th data-priority="1">Guardian</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php
                                                $i = 1;
                                                foreach ($data as $row) {

                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>" . $row->StudentNumber . "</td>";
                                                    echo "<td>" . $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName . "</td>";
                                                ?>
                                                    <td><?php echo $row->Course; ?></td>
                                                    <td><?php echo $row->Major; ?></td>
                                                    <?php
                                                    echo "<td>" . $row->YearLevel . "</td>";
                                                    echo "<td>" . $row->Sex . "</td>";
                                                    echo "<td>" . $row->CivilStatus . "</td>";
                                                    echo "<td>" . $row->birthDate . "</td>";
                                                    ?>

                                                <?php
                                                    echo "<td>" . $row->sitioPresent . ' ' . $row->brgyPresent . ', ' . $row->cityPresent . ', ' . $row->provincePresent . "</td>";
                                                    echo "<td>" . $row->guardian . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
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
        <!-- end content -->



        <!-- Footer Start -->
        <?php include('includes/footer.php'); ?>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <!-- Right Sidebar -->
    <?php include('includes/themecustomizer.php'); ?>
    <!-- /Right-bar -->


    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Chat app -->
    <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>

    <!-- Todo app -->
    <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>

    <!--Morris Chart-->
    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>

    <!-- Sparkline charts -->
    <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Dashboard init JS -->
    <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <!-- Required datatable js -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- Responsive Table js -->
    <script src="<?= base_url(); ?>assets/libs/rwd-table/rwd-table.min.js"></script>

    <!-- Init js -->
    <script src="<?= base_url(); ?>assets/js/pages/responsive-table.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>

</html>