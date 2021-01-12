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
                <form action="/user/edit" method="POST">
                    <div class="form-group">
                        <h1>Edit user: <?= $user['name'];?></h1>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="id" value="<?= ($user['id']) ? : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="<?= ($user['name']) ? : '' ;?>">
                        <span style="color:red;font-size: 14px;"><?= isset($error['name']) ? $error['name'] : '' ;?></span>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="text" class="form-control" name="email" value="<?= ($user['email']) ? : '' ;?>">
                        <span style="color:red;font-size: 14px;"><?= isset($error['email']) ? $error['email'] : '' ;?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" value="">
                        <span style="color:red;font-size: 14px;"><?= isset($error['password']) ? $error['password'] : '' ;?></span>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select  class="form-control" name="status">
                            <option><?= isset($user['status']) ? $user['status'] : '' ;?></option>
                            <option><?= isset($user['status']) ? (int)!($user['status']) : '' ;?></option>
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
