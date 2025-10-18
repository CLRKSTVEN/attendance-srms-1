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
                     <!-- Back button (browser-back first; falls back to Page/admin) -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                 <a href="<?= base_url('Page/admin'); ?>" class="btn btn-primary btn-sm"
   onclick="if (history.length > 1) { history.back(); return false; }">
   <i class="mdi mdi-arrow-left"></i> Back
</a>
</div>
                <h4 class="page-title">Masterlist By Year Level - <?php echo $_GET['yearlevel']; ?> Year, <?php echo $this->session->userdata('semester'); ?> SY <?php echo $this->session->userdata('sy'); ?></h4>
             
                <div class="page-title-right">
                  <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li>
                  </ol>
                </div>
                <div class="clearfix"></div>
                <hr style="border:0; height:2px; background:linear-gradient(to right, #4285F4 60%, #FBBC05 80%, #34A853 100%); border-radius:1px; margin:20px 0;" />
              </div>
            </div>
          </div>
          
          <!-- end page title -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body table-responsive">
                  <!--<h4 class="m-t-0 header-title mb-4"><b>Default Example</b></h4>-->
                  <?php echo $this->session->flashdata('msg'); ?>
                  <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                        <th>Studemt Name</th>
                        <th>Student No.</th>
                        <th>Course</th>
                        <th>Section</th>
                      </tr>
                    </thead>
                    <tbody>


                      <?php
                      $i = 1;
                      foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>" . $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName . "</td>";
                      ?>
                        <td><?php echo $row->StudentNumber; ?></a></td>
<td><?= htmlspecialchars($row->Course ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $row->Section; ?></td>

                        <td style="text-align:center;">
                          <?php
                          $allowed_levels = ['Head Registrar', 'Registrar', 'Assistant Registrar'];
                          if (in_array($this->session->userdata('level'), $allowed_levels)):
                          ?>

                            <button type="button" class="btn btn-info btn-xs waves-effect waves-light">
                              <a href="<?= base_url(); ?>Page/updateEnrollment?id=<?php echo $row->semstudentid; ?>&?email=<?php echo $row->email; ?>"><b><i class="mdi mdi-account-settings-variant mr-1"></i> Edit</b></a>
                            </button>

                            <button type="button" class="btn btn-warning btn-xs waves-effect waves-light">
                              <a href="<?= base_url(); ?>Page/deleteEnrollment?id=<?php echo $row->semstudentid; ?>"
                                onclick="return confirm('Are you sure you want to delete this enrollment?');">
                                <b><i class="mdi mdi-account-settings-variant mr-1"></i> Delete</b>
                              </a>

                            </button>
                          <?php endif; ?>
                        </td>
                      <?php
                        echo "</tr>";
                      }
                      ?>
                    </tbody>

                  </table>
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

  <!-- Responsive examples -->
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

  <!-- Datatables init -->
  <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>

</html>