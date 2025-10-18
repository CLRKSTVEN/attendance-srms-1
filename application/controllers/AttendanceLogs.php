<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AttendanceLogs extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url','form']);
        $this->load->library(['session']);
        $this->load->model('Activities_model','ActivitiesModel');
        $this->load->model('Activity_attendance_model','ActAttModel');
    }
public function index()
{
    $activity_id = (int)$this->input->get('activity_id');
    $section     = trim((string)$this->input->get('section'));
    $yearLevel   = trim((string)$this->input->get('year_level'));
    $date        = trim((string)$this->input->get('date'));      // YYYY-MM-DD (optional)
    $session     = trim((string)$this->input->get('session'));   // am|pm|eve (optional)

    // ❶ Get active SY/Sem (fallback to settings if session is empty)
    $active = $this->db->select('active_sy, active_sem')
                       ->from('settings')
                       ->order_by('settingsID','DESC')->limit(1)
                       ->get()->row();
    $use_sy  = $this->session->userdata('sy')       ?: ($active->active_sy  ?? null);
    $use_sem = $this->session->userdata('semester') ?: ($active->active_sem ?? null);

    $data = [
        'activities' => $this->db->select('activity_id, title')
                                  ->from('activities')->order_by('start_at','DESC')->get()->result(),
        'activity_id'=> $activity_id ?: null,
        'section'    => $section ?: '',
        'year_level' => $yearLevel ?: '',
        'date'       => $date ?: '',
        'session'    => $session ?: '',
        'rows'       => []
    ];

    if ($activity_id > 0) {
        // 1st pass: with current filters
        $rows = $this->ActAttModel->report_by_activity_section(
            $activity_id,
            $section ?: null,
            $date ?: null,
            $session ?: null,
            $yearLevel ?: null,
            $use_sy,
            $use_sem
        );

        if (empty($rows)) {
            // Fallback: show ALL logs for the activity so you SEE data
            $rowsAll = $this->ActAttModel->report_by_activity_section(
                $activity_id, null, null, null, null,
                $use_sy, $use_sem
            );
            if (!empty($rowsAll)) {
                $data['rows'] = $rowsAll;
                $data['filter_note'] = 'No logs matched your filters - showing all logs for this activity.';
            } else {
                $data['rows'] = [];
            }
        } else {
            $data['rows'] = $rows;
        }
    }

    // ❷ Build Section dropdown from semesterstude for the active SY/Sem
    $secQB = $this->db->select("DISTINCT TRIM(ss.Section) AS section", false)
                      ->from('semesterstude ss')
                      ->where("ss.Section IS NOT NULL", null, false)
                      ->where("TRIM(ss.Section) <> ''", null, false);
    if ($use_sy)  $secQB->where('ss.SY', $use_sy);
    if ($use_sem) $secQB->where('ss.Semester', $use_sem);
    $data['sections'] = $secQB->order_by('ss.Section','ASC')->get()->result();

    // Year level dropdown (same scope as sections)
    $yrQB = $this->db->select("DISTINCT TRIM(ss.YearLevel) AS year_level", false)
                     ->from('semesterstude ss')
                     ->where("ss.YearLevel IS NOT NULL", null, false)
                     ->where("TRIM(ss.YearLevel) <> ''", null, false);
    if ($use_sy)  $yrQB->where('ss.SY', $use_sy);
    if ($use_sem) $yrQB->where('ss.Semester', $use_sem);
    $data['year_levels'] = $yrQB->order_by('ss.YearLevel','ASC')->get()->result();

    $this->load->view('attendance_logs_index', $data);
}
public function activity($activity_id)
{
    $activity_id = (int)$activity_id;
    $section     = trim((string)$this->input->get('section'));
    $date        = trim((string)$this->input->get('date'));
    $session     = trim((string)$this->input->get('session'));
    $yearLevel   = trim((string)$this->input->get('year_level'));

    $activity = $this->ActivitiesModel->find($activity_id);
    if (!$activity) show_404();

    // Ensure consistent SY/Sem
    $active = $this->db->select('active_sy, active_sem')
                       ->from('settings')
                       ->order_by('settingsID','DESC')->limit(1)
                       ->get()->row();
    $use_sy  = $this->session->userdata('sy')       ?: ($active->active_sy  ?? null);
    $use_sem = $this->session->userdata('semester') ?: ($active->active_sem ?? null);

    $rows = $this->ActAttModel->report_by_activity_section(
        $activity_id,
        $section ?: null,
        $date ?: null,
        $session ?: null,
        $yearLevel ?: null,
        $use_sy,
        $use_sem
    );

    $this->load->view('attendance_logs_report', [
        'activity' => $activity,
        'rows'     => $rows,
        'filters'  => [
            'section'    => $section,
            'date'       => $date,
            'session'    => $session,
            'year_level' => $yearLevel,
        ],
    ]);
}
public function export_csv($activity_id)
{
    $activity_id = (int)$activity_id;
    $section     = trim((string)$this->input->get('section'));
    $date        = trim((string)$this->input->get('date'));
    $session     = trim((string)$this->input->get('session'));
    $yearLevel   = trim((string)$this->input->get('year_level'));

    $activity = $this->ActivitiesModel->find($activity_id);
    if (!$activity) show_404();

    // Ensure consistent SY/Sem
    $active = $this->db->select('active_sy, active_sem')
                       ->from('settings')
                       ->order_by('settingsID','DESC')->limit(1)
                       ->get()->row();
    $use_sy  = $this->session->userdata('sy')       ?: ($active->active_sy  ?? null);
    $use_sem = $this->session->userdata('semester') ?: ($active->active_sem ?? null);

    $rows = $this->ActAttModel->report_by_activity_section(
        $activity_id,
        $section ?: null,
        $date ?: null,
        $session ?: null,
        $yearLevel ?: null,
        $use_sy,
        $use_sem
    );

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="attendance_'.$activity_id.'.csv"');
    $out = fopen('php://output','w');
    fputcsv($out, ['StudentNumber','StudentName','Course','YearLevel','Section','Session','Check-In','Check-Out','Duration(min)','Remarks','Checked-In By']);
    foreach ($rows as $r) {
        $mins = ($r->checked_out_at && $r->checked_in_at)
            ? round((strtotime($r->checked_out_at) - strtotime($r->checked_in_at)) / 60)
            : null;
        fputcsv($out, [
            $r->student_number,
            $r->student_name,
            $r->course, $r->YearLevel, $r->section,
            strtoupper($r->session ?: ''),
            $r->checked_in_at, $r->checked_out_at, $mins,
            $r->remarks, $r->checked_in_by
        ]);
    }
    fclose($out);
    exit;
}

}
