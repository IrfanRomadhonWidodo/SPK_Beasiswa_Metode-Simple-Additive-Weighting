<?php

namespace App\Controllers;

use App\Models\ProfileModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new ProfileModel();
        $this->session = \Config\Services::session(); // Tambahkan ini
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);
        
        return view('profile', [
            'user' => $user,
            'validation' => $this->validator
        ]);
    }

    public function update()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $userId = $this->session->get('user_id');
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $userId . ']',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
            'full_name' => 'permit_empty|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->update($userId, $data)) {
            // Update session data juga
            $this->session->set([
                'username' => $data['username'],
                'email' => $data['email'],
                'full_name' => $data['full_name']
            ]);
            
            return redirect()->to('/profile')->with('success', 'Profile berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate profile.');
        }
    }

    public function changePassword()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $userId = $this->session->get('user_id');
        
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data user dari database
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Verifikasi password saat ini
        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini salah.');
        }

        // Hash password baru
        $newPasswordHash = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        
        // Update password di database
        $updateData = ['password' => $newPasswordHash];
        
        if ($this->userModel->update($userId, $updateData)) {
            return redirect()->to('/profile')->with('success', 'Password berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password. Silakan coba lagi.');
        }
    }
}