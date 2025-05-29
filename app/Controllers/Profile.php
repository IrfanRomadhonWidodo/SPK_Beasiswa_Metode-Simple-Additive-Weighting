<?php

namespace App\Controllers;

use App\Models\ProfileModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new ProfileModel();
    }

    public function index()
    {
        $userId = session()->get('user_id'); // Sesuaikan dengan session Anda
        $user = $this->userModel->find($userId);
        
        return view('profile', [
            'user' => $user,
            'validation' => $this->validator
        ]);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $userId . ']',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
            'full_name' => 'permit_empty|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->update($userId, $data)) {
            return redirect()->to('/profile')->with('success', 'Profile berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate profile.');
        }
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('validation', $this->validator);
        }

        $user = $this->userModel->find($userId);
        
        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini salah.');
        }

        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        
        if ($this->userModel->update($userId, ['password' => $newPassword])) {
            return redirect()->to('/profile')->with('success', 'Password berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password.');
        }
    }
}