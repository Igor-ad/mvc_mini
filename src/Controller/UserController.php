<?php

namespace App\Controller;

use App\Model\User;
use App\Exception\ValidationException;

class UserController
{
    public const TABLE = 'users';

    public function index()
    {
        $users = User::findAll(self::TABLE);

        $data = [
            'title' => 'Users',
            'users' => $users
        ];
        return view('user.user_list', $data);
    }

    /**
     * @return string
     * @throws ValidationException
     * @throws \Exception
     */
    public function registration(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'title' => 'User registration',
            ];
            return view('user.user_registration', $data);
        }

        $data = $_POST;
        $errors = $this->validate($data);

        if ($errors) {
            throw new ValidationException($errors);
        }

        $user = new User(
            $data['name'],
            $data['email'],
            $data['password']
        );

        $checkUserExist = User::findByEmail($user->getEmail());
        if ($checkUserExist) {
            throw new ValidationException([
                'email' => 'Email already exist'
            ]);
        }

        User::save($user);

        header('Location: /user');
        exit;
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            User::remove(self::TABLE, $id);
        }
        header('Location: /user');
        exit;
    }

    /**
     * @return string
     * @throws ValidationException
     * @throws \Exception
     */
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = (int) $_GET['id'];
            $data = $this->getUserParams($id);

            return view('user.user_edit', $data);
        }

        $dataPost = $_POST;
        $data = $this->getUserParams($dataPost['id']);

        $errors = $this->validate($dataPost);
        if ($errors) {
            $data['act'] = 'Please, check all items of form again';
            $data['error'] = $errors;
            return view('user.user_edit', $data);
        }
        User::update($dataPost);

        header('Location: /user');
        exit;
    }

    public function getUserParams($id): array
    {
        $user = User::findById(self::TABLE, $id);
        if (!$user) {
            header('Location: /user');
            exit;
        }
        return $data = [
            'title' => 'Edit user`s data',
            'user' => $user
        ];
    }

    public function validate($data): array
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Cannot be empty';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Cannot be empty';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid format';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Cannot be empty';
        }
        return !empty($errors) ? $errors : [];
    }
}