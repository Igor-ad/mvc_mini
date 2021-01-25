<?php

namespace App\Controller;


use App\Exception\ValidationException;
use App\Model\Ads;
use App\Utils\Router;
use Valitron\Validator;

class AdsController
{
    public const TABLE = 'ads';
    private Ads $adsModel;

    public function __construct()
    {
        $this->adsModel = new Ads(self::TABLE);
    }

    public function index(): string
    {
        $ads = $this->adsModel->findAll();

        $data = [
            'title' => 'Ads list',
            'ads' => $ads
        ];
        return view('ads.ads_list', $data);
    }

    /**
     * @return string
     * @throws ValidationException
     * @throws \App\Exception\InvalidStringLength
     */
    public function create(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'title' => 'Ads create',
            ];
            return view('ads.ads_create', $data);
        }

        $dataPost = $_POST;
        $errors = $this->validate($dataPost);

        if ($errors) {
            throw new ValidationException($errors);
        }
        $this->adsModel->save($dataPost);

        header('Location: /ads');
        exit;
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $this->adsModel->remove($id);
        }
        header('Location: /ads');
        exit;
    }

    public function edit(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = (int) $_GET['id'];
            $data = $this->getAdsParams($id);

            return view('ads.ads_edit', $data);
        }

        $dataPost = $_POST;
        $data = $this->getAdsParams($dataPost['id']);

        $errors = $this->validate($dataPost);
        if ($errors) {
            $data['act'] = 'Please, check all items of form again';
            $data['error'] = $errors;
            $logs = new Router();
            $logs->writeLog($errors, __CLASS__);
            return view('ads.ads_edit', $data);
        }
        $this->adsModel->update($dataPost);

        header('Location: /ads');
        exit;
    }

    public function getAdsParams($id): array
    {
        $ads = $this->adsModel->findById($id);
        if (!$ads) {
            header('Location: /ads');
            exit;
        }
        return $data = [
            'title' => 'Edit ads data',
            'ads' => $ads
        ];
    }

    public function validate($data): array
    {
        $v = new Validator($data);
        $v->rule('required', ['title', 'body']);
        $v->rule('lengthMax', 'title', $this->adsModel::LENGTH_TITLE_MAX);
        if(!$v->validate()) {
            return $v->errors();
        } else {
            return [];
        }
    }
}