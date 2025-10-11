<?php
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('SettingsModel');
        $this->load->model('StudentModel');
    }

    function index()
    {
        $settings = $this->Login_model->loginImage(); // returns an array of result objects
        $result['data'] = $settings;

        // Assuming there's at least one row returned
        if (!empty($settings)) {
            $result['active_sem'] = $settings[0]->active_sem;
            $result['active_sy'] = $settings[0]->active_sy;
            $result['allow_signup'] = $settings[0]->allow_signup; // <- Add this line
        } else {
            $result['active_sem'] = null;
            $result['active_sy'] = null;
            $result['allow_signup'] = 'No'; // default to No
        }

        $this->load->view('home_page', $result);
    }


    function faq()
    {
        $result['data'] = $this->Login_model->loginImage();
        //$this->output->cache(60);
        $this->load->view('web-faq', $result);
    }

    function login()
    {
        $result['data'] = $this->Login_model->loginImage();
        $data['allow_signup'] = 'Yes';
        //$this->output->cache(60);
        $this->load->view('home_page', $result);
    }



    function registration()
    {
        $courseVal = $this->input->post('course');
        $result['course'] = $this->StudentModel->getCourse();
        $result['major'] = $this->StudentModel->getCourseMajor();
        $result['province'] = $this->StudentModel->getProvince();
        $result['city'] = $this->StudentModel->getCity();
        $this->load->view('registration_form', $result);

        if ($this->input->post('register')) {
            $query1 = $this->db->query("SELECT *  from o_srms_settings");
            $row = $query1->result_array();

            $StudentNumber = $this->input->post('StudentNumber');
            $FirstName = strtoupper($this->input->post('FirstName'));
            $MiddleName = strtoupper($this->input->post('MiddleName'));
            $LastName = strtoupper($this->input->post('LastName'));
            $nameExtn = strtoupper($this->input->post('nameExtn'));
            $completeName = $FirstName . ' ' . $LastName;
            $Sex = $this->input->post('Sex');
            $bdate = $this->input->post('bdate');
            $BirthPlace = $this->input->post('BirthPlace');
            $age = $this->input->post('age');
            $contactNo = $this->input->post('contactNo');
            $email = $this->input->post('email');
            $date = date('Y-m-d');
            $pass = $this->input->post('bdate');
            $h_upass = sha1($pass);

            $MobileNumber = $this->input->post('MobileNumber');
            $CivilStatus = $this->input->post('CivilStatus');
            $Religion = $this->input->post('Religion');
            $ethnicity = $this->input->post('ethnicity');
            $working = $this->input->post('working');
            $VaccStat = $this->input->post('VaccStat');
            $province = $this->input->post('province');
            $city = $this->input->post('city');
            $brgy = $this->input->post('brgy');
            $sitio = $this->input->post('sitio');

            $course = $this->input->post('Course');
            $major = $this->input->post('Major');


            $que = $this->db->query("select * from studeprofile where FirstName='" . $FirstName . "' and LastName='" . $LastName . "'");
            $row = $que->num_rows();
            if ($row) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Duplicate record!</b></div>');
            } else {

                // $que=$this->db->query("insert into users (username, password, position, fName, mName, lName, email, avatar, acctStat, dateCreated, name) values('$lrn','$h_upass','Student','$fname','$mname','$lname','$email','avatar.png','active','$date','$fname.' '.$lname ')");
                $que1 = $this->db->query("insert into studeprofile (StudentNumber, FirstName, MiddleName, LastName, nameExtn, Sex, CivilStatus, birthDate, age, BirthPlace, contactNo, ethnicity, Religion, working, province, city, brgy, sitio, provincePresent, cityPresent, brgyPresent, sitioPresent, email, VaccStat, settingsID) values('$StudentNumber','$FirstName','$MiddleName','$LastName','$nameExtn','$Sex','$CivilStatus','$bdate','$age','$BirthPlace','$contactNo','$ethnicity','$Religion','$working','$province','$city','$brgy','$sitio','$province','$city','$brgy','$sitio','$email','$VaccStat','1')");
                $que = $this->db->query("insert into studentsignup values('','$StudentNumber','$FirstName','$MiddleName','$LastName','For Confirmation','$date','$course','$major')");
                $que2 = $this->db->query("insert into users values('$StudentNumber','$h_upass','Student','$FirstName','$MiddleName','$LastName','$email','avatar.png','active','$date','$completeName','$StudentNumber')");
                echo '<script language="javascript">';
                echo 'alert("Registration details have been submitted successfully. You will be notified via email for your login credentials after the processing of your enrollment.")';
                echo '</script>';
                //redirect('Login');

                //      Email Notification
                $this->load->config('email');
                $this->load->library('email');
                $mail_message = 'Dear ' . $FirstName . ',' . "\r\n";
                $mail_message .= '<br><br>Thank you for signing up!' . "\r\n";
                $mail_message .= '<br><br>You may now login to the system using <span style="color:red; font-weight:bold;">' . $StudentNumber . '</span> as your username and <span style="color:red; font-weight:bold;">' . $pass . ' </span> as your password.' . "\r\n";
                $mail_message .= '<br><br>Thanks & Regards,';
                $mail_message .= '<br>SRMS - Online';

                $this->email->from('no-reply@lxeinfotechsolutions.com', 'School Records Management System')
                    ->to($email)
                    ->subject('Account Created')
                    ->message($mail_message);
                $this->email->send();
                // redirect('Login');
            }
        }
    }

    function fetch_major()
    {

        if ($this->input->post('course')) {
            $output = '<option value=""></option>';
            $yearlevel = $this->StudentModel->getMajor($this->input->post('course'));
            foreach ($yearlevel as $row) {
                $output .= '<option value ="' . $row->Major . '">' . $row->Major . '</option>';
            }
            echo $output;
        }
    }


    function reservation()
    {
        $this->load->view('reservation_form');

        if ($this->input->post('reserve')) {
            $appDate = date("Y-m-d");
            $firstName = strtoupper($this->input->post('firstName'));
            $middleName = strtoupper($this->input->post('middleName'));
            $lastName = strtoupper($this->input->post('lastName'));
            $nameExtn = strtoupper($this->input->post('nameExtn'));
            $sex = $this->input->post('sex');
            $bDate = $this->input->post('bDate');
            $age = $this->input->post('age');
            $civilStatus = $this->input->post('civilStatus');
            $empStatus = $this->input->post('empStatus');
            $ad_street = $this->input->post('ad_street');
            $ad_barangay = $this->input->post('ad_barangay');
            $ad_city = $this->input->post('ad_city');
            $ad_province = $this->input->post('ad_province');
            $email = $this->input->post('email');
            $contactNos = $this->input->post('contactNos');
            $course = $this->input->post('course');


            // $que=$this->db->query("select * from reservation where username='".$lrn."'");
            // $row = $que->num_rows();
            // if($row)
            // {
            // $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Record already exist.</b></div>');
            // }
            // else
            // {
            $que = $this->db->query("insert into reservation values(0,'$appDate','$firstName','$middleName','$lastName','$nameExtn','$sex','$bDate','$age','$civilStatus','$empStatus','$ad_street','$ad_barangay','$ad_city','$ad_province','$email','$contactNos','$course','Pending')");
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Reservation details have been processed successfully.  You will be notified via text or phone call for the status of your reservation.  Thank you.</b></div>');
            redirect('Login/reservation');

            //   //Email Notification
            //     $this->load->config('email');
            //     $this->load->library('email');
            //     $mail_message = 'Dear ' . $fname . ',' . "\r\n"; 
            //     $mail_message .= '<br><br>Thank you for reservation!' . "\r\n"; 
            //     $mail_message .= '<br><br>You may now login to the system using <span style="color:red; font-weight:bold;">' .$lrn. '</span> as your username and <span style="color:red; font-weight:bold;">' . $pass . ' </span> as your password.' ."\r\n";
            //     $mail_message .= '<br><br>Thanks & Regards,';
            //     $mail_message .= '<br>SRMS - Online';

            //     $this->email->from('no-reply@lxeinfotechsolutions.com', 'SRMS Online Team')
            //         ->to($email)
            //         ->subject('Scholarship Reservation')
            //         ->message($mail_message);
            //         $this->email->send();
            //redirect('Login/reservation');

        }
    }


    // function auth()
    // {
    //     $username = $this->input->post('username', TRUE);
    //     $raw_password  = $this->input->post('password', TRUE); 
    //     $password = sha1($this->input->post('password', TRUE));
    //     $sy = $this->input->post('sy', TRUE);
    //     $semester = $this->input->post('semester', TRUE);


    //     // Validate user credentials
    //     $validate = $this->Login_model->validate($username, $password);

    //     if ($validate->num_rows() > 0) {
    //         $data = $validate->row_array();
    //         $username = $data['username'];
    //         $fname = $data['fName'];
    //         $mname = $data['mName'];
    //         $lname = $data['lName'];
    //         $avatar = $data['avatar'];
    //         $email = $data['email'];
    //         $level = $data['position'];
    //         $IDNumber = $data['IDNumber'];
    //         $position = $data['position'];
    //         $acctStat = $data['acctStat']; // Assuming `acctStat` is a column in the database

    //         if ($acctStat === 'active') {
    //                $this->Login_model->log_login_attempt($username, $raw_password, 'success');
    //             // User data to be stored in session
    //             $user_data = array(
    //                 'username'  => $username,
    //                 'fname'  => $fname,
    //                 'mname'  => $mname,
    //                 'lname'  => $lname,
    //                 'avatar'  => $avatar,
    //                 'email'     => $email,
    //                 'level'     => $level,
    //                 'IDNumber'     => $IDNumber,
    //                 'position'     => $position,
    //                 'sy' => $sy,
    //                 'semester' => $semester,
    //                 'logged_in' => TRUE
    //             );
    //             $this->session->set_userdata($user_data);

    //             // Redirect based on user level
    //             switch ($level) {
    //                 case 'Admin':
    //                     redirect('page/admin');
    //                     break;
    //                 case 'School Admin':
    //                     redirect('page/school_admin');
    //                     break;
    //                 case 'Registrar':
    //                     redirect('page/registrar');
    //                     break;
    //                 case 'Head Registrar':
    //                     redirect('page/registrar');
    //                     break;
    //                 case 'Super Admin':
    //                     redirect('page/superAdmin');
    //                     break;
    //                 case 'Property Custodian':
    //                     redirect('page/p_custodian');
    //                     break;
    //                 case 'HR Admin':
    //                     redirect('page/hr');
    //                     break;
    //                 case 'Academic Officer':
    //                     redirect('page/a_officer');
    //                     break;
    //                 case 'Student':
    //                     redirect('page/student');
    //                     break;
    //                 case 'Stude Applicant':
    //                     redirect('page/student_registration');
    //                     break;
    //                 case 'Accounting':
    //                     redirect('page/accounting');
    //                     break;
    //                 case 'Instructor':
    //                     redirect('page/Instructor');
    //                     break;
    //                 case 'Encoder':
    //                     redirect('page/encoder');
    //                     break;
    //                 case 'Human Resource':
    //                     redirect('page/hr');
    //                     break;
    //                 case 'Guidance':
    //                     redirect('page/guidance');
    //                     break;
    //                 case 'School Nurse':
    //                     redirect('page/medical');
    //                     break;
    //                 case 'IT':
    //                     redirect('page/IT');
    //                     break;
    //                 case 'Librarian':
    //                     redirect('page/library');
    //                     break;
    //                 case 'Principal':
    //                     redirect('page/s_principal');
    //                     break;
    //                 default:
    //                     // Handle unexpected levels
    //                     $this->session->set_flashdata('danger', 'Unauthorized access.');
    //                     redirect('login');
    //             }
    //         } else {
    //             // ❌ Log failed due to inactive account
    //             $this->Login_model->log_login_attempt($username, $raw_password, 'failed');
    //             $this->session->set_flashdata('danger', 'Your account is not active. Please contact support.');
    //             redirect('login');
    //         }
    //     } else {
    //         // ❌ Log failed due to invalid credentials
    //         $this->Login_model->log_login_attempt($username, $raw_password, 'failed');
    //         $this->session->set_flashdata('danger', 'The username or password is incorrect!');
    //         redirect('login');
    //     }
    // }
function auth()
{
    $username = $this->input->post('username', TRUE);
    $raw_password  = $this->input->post('password', TRUE);
    $password = sha1($this->input->post('password', TRUE));
    $sy = $this->input->post('sy', TRUE);
    $semester = $this->input->post('semester', TRUE);

    // NEW: capture next from POST first (form), then GET
    $next = $this->input->post('next', TRUE) ?: $this->input->get('next', TRUE);

    $validate = $this->Login_model->validate($username, $password);

    if ($validate->num_rows() > 0) {
        $data = $validate->row_array();
        $username = $data['username'];
        $fname = $data['fName'];
        $mname = $data['mName'];
        $lname = $data['lName'];
        $avatar = $data['avatar'];
        $email = $data['email'];
        $level = $data['position'];
        $IDNumber = $data['IDNumber'];
        $position = $data['position'];
        $acctStat = $data['acctStat'];

        if ($acctStat === 'active') {
            $this->Login_model->log_login_attempt($username, $raw_password, 'success');

            $user_data = array(
                'username'  => $username,
                'fname'  => $fname,
                'mname'  => $mname,
                'lname'  => $lname,
                'avatar'  => $avatar,
                'email'     => $email,
                'level'     => $level,          // <-- Attendance::checkin reads this
                'IDNumber'  => $IDNumber,
                'position'  => $position,
                'sy'        => $sy,
                'semester'  => $semester,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($user_data);

            // NEW: if there's a safe "next", go there first (same-host only)
            if ($next) {
                $host = parse_url($next, PHP_URL_HOST);
                if (!$host || strcasecmp($host, $_SERVER['HTTP_HOST']) === 0) {
                    redirect($next);
                    return;
                }
            }

            // Fallback: your existing role-based redirects
            switch ($level) {
                case 'Admin':               redirect('page/admin'); break;
                case 'School Admin':        redirect('page/school_admin'); break;
                case 'Registrar':           redirect('page/registrar'); break;
                case 'Head Registrar':      redirect('page/registrar'); break;
                case 'Super Admin':         redirect('page/superAdmin'); break;
                case 'Property Custodian':  redirect('page/p_custodian'); break;
                case 'HR Admin':            redirect('page/hr'); break;
                case 'Academic Officer':    redirect('page/a_officer'); break;
                case 'Student':             redirect('page/student'); break; // keep your existing student landing
                case 'Stude Applicant':     redirect('page/student_registration'); break;
                case 'Accounting':          redirect('page/accounting'); break;
                case 'Instructor':          redirect('page/Instructor'); break;
                case 'Encoder':             redirect('page/encoder'); break;
                case 'Human Resource':      redirect('page/hr'); break;
                case 'Guidance':            redirect('page/guidance'); break;
                case 'School Nurse':        redirect('page/medical'); break;
                case 'IT':                  redirect('page/IT'); break;
                case 'Librarian':           redirect('page/library'); break;
                case 'Principal':           redirect('page/s_principal'); break;
                default:
                    $this->session->set_flashdata('danger', 'Unauthorized access.');
                    redirect('login');
            }
            return;
        } else {
            // Inactive account
            $this->Login_model->log_login_attempt($username, $raw_password, 'failed');
            $this->session->set_flashdata('danger', 'Your account is not active. Please contact support.');
            // NEW: preserve next on failure
            redirect('login' . ($next ? ('?next=' . urlencode($next)) : ''));
            return;
        }
    } else {
        // Invalid credentials
        $this->Login_model->log_login_attempt($username, $raw_password, 'failed');
        $this->session->set_flashdata('danger', 'The username or password is incorrect!');
        // NEW: preserve next on failure
        redirect('login' . ($next ? ('?next=' . urlencode($next)) : ''));
        return;
    }
}


    public function deleteUser($user)
    {
        // Attempt to delete the user
        $deleteSuccess = $this->Login_model->deleteUser($user);

        // Check the outcome of the delete operation and set the appropriate flash message
        if ($deleteSuccess) {
            $this->session->set_flashdata('success', '<div class="alert alert-success">User account deleted successfully.</div>');
        } else {
            $this->session->set_flashdata('error', '<div class="alert alert-danger">Error deleting enrollment. Please try again.</div>');
        }

        // Redirect back to the user accounts page
        redirect(base_url('Page/userAccounts'));
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
    public function forgot_pass()
    {
        $email = $this->input->post('email');
        $findemail = $this->Login_model->forgotPassword($email);
        if ($findemail) {
            $this->Login_model->sendpassword($findemail);
        } else {
            $this->session->set_flashdata('msg', ' Email not found!');
            redirect(base_url() . 'login', 'refresh');
        }
    }

    // public function sendpassword($user)
    // {
    //     $this->load->library('email');
    //     $this->email->set_mailtype("html");

    //     $resetToken = sha1(time() . $user->IDNumber); // or a better token generator
    //     $resetLink = base_url("login/reset_password/" . $resetToken);

    //     // Save token in DB if you're validating it later (optional)
    //     // $this->db->where('email', $user->email)->update('o_users', ['reset_token' => $resetToken]);

    //     $school = $this->db->get('o_srms_settings')->row();
    //     $schoolName = $school ? $school->SchoolName : 'SRMS Portal';

    //     $message = '
    // <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f8f9fa; color: #333;">
    //     <h2 style="color: #007bff;">Password Reset Request</h2>
    //     <p>Hello <strong>' . htmlspecialchars($user->fName) . '</strong>,</p>

    //     <p>We received a request to reset your password for your <strong>' . htmlspecialchars($schoolName) . '</strong> account.</p>

    //     <p style="margin: 20px 0;">
    //         <a href="' . $resetLink . '" style="padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Reset Your Password</a>
    //     </p>

    //     <p>If you didn\'t request a password reset, you can ignore this email. Your password will remain unchanged.</p>

    //     <hr style="margin: 30px 0;">
    //     <p style="font-size: 12px; color: #999;">
    //         This is an automated message from ' . htmlspecialchars($schoolName) . '. Please do not reply.
    //     </p>
    // </div>';

    //     $this->email->from('no-reply@srmsportal.com', $schoolName);
    //     $this->email->to($user->email);
    //     $this->email->subject('Reset Your Password - ' . $schoolName);
    //     $this->email->message($message);
    //     $this->email->send();
    // }
}
