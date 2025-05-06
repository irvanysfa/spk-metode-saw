<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModel extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $allowedFields = ['kode_kriteria', 'nama_kriteria', 'bobot', 'sifat','tipe_kriteria'];

    public function getAllKriteria()
    {
        return $this->findAll();
    }
}
