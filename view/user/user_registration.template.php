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
                <form action="/user/registration" method="POST">
                    <div class="form-group">
                        <h1>User registration form</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="<?= isset($_SESSION['data']['name']) ? $_SESSION['data']['name'] : '';?>">
                        <span style="color:red;font-size: 14px;"><?= isset($_SESSION['errors']['name']) ? implode(' ', $_SESSION['errors']['name']) : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="text" class="form-control" name="email" value="<?= isset($_SESSION['data']['email']) ?  $_SESSION['data']['email'] : ''; ?>">
                        <span style="color:red;font-size: 14px;"><?= isset($_SESSION['errors']['email']) ? implode(' ', $_SESSION['errors']['email']) : '';?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" value="<?= isset($_SESSION['data']['password']) ? $_SESSION['data']['password'] : ''; ?>">
                        <span style="color:red;font-size: 14px;"><?= isset($_SESSION['errors']['password']) ? implode(' ', $_SESSION['errors']['password']) : ''; ?></span>
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