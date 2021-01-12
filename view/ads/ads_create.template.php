<!doctype html>
<html lang="en">
<head>
    <?php require __DIR__ . '../../parts/header.template.php'?>

<title><?= $title; ?></title>
</head>
<body>
    <?php require __DIR__ . '../../parts/nav.template.php'?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">

            </div>
            <div class="col-lg-6">
                <form action="/ads/create" method="POST">
                    <div class="form-group">
                        <h1>Ads create form</h1>
                    </div>
                    <div class="form-group">
                        <label>Ads title</label>
                        <input type="text" class="form-control" name="title" value="<?= isset($_SESSION['data']['title']) ? $_SESSION['data']['title'] : '' ;?>">
                        <span style="color:red;font-size: 14px;"><?= error('title'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Ads body</label>
                        <textarea  class="form-control" name="body" rows="8" value="<?= isset($_SESSION['data']['body']) ? $_SESSION['data']['body'] : '' ;?>"></textarea>
                        <span style="color:red;font-size: 14px;"><?= error('body'); ?></span>
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