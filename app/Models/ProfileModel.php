<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'username',
        'email',
        'full_name',
        'password',
        'profile_picture',
        'phone',
        'address',
        'bio',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|alpha_numeric_punct',
        'email' => 'required|valid_email|max_length[100]',
        'full_name' => 'permit_empty|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'address' => 'permit_empty|max_length[255]',
        'bio' => 'permit_empty|max_length[500]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi.',
            'min_length' => 'Username minimal 3 karakter.',
            'max_length' => 'Username maksimal 50 karakter.',
            'alpha_numeric_punct' => 'Username hanya boleh mengandung huruf, angka, dan tanda baca.'
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
            'max_length' => 'Email maksimal 100 karakter.'
        ],
        'full_name' => [
            'max_length' => 'Nama lengkap maksimal 100 karakter.'
        ],
        'phone' => [
            'max_length' => 'Nomor telepon maksimal 20 karakter.'
        ],
        'address' => [
            'max_length' => 'Alamat maksimal 255 karakter.'
        ],
        'bio' => [
            'max_length' => 'Bio maksimal 500 karakter.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    // protected $beforeUpdate = ['hashPassword'];

    /**
     * Get user profile by ID
     */
    public function getProfile($userId)
    {
        return $this->select('id, username, email, full_name, profile_picture, phone, address, bio, created_at, updated_at')
                    ->find($userId);
    }

    /**
     * Update user profile
     */
    public function updateProfile($userId, $data)
    {
        // Remove password from data if empty (to avoid updating with empty password)
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        }

        return $this->update($userId, $data);
    }

    /**
     * Check if username is unique (excluding current user)
     */
    public function isUsernameUnique($username, $excludeUserId = null)
    {
        $builder = $this->where('username', $username);
        
        if ($excludeUserId) {
            $builder->where('id !=', $excludeUserId);
        }
        
        return $builder->countAllResults() === 0;
    }

    /**
     * Check if email is unique (excluding current user)
     */
    public function isEmailUnique($email, $excludeUserId = null)
    {
        $builder = $this->where('email', $email);
        
        if ($excludeUserId) {
            $builder->where('id !=', $excludeUserId);
        }
        
        return $builder->countAllResults() === 0;
    }

    /**
     * Verify current password
     */
    public function verifyPassword($userId, $password)
    {
        $user = $this->select('password')->find($userId);
        
        if (!$user) {
            return false;
        }
        
        return password_verify($password, $user['password']);
    }

    /**
     * Change user password
     */
    public function changePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        return $this->update($userId, [
            'password' => $hashedPassword,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Upload and update profile picture
     */
    public function updateProfilePicture($userId, $picturePath)
    {
        return $this->update($userId, [
            'profile_picture' => $picturePath,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get user's profile picture path
     */
    public function getProfilePicture($userId)
    {
        $user = $this->select('profile_picture')->find($userId);
        return $user ? $user['profile_picture'] : null;
    }

    /**
     * Delete profile picture
     */
    public function deleteProfilePicture($userId)
    {
        return $this->update($userId, [
            'profile_picture' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get user statistics/summary
     */
    public function getUserStats($userId)
    {
        $user = $this->find($userId);
        
        if (!$user) {
            return null;
        }

        return [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'member_since' => $user['created_at'],
            'last_updated' => $user['updated_at'],
            'has_profile_picture' => !empty($user['profile_picture'])
        ];
    }

    /**
     * Hash password before insert/update
     */
    // protected function hashPassword(array $data)
    // {
    //     if (isset($data['data']['password']) && !empty($data['data']['password'])) {
    //         $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    //     }
        
    //     return $data;
    // }

    /**
     * Custom validation for profile update
     */
    public function validateProfileUpdate($data, $userId)
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|max_length[100]',
            'full_name' => 'permit_empty|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
            'address' => 'permit_empty|max_length[255]',
            'bio' => 'permit_empty|max_length[500]'
        ];

        // Check username uniqueness
        if (isset($data['username']) && !$this->isUsernameUnique($data['username'], $userId)) {
            return [
                'valid' => false,
                'errors' => ['username' => 'Username sudah digunakan.']
            ];
        }

        // Check email uniqueness
        if (isset($data['email']) && !$this->isEmailUnique($data['email'], $userId)) {
            return [
                'valid' => false,
                'errors' => ['email' => 'Email sudah digunakan.']
            ];
        }

        // Validate with CodeIgniter validation
        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if (!$validation->run($data)) {
            return [
                'valid' => false,
                'errors' => $validation->getErrors()
            ];
        }

        return ['valid' => true];
    }

    /**
     * Custom validation for password change
     */
    public function validatePasswordChange($data, $userId)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if (!$validation->run($data)) {
            return [
                'valid' => false,
                'errors' => $validation->getErrors()
            ];
        }

        // Verify current password
        if (!$this->verifyPassword($userId, $data['current_password'])) {
            return [
                'valid' => false,
                'errors' => ['current_password' => 'Password saat ini salah.']
            ];
        }

        return ['valid' => true];
    }
}