<?php
require_once '../config.php';
if (!isset($_GET['id']))
    $_GET['page'] = 0;
$querry_string = "SELECT * FROM hanghoa where mshh = ?";

$statment = $conn->prepare($querry_string);
$statment->bind_param('s', $_GET['id']);
$statment->execute();
$HangHoa = $statment->get_result()->fetch_assoc();
$HangHoa['Hinh'] = json_decode($HangHoa['Hinh']);
$HangHoa['MoTaHH'] = json_decode($HangHoa['MoTaHH']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= host ?>/public/css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="<?= host ?>/public/css/header__footer.css">
    <link rel="stylesheet" href='<?= host ?>/public/css/detail.css'>
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
    <div class="container">
        <div class="details">
            <div class="details-left">
                <div class="small-img">
                    <?php for ($i = 0; $i < count($HangHoa['Hinh']); $i++) : ?>
                        <div class="small-img-item"> <img onmouseover="change_img(event)" class="small-img-item-inner" src="<?= host . $HangHoa['Hinh'][$i] ?>" alt="">
                        </div>
                    <?php endfor ?>
                </div>
            </div>
            <div class="details-center">
                <div class="img"><img id='main_img' src="<?= host . $HangHoa['Hinh'][0] ?>" alt=""></div>
            </div>
            <div class="details-right">
                <div>
                    <div class="content-header">
                        <div class="produce-title">
                            <?= $HangHoa['TenHH'] ?>
                        </div>
                        <div class="produce-price">
                            <?= $HangHoa['Gia'] ?>
                        </div>
                    </div>
                    <div class="content-main">

                        <div class="content-describes">
                            <ul class="content-describes-item">
                                <?php for ($i = 0; $i < count($HangHoa['MoTaHH']); $i++) : ?>
                                    <li><?= $HangHoa['MoTaHH'][$i] ?></li>
                                <?php endfor ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="content-buttons">
                    <div class="Produce-number">
                        <div class="span">
                            <div onclick="Produce_number_minus()" id="Produce-number--">-</div>
                        </div>
                        <input class="number" type="number" name="Produce-number" id="Produce-number" min="0">
                        <div class="span">
                            <div onclick="Produce_number_plus()" id="Produce-number-+">+</div>
                        </div>
                    </div>
                </div>
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
        <script>
            function Produce_number_minus() {
                let Produce_number = document.getElementById('Produce-number')
                if (!(Produce_number.value = parseInt(Produce_number.value) - 1))
                    Produce_number.value = 1
            }

            function Produce_number_plus() {

                let Produce_number = document.getElementById('Produce-number')
                if (!(Produce_number.value = parseInt(Produce_number.value) + 1))
                    Produce_number.value = 1

            }

            var images = document.getElementsByClassName('small-img-item-inner')

            function change_img(e) {
                e.target.getAttribute('src')
                var main_img = document.getElementById('main_img')
                main_img.setAttribute('src', e.target.getAttribute('src'))
            }
        </script>
</body>

</html>