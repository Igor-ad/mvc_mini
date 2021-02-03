<?php

namespace App\Controller;

use App\Model\User;
use App\Exception\ValidationException;
use App\Utils\Router;
use Valitron\Validator;

class UserController
{
    public const TABLE = 'users';
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User(self::TABLE);
    }

    public function index(): string
    {
        $users = $this->userModel->findAll();

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

        $dataPost = $_POST;
        $errors = (empty($this->validate($dataPost)))
            ? $this->userModel->save($dataPost) : $this->validate($dataPost);

        if ($errors) {
            throw new ValidationException($errors);
        }

        header('Location: /user');
        exit;
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $this->userModel->remove($id);
        }
        header('Location: /user');
        exit;
    }

    public function edit(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = (int) $_GET['id'];
            $data = $this->getUserParams($id);

            return view('user.user_edit', $data);
        }

        $dataPost = $_POST;
        $data = $this->getUserParams($dataPost['id']);

        $errors = (empty($this->validate($dataPost)))
            ? $this->userModel->update($dataPost) : $this->validate($dataPost);

        if ($errors) {
            $data['act'] = 'Please, check all items of form again';
            $data['error'] = $errors;
            return view('user.user_edit', $data);
        }

        header('Location: /user');
        exit;
    }

    public function getUserParams($id): array
    {
        $user = $this->userModel->findById($id);
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
        $v = new Validator($data);
        $v->rule('required', ['name', 'email', 'password']);
        $v->rule('email', 'email');
        if(!$v->validate()) {
            return $v->errors();
        } else {
            return [];
        }
    }
}