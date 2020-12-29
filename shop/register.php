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
try {
    $querry_string = 'INSERT INTO khachhang VALUES (?,?,?,?,?,?)';
    $statment = $conn->prepare($querry_string);
    $_POST['MatKhau'] = password_hash($_POST['MatKhau'], PASSWORD_BCRYPT);
    $statment->bind_param('ssssss', $_POST['MSKH'], $_POST['HoTenKH'], $_POST['Email'], $_POST['DiaChi'], $_POST['SoDienThoai'], $_POST['MatKhau']);
    $statment->execute();
    header('Location: ' . host . '/shop/index.php');
} catch (Throwable $th) {
    $th->getMessage();
}
label_endpost:; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= host ?>/public/css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= host ?>/public/css/header__footer.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossOrigin="anonymous" />
    <link rel="stylesheet" href="<?= host ?>/public/css/register.css">
    <title>Đăng kí</title>
</head>

<body>
    <div class="header-background">
        <div class="container header">
            <div class="row header__header-top">
                <div class=" header-top__left">
                    <a href="#">Tuấn B1704786</a>
                </div>
                <div class="header-top__right">
                    <?php if (isset($_SESSION['MSKH']) || isset($_SESSION['MSNV'])) : ?>
                        <?php if (isset($_SESSION['MSKH'])) : ?>
                            <?= "Xin Chào, " . $_SESSION['MSKH'] ?>
                        <?php else : ?>
                            <?= "Xin Chào, " . $_SESSION['MSNV'] ?>
                        <?php endif ?>
                    <?php else : ?>
                        <a class="header-top__right__item" href="<?= host . '/shop/register.php' ?>">Đăng Kí</a>
                        <a class="header-top__right__item" href="<?= host . '/shop/login.php' ?>">Đăng Nhập</a>
                    <?php endif ?>

                </div>
            </div>
            <div class="header__header-bottom">
                <div class="header-bottom__left">
                    <a href="<?= host ?>/shop" class="header-bottom__index-icon">
                        <img src="<?= host ?>/public/img/icon/index.png" alt="">
                    </a>
                    <div class="header-bottom__menu">
                        <a href="<?= host ?>/shop/index.php" class="header-bottom__menu-item">Trang Chủ</a>
                        <a href="<?= host ?>/shop/thongtin.php" class="header-bottom__menu-item">Thông Tin</a>
                        <a href="<?= host ?>/shop/giohang.php" class="header-bottom__menu-item">Giỏ Hàng</a>
                        <a href="<?= host ?>/admin/tatcadonhang.php" class="header-bottom__menu-item">Admin</a>

                    </div>

                </div>
                <div class="header-bottom__right">

                </div>

            </div>
        </div>
    </div>
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
                <div class="form-group">
                    <label for="re-password" class="form-label">nhập lại mật khẩu</label>
                    <input type="password" id="re-password" class="form-input" placeholder="************" value="<?= isset($values['re-MatKhau']) ? $values['re-MatKhau'] : '' ?>" name='re-MatKhau'>
                    <?php if (isset($err['re-MatKhau'])) : ?>
                        <div class='err'>
                            <?= join(', ', $err['re-MatKhau']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" id="name" class="form-input" placeholder="Trần Anh Tuấn" value="<?= isset($values['HoTenKH']) ? $values['HoTenKH'] : '' ?>" name="HoTenKH">
                    <?php if (isset($err['HoTenKH'])) : ?>
                        <div class='err'>
                            <?= join(', ', $err['HoTenKH']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-input" placeholder="Ex: johndoe@email.com" value="<?= isset($values['Email']) ? $values['Email'] : '' ?>" name="Email">
                    <?php if (isset($err['Email'])) : ?>
                        <div class='err'>
                            <?= join(', ', $err['Email']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="sdt" class="form-label">Số Điện thoại</label>
                    <input type="number" id="number" class="form-input" placeholder="0356788555" value="<?= isset($values['SoDienThoai']) ? $values['SoDienThoai'] : ''  ?>" name="SoDienThoai">
                    <?php if (isset($err['SoDienThoai'])) : ?>
                        <div class='err'>
                            <?= join(', ', $err['SoDienThoai']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="DiaChi" class="form-label">Địa Chỉ</label>
                    <input type="text" id="DiaChi" class="form-input" placeholder="1 3/2 tp.cần thơ" value="<?= isset($values['DiaChi']) ? $values['DiaChi'] : ''  ?>" name="DiaChi">
                    <?php if (isset($err['DiaChi'])) : ?>
                        <div class='err'>
                            <?= join(', ', $err['DiaChi']) ?>
                        </div>
                    <?php endif ?>
                </div>
                <button type="submit" class="btn btn--gradient">Sign up</button>
            </form>
        </div>
    </div>
    <footer class="bg_footer">
        <div class="container">
            <div class="row">
                <div class="about_footer">
                    <div class="footer_title">
                        <p>VỀ CHÚNG TÔI</p>
                    </div>
                    <p>Nếu bạn đang tìm kiếm một trang web để mua và bán hàng trực tuyến thì chúng tôi là một sự lựa chọn hiệu quả dành cho bạn. Bản chất của Shopee là một social ecommerce platform - nền tảng trang web thương mại điện tử tích hợp mạng xã hội</p>
                    <div class="footer_title">
                        <p>MẠNG XÃ HỘI</p>
                    </div>
                    <ul>
                        <li><i class="fab fa-facebook-f"></i></li>
                        <li><i class="fab fa-twitter"></i></li>
                        <li><i class="fab fa-instagram"></i></li>
                    </ul>
                </div>
                <div class="info">
                    <div class="footer_title">
                        <p>THANH TOÁN</p>
                    </div>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Signin</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="ourwork">
                    <div class="footer_title">
                        <p>DANH MỤC HÀNG</p>
                    </div>
                    <ul>
                        <?php foreach ($NhomHangHoa as $value) : ?>
                            <li><img src="<?= $value['HinhNhom'] ?>"></li>
                        <?php endforeach ?>

                    </ul>
                </div>
                <div class="contact">
                    <div class="footer_title">
                        <p>LIÊN HỆ</p>
                    </div>
                    <div class="contact_content">
                        <div class="contact_icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="contact_details">
                            <h4>Số điện thoại</h4>
                            <p>+84 899016864</p>
                        </div>
                        <div class="contact_icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="contact_details">
                            <h4>Địa chỉ Email</h4>
                            <p>tuanb1704786@gmail.m</p>
                        </div>
                        <div class="contact_icon">
                            <i class="fa fa-location-arrow"></i>
                        </div>
                        <div class="contact_details">
                            <h4>Địa chỉ</h4>
                            <p>Cần Thơ</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>