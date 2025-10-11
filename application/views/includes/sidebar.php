
<div class="left-side-menu">
    <div class="slimscroll-menu">
     

        <?php if ($this->session->userdata('level') === 'IT'): ?>
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
                </ul>

            </div>
            <!-- End Sidebar -->

       

      
   <?php elseif ($this->session->userdata('level') === 'SAMPLE'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title"></li>

                  for other positions sidebar

                </ul>

            </div>
            <!-- End Sidebar -->

       

      

        <?php endif; ?>





        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>