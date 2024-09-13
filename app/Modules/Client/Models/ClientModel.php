<?php
namespace App\Modules\Client\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'cnpj', 'logo', 'created_at', 'updated_at'];

    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'cnpj' => 'required|is_unique[clients.cnpj]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getClientByCnpj($cnpj)
    {
        return $this->where('cnpj', $cnpj)->first();
    }
}
