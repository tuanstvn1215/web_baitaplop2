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
foreach ($_POST as $key => $value) {
    $err[$key] = [];
    $values[$key] = $value;
    if (($value) == '') {
        $i++;
        array_push($err[$key], 'không được bỏ trống');
    }
}

if ($err['MSKH'] === []) {
    if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9]/', $_POST['MSKH'], $matches) || preg_match('/\ /', $_POST['MSKH'], $matches)) {
        $i++;
        array_push($err['MSKH'], 'tài khoản phải bắt đầu bắt kí tự và không có khoảng trắng');
    }
}

if ($err['MatKhau'] === []) {
    if (!strlen($_POST['MatKhau']) > 8 && !strlen($_POST['MatKhau']) < 16)
        array_push($err['MatKhau'], 'mật khẩu phải dài hơn 8 và ngắn hơn 16 kí tự');
    else {
        if (!(preg_match('/(?=.*[0-9])(?=.*[a-z])(\S+)/', $_POST['MatKhau'], $matches))) {
            $i++;
            array_push($err['MatKhau'], 'mật khẩu phải bao gồm kí tự thường, kí tự in hoa kí tự đặt biệt và số');
        }
    }
}

if ($err['re-MatKhau'] === []) {
    if ($_POST['re-MatKhau'] != $_POST['MatKhau']) {
        $i++;
        array_push($err['re-MatKhau'], 'nhập lại mật khẩu phải trùng với mật khẩu');
    }
}

if ($err['Email'] === []) {
    if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
        $i++;
        array_push($err['Email'], 'email không đúng định dạng');
    }
}

// if ($err['SoDienThoai'] === []) {
//     if (!filter_var($_POST['SoDienThoai'], FILTER_VALIDATE_INT)) {
//         $i++;
//         array_push($err['SoDienThoai'], 'số điện thoại chỉ bao gồm số');
//     }
// }


$querry_string = 'SELECT MSKH FROM khachhang WHERE MSKH= ?';
$statment = $conn->prepare($querry_string);
$statment->bind_param('s', $_POST['MSKH']);
$statment->execute();
if ($statment->get_result()->fetch_assoc()) {
    array_push($err['MSKH'], 'tài khoản đã tồn tại vui lòng chọn tài khoản khác');
    $i++;
}
unset($statment);
$querry_string = 'SELECT MSKH FROM khachhang WHERE Email= ?';
$statment = $conn->prepare($querry_string);
$statment->bind_param('s', $_POST['Email']);
$statment->execute();
if ($statment->get_result()->fetch_assoc()) {
    array_push($err['Email'], 'email đã có người sử dụng vui lòng chọn email khác');
    $i++;
}
unset($statment);

if ($i != 0) {

    goto label_endpost;
}
echo "<script type='text/javascript'>alert('Đăng kí thành công');</script>";
$_SESSION['MSKH'] = $_POST['MSKH'];
header('Location: ' . host . '/shop/index.php');
$querry_string = 'INSERT INTO khachhang VALUES (?,?,?,?,?,?)';
$statment = $conn->prepare($querry_string);
$statment->bind_param('ssssss', $_POST['MSKH'], $_POST['HoTenKH'], $_POST['Email'], $_POST['DiaChi'], $_POST['SoDienThoai'], $_POST['MatKhau']);
$statment->execute();
label_endpost:; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <link rel="stylesheet" href="<?= host ?>/public/css/register.css">

    <head>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossOrigin="anonymous" />
    </head>

    <div class="signup">
        <img src="<?= $host ?>/public/images/picture/promotion/1.png" alt="" class="signup-image">
        <div class="signup-container">
            <div class="tab">
                <div class="tab-item is-active">Đăng Kí</div>
                <a href="<?= host ?>/shop/login.php" class="tab-item">Đăng Nhập</a>
            </div>
            <h1 class='signup-heading'>Đăng Kí</h1>
            <form class="signup-form" action="<?= host ?>/shop/register.php" method="POST">

                <div class="form-group">
                    <label for="name" class="form-label">Tài Khoản</label>
                    <input type="text" id="MSKH" class="form-input" placeholder="B1704786" value="<?= isset($values['MSKH']) ? $values['MSKH'] : '' ?>" name="MSKH">
                    <?php if (isset($err['MSKH'])) : ?>
                        <div class='err'>
                            <?= join($err['MSKH']) ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" id="password" class="form-input" placeholder="************" value="<?= isset($values['MatKhau']) ? $values['MatKhau'] : '' ?>" name="MatKhau">
                    <?php if (isset($err['MatKhau'])) : ?>
                        <div class='err'>
                            <?= join($err['MatKhau']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="re-password" class="form-label">nhập lại mật khẩu</label>
                    <input type="password" id="re-password" class="form-input" placeholder="************" value="<?= isset($values['re-MatKhau']) ? $values['re-MatKhau'] : '' ?>" name='re-MatKhau'>
                    <?php if (isset($err['re-MatKhau'])) : ?>
                        <div class='err'>
                            <?= join($err['re-MatKhau']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" id="name" class="form-input" placeholder="Trần Anh Tuấn" value="<?= isset($values['HoTenKH']) ? $values['HoTenKH'] : '' ?>" name="HoTenKH">
                    <?php if (isset($err['HoTenKH'])) : ?>
                        <div class='err'>
                            <?= join($err['HoTenKH']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-input" placeholder="Ex: johndoe@email.com" value="<?= isset($values['Email']) ? $values['Email'] : '' ?>" name="Email">
                    <?php if (isset($err['Email'])) : ?>
                        <div class='err'>
                            <?= join($err['Email']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="sdt" class="form-label">Số Điện thoại</label>
                    <input type="number" id="number" class="form-input" placeholder="0356788555" value="<?= isset($values['SoDienThoai']) ? $values['SoDienThoai'] : ''  ?>" name="SoDienThoai">
                    <?php if (isset($err['SoDienThoai'])) : ?>
                        <div class='err'>
                            <?= join($err['SoDienThoai']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="DiaChi" class="form-label">Địa Chỉ</label>
                    <input type="text" id="DiaChi" class="form-input" placeholder="1 3/2 tp.cần thơ" value="<?= isset($values['DiaChi']) ? $values['DiaChi'] : ''  ?>" name="DiaChi">
                    <?php if (isset($err['DiaChi'])) : ?>
                        <div class='err'>
                            <?= join($err['DiaChi']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <button type="submit" class="btn btn--gradient">Sign up</button>
            </form>
        </div>
    </div>
</body>

</html>