<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class ProfileController extends BaseController
{
    protected $users;
    protected $session;
    public function __construct()
    {
        $this->users = new UserModel();
        $this->session = service('session');
    }

    public function index()
    {
        $breadcrumb = [
            'title' => 'Profile',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'Profile', 'url_to' => '#', 'active' => true],
            ],
        ];
        return view('admin/profile/profile', compact('breadcrumb'));
    }

    public function update()
    {
        $data = $this->request->getPost();
        $rules = [
            'fullname' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|is_unique[users.username,id,' . user()->id . ']',
            'email' => 'required|valid_email|is_unique[users.email,id,' . user()->id . ']',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User();
        $user->id = user()->id;
        $user->fullname = $data['fullname'];
        $user->username = $data['username'];
        $user->email = $data['email'];

        if ($this->users->skipValidation(true)->save($user)) {
            if ($this->request->isAJAX()) {
                $this->session->setFlashdata('message', 'Profile updated successfully');
                return $this->response->setJSON(['status' => 'success', 'message' => 'Profile updated successfully', 'redirect' => route_to('profile')]);
            }
            return redirect()->back()->with('message', 'Profile updated successfully');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'error' => 'Failed to update profile']);
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update profile');
    }


    public function changePassword()
    {
        $breadcrumb = [
            'title' => 'Change Password',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'Profile', 'url_to' => 'profile', 'active' => false],
                ['title' => 'Change Password', 'url_to' => '#', 'active' => true],
            ],
        ];

        return view('admin/profile/change-password', compact('breadcrumb'));
    }

    public function updatePassword()
    {
        $data = $this->request->getPost();
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        if (!password_verify(base64_encode(hash('sha384', $data['current_password'], true)), user()->password_hash)) {

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => 'Current password is incorrect']);
            }

            return redirect()->back()->withInput()->with('error', 'Current password is incorrect');
        }

        $user = new User();
        $user->password_hash = Password::hash($data['new_password']);

        if ($this->users->skipValidation(true)->update(user()->id, $user)){
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Password updated successfully']);
            }

            return redirect()->back()->with('message', 'Password updated successfully');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'error' => 'Failed to update password']);
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update password');
    }
}