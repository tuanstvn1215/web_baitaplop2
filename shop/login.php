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
echo "<script type='text/javascript'>alert('Đăng kí thành công');</script>";
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