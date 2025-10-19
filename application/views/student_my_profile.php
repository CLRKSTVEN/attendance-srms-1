<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
  <div id="wrapper">
    <?php include('includes/top-nav-bar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <style>
            .profile-wrapper {
              max-width: 960px;
              margin: 0 auto 48px;
            }
            .profile-section + .profile-section {
              margin-top: 32px;
            }
            .profile-section h4 {
              font-weight: 600;
              font-size: 1.05rem;
              margin-bottom: 20px;
              color: #1f2937;
            }
            .profile-grid {
              display: grid;
              grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
              gap: 18px 20px;
            }
            .profile-grid .form-group {
              margin-bottom: 0;
            }
            .profile-grid small {
              margin-top: 6px;
              display: block;
            }
            @media (max-width: 767.98px) {
              .profile-wrapper {
                max-width: 100%;
                margin: 0 0 36px;
              }
            }
          </style>
          <?php
          $account    = $bundle->account ?? (object)[];
          $profile    = $bundle->profile ?? (object)[];
          $enrollment = $bundle->enrollment ?? (object)[];

          $studentNumber = trim((string)($account->username ?? $profile->StudentNumber ?? ''));
          $flashSuccess  = $this->session->flashdata('success');
          $flashDanger   = $this->session->flashdata('danger');

          $firstName  = trim((string)($account->fName ?? $profile->FirstName ?? ''));
          $middleName = trim((string)($account->mName ?? $profile->MiddleName ?? ''));
          $lastName   = trim((string)($account->lName ?? $profile->LastName ?? ''));
          $nameExtn   = trim((string)($profile->nameExtn ?? ''));

          $birthDate  = trim((string)($profile->birthDate ?? ''));
          if ($birthDate === '0000-00-00') {
            $birthDate = '';
          }
          $sexValue   = trim((string)($profile->Sex ?? ''));
          $contactNo  = trim((string)($profile->contactNo ?? ''));
          $email      = trim((string)($account->email ?? $profile->email ?? ''));

          $currentCourseDesc = trim((string)($currentCourseDesc ?? ''));
          $currentYear       = trim((string)($currentYear ?? ''));
          $currentSection    = trim((string)($currentSection ?? ''));
          $nationality       = trim((string)($profile->nationality ?? 'Filipino'));
          $working           = trim((string)($profile->working ?? 'No'));
          $vaccStat          = trim((string)($profile->VaccStat ?? ''));
          ?>

          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
                <div>
                  <h4 class="page-title mb-1">My Profile</h4>
                  <p class="text-muted mb-0">Update your personal and academic details.</p>
                </div>
                <div>
                  <a href="<?= base_url('Page/student'); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="mdi mdi-arrow-left"></i> Back to Dashboard
                  </a>
                </div>
              </div>
            </div>
          </div>

          <?php if (!empty($flashSuccess)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8'); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <?php if (!empty($flashDanger)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= htmlspecialchars($flashDanger, ENT_QUOTES, 'UTF-8'); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-lg-12">
              <div class="card shadow-sm border-0">
                <div class="card-body profile-wrapper">
                  <form method="post" autocomplete="off">
                    <div class="profile-section">
                      <h4>Personal Information</h4>
                      <div class="profile-grid">
                        <div class="form-group">
                          <label for="StudentNumber">Student ID / Number <span class="text-danger">*</span></label>
                          <input type="text"
                                 id="StudentNumber"
                                 class="form-control"
                                 name="StudentNumber"
                                 value="<?= htmlspecialchars($studentNumber, ENT_QUOTES, 'UTF-8'); ?>"
                                 readonly
                                 required>
                          <small class="text-muted">This is your username and should match your school ID.</small>
                        </div>
                      </div>

                      <input type="hidden" name="nationality" value="<?= htmlspecialchars($nationality, ENT_QUOTES, 'UTF-8'); ?>">
                      <input type="hidden" name="working" value="<?= htmlspecialchars($working, ENT_QUOTES, 'UTF-8'); ?>">
                      <input type="hidden" name="VaccStat" value="<?= htmlspecialchars($vaccStat, ENT_QUOTES, 'UTF-8'); ?>">

                      <div class="profile-grid">
                        <div class="form-group">
                          <label for="FirstName">First Name <span class="text-danger">*</span></label>
                          <input type="text" id="FirstName" class="form-control" name="FirstName" style="text-transform: uppercase;"
                                 value="<?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="MiddleName">Middle Name</label>
                          <input type="text" id="MiddleName" class="form-control" name="MiddleName" style="text-transform: uppercase;"
                                 value="<?= htmlspecialchars($middleName, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="form-group">
                          <label for="LastName">Last Name <span class="text-danger">*</span></label>
                          <input type="text" id="LastName" class="form-control" name="LastName" style="text-transform: uppercase;"
                                 value="<?= htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="nameExtn">Name Extn.</label>
                          <input type="text" id="nameExtn" class="form-control" name="nameExtn" style="text-transform: uppercase;"
                                 value="<?= htmlspecialchars($nameExtn, ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Jr., Sr.">
                        </div>
                      </div>

                      <div class="profile-grid">
                        <div class="form-group">
                          <label for="Sex">Sex <span class="text-danger">*</span></label>
                          <select class="form-control" id="Sex" name="Sex" required>
                            <option value=""></option>
                            <?php foreach ($sexOptions as $option): ?>
                              <option value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8'); ?>"
                                <?= strcasecmp($sexValue, $option) === 0 ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8'); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="bday">Birth Date <span class="text-danger">*</span></label>
                          <input type="date" id="bday" class="form-control" name="birthDate" onchange="submitBday()"
                                 value="<?= htmlspecialchars($birthDate, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="email">E-mail Address <span class="text-danger">*</span></label>
                          <input type="email" id="email" class="form-control" name="email"
                                 value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="contactNo">Mobile No. <span class="text-danger">*</span></label>
                          <input type="text" id="contactNo" class="form-control" name="contactNo"
                                 value="<?= htmlspecialchars($contactNo, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <input type="hidden" id="resultBday" class="form-control" name="age" value="<?= htmlspecialchars($profile->age ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly>
                      </div>
                    </div>

                    <div class="profile-section">
                      <h4>Academic Information</h4>
                      <div class="profile-grid">
                        <div class="form-group">
                          <label for="course1">Course/Program <span class="text-danger">*</span></label>
                          <select name="Course1" id="course1" class="form-control" required>
                            <option value="">Select Course</option>
                            <?php foreach ($courses as $course):
                              $desc = trim((string)$course->CourseDescription);
                              $selected = (strcasecmp($currentCourseDesc, $desc) === 0);
                            ?>
                              <option value="<?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>" <?= $selected ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="yearLevel">Year Level <span class="text-danger">*</span></label>
                          <select class="form-control" name="yearLevel" id="yearLevel" required>
                            <option value="">Select Year Level</option>
                            <?php foreach ($yearLevels as $yl): ?>
                              <option value="<?= htmlspecialchars($yl, ENT_QUOTES, 'UTF-8'); ?>"
                                <?= strcasecmp($currentYear, $yl) === 0 ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($yl, ENT_QUOTES, 'UTF-8'); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <small class="text-muted">Format: 1st / 2nd / 3rd / 4th</small>
                        </div>
                        <div class="form-group">
                          <label for="section">Section <span class="text-danger">*</span></label>
                          <select class="form-control" name="section" id="section" data-current="<?= htmlspecialchars($currentSection, ENT_QUOTES, 'UTF-8'); ?>" required>
                            <option value="">Select Section</option>
                          </select>
                          <small class="text-muted">Sections depend on Course/Program &amp; Year Level.</small>
                        </div>
                      </div>
                    </div>

                    <div class="text-right">
                      <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save-outline"></i> Save Changes
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php include('includes/footer.php'); ?>
    </div>
  </div>

  <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
  <script>
    function submitBday() {
      var input = document.getElementById('bday');
      var target = document.getElementById('resultBday');
      if (!input || !target) { return; }
      var value = input.value;
      if (!value) { target.value = ''; return; }
      var birth = new Date(value);
      if (isNaN(birth.getTime())) { target.value = ''; return; }
      var today = new Date();
      var age = today.getFullYear() - birth.getFullYear();
      var m = today.getMonth() - birth.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
        age--;
      }
      target.value = age >= 0 ? age : '';
    }
  </script>
  <script>
    (function($) {
      var $course = $('#course1');
      var $year = $('#yearLevel');
      var $section = $('#section');

      function populateSections(html) {
        var current = ($section.data('current') || '').trim();
        if (!html) {
          $section.html('<option value="">Select Section</option>');
          return;
        }
        var $temp = $('<select>' + html + '</select>');
        if (current) {
          $temp.find('option').each(function() {
            var val = ($(this).val() || '').trim();
            if (val && val.toLowerCase() === current.toLowerCase()) {
              $(this).attr('selected', 'selected');
            }
          });
        }
        $section.html($temp.html());
      }

      function reloadSections() {
        var course = ($course.val() || '').trim();
        var year = ($year.val() || '').trim();
        if (!course || !year) {
          $section.html('<option value="">Select Section</option>');
          return;
        }
        $.post('<?= base_url("Registration/getSectionsByCourseYear"); ?>', { course: course, yearLevel: year })
          .done(function(html) {
            populateSections(html);
          })
          .fail(function() {
            alert('Failed to load sections. Please try again.');
            $section.html('<option value="">Select Section</option>');
          });
      }

      $(function() {
        $course.on('change', function() {
          $section.data('current', '');
          reloadSections();
        });
        $year.on('change', function() {
          $section.data('current', '');
          reloadSections();
        });

        reloadSections();
        submitBday();
      });
    })(jQuery);
  </script>
</body>

</html>
