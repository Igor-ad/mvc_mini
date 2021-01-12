<!doctype html>
<html lang="en">
<head>
    <?php require __DIR__ . '../../parts/header.template.php'?>

    <title><?= $title;?></title>
</head>
<body>
    <?php require __DIR__ . '../../parts/nav.template.php'?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 style="margin: 20px 0;">Users</h1>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody><?php foreach ($users as $user) { ?>

                        <tr>
                            <th scope="row"><?= $user['id'];?></th>
                            <td><?= $user['name']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?php if ($user['status'] == 1) { echo 'Active'; } else { echo 'Inactive'; } ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($user['created_at'])); ?></td>
                            <td>
                                <a href="/user/edit?id=<?= $user['id']; ?>" class="btn btn-primary">Edit</a>
                                <a href="/user/delete?id=<?= $user['id']; ?>" class="btn btn-primary">Delete</a>
                            </td>
                        </tr>
                    <?php } ?></tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>