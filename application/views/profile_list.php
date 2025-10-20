<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
  <div id="wrapper">
    <?php include('includes/top-nav-bar.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    <?php
    // Helper to build the view URL for a student's profile
    function view_signup_url($id)
    {
      // Choose your preferred style; both are supported by the controller patch.
      // return site_url('Page/editSignup/' . rawurlencode($id)); // segment style
      return site_url('Page/editSignup') . '?id=' . rawurlencode($id); // query style
    }
    ?>
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">

          <?php
          $flashSuccess = $this->session->flashdata('success');
          $flashDanger  = $this->session->flashdata('danger');
          ?>

          <div class="row">
            <div class="col-md-12">
              <div class="page-title-box">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <a href="<?= base_url('Page/admin'); ?>" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-arrow-left"></i> Back to Dashboard
                  </a>
                </div>
                <hr style="border:0;height:2px;background:linear-gradient(to right,#4285F4 60%,#FBBC05 80%,#34A853 100%);border-radius:1px;margin:20px 0;">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body table-responsive">
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
                        $fullname = trim(($ln ? $ln : '') . (($ln || $fn) ? ', ' : '') . ($fn ? $fn : '') . ($mn ? ' ' . $mn : ''));
                        if ($fullname === '' && !empty($row->StudentNumber)) $fullname = $row->StudentNumber;

                        $studno = $row->StudentNumber ?? '';
                        $bdate  = !empty($row->birthDate) ? $row->birthDate : 'N/A';
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
                            <a href="<?= view_signup_url($studno); ?>" class="btn btn-info btn-xs">
                              <i class="mdi mdi-eye-outline"></i> View
                            </a>
                            <?php
                            $allowed = ['Head Registrar', 'Registrar', 'Assistant Registrar', 'Admin', 'Administrator'];
                            $role = strtolower((string)($this->session->userdata('level') ?? ''));
                            $canDelete = in_array($role, array_map('strtolower', $allowed), true);
                            ?>
                            <?php if ($canDelete): ?>
                              <form method="post" action="<?= base_url('Page/deleteSignup'); ?>" style="display:inline" class="delete-signup-form">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($studno, ENT_QUOTES, 'UTF-8'); ?>">
                                <button type="button" class="btn btn-danger btn-xs delete-signup-btn" data-studno="<?= htmlspecialchars($studno, ENT_QUOTES, 'UTF-8'); ?>">
                                  <i class="mdi mdi-delete-forever"></i> Delete
                                </button>
                              </form>
                            <?php else: ?>
                              <span class="text-muted">&mdash;</span>
                            <?php endif; ?>
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
      <?php include('includes/footer.php'); ?>
    </div>
  </div>

  <?php include('includes/themecustomizer.php'); ?>

  <!-- Vendor / DataTables -->
  <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <link href="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" />
  <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
  <script>
    $(function() {
      $('#datatable').DataTable();
    });
  </script>
  <script>
    (function() {
      var successMessage = <?= json_encode($flashSuccess ?? null); ?>;
      var dangerMessage = <?= json_encode($flashDanger ?? null); ?>;

      function fireAlert(options) {
        if (!options) {
          return;
        }
        if (window.Swal && typeof window.Swal.fire === 'function') {
          return window.Swal.fire(options);
        }
        if (options.text) {
          window.alert(options.text);
        }
        return Promise.resolve();
      }

      var alertOptions = null;
      if (dangerMessage) {
        alertOptions = {
          icon: 'error',
          title: 'Error',
          text: dangerMessage,
          confirmButtonColor: '#348cd4'
        };
      } else if (successMessage) {
        alertOptions = {
          icon: 'success',
          title: 'Success',
          text: successMessage,
          confirmButtonColor: '#348cd4'
        };
      }

      if (alertOptions) {
        fireAlert(alertOptions);
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

      function handleDeleteClick(event, button) {
        event.preventDefault();
        var form = button.closest('form');
        if (!form) {
          return;
        }
        var studno = button.getAttribute('data-studno') || 'this record';
        var promptText = 'Delete ' + studno + '? This cannot be undone.';

        var confirmed = function(result) {
          var ok = false;
          if (result) {
            if (typeof result.isConfirmed !== 'undefined') {
              ok = result.isConfirmed;
            } else if (typeof result.value !== 'undefined') {
              ok = !!result.value;
            } else if (result === true) {
              ok = true;
            }
          }
          if (ok) {
            form.submit();
          }
        };

        if (window.Swal && typeof window.Swal.fire === 'function') {
          window.Swal.fire({
            title: 'Delete record?',
            text: promptText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#f1556c',
            cancelButtonColor: '#6c757d'
          }).then(confirmed);
        } else if (window.confirm(promptText)) {
          form.submit();
        }
      }

      document.addEventListener('click', function(event) {
        var button = closestByClass(event.target, 'delete-signup-btn');
        if (!button) {
          return;
        }
        handleDeleteClick(event, button);
      });
    })();
  </script>
</body>

</html>
