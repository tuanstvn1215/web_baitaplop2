<?php
require_once '../config.php';
$querry_string = "SELECT * FROM nhomhanghoa";
$statment = $conn->prepare($querry_string);
$statment->execute();
$NhomHangHoa = $statment->get_result()->fetch_all(MYSQLI_ASSOC);
if (isset($_SESSION['MSKH']) || isset($_SESSION['MSNV'])) {
    header('Location: ' . host . '/shop/index.php');
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    goto label_endpost;
};

$i = 0;
$values = [];
$err = [];
foreach ($_POST as $key => $value) {
    $err[$key] = [];
    $values[$key] = $value;
    if (($value) == '') {
        $i++;
        array_push($err[$key], 'không được bỏ trống');
    }
}

if ($err['MSKH'] === [] && $err['MatKhau'] === []) {

    $querry_string = 'SELECT * FROM khachhang WHERE MSKH= ?';
    $statment = $conn->prepare($querry_string);
    $statment->bind_param('s', $_POST['MSKH']);
    $statment->execute();
    $result = $statment->get_result()->fetch_assoc();
    if ($result['MSKH']) {
        if (!password_verify($_POST['MatKhau'], $result['MatKhau'])) {
            $i++;
            array_push($err['MatKhau'], 'Sai mật khẩu');
        } else {
            $_SESSION['MSKH'] = $_POST['MSKH'];
        }
    } else {
        $querry_string = 'SELECT * FROM nhanvien WHERE MSNV= ?';
        $statment = $conn->prepare($querry_string);
        $statment->bind_param('s', $_POST['MSKH']);
        $statment->execute();
        $result = $statment->get_result()->fetch_assoc();
        if ($result['MSNV']) {
            if (!password_verify($_POST['MatKhau'], $result['MatKhau'])) {
                $i++;
                array_push($err['MatKhau'], 'Sai mật khẩu');
            } else {
                $_SESSION['MSNV'] = $_POST['MSKH'];
            }
        } else {
            $i++;
            array_push($err['MSKH'], 'tài khoản không tồn tại');
        }
    }
}

if ($i != 0) {

    goto label_endpost;
}
lable_login:
alert('Đăng kí thành công');
header('Location: ' . host . '/shop/index.php');

label_endpost: ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="<?= host ?>/public/css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="B1704786/public/css/reset.css">
    <link rel="stylesheet" href="<?= host ?>/public/css/login.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossOrigin="anonymous" />

    <link rel="stylesheet" href="<?= host ?>/public/css/header__footer.css">
</head>

<body>
    <?php require_once './block/header.php' ?>
    <div class="signup">

        <img src="<?= host ?>/public/images/picture/promotion/1.png" alt="" class="signup-image">

        <div class="signup-container">
            <div class="tab">
                <a href="<?= host ?>/shop/register.php" class="tab-item ">Đăng Kí</a>
                <div class="tab-item is-active">Đăng Nhập</div>
            </div>
            <h1 class='signup-heading'>Đăng Nhập</h1>
            <form class="signup-form" action="<?= host ?>/shop/login.php" method="POST">
                <div class="form-group">
                    <label for="name" class="form-label">Tài Khoản</label>
                    <input type="text" id="MSKH" class="form-input" placeholder="B1704786" value="<?= isset($values['MSKH']) ? $values['MSKH'] : '' ?>" name="MSKH">
                    <?php if (isset($err['MSKH'])) : ?>
                        <div class='err'>
                            <?= join(', ', $err['MSKH']) ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" id="password" class="form-input" placeholder="************" value="<?= isset($values['MatKhau']) ? $values['MatKhau'] : '' ?>" name="MatKhau">
                    <?php if (isset($err['MatKhau'])) : ?>
                        <div class='err'>
                            <?= join(', ', $err['MatKhau']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <button type="submit" class="btn btn--gradient">Đăng Nhập</button>
            </form>
        </div>
    </div>
    <?php require_once './block/footer.php' ?>
</body>

</html>