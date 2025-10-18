<?php
if (!isset($online_settings)) {
    $settingsRow = $this->db->select('show_online_payments')
        ->from('o_srms_settings')->limit(1)->get()->row();
    $online_settings = $settingsRow ?: (object)['show_online_payments' => 1]; // default ON
}
$showOnline = (int)($online_settings->show_online_payments ?? 1);
?>



<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!-- System Administrator -->
       <?php if ($this->session->userdata('level') === 'Admin'): ?>
    <div id="sidebar-menu">
        <ul class="metismenu" id="side-menu">

            <li class="menu-title">ADMINISTRATION</li>

            <!-- Dashboard (keep visible) -->
            <li>
                <a href="<?= base_url(); ?>Page/admin" class="waves-effect">
                    <i class="bi bi-speedometer2"></i>
                    <span> Dashboard </span>
                </a>
            </li>
          
              <li>


            <!-- student profile  -->
<a href="<?= base_url('Page/profileList'); ?>">
<i class="bi bi-person-fill"></i>
    <span> Student Profile </span>
  </a>
</li>



  <li>
  <a href="<?= base_url('AttendanceLogs'); ?>" class="waves-effect">
    <i class="bi bi-clipboard-check"></i>
    <span> Attendance Logs </span>
  </a>
</li>
        
            <!-- ===== HIDE: Document Request =====
            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="fas fa-archive"></i>
                    <span> Document Request </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level nav" aria-expanded="false">
                    <li><a href="<?= base_url(); ?>Request/document_types">Docs for Request</a></li>
                    <li><a href="<?= base_url(); ?>Request/">Requests</a></li>
                    <li><a href="<?= base_url(); ?>Page/requestSummary">Summary</a></li>
                </ul>
            </li>
            ===== /HIDE ===== -->

            <!-- ===== HIDE: Upload =====
            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="ion ion-md-cloud-upload"></i>
                    <span> Upload </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li><a href="<?= base_url(); ?>FileUploader/">Students' Profile</a></li>
                    <li><a href="<?= base_url(); ?>FileUploader/teachers">Faculty and Staff</a></li>
                    <li><a href="<?= base_url(); ?>FileUploader/Courses">Courses</a></li>
                    <li><a href="<?= base_url(); ?>FileUploader/subjects">Subjects</a></li>
                </ul>
            </li>
            ===== /HIDE ===== -->

            <!-- Announcement (keep visible) -->
        

            <!-- Activities (QR) (keep visible) -->
            <?php
              $flagPath = APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'qr_poster_mode.flag';
              $posterModeGlobal = (is_file($flagPath) && strtolower(trim(@file_get_contents($flagPath))) === 'on');
              $isAdmin = ($this->session->userdata('level') === 'Admin');
            ?>
            <li>
              <a href="javascript:void(0);" class="waves-effect">
                <i class="ion bi bi-qr-code-scan"></i>
                <span> Activities (QR) </span>
                <span class="menu-arrow"></span>
              </a>
              <ul class="nav-second-level" aria-expanded="false">
                <li><a href="<?= base_url('activities'); ?>">Open Activities</a></li>

                <?php if ($isAdmin): ?>
                  <li class="pt-1 pb-2 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="text-muted">Poster Mode</span>
                      <div class="custom-control custom-switch m-0">
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          id="qrPosterSwitch"
                          aria-label="Toggle Poster Mode"
                          onchange="location.href='<?= site_url('activities/set_mode/') ?>'+(this.checked?'on':'off')"
                          <?= $posterModeGlobal ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="qrPosterSwitch"></label>
                      </div>
                    </div>
                    <div class="text-muted small mt-1">(On = Poster, Off = Scanner)</div>
                  </li>
                <?php endif; ?>
              </ul>
            </li>
    <!-- <li>
                <a href="<?= base_url(); ?>Page/announcement?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                    <i class="bi bi-megaphone"></i>
                    <span> Announcement </span>
                </a>
            </li> -->

            <!-- To Do (keep visible) -->
            <!-- <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="ion ion-md-paper"></i>
                    <span> To Do </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                </ul>
            </li> -->

            <!-- Notes (keep visible) -->
            <!-- <li>
                <a href="<?= base_url(); ?>Note/" class="waves-effect">
                    <i class="ion ion-md-paper"></i>
                    <span> Notes </span>
                </a>
            </li> -->
  <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-contacts "></i>
                            <span> Manage Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                               <li><a href="<?= base_url(); ?>Settings/Department">Course & Section</a></li>
                            <li><a href="<?= base_url(); ?>Page/userAccounts">User Accounts</a></li>
                        </ul>
                    </li>
            <!-- Change Password (keep visible) -->
            <li>
                <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                    <span> Change Password </span>
                </a>
            </li>
   <li>
                <a href="<?= base_url('Login/logout'); ?>" class="waves-effect">
                    <i class="ion bi bi-box-arrow-right"></i>
                    <span> Logout </span>
                </a>
            </li>
            <!-- Settings (keep visible) -->
            <!-- <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="ion ion-md-settings"></i>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li><a href="<?= base_url(); ?>Settings/schoolInfo">School Information</a></li>
                    <li><a href="<?= base_url(); ?>Settings/loginFormBanner">Login Page Image</a></li>
                    <li><a href="<?= base_url(); ?>GradeSetting/index">Grades Settings</a></li>
                    <li>
                        <a href="<?= base_url(); ?>GradeEncoding/index" class="waves-effect">
                            <i class="ion ion-ios-key"></i>
                            <span> Encode Grades </span>
                        </a>
                    </li>
                </ul>
            </li> -->

            <!-- ===== HIDE: SRMS FAQ =====
            <li>
                <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                    <i class="ion ion-md-help"></i>
                    <span> SRMS FAQ </span>
                </a>
            </li>
            ===== /HIDE ===== -->

        </ul>
    </div>


        <?php elseif ($this->session->userdata('level') === 'IT'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">ADMINISTRATION</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/IT" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-contacts "></i>
                            <span> Manage Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/userAccounts">User Accounts</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-settings"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Settings/schoolInfo">School Information</a></li> -->
                            <li><a href="<?= base_url(); ?>Settings/loginFormBanner">Login Page Image</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="<?= base_url(); ?>admin/backup_database" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Backup Database </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Encoder') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/encoder" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Admission </span>
                            <span class="menu-arrow"></span>


                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/profileListEncoder">Student's Profile</a> </li>
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li> -->

                        </ul>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'School Admin'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">ADMINISTRATION</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/school_admin" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-list-box"></i>
                            <span> Masterlist </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/dailyEnrollees">Enrollees By Date</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/masterlistByCourseFiltered">By Course</a></li> -->

                            <!-- <li><a href="<?= base_url(); ?>Page/masterlistBySectionFiltered">By Section</a></li> -->
                            <li><a href="<?= base_url(); ?>Masterlist/bySY">By Semester</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/subregistration">By Subject</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-list-box"></i>
                            <span> Registrar Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/slotsMonitoring">Slots Monitoring</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/grades">Grading Sheets</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/gradesSummary">Grades Summary</a></li> -->
                            <li><a href="<?= base_url(); ?>Masterlist/crossEnrollees">Cross-Enrollees</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/fteRecords">Units Summary</a></li>
                            <li><a href="<?= base_url(); ?>Page/er" target="_blank">Enrollment Report</a></li>
                            <li><a href="<?= base_url(); ?>Page/pr" target="_blank">Promotional Report</a></li>

                        </ul>
                    </li>

                    <!-- <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"></i>
                            <span> Accounting Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Accounting/collectionReport">Collection Reports</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/collectionYear">Collection Per Year</a></li>

                            <li><a href="<?= base_url(); ?>Accounting/studeAccountsWithBalance">Students With Outstanding Balance</a></li>

                        </ul>
                    </li> -->


                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Head Registrar'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/registrar" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Admission </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/profileList">Student's Profile</a> </li>
                            <li><a href="<?= base_url(); ?>Page/signUpList">Signup List</a> </li>
                            <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li>
                            <li><a href="<?= base_url(); ?>Ren/sub_enlist">Subject Enlistment</a></li>

                            <!-- <li><a href="<?= base_url(); ?>page/forValidation">Online Enrollees <small style="color:red;">[for action]</small></a></li> -->

                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-list-box"></i>
                            <span> Masterlist </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/dailyEnrollees">Enrollees By Date</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/masterlistByCourseFiltered">By Course</a></li> -->

                            <!-- <li><a href="<?= base_url(); ?>Page/masterlistBySectionFiltered">By Section</a></li> -->
                            <li><a href="<?= base_url(); ?>Masterlist/bySY">By Semester</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/subregistration">By Subject</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/deanList">Dean's Lister</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineSem?sy=<?php echo $this->session->userdata('sy'); ?>&sem=<?php echo $this->session->userdata('semester'); ?>">Online Enrollees (By Sem)</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineAll">Online Enrollees (All)</a></li> -->
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-list-box"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/slotsMonitoring">Slots Monitoring</a></li> -->

                            <!-- <li><a href="<?= base_url(); ?>Masterlist/gradesSummary">Grades Summary</a></li> -->
                            <li><a href="<?= base_url(); ?>Masterlist/crossEnrollees">Cross-Enrollees</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/fteRecords">Units Summary</a></li>
                            <li><a href="<?= base_url(); ?>Page/er" target="_blank">Enrollment Report</a></li>
                            <li><a href="<?= base_url(); ?>Page/pr" target="_blank">Promotional Report</a></li>
                            <li>
                                <a href="<?= base_url(); ?>Records/index">
                                    Academic Credentials
                                </a>
                            </li>
                            <!-- <li><a href="<?= base_url(); ?>Page/evaluation" class="waves-effect">Evaluation</a></li> -->

                        </ul>
                    </li>
                    <!-- <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="fas fa-envelope"></i>
                            <span> TESDA </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/scholarship">Dashboard</a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="fas fa-archive"></i>
                            <span> Document Request </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Page/newRequest">Add New</a></li> -->
                            <li><a href="<?= base_url(); ?>Page/allRequest">Requests</a></li>
                            <li><a href="<?= base_url(); ?>Page/requestSummary">Summary</a></li>
                        </ul>
                    </li>

                    <!-- <li>
  <a href="<?= base_url('records'); ?>">
    <i class="fe-file-text"></i> <span> Academic Credentials</span>
  </a>
</li> -->



                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-settings"></i>
                            <span> Configurations </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Settings/Department">Courses</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Settings/Sections">Sections</a></li> -->
                            <!-- <li><a href="<?= base_url() ?>Settings/subjects">Subjects</a></li> -->
                            <li><a href="<?= base_url() ?>Settings/classSched">Class Schedules</a></li>
                            <li><a href="<?= base_url() ?>GradesLock/index">Locking Grades Schedules</a></li>
                            <!-- <li><a href="<?= base_url() ?>Settings/subjects">Subjects</a></li> -->
                            <li><a href="<?= base_url(); ?>Settings/rooms">Rooms</a></li>
                            <li><a href="<?= base_url(); ?>Settings/ethnicity">Ethnicity</a></li>
                            <li><a href="<?= base_url(); ?>Settings/religion">Religion</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Page/announcement?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                            <i class="bi bi-megaphone"></i>
                            <span> Announcement </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>


                    <!-- <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Calendar </span>

                        </a>

                    </li> -->

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Notes </span>

                        </a>

                    </li>



                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Registrar'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/registrar" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Admission </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/signUpList">Signup List</a> </li>
                            <li><a href="<?= base_url(); ?>Page/profileList">Student's Profile</a> </li>
                            <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li>
                            <li><a href="<?= base_url(); ?>Student/enlistment">Subject Enlistment</a></li>
                            <li><a href="<?= base_url(); ?>Student/requestSub">Subject Request</a></li>
                            <!-- <li><a href="<?= base_url(); ?>page/forValidation">Online Enrollees <small style="color:red;">[for action]</small></a></li> -->

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Grades </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/viewing_grades" title="Enter new grades for students">Encode Grades</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/save_grades" title="Edit or adjust existing student grades">Manual Encoding Grades</a></li> -->

                            <li><a href="<?= base_url(); ?>Accreditation/index" title="Enter new grades for students">Encode Grades from Previous School</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/grades">Grading Sheets</a></li>
                            <li><a href="<?= base_url(); ?>ModifyGrades/index">Modify Grades</a> </li>
                            <li><a href="#">Calculate Average</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Requirements </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Student/req_list">Requirements List</a> </li>
                            <li><a href="<?= base_url(); ?>Student/pending_uploads">For Approval</a> </li>
                            <li><a href="<?= base_url(); ?>Student/approved_uploads">Approved Uploads</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-list-box"></i>
                            <span> Masterlist </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/dailyEnrollees">Enrollees By Date</a></li>
                            <li><a href="<?= base_url(); ?>Page/masterlistByCourse1">By Course</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/masterlistBySectionFiltered">By Section</a></li> -->

                            <li><a href="<?= base_url(); ?>Masterlist/bySY">By Semester</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/subregistration">By Subject</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/bySYLMS">For LMS Bulk Upload</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/deanList">Dean's Lister</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineSem?sy=<?php echo $this->session->userdata('sy'); ?>&sem=<?php echo $this->session->userdata('semester'); ?>">Online Enrollees (By Sem)</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineAll">Online Enrollees (All)</a></li> -->
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-list-box"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/slotsMonitoring">Slots Monitoring</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/grades">Grading Sheets</a></li> -->

                            <li><a href="<?= base_url(); ?>Instructor/employeeList">Faculty Loading</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/crossEnrollees">Cross-Enrollees</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/fteRecords">Units Summary</a></li>
                            <li><a href="<?= base_url(); ?>Page/erform" target="_blank">Enrollment Report</a></li>
                            <li><a href="<?= base_url(); ?>Page/prform" target="_blank">Promotional Report</a></li>
                            <li><a href="<?= base_url(); ?>ReportGrades/index">Report of Grades</a></li>
                            <li>
                                <a href="<?= base_url(); ?>Records/index">
                                    Academic Credentials
                                </a>
                            </li>
                            <li><a href="<?= base_url(); ?>Student/evaluation" class="waves-effect">Evaluation</a></li>
                            <li><a href="<?= base_url(); ?>Reports/enrollment_summary">Enrollment Summary</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-update"></i>
                            <span> Document Request </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Request/document_types">Docs for Request</a></li>
                            <li><a href="<?= base_url(); ?>Request/">Requests</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/allRequest">Requests</a></li> -->
                            <!-- <li><a href="<?= base_url(); ?>Page/requestSummary">Summary</a></li> -->
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-settings"></i>
                            <span> Configurations </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Settings/Department">Courses</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Settings/Sections">Sections</a></li> -->
                            <!-- <li><a href="<?= base_url() ?>Settings/subjects">Subjects</a></li> -->
                            <li><a href="<?= base_url() ?>Settings/classSched">Class Schedules</a></li>
                            <li><a href="<?= base_url() ?>GradesLock/index">Locking Grades Schedules</a></li>

                            <li><a href="<?= base_url(); ?>Settings/rooms">Rooms</a></li>

                            <li><a href="<?= base_url(); ?>Settings/ethnicity">Ethnicity</a></li>
                            <li><a href="<?= base_url(); ?>Settings/religion">Religion</a></li>
                            <li><a href="<?= base_url(); ?>Settings/prevschool">Previous Schools</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-update"></i>
                            <span> Flag Students </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Flag/">Flagged Students</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-update"></i>
                            <span> Bulk Update </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Student/update_student_ages">Student Ages</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Page/announcement?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                            <i class="bi bi-megaphone"></i>
                            <span> Announcement </span>
                        </a>
                    </li>
                    <!-- <li>
    <a href="<?= base_url('activities'); ?>" class="waves-effect">
        <i class="ion ion-ios-qr-scanner"></i>
        <span> Activities (QR) </span>
    </a>
</li> -->

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <!-- 
                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Calendar </span>

                        </a>

                    </li> -->

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Notes </span>

                        </a>

                    </li>


                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Accounting'): ?>
            <?php
            // Active/open helpers
            $uri = trim(uri_string(), '/');
            $is = function ($prefix) use ($uri) {
                return (strpos($uri, trim($prefix, '/')) === 0);
            };
            $active = function ($prefix) use ($is) {
                return $is($prefix) ? 'mm-active active' : '';
            };
            $open = function (array $prefixes) use ($is) {
                foreach ($prefixes as $p) {
                    if ($is($p)) return ['true', 'mm-show'];
                }
                return ['false', ''];
            };

            // Expand states per group
            list($paymentsExpanded, $paymentsShow) = $open([
                'Accounting/Payment',
                'Accounting/services',
                'Page/proof_payment_view',
                'Page/onlinePaymentsAll',
                'Page/deniedPayments',
                'Page/voidORs'
            ]);

            list($expensesExpanded, $expensesShow) = $open([
                'Accounting/expenses',
                'Accounting/expensescategory',
                'Accounting/expensesReport'
            ]);

            list($voidExpanded, $voidShow) = $open([
                'Accounting/VoidPayment'
            ]);

            list($docsExpanded, $docsShow) = $open([
                'Request/document_types',
                'Request'
            ]);

            list($configsExpanded, $configsShow) = $open([
                'Accounting/course_setUp'
            ]);

            list($acctRptExpanded, $acctRptShow) = $open([
                'Accounting/studeAccountsWithBalance',
                'Accounting/collectionMonthly',
                'Accounting/collectionYear',
                'Accounting/collectionDateRange'
            ]);

            list($todoExpanded, $todoShow) = $open([
                'ToDo'
            ]);

            // Online payments toggle (safe default = show)
            $showOnline = isset($online_settings->show_online_payments)
                ? (int)$online_settings->show_online_payments
                : 1;
            ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li class="<?= $active('Page/accounting'); ?>">
                        <a href="<?= base_url('Page/accounting'); ?>" class="waves-effect">
                            <i class="ion bi bi-house-door"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li class="<?= $active('Accounting/studeAccounts'); ?>">
                        <a href="<?= base_url('Accounting/studeAccounts'); ?>" class="waves-effect">
                            <i class="ion ion-md-analytics"></i>
                            <span> Student's Accounts </span>
                        </a>
                    </li>

                    <!-- Payments -->
                    <li class="<?= $paymentsShow ? 'mm-active' : '' ?>">
                        <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $paymentsExpanded; ?>">
                            <i class="ion ion-ios-cash"></i>
                            <span> Payments </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav <?= $paymentsShow; ?>" aria-expanded="<?= $paymentsExpanded; ?>">
                            <li class="<?= $active('Accounting/Payment'); ?>">
                                <a href="<?= base_url('Accounting/Payment'); ?>">School Fees</a>
                            </li>
                            <li class="<?= $active('Accounting/services'); ?>">
                                <a href="<?= base_url('Accounting/services'); ?>">Other Fees/Services</a>
                            </li>



                            <li class="<?= $active('Page/onlinePaymentsAll'); ?>">
                                <a href="<?= base_url('Page/onlinePaymentsAll'); ?>">Verified Online Payments</a>
                            </li>
                            <li class="<?= $active('Page/deniedPayments'); ?>">
                                <a href="<?= base_url('Page/deniedPayments'); ?>">Denied Online Payments</a>
                            </li>


                            <li class="<?= $active('Page/voidORs'); ?>">
                                <a href="<?= base_url('Page/voidORs'); ?>">Void O.R.</a>
                            </li>
                        </ul>
                    </li>

                    <!-- School Expenses -->
                    <li class="<?= $expensesShow ? 'mm-active' : '' ?>">
                        <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $expensesExpanded; ?>">
                            <i class="ion ion-md-folder-open"></i>
                            <span> School Expenses </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav <?= $expensesShow; ?>" aria-expanded="<?= $expensesExpanded; ?>">
                            <li class="<?= $active('Accounting/expenses'); ?>">
                                <a href="<?= base_url('Accounting/expenses'); ?>">Expenses</a>
                            </li>
                            <li class="<?= $active('Accounting/expensescategory'); ?>">
                                <a href="<?= base_url('Accounting/expensescategory'); ?>">Expenses Category</a>
                            </li>
                            <li class="<?= $active('Accounting/expensesReport'); ?>">
                                <a href="<?= base_url('Accounting/expensesReport'); ?>">Expenses Reports</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Void -->
                    <li class="<?= $voidShow ? 'mm-active' : '' ?>">
                        <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $voidExpanded; ?>">
                            <i class="ion ion-md-paper"></i>
                            <span> Void </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav <?= $voidShow; ?>" aria-expanded="<?= $voidExpanded; ?>">
                            <li class="<?= $active('Accounting/VoidPayment'); ?>">
                                <a href="<?= base_url('Accounting/VoidPayment'); ?>">Void Receipts</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Document Request -->
                    <li class="<?= $docsShow ? 'mm-active' : '' ?>">
                        <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $docsExpanded; ?>">
                            <i class="mdi mdi-update"></i>
                            <span> Document Request </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav <?= $docsShow; ?>" aria-expanded="<?= $docsExpanded; ?>">
                            <li class="<?= $active('Request/document_types'); ?>">
                                <a href="<?= base_url('Request/document_types'); ?>">Docs for Request</a>
                            </li>
                            <li class="<?= $active('Request'); ?>">
                                <a href="<?= base_url('Request'); ?>">Requests</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Configurations -->
                    <li class="<?= $configsShow ? 'mm-active' : '' ?>">
                        <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $configsExpanded; ?>">
                            <i class="ion ion-md-settings"></i>
                            <span> Configurations </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav <?= $configsShow; ?>" aria-expanded="<?= $configsExpanded; ?>">
                            <li class="<?= $active('Accounting/course_setUp'); ?>">
                                <a href="<?= base_url('Accounting/course_setUp'); ?>">Fees Setup</a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title">Reports</li>

                    <!-- Accounting Reports -->
                    <li class="<?= $acctRptShow ? 'mm-active' : '' ?>">
                        <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $acctRptExpanded; ?>">
                            <i class="ion ion-md-paper"></i>
                            <span> Accounting Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav <?= $acctRptShow; ?>" aria-expanded="<?= $acctRptExpanded; ?>">
                            <li>
                                <a href="<?= base_url('Accounting/studeAccountsWithBalance'); ?>">Students With Outstanding Balance</a>
                            </li>

                            <li>
                                <a href="<?= base_url('Accounting/fullyPaid'); ?>">Fully Paid Students</a>
                            </li>

                            <li>
                                <a href="javascript:void(0);" aria-expanded="<?= $acctRptExpanded; ?>">Collection Reports
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-third-level nav <?= $acctRptShow; ?>">
                                    <li>
                                        <a href="<?= base_url('Accounting/collectionMonthly'); ?>">Monthly</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('Accounting/collectionYear'); ?>">Yearly</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('Accounting/collectionDateRange'); ?>">By Date Range</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <!-- Students' Reports -->
                    <li class="<?= $active('Accounting/accountingStudeReports'); ?>">
                        <a href="<?= base_url('Accounting/accountingStudeReports'); ?>" class="waves-effect">
                            <i class="ion ion-md-folder"></i>
                            <span> Students' Reports </span>
                        </a>
                    </li>
                    <!-- <li class="<?= $active('activities'); ?>">
    <a href="<?= base_url('activities'); ?>" class="waves-effect">
        <i class="ion ion-ios-qr-scanner"></i>
        <span> Activities (QR) </span>
    </a>
</li> -->

                    To Do
                    <li class="<?= $todoShow ? 'mm-active' : '' ?>">
                        <a href="javascript:void(0);" class="waves-effect" aria-expanded="<?= $todoExpanded; ?>">
                            <i class="ion ion-md-paper"></i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav <?= $todoShow; ?>" aria-expanded="<?= $todoExpanded; ?>">
                            <li class="<?= $active('ToDo'); ?>">
                                <a href="<?= base_url('ToDo'); ?>">ToDo</a>
                            </li>
                        </ul>
                    </li>

                    <li class="<?= $active('Note'); ?>">
                        <a href="<?= base_url('Note'); ?>" class="waves-effect">
                            <i class="ion ion-md-paper"></i>
                            <span> Notes </span>
                        </a>
                    </li>

                    <li class="<?= $active('Page/changepassword'); ?>">
                        <a href="<?= base_url('Page/changepassword'); ?>" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('FAQ'); ?>" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>

                </ul>
            </div>

<?php elseif (in_array($this->session->userdata('level'), ['Student','Stude Applicant'], true)): ?>
    <div id="sidebar-menu">
        <ul class="metismenu" id="side-menu">
            <li class="menu-title">Navigation</li>

            <li>
                <a href="<?= base_url('Page/student'); ?>" class="waves-effect">
                    <i class="ion-md-speedometer"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('Page/studentsprofile?id=' . $this->session->userdata('username')); ?>" class="waves-effect">
                    <i class="ion ion-md-contact"></i>
                    <span> My Profile </span>
                </a>
            </li>

            <li>
                <a href="<?= site_url('student/my_qr'); ?>" class="waves-effect" title="My QR Code">
                    <i class="bi bi-qr-code"></i>
                    <span> My QR Code </span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('Page/changepassword'); ?>" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                    <span> Change Password </span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('Login/logout'); ?>" class="waves-effect">
                    <i class="ion bi bi-box-arrow-right"></i>
                    <span> Logout </span>
                </a>
            </li>
        </ul>
    </div>

        <?php elseif ($this->session->userdata('level') === 'Instructor'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/instructor" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <!-- <li>
                        <a href="<?= base_url(); ?>Page/staffprofile?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                            <i class="ion ion-md-contact "></i>
                            <span> My Profile </span>
                        </a>
                    </li> -->


                    <!-- 
                    <li>
                        <a href="<?= base_url(); ?>Instructor/facultyLoad?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                            <i class="ion ion-md-contact "></i>
                            <span> Faculty Load </span>
                        </a>
                    </li> -->



                    <!-- <li>
                        <a href="<?= base_url(); ?>GradeEncoding/index" class="waves-effect">
                            <i class=" ion ion-ios-key"></i>
                            <span> Encode Grades </span>
                        </a>
                    </li> -->



                    <li class="has-nav-second-level">
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="ion-md-create"></i>
                            <span> Grades Module </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level">
                            <li>
                                <a href="<?= base_url(); ?>Page/save_grades">Manual Grades Encoding</a>
                            </li>

                            <li>
                                <a href="<?= base_url(); ?>Settings/grades_status_list">Grades Encoding Status</a>
                            </li>
                            <li>
                                <!-- <a href="<?= base_url(); ?>Instructor/consol_teacher" target="_blank">Consolidated Grades</a> -->
                            </li>
                            <li>
                                <!-- <a href="<?= base_url(); ?>Page/update_grades">Calculate Grades</a> -->
                            </li>


                        </ul>
                    </li>


                    <?php
                    $id = $this->session->userdata('username');
                    $isProgramHead = $this->db->where('IDNumber', $id)->get('course_table')->num_rows() > 0;

                    // Get the first assigned course/major for direct link
                    $firstCourse = $this->db->where('IDNumber', $id)->get('course_table')->row();
                    ?>

                    <?php if ($isProgramHead): ?>


                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class=" ion ion-md-school"></i>
                                <span> Admission </span>
                                <span class="menu-arrow"></span>


                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <!-- <li><a href="<?= base_url(); ?>Page/profileListEncoder">Student's Profile</a> </li> -->
                                <li><a href="<?= base_url('Masterlist/enrolledListPH') ?>">Enrollment</a></li>

                            </ul>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="ion ion-md-folder"></i>
                                <span>Class Program</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level nav" aria-expanded="false">
                                <li>
                                    <a href="<?= base_url(); ?>Settings/classprogramform_head">Create Class Program</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('Settings/classprogram_list') ?>">Schedules</a>
                                </li>

                                <li>
                                    <!-- <a href="<?= base_url('Masterlist/enrolledListPH') ?>"></a> -->
                                </li>

                                <?php if (!empty($firstCourse)): ?>
                                    <li>
                                        <a href="<?= base_url('Settings/Subjects?Course=' . urlencode($firstCourse->CourseDescription) . '&Major=' . urlencode($firstCourse->Major)); ?>">
                                            Subjects
                                        </a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>




                        <li>
                            <a href="<?= base_url(); ?>Student/evaluationPH" class=" waves-effect">
                                <i class="ion ion-md-paper"> </i>
                                <span> Evaluation </span>

                            </a>

                        </li>


                    <?php endif; ?>

                    <li>
                        <a href="<?= base_url(); ?>Page/announcement?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                            <i class="bi bi-megaphone"></i>
                            <span> Announcement </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('activities'); ?>" class="waves-effect">
                            <i class="ion bi bi-qr-code-scan"></i>
                            <span> Activities (QR) </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Notes </span>

                        </a>

                    </li>




                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>
                </ul>
            </div>
        <?php elseif ($this->session->userdata('level') === 'Librarian'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/library" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>



                    <li>
                        <a href="<?= base_url(); ?>Library/Books" class="waves-effect">
                            <i class=" ion ion-ios-document"></i>
                            <span> Cataloging </span>
                        </a>
                    </li>
                    <!-- <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class=" ion ion-ios-photos"></i>
                        <span>  Circulation  </span>
						<span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>Library/borrow">Borrow</a></li>
						<li><a href="<?= base_url(); ?>Library/returnbooks">Return</a></li>
                    </ul>
                </li> -->
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-settings"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Library/author">Author</a></li>
                            <li><a href="<?= base_url(); ?>Library/category">Category</a></li>
                            <li><a href="<?= base_url(); ?>Library/location">Location</a></li>
                            <li><a href="<?= base_url(); ?>Library/publisher">Publisher</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-paper"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Library/reportsAllBooks">All Books</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>
                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'Guidance'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/guidance" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/incidents" class="waves-effect">
                            <i class="ion ion-md-alert"></i>
                            <span> Incidents </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/counselling" class="waves-effect">
                            <i class="ion ion-ios-analytics"></i>
                            <span> Counselling </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>
                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'HR Admin'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/hr" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-contact "> </i>
                            <span> Personnel </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/employeeList">Faculty and Staff</a></li>
                            <li><a href="<?= base_url(); ?>Instructor/employeeList">Faculty Loading</a></li>
                            <li><a href="#">Summary by Position</a></li>
                            <li><a href="#">Summary by Department</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>


                    <!-- <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Calendar </span>

                        </a>

                    </li> -->

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>
                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'Property Custodian') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/p_custodian" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-podium"></i>
                            <span> Inventory </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/inventoryList">Item List</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-podium"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Settings/brand">Brands</a></li>
                            <li><a href="<?= base_url(); ?>Settings/category">Category</a></li>
                            <li><a href="<?= base_url(); ?>Settings/office">Office</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>


                    <!-- <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Calendar </span>

                        </a>

                    </li> -->

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                </ul>

                <ul>

                </ul>
                </li>


                </ul>

            </div>
            <!-- End Sidebar -->


        <?php elseif ($this->session->userdata('level') === 'School Nurse'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/medical" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/medInfo" class="waves-effect">
                            <i class="ion ion-md-medical "></i>
                            <span> Medical Info </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/medRecords" class="waves-effect">
                            <i class="ion ion-md-medkit "></i>
                            <span> Medical Records </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>


                    <!-- <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Calendar </span>

                        </a>

                    </li> -->

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/changepassword" class="waves-effect">
                            <i class=" ion bi bi-shield-lock"></i>
                            <span> Change Password </span>
                        </a>
                    </li>
                </ul>
            </div>



        <?php elseif ($this->session->userdata('level') === 'Super Admin'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/superAdmin" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/school_info" class="waves-effect">
                            <i class="ion ion-md-folder-open"></i>
                            <span> School Info </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Settings/view_logs" class="waves-effect">
                            <i class="ion ion-md-folder-open"></i>
                            <span> User Logs </span>
                        </a>
                    </li>



                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> School Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url('OnlineSettings'); ?>">On/Off Online Payment</a></li>
                            <!-- <li><a href="<?= base_url('OnlineSettings/OnlinePaymentSettings'); ?>">Online Payment Settings</a></li> -->
                            <!-- <li><a href="#">LMS Settings</a></li> -->
                        </ul>
                    </li>







                </ul>

            </div>


        <?php endif; ?>



        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>