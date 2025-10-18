<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<body>
<div id="wrapper">
  <?php include('includes/top-nav-bar.php'); ?>
  <?php include('includes/sidebar.php'); ?>
<?php
// Safer helper to build the edit URL
function edit_signup_url($id) {
    // Choose your preferred style; both are supported by the controller patch.
    // return site_url('Page/editSignup/' . rawurlencode($id)); // segment style
    return site_url('Page/editSignup') . '?id=' . rawurlencode($id); // query style
}
?>
  <div class="content-page">
    <div class="content">
      <div class="container-fluid">

        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('danger')): ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <?= $this->session->flashdata('danger'); ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-12">
            <div class="page-title-box">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <a href="<?= base_url('Page/admin'); ?>" class="btn btn-primary btn-sm">
                  <i class="mdi mdi-arrow-left"></i> Back
                </a>
              </div>
              <hr style="border:0;height:2px;background:linear-gradient(to right,#4285F4 60%,#FBBC05 80%,#34A853 100%);border-radius:1px;margin:20px 0;">
            </div>
          </div>
        </div>

        <div class="row"><div class="col-md-12">
          <div class="card"><div class="card-body table-responsive">
            <h4 class="m-t-0 header-title mb-4">STUDENTS' LIST</h4>
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Student No.</th>
                  <th style="width:110px">Birth Date</th>
                  <th style="text-align:center;width:220px">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $row): ?>
                  <?php
                    $ln = trim($row->LastName ?? '');
                    $fn = trim($row->FirstName ?? '');
                    $mn = trim($row->MiddleName ?? '');
                    $fullname = trim(($ln? $ln:'').(($ln||$fn)?', ':'').($fn?$fn:'').($mn?' '.$mn:''));
                    if ($fullname==='' && !empty($row->StudentNumber)) $fullname = $row->StudentNumber;

                    $studno = $row->StudentNumber ?? '';
                    $bdate  = !empty($row->birthDate) ? $row->birthDate : '—';
                    $yl     = $row->yearLevel ?? '';
                    $sec    = $row->section ?? '';
                    $stat   = $row->signupStatus ?? '';
                  ?>
                  <tr>
                    <td>
                      <?= htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8'); ?>
                      <?php if ($yl || $sec): ?>
                        <div class="text-muted small"><?= htmlspecialchars("$yl $sec", ENT_QUOTES, 'UTF-8'); ?></div>
                      <?php endif; ?>
                      <?php if ($stat): ?>
                        <div class="text-muted small">Status: <?= htmlspecialchars($stat, ENT_QUOTES, 'UTF-8'); ?></div>
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($studno, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($bdate, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-center">
                      <a href="<?= base_url('Page/editSignup?id='.urlencode($studno)); ?>" class="btn btn-success btn-xs">
                        <i class="mdi mdi-account-edit-outline"></i> Edit
                      </a>
                      <?php
                        $allowed = ['Head Registrar','Registrar','Assistant Registrar','Admin','Administrator'];
                        $role = strtolower((string)($this->session->userdata('level') ?? ''));
                        $canDelete = in_array($role, array_map('strtolower',$allowed), true);
                      ?>
                      <?php if ($canDelete): ?>
                        <form method="post" action="<?= base_url('Page/deleteSignup'); ?>" style="display:inline"
                              onsubmit="return confirm('Delete <?= htmlspecialchars($studno,ENT_QUOTES,'UTF-8'); ?>? This cannot be undone.');">
                          <input type="hidden" name="id" value="<?= htmlspecialchars($studno, ENT_QUOTES, 'UTF-8'); ?>">
                          <button type="submit" class="btn btn-danger btn-xs">
                            <i class="mdi mdi-delete-forever"></i> Delete
                          </button>
                        </form>
                      <?php else: ?>
                        <span class="text-muted">—</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div></div>
        </div></div>

      </div>
    </div>
    <?php include('includes/footer.php'); ?>
  </div>
</div>

<?php include('includes/themecustomizer.php'); ?>

<!-- Vendor / DataTables -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<link  href="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link  href="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" />
<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
<script>$(function(){ $('#datatable').DataTable(); });</script>
</body>
</html>
