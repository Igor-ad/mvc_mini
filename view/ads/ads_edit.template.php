<!doctype html>
<html lang="en">
<head>
    <?php require __DIR__ . '../../parts/header.template.php' ?>

    <title><?= $title;?></title>
</head>
<body>
<?php require __DIR__ . '../../parts/nav.template.php' ?>

<div class="container">
    <div class="row">
        <div class="col-lg-3">

        </div>
        <div class="col-lg-6">
            <form action="/ads/edit" method="POST">
                <div class="form-group">
                    <h1>Ads edit: <?= $ads['title'];?></h1>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="id" value="<?= ($ads['id']) ? : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="<?= ($ads['title']) ? : '' ;?>">
                    <span style="color:red;font-size: 14px;"><?= isset($error['title']) ? implode(' ', $error['title']) : '' ;?></span>
                </div>
                <div class="form-group">
                    <label>Ads body</label>
                    <input type="text" class="form-control" name="body" value="<?= ($ads['body']) ? : '' ;?>">
                    <span style="color:red;font-size: 14px;"><?= isset($error['body']) ? implode(' ', $error['body']) : '' ;?></span>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option><?= isset($ads['status']) ? $ads['status'] : 1 ;?></option>
                        <option><?= isset($ads['status']) ? (int)!($ads['status']) : 0 ;?></option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-md-6 offset-md-6">
            <h5><?= empty($data['act']) ? '' : $data['act']; ?></h5>
        </div>
    </div>
</div>
</body>
</html>
