<?php
require_once '../config.php';
if (!(isset($_SESSION['MSKH']) || isset($_SESSION['MSNV'])))
    header('Location: ' . host . '/shop/index.php');
if (isset($_SESSION['MSKH'])) {
    $querry_string = "SELECT * FROM Khachhang where mskh=?";
    $statment = $conn->prepare($querry_string);
    $statment->bind_param('s', $_SESSION['MSKH']);
}
if (isset($_SESSION['MSNV'])) {
    $querry_string = "SELECT * FROM nhanvien where msnv=?";
    $statment = $conn->prepare($querry_string);
    $statment->bind_param('s', $_SESSION['MSNV']);
}
$statment->execute();
$Nguoidung = $statment->get_result()->fetch_assoc();
$querry_string = "SELECT * FROM nhomhanghoa";
$statment = $conn->prepare($querry_string);
$statment->execute();
$NhomHangHoa = $statment->get_result()->fetch_all(MYSQLI_ASSOC);
$querry_string = "SELECT * FROM dathang join chitietdathang join hanghoa where mskh=? ORDER BY NgayDH  DESC";
$statment = $conn->prepare($querry_string);
$statment->bind_param('s', $_SESSION['MSKH']);
$statment->execute();
$Dondat = $statment->get_result()->fetch_all(MYSQLI_ASSOC);  ?>

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
    <link rel="stylesheet" href="<?= host ?>/public/css/header__footer.css">
    <link rel="stylesheet" href="<?= host ?>/public/css/lichsudonhang.css">
    <title>Giỏ Hàng</title>
</head>

<body> <?php require_once './block/header.php'; ?>

    <div class="container">
        <h1 class="text-center">Lịch sử đơn hàng</h1>
        <div class="container">
            <div class="row profile">
                <div class="col-md-3">
                    <?php if (isset($_SESSION['MSKH'])) : ?>
                        <div class="profile-sidebar">

                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name"> <?= $Nguoidung['MSKH'] ?> </div>
                                <div class="profile-usertitle-job"><?= $Nguoidung['HoTenKH'] ?> </div>
                                <div class="profile-usertitle-job"><?= $Nguoidung['DiaChi'] ?> </div>
                                <div class="profile-usertitle-job"><?= $Nguoidung['SoDienThoai'] ?> </div>
                            </div>
                            <div class="profile-userbuttons">
                                <a href="<?= host ?>/shop" type="button" class="btn btn-success btn-sm">Trang chủ</a>
                                <a href="<?= host ?>/shop.dangxuat.php" type="button" class="btn btn-danger btn-sm">Thoát ra</a>
                            </div>
                            <div class="profile-usermenu">
                                <ul class="nav">

                                    <li> <a href="<?= host ?>/shop/thongtin.php"> <i class="glyphicon glyphicon-info-sign"></i> Cập nhật thông tin cá nhân </a>
                                    </li>

                                    <li class="active"> <a href="<?= host ?>/shop/lichsudonhang.php"> <i class=" glyphicon glyphicon-shopping-cart"></i> Quản lý đơn hàng </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="profile-sidebar">

                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name"> <?= $Nguoidung['MSNV'] ?> </div>
                                <div class="profile-usertitle-job"><?= $Nguoidung['HoTenNV'] ?> </div>
                                <div class="profile-usertitle-job"><?= $Nguoidung['DiaChi'] ?> </div>
                                <div class="profile-usertitle-job"><?= $Nguoidung['SoDienThoai'] ?> </div>
                            </div>
                            <div class="profile-userbuttons">
                                <a href="<?= host ?>/shop" type="button" class="btn btn-success btn-sm">Trang chủ</a>
                                <a href="<?= host ?>/shop/dangxuat.php" type="button" class="btn btn-danger btn-sm">Thoát ra</a>
                            </div>
                            <div class="profile-usermenu">
                                <ul class="nav">

                                    <li> <a href="<?= host ?>/shop/thongtin.php"> <i class="glyphicon glyphicon-info-sign"></i> Cập nhật thông tin cá nhân </a>
                                    </li>

                                    <li class="active"> <a href="<?= host ?>/shop/lichsudonhang.php"> <i class=" glyphicon glyphicon-shopping-cart"></i> Quản lý đơn hàng </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <table class="table-item">
                            <tr>
                                <th class="table-item-title">
                                    Mã Số Đơn đặt hàng
                                </th>

                                <th class="table-item-title">
                                    Tên hàng hóa
                                </th>
                                <th class="table-item-title">
                                    Ngày đặt
                                </th>

                                <th class="table-item-title">
                                    Giá
                                </th>
                                <th class="table-item-title">
                                    Trạng Thái
                                </th>
                            </tr>
                            <?php foreach ($Dondat as $item) : ?>
                                <tr>
                                    <th class="table-item-title">
                                        <?= $item['SoDonDH'] ?>
                                    </th>

                                    <th class="table-item-title">
                                        <?= $item['TenHH'] ?>
                                    </th>
                                    <th class="table-item-title">
                                        <?= $item['NgayDH'] ?>
                                    </th>

                                    <th class="table-item-title">
                                        <?= $item['GiaDatHang'] * $item['SoLuong'] ?>
                                    </th>
                                    <th class="table-item-title">
                                        <?= $item['TrangThai'] ?>
                                    </th>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once './block/footer.php' ?>
</body>

</html>