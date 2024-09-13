<?php
namespace App\Modules\Client\Controllers;

use App\Controllers\BaseController;
use App\Modules\Client\Models\ClientModel;

class ClientController extends BaseController
{
    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        return view('App\Modules\Client\Views\header')
                .view('App\Modules\Client\Views\index')
                .view('App\Modules\Client\Views\footer');
    }

    public function create()
    {
        return $this->response->setJSON(['message' => 'Formulário de criação de cliente']);
    }

    public function add(): ResponseInterface|\CodeIgniter\HTTP\ResponseInterface
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required',
            'cnpj' => 'required|is_unique[clients.cnpj]',
            'logo' => 'uploaded[logo]|max_size[logo,1024]|is_image[logo]|mime_in[logo,image,jpeg,image/png,image/gif]'
        ]);
        if(!$validation->withRequest($this->request)->run()){
            $errors = $validation->getErrors();
            return $this->response->setJSON(['errors' => $validation->getErrors()]);
        }

        $file = $this->request->getFile('logo');
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/modules/clients/logo', $newName);

        $data = [
            'name' => $this->request->getPost('name'),
            'cnpj' => $this->request->getPost('cnpj'),
            'logo' => 'uploads/modules/clients/logo/' . $newName
        ];

        $this->clientModel->save($data);

        return $this->response->setJSON(['message' => 'Client created successfully']);
    }

    public function edit($id)
    {
        $clientModel = new ClientModel();
        $client = $clientModel->find($id);
        
        if ($client) {
            return $this->response->setJSON($client);
        } else {
            return $this->response->setJSON(['message' => 'Cliente não encontrado'], 404);
        }
    }

    public function update($id)
    {
        $clientModel = new ClientModel();
        $data = $this->request->getRawInput();
        
        if ($clientModel->update($id, $data)) {
            return $this->response->setJSON(['message' => 'Cliente atualizado com sucesso']);
        } else {
            return $this->response->setJSON(['message' => 'Erro ao atualizar cliente'], 400);
        }
    }

    public function remove($id)
    {
        $clientModel = new ClientModel();
        
        if ($clientModel->delete($id)) {
            return $this->response->setJSON(['message' => 'Cliente removido com sucesso']);
        } else {
            return $this->response->setJSON(['message' => 'Erro ao remover cliente'], 400);
        }
    }

    public function listAll(): ResponseInterface
    {
        $clientModel = new ClientModel();
        $clients = $clientModel->findAll();

        if ($clients) {
            return $this->response->setJSON($clients);
        } else {
            return $this->response->setJSON(['message' => 'Nenhum cliente encontrado'], 404);
        }
    }
}
