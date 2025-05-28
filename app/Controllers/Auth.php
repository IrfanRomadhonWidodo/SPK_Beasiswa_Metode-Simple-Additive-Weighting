<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function register()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register');
    }

    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak terdaftar');
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        if (!$user['is_active']) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif');
        }

        // Set session
        $sessionData = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'logged_in' => true
        ];
        $this->session->set($sessionData);

        // Set remember me cookie
        if ($remember) {
            $cookieData = [
                'name' => 'remember_me',
                'value' => base64_encode($user['email']),
                'expire' => 86400 * 30, // 30 days
                'secure' => false,
                'httponly' => true
            ];
            $this->response->setCookie($cookieData);
        }

        return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
    }

    public function attemptRegister()
    {
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'is_active' => 1
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        
        
        return redirect()->to('/auth/login')->with('success', 'Logout berhasil!');
    }

    public function dashboard()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        $data = [
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'username' => $this->session->get('username'),
                'email' => $this->session->get('email')
            ]
        ];
        
        return view('auth/dashboard', $data);
    }
}