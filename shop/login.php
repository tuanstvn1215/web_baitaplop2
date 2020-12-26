<?php
require_once '../config.php';
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
echo "<script type='text/javascript'>alert('Đăng kí thành công');</script>";
header('Location: ' . host . '/shop/index.php');

label_endpost: ?>


<head>
    <link rel="stylesheet" href="<?= host ?>/public/css/login.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossOrigin="anonymous" />
</head>

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