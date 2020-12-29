<?php
require_once '../config.php';

$querry_string =  "SELECT * FROM hanghoa ORDER BY NgayThem  DESC limit 8";
$statment = $conn->prepare($querry_string);
$statment->execute();

$hanghoamoi = $statment->get_result()->fetch_all(MYSQLI_ASSOC);
for ($i = 0; $i < count($hanghoamoi); $i++) {
    $hanghoamoi[$i]['Hinh'] = json_decode($hanghoamoi[$i]['Hinh']);
    $hanghoamoi[$i]['MoTaHH'] = json_decode($hanghoamoi[$i]['MoTaHH']);
}
$querry_string = "SELECT * FROM hanghoa ";
$statment = $conn->prepare($querry_string);
$statment->execute();

$hanghoa = $statment->get_result()->fetch_all(MYSQLI_ASSOC);

for ($i = 0; $i < count($hanghoa); $i++) {
    $hanghoa[$i]['Hinh'] = json_decode($hanghoa[$i]['Hinh']);
    $hanghoa[$i]['MoTaHH'] = json_decode($hanghoa[$i]['MoTaHH']);
}
$pages = round(count($hanghoa) / 16, 0, PHP_ROUND_HALF_DOWN);
if (isset($_GET['manhom'])) {
    $hanghoa = array_filter($hanghoa, function ($value, $key) {
        return $value['MaNhom'] === $_GET['manhom'];
    }, ARRAY_FILTER_USE_BOTH);
}
if (!isset($_GET['page']))
    $_GET['page'] = 0;

$hanghoa = array_filter($hanghoa, function ($value, $key) {
    return $key >= ($_GET['page'] * 16) && $key <= ($_GET['page'] * 16 + 16);
}, ARRAY_FILTER_USE_BOTH);
$querry_string = "SELECT * FROM nhomhanghoa";
$statment = $conn->prepare($querry_string);
$statment->execute();
$NhomHangHoa = $statment->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= host ?>/public/css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="<?= host ?>/public/css/header__footer.css">
    <link rel="stylesheet" href="<?= host ?>/public/css/index.css">
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
        <div class="row main">
            <div class="col-xl-2 main__categorys" style="background-color: white; box-shadow: gainsboro;">
                <div class="categorys__header">
                    <div class="categorys__header__title">
                        <h2>Danh Mục</h2>

                    </div>
                </div>
                <div class="categorys__list">
                    <?php foreach ($NhomHangHoa as $item) : ?>
                        <a href="<?= host ?>/shop/index.php?manhom=<?= $item['MaNhom'] ?>" class="categorys__list__item"><?= $item['TenNhom'] ?></a>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-xl-10 row main__produces">
                <div class="col-12 produces__header">

                    <div class="produces__header__title">
                        <h1>Sản Phẩm</h1>

                    </div>
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="<?= host ?>/shop/index.php<?php if (isset($_GET['manhom'])) echo '?manhom=' . $_GET['manhom']; ?>page=0">Đầu</a></li>
                        <li class="page-item"><input id="pageNumber" onkeyup="pagechanged()" type="text" value="0"></li>
                        <li class="page-item"><a id="pageLink" class="page-link" href="<?= host ?>/shop/index.php<?php if (isset($_GET['manhom'])) echo '?manhom=' . $_GET['manhom']; ?>?page=0">Đến</a></li>
                        <li class="page-item"><a class="page-link" href="<?= host ?>/shop/index.php<?php if (isset($_GET['manhom'])) echo '?manhom=' . $_GET['manhom']; ?>?page=<?= $pages ?>">Cuối</a></li>
                    </ul>
                </div>

                <?php foreach ($hanghoa as $value) : ?>
                    <div class="col-xl-3 produces__produce">
                        <div class="produce__inner">
                            <a href="<?= host ?>/shop/chitiet.php?id=<?= $value['MSHH'] ?>">
                                <div class="produce__image"><img src="<?= host . $value['Hinh'][0] ?>" alt=""></div>
                                <div class="produce__name"><?= $value['TenHH'] ?></div>
                                <div class="produce__detail"><?= $value['MoTaHH'][0] ?></div>
                                <div class="produce__price"><?= $value['Gia'] ?></div>
                            </a>
                        </div>
                    </div>

                <?php endforeach ?>
            </div>

        </div>

    </div>
    <div class="produce-new block 2 container">
        <h1>Sản phẩm mới</h1>
        <div class=" row">
            <?php foreach ($hanghoamoi as $value) : ?>
                <div class="col-xl-3">
                    <div class=" produce-new__inner">
                        <a href="<?= host ?>/shop/chitiet.php?id=<?= $value['MSHH'] ?>">
                            <div class="produce-new__image"><img src="<?= host . $value['Hinh'][0] ?>" alt=""></div>
                            <div class="produce__name"><?= $value['TenHH'] ?></div>
                            <div class="produce__detail"><?= $value['MoTaHH'][0] ?></div>
                            <div class="produce__price"><?= $value['Gia'] ?></div>
                        </a>
                    </div>
                </div>

            <?php endforeach ?>
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
        function pagechanged() {
            var pageNumber = document.getElementById('pageNumber')
            var pageLink = document.getElementById('pageLink')
            pageLink.setAttribute('href', '<?= host ?>/shop/index.php<?php if (isset($_GET['manhom'])) echo '?manhom=' . $_GET['manhom']; ?>?page=' + pageNumber.value)
        }
    </script>
</body>

</html>