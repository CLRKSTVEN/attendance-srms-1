<?php defined('BASEPATH') or exit('No direct script access allowed');

class FbmsoPersonnelReviewsModel extends CI_Model
{
    private $t = 'fbmso_personnel_reviews';

    public function all_for_personnel($personnelId)
    {
        $qb = $this->db->order_by('created_at DESC, id DESC');
        if ($personnelId === null) {
            $qb->where('personnel_id IS NULL', null, false);
        } else {
            $qb->where('personnel_id', (int)$personnelId);
        }

        return $qb->get($this->t)->result();
    }

    public function map_for_personnel_ids(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $rows = $this->db
            ->where_in('personnel_id', $ids)
            ->order_by('created_at DESC, id DESC')
            ->get($this->t)
            ->result();

        $grouped = [];
        foreach ($rows as $row) {
            $pid = (int)$row->personnel_id;
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [];
            }
            $grouped[$pid][] = $row;
        }

        return $grouped;
    }

    public function general_reviews()
    {
        return $this->db
            ->where('personnel_id IS NULL', null, false)
            ->order_by('created_at DESC, id DESC')
            ->get($this->t)
            ->result();
    }

    public function all_with_personnel()
    {
        return $this->db
            ->select('r.*, p.full_name AS personnel_name')
            ->from($this->t . ' AS r')
            ->join('fbmso_personnels AS p', 'p.id = r.personnel_id', 'left')
            ->order_by('r.created_at DESC, r.id DESC')
            ->get()
            ->result();
    }

    public function get($id)
    {
        return $this->db->get_where($this->t, ['id' => (int)$id])->row();
    }

    public function create($data)
    {
        if (array_key_exists('personnel_id', $data)) {
            $pid = (int)$data['personnel_id'];
            $data['personnel_id'] = $pid > 0 ? $pid : null;
        }

        $data['created_at'] = $data['created_at'] ?? date('Y-m-d H:i:s');
        $this->db->insert($this->t, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if (array_key_exists('personnel_id', $data)) {
            $pid = (int)$data['personnel_id'];
            $data['personnel_id'] = $pid > 0 ? $pid : null;
        }

        $this->db->where('id', (int)$id)->update($this->t, $data);
    }

    public function delete($id)
    {
        $this->db->delete($this->t, ['id' => (int)$id]);
    }
}
