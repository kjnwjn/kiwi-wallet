<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="icon" 
     type="image/png" 
     href="../../public/assest/img/icon.png">
    <link rel="stylesheet" href="<?= getenv('BASE_URL') ?>style2.css">
    <title><?= isset($data['title']) ? $data['title'] : 'Document' ?></title>
</head>

<body onload="preloader()" style="font-size: initial;"> 
    <div class="loader-wrapper">
        <div class="loader-circle">
            <div class="loader-wave"></div>
        </div>
    </div>
    <!-- Header -->

    <?php
        include('./private/view/partial/header.php')
    ?>
    <?php
    isset($data['page']) ?
        include('./private/view/pages/actionPages/' . $data['page'] . '.php') : null
    ?>
    <?php echo(false);?>

    <?php
        include('./private/view/partial/footer.php')
    ?>
</body>

<script type="module" src="<?= getenv('BASE_URL') ?>main.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="<?= getenv('BASE_URL') ?>main.js"></script>

</html>