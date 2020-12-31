<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $querry_string = "SELECT * FROM nhanvien where MSNV=? ";
        $statment = $conn->prepare($querry_string);
        $statment->bind_param('s', $_POST['MSNV']);
        $statment->execute();
        $Nhavien = $statment->get_result()->fetch_assoc();
        if (!count($Nhavien)) {
            try {
                $querry_string = 'INSERT INTO nhanvien VALUES (?,?,?,?,?,?)';
                $statment = $conn->prepare($querry_string);
                $_POST['MatKhau'] = password_hash($_POST['MatKhau'], PASSWORD_BCRYPT);
                $_POST['ChucVu'] = 'NhanVien';
                $statment->bind_param('ssssss', $_POST['MSNV'], $_POST['HoTenNV'], $_POST['ChucVu'], $_POST['DiaChi'], $_POST['SoDienThoai'], $_POST['MatKhau']);
                $statment->execute();
                alert('thêm nhân viên thành công');
                //code...
            } catch (\Throwable $th) {
                throw new Error('lưu thât bại');
                //throw $th;
            }
        } else {
            throw new Error('Nhân viên đã tồn tại');
        }

        header('Location: ' . host . '/admin/tatcahanghoa.php');
    } catch (Exception $ex) {
        alert($ex->getMessage());
    }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hàng hóa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= host ?>/public/css/admin/tatcahanghoa.css">
</head>

<body>
    <div class="warpper">
        <?php require_once './block/menu.php' ?>
        <div class="content">
            <?php require_once './block/navbar.php' ?>
            <div class="main_content">
                <form enctype="multipart/form-data" method="POST" action="<?= host ?>/admin/themnhanvien.php">
                    <div class='form mt-5' style="display:flex;flex-direction: column;justify-content:space-evenly;width:  500px; margin: auto; background-color: white; border: solid 1px gainsboro;padding: 20px;border-radius: 5px;height: 500px;">
                        <h1 style="text-align: center;">Thêm Nhân Viên</h1>
                        <div class="form-item-group">
                            <label for="">Tài Khoản:</label>
                            <input class="form-input" type="text" placeholder="tài khoản nhân viên" name="MSNV" required>
                        </div>
                        <div class="form-item-group">
                            <label for="">Tên Nhân Viên:</label>
                            <input class="form-input" type="text" placeholder="tên nhân viên" name="HoTenNV" required>
                        </div>
                        <div class="form-item-group">
                            <label for="">Địa Chỉ:</label>
                            <input class="form-input" type="text" name="DiaChi" required>
                        </div>
                        <div class="form-item-group">
                            <label for="">Số Điện Thoại</label>
                            <input class="form-input" type="text" name="SoDienThoai" required>
                        </div>
                        <div class="form-item-group">
                            <label for="">Mật Khẩu</label>
                            <input type="password" name="MatKhau" required>
                        </div>
                        <div class="form-item-group">
                            <label for=""></label>
                            <button class="form-btn btn btn-success" type="submit"> Thêm Nhân Viên</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <script>
        function right_menu() {
            var right_menu = document.getElementById('right-menu')
            var menu_content = document.getElementById('menu-content')
            if (right_menu.classList.contains('right-menu')) {
                right_menu.classList.replace('right-menu', 'right-menu-hidden')
                menu_content.classList.add('menu_content-hidden')

            } else {
                right_menu.classList.replace('right-menu-hidden', 'right-menu')
                menu_content.classList.remove('menu_content-hidden')
            }
        }

        function notification() {
            var notification = document.getElementById('notification')
            if (notification.classList.contains('notification')) {
                notification.classList.replace('notification', 'notification-hidden')


            } else {
                notification.classList.replace('notification-hidden', 'notification')
            }
        }
    </script>

</body>

</html>