<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

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
          <?php if ($this->session->flashdata('msg')): ?>
            <?= $this->session->flashdata('msg'); ?>
          <?php endif; ?>

          <!-- start page title -->
          <div class="row">
            <div class="col-md-12">
              <div class="page-title-box">
                <h4 class="page-title">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#courseModal">
                    Add Course
                  </button>
                </h4>
                <div class="page-title-right">
                  <ol class="breadcrumb p-0 m-0">
                    <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                  </ol>
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
                <!-- <div class="panel-heading">
                                                    <h4>Invoice</h4>
                                                </div> -->
                <div class="card-body">
                  <div class="clearfix">

                    <div class="float-left">
                      <h5 style="text-transform:uppercase"><strong>COURSES</strong>
                        <br /><span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                      </h5>
                    </div>
                    <div class="table-responsive">
                      <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Course</th>
                            <th>Major</th>
                            <th>Duration</th>
                            <th>Recognition No.</th>
                            <th>Series Year</th>
                            <!-- <th>Program Head</th> -->
                            <th style="text-align:center;">Action</th>
                          </tr>
                        </thead>
                        <tbody>


                          <?php foreach ($data as $row) { ?>
                            <tr>
                              <td><?= $row->CourseCode; ?></td>
                              <td><?= $row->CourseDescription; ?></td>
                              <td><?= $row->Major; ?></td>
                              <td><?= $row->Duration; ?></td>
                              <td><?= $row->recogNo; ?></td>
                              <td><?= $row->SeriesYear; ?></td>
                              <!-- <td><?= $row->FirstName; ?> <?= $row->MiddleName; ?> <?= $row->LastName; ?></td> -->

                              <td style="text-align:center;">
                                <a href="<?= base_url('Settings/updateCourse?courseid=' . $row->courseid); ?>"
                                  class="btn btn-primary waves-effect waves-light btn-sm"><i class="mdi mdi-pencil"></i>Edit</a>

                                <!-- <a href="<?= base_url('Settings/Subjects?Course=' . urlencode($row->CourseDescription) . '&Major=' . urlencode($row->Major)); ?>"
                                  class="btn btn-info btn-sm">
                                  View Subjects
                                </a> -->

                                <a href="<?= base_url('Settings/SectionsList?Course=' . urlencode($row->CourseDescription) . '&Major=' . urlencode($row->Major)); ?>" class="btn btn-info waves-effect waves-light btn-sm">Sections</a>

                                <!-- <a href=<?= base_url(); ?>Settings/studentsprofile><button type="button" class="btn btn-success btn-xs">Update</button></a> -->
                                <a href="<?= base_url(); ?>Settings/deleteCourse?id=<?php echo $row->courseid; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                              </td>
                              </td>
                            <?php } ?>
                        </tbody>

                      </table>

                    </div>
                    <hr>


                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>

      <!-- end container-fluid -->
      <!-- Confirmation Modal -->
      <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Delete Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="text-center">
                <div class="circle-with-stroke d-inline-flex justify-content-center align-items-center">
                  <span class="h1 text-danger">!</span>
                </div>
                <p class="mt-3">Are you sure you want to delete this data?</p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <a href="<?= base_url('Settings/Deleteethnicity?id=' . $row->id); ?>); ?>" class="btn btn-danger" onclick="deleteData()">Delete</a>
            </div>
          </div>
        </div>
      </div>

      <style>
        .circle-with-stroke {
          width: 100px;
          height: 100px;
          border: 4px solid #dc3545;
          border-radius: 50%;
        }
      </style>

      <script>
        var deleteUrl = "";

        function setDeleteUrl(url) {
          deleteUrl = url;
        }

        function deleteData() {
          // Proceed with deletion
          window.location.href = deleteUrl;
        }
      </script>


    </div>
    <!-- end content -->




    <!-- Modal -->
    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="courseModalLabel">Course</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Form -->
            <form class="form-horizontal" method="POST">
              <div class="card-body">
                <div class="form-group row">
                  <label for="CourseCode" class="col-md-4 col-form-label">Course Code</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="CourseCode" placeholder="BS IT" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="CourseDescription" class="col-md-4 col-form-label">Course</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="CourseDescription" placeholder="Bachelor of Science in Information Technology" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Major" class="col-md-4 col-form-label">Major</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="Major" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Duration" class="col-md-4 col-form-label">Duration</label>
                  <div class="col-md-8">
                    <select class="form-control" name="Duration">
                      <option value=""></option>
                      <option value="1 Year">1 Year</option>
                      <option value="2 Years">2 Years</option>
                      <option value="3 Years">3 Years</option>
                      <option value="4 Years">4 Years</option>
                      <option value="5 Years">5 Years</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="recogNo" class="col-md-4 col-form-label">Recognition No./Permit No.</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="recogNo" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="SeriesYear" class="col-md-4 col-form-label">Series Year</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="SeriesYear" placeholder="">
                  </div>
                </div>
           <div class="form-group row">
  <label for="ProgramHead" class="col-md-4 col-form-label">Program Head</label>
  <div class="col-md-8">
    <select class="form-control select2" name="IDNumber" id="IDNumber">
      <option value="">Select Program Head</option>
      <?php foreach ($staff as $s): ?>
        <option value="<?= $s->IDNumber ?>">
          <?= $s->FirstName . ' ' . $s->MiddleName . ' ' . $s->LastName ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</div>



              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <input type="submit" name="submit" class="btn btn-info" value="Save">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



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
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

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

 <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>

</html>