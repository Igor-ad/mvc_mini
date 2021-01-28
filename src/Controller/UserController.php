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

        $data = $_POST;
        $errors = $this->validate($data);

        if ($errors) {
            throw new ValidationException($errors);
        }
        $this->userModel->save($data);

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

        $errors = $this->validate($dataPost);
        if ($errors) {
            $data['act'] = 'Please, check all items of form again';
            $data['error'] = $errors;
            $logs = new Router();
            $logs->writeLog($errors, __CLASS__);
            return view('user.user_edit', $data);
        }

        $this->userModel->update($dataPost);

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
        if (!empty($data['email'])) {
            $search = ($this->userModel->findBy(['email' => $data['email']]))
                ? $this->userModel->findBy(['email' => $data['email']]) : [];
            if (!empty($data['id']) && (!empty($search)) && ($data['id'] != $search['id'])) {
                $v->rule('different', 'email', $search['email']);
            }
            if (empty($data['id']) && !empty($search)) {
                $v->rule('different', 'email', $search['email']);
            }
        }
        if(!$v->validate()) {
            return $v->errors();
        } else {
            return [];
        }
    }
}