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
            <div class="col-lg-12">

                <h1 style="margin: 20px 0;">Ads</h1>
                <table class="table table-striped" >
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Body</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody><?php foreach ($ads as $item) { ?>

                        <tr>
                            <th scope="row"><?= $item['id'];?></th>
                            <td><?= $item['title']; ?></td>
                            <td><?= substr($item['body'], 0, 70) . ' ... '; ?></td>
                            <td><?php if ($item['status'] == 1) { echo 'Active'; } else { echo 'Inactive'; } ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($item['created_at'])); ?></td>
                            <td>
                                <a href="/ads/edit?id=<?= $item['id']; ?>" class="btn btn-primary">Edit</a>
                                <a href="/ads/delete?id=<?= $item['id']; ?>" class="btn btn-primary">Delete</a>
                            </td>
                        </tr>
                    <?php } ?></tbody>
                </table>

            </div>
        </div>
    </div>
</body>
</html>