<?php
namespace App\Modules\User\Controllers;

use App\Controllers\BaseController;
use App\Modules\User\Models\UserModel; // Supondo que o model de usuário esteja neste caminho
use CodeIgniter\Session\Session;

class UserController extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = session();
        helper('form'); // Para usar o form helper no login
    }

    // Exibe a lista de usuários
    public function index()
    {

        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('App\Modules\User\Views\header')
                .view('App\Modules\User\Views\index', $data)
                .view('App\Modules\User\Views\footer');
    }

    public function create()
    {
        return view('App\Modules\User\Views\create');
    }
    public function addOrEdit()
    {
        $userModel = new UserModel();
    
        // Regras de validação
        $validationRules = [
            'username' => 'required|min_length[3]|max_length[20]',
            'email'    => 'required|valid_email',
            'password' => 'permit_empty|min_length[6]',
        ];
    
        // Validação
        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400); // Código de erro 400 (Bad Request)
        }
    
        $id = $this->request->getPost('id'); // Supondo que você está passando um ID no formulário para editar um usuário existente
    
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];
    
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
    
        if ($id) {
            // Atualizar usuário existente
            if ($userModel->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Usuário atualizado com sucesso!',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Erro ao atualizar o usuário, confira os dados e tente novamente.',
                ])->setStatusCode(400);
            }
        } else {
            // Criar novo usuário
            if ($userModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Usuário criado com sucesso!',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Erro ao criar o usuário, confira os dados e tente novamente.',
                ])->setStatusCode(code: 400);
            }
        }
    }
    
    
    // Lógica de login
    public function login()
    {
        $session = session();
        $userModel = new UserModel();

        // Validação dos dados de login
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('App\Modules\User\Views\login', ['validation' => $validation]);
        }

        // Buscar o usuário pelo email
        $user = $userModel->where('email', $this->request->getPost('email'))->first();

        if ($user) {
            // Verificar se a senha está correta
            if (password_verify($this->request->getPost('password'), $user['password'])) {
                // Criar a sessão do usuário
                $sessionData = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'email'    => $user['email'],
                    'logged_in' => true
                ];
                $session->set($sessionData);

                return redirect()->to('/clients');
            } else {
                return view('App\Modules\User\Views\login', ['error' => 'Senha incorreta.']);
            }
        } else {
            return view('App\Modules\User\Views\login', ['error' => 'Usuário não encontrado.']);
        }
    }

    // Deletar um usuário
    public function delete($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect()->to('/users');
    }

    public function listAll()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        if ($users) {
            return $this->response->setJSON($users);
        } else {
            return $this->response->setJSON(['message' => 'Nenhum usuário encontrado'], 404);
        }
    }

}
