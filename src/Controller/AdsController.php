<?php

namespace App\Controller;


use App\Exception\ValidationException;
use App\Model\Ads;

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

        $data = $_POST;
        $errors = $this->validate($data);

        if ($errors) {
            throw new ValidationException($errors);
        }
        $this->adsModel->save($data);

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

    public function validate($data):array
    {
        $errors = [];
        if (empty($data['title'])) {
            $errors['title'] = 'Cannot be empty';
        } elseif (strlen($data['title']) > $this->adsModel::LENGTH_TITLE_MAX) {
            $errors['title'] = 'Length of title can`t be more than ' . $this->adsModel::LENGTH_TITLE_MAX . ' chars.';
        }

        if (empty($data['body'])) {
            $errors['body'] = 'Cannot be empty';
        } elseif (strlen($data['body']) > $this->adsModel::LENGTH_BODY_MAX) {
            $errors['body'] = 'Length of body can`t be more than ' . $this->adsModel::LENGTH_BODY_MAX . ' chars.';
        }
        return !empty($errors) ? $errors : [];
    }
}