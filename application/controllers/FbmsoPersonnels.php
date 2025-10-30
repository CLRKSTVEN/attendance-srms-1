<?php defined('BASEPATH') or exit('No direct script access allowed');

class FbmsoPersonnels extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('FbmsoPersonnelsModel', 'Team');
        $this->load->model('FbmsoPersonnelReviewsModel', 'Reviews');
        $this->load->model('SettingsModel'); // <-- add
        $this->load->helper(['form', 'url']);
        $this->load->library('upload');
        // Gatekeep if needed:
        // if ($this->session->userdata('level')!=='Administrator') show_404();
    }

    private function is_student()
    {
        return $this->session->userdata('level') === 'Student';
    }

    private function is_admin()
    {
        return $this->session->userdata('level') === 'Administrator';
    }

    private function user_fullname_from_users($username)
    {
        if (!$username) return null;
        $row = $this->db->get_where('o_users', ['username' => $username])->row();
        if (!$row) return null;

        $parts = array_filter([
            trim($row->fName ?? ''),
            trim($row->mName ?? ''),
            trim($row->lName ?? ''),
        ]);
        $full = trim(implode(' ', $parts));
        if ($full === '') $full = trim($row->name ?? '');
        if ($full === '') $full = $username;
        return strtoupper($full);
    }

    private function current_student_name()
    {
        if (!$this->is_student()) return null;
        return $this->user_fullname_from_users($this->session->userdata('username'));
    }

    private function school_info_block()
    {
        // Pull SchoolName / SchoolAddress / letterhead_web from o_srms_settings
        if ($this->db->table_exists('o_srms_settings')) {
            $q = $this->db->select('SchoolName, SchoolAddress, letterhead_web')
                ->from('o_srms_settings')
                ->limit(1)
                ->get();
            if ($q && $q->num_rows() > 0) {
                // Your template expects $data18[0]->SchoolName and ->SchoolAddress
                return ['data18' => $q->result()];
            }
        }

        // Fallback if table is missing/empty
        return ['data18' => [(object)[
            'SchoolName'     => 'Faculty of Business & Management Student Org.',
            'SchoolAddress'  => '',
            'letterhead_web' => null
        ]]];
    }

    /** Public landing page */
    public function index()
    {
        $data = $this->school_info_block();
        $data['people'] = $this->Team->all_active();
        $data['reviews_by_person'] = $this->collect_reviews_by_person($data['people']);
        $data['general_reviews']   = $this->Reviews->general_reviews();
        $data['currentStudentName'] = $this->current_student_name(); // <-- pass to view
        $this->load->view('fbmso_team_public', $data);
    }

    /** Admin manage page */
    public function manage()
    {
        $data = $this->school_info_block();
        $data['people'] = $this->Team->all();
        $data['reviews_by_person'] = $this->collect_reviews_by_person($data['people']);
        $data['reviews_list']      = $this->Reviews->all_with_personnel();
        $data['general_reviews']   = $this->Reviews->general_reviews();
        $data['currentStudentName'] = $this->current_student_name(); // <-- pass to view
        $this->load->view('fbmso_team_manage', $data);
    }

    private function collect_reviews_by_person($people)
    {
        $ids = [];
        if (!empty($people)) {
            foreach ($people as $person) {
                $ids[] = (int)$person->id;
            }
        }
        return $this->Reviews->map_for_personnel_ids($ids);
    }

    public function review_save()
    {
        // Only students can submit reviews
        if (!$this->is_student()) {
            $this->session->set_flashdata('danger', 'Only students can submit reviews.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        // Editing is disabled globally
        $reviewId = (int)$this->input->post('review_id');
        if ($reviewId) {
            $this->session->set_flashdata('danger', 'Editing reviews is disabled once submitted.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        $personnelRaw = trim((string)$this->input->post('personnel_id'));
        $personnelId  = ($personnelRaw === '' || $personnelRaw === '0') ? null : (int)$personnelRaw;

        // Force reviewer name from session / o_users
        $reviewerName = $this->current_student_name();
        if (!$reviewerName) {
            $this->session->set_flashdata('danger', 'Unable to resolve your student identity.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        $reviewText   = trim((string)$this->input->post('review_text', true));

        if ($personnelId && !$this->Team->get($personnelId)) {
            $this->session->set_flashdata('danger', 'Selected officer could not be found.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        if ($reviewText === '') {
            $this->session->set_flashdata('danger', 'Please complete all review fields.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        $this->Reviews->create([
            'personnel_id'  => $personnelId,
            'reviewer_name' => $reviewerName, // <-- from session
            'review_text'   => $reviewText,
        ]);

        $this->session->set_flashdata('success', 'Thank you for the review!');
        redirect('FbmsoPersonnels/index');
    }

    public function review_delete($id = null)
    {
        // Only students can delete (note: without ownership field, this deletes any review)
        if (!$this->is_student()) {
            $this->session->set_flashdata('danger', 'Only students can delete reviews.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        $id = (int)$id;
        if (!$id) {
            $this->session->set_flashdata('danger', 'Review not found.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        $review = $this->Reviews->get($id);
        if (!$review) {
            $this->session->set_flashdata('danger', 'Review not found.');
            redirect('FbmsoPersonnels/index');
            return;
        }

        $this->Reviews->delete($id);
        $this->session->set_flashdata('success', 'Review removed.');
        redirect('FbmsoPersonnels/index');
    }

    public function save()
    {
        $id = $this->input->post('id');
        $payload = [
            'full_name'  => $this->input->post('full_name', true),
            'title'      => $this->input->post('title', true),
            'bio'        => $this->input->post('bio', false),
            'sort_order' => (int)$this->input->post('sort_order'),
            'is_active'  => (int)$this->input->post('is_active', 1),
        ];

        if (!empty($_FILES['photo']['name'])) {
            $path = FCPATH . 'upload/banners/';
            if (!is_dir($path)) @mkdir($path, 0777, true);
            $config = [
                'upload_path'   => $path,
                'allowed_types' => 'jpg|jpeg|png|webp',
                'max_size'      => 4096,
                'file_name'     => 'fbmso_' . time() . '_' . mt_rand(1000, 9999),
                'overwrite'     => false,
            ];
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('photo')) {
                $this->session->set_flashdata('danger', $this->upload->display_errors('', ''));
                redirect('FbmsoPersonnels/manage');
                return;
            }
            $payload['photo'] = $this->upload->data('file_name');
        }

        $this->Team->upsert($payload, $id ?: null);
        $this->session->set_flashdata('success', 'Saved successfully.');
        redirect('FbmsoPersonnels/manage');
    }

    public function delete($id)
    {
        $this->Team->delete((int)$id);
        $this->session->set_flashdata('success', 'Removed.');
        redirect('FbmsoPersonnels/manage');
    }

    public function toggle($id)
    {
        $active = (int)$this->input->get('v', 1);
        $this->Team->toggle((int)$id, $active);
        redirect('FbmsoPersonnels/manage');
    }
}
