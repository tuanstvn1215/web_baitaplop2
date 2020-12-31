<?php
require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $files = $_FILES['Hinh'];
        $names      = $files['name'];
        $types      = $files['type'];
        $tmp_names  = $files['tmp_name'];
        $errors     = $files['error'];
        $sizes      = $files['size'];

        $_POST['MSHH'] = uniqid('');
        $ex_arr = array('0' => 'JPG', '1' => 'PNG', '2' => 'JPEG');
        if (count($names) > 4) {
            throw new Error('được phép upload tối đa 4 ảnh');
        }
        for ($i = 0; $i < count($names); $i++) {
            $types[$i] =  pathinfo($names[$i], PATHINFO_EXTENSION);
            if (!in_array(strtoupper($types[$i]), $ex_arr)) {
                throw new Error('Chỉ được upload các định dạng JPG, PNG, JPEG');
            }
            if ($errors[$i] != 0) {
                throw new Error("Dữ liệu upload bị lỗi");
            }

            if ($sizes[$i] > 1048576) {
                throw new Error('Không được upload ảnh lớn hơn 1MB');
            }
            $upload_target[$i] = '../public/img/upload/hanghoa/'  . $_POST['MSHH'] . '_' . $i . '.' . $types[$i];
            echo realpath($upload_target[$i]);
            var_dump(("/public/img/upload"));
            var_dump(realpath('./public/img/icon/index.png'));
            if (!move_uploaded_file($tmp_names[$i], $upload_target[$i])) {
                throw new Error('upload lưu thất bại');
            }
            echo 'đã lưu thành công hình ảnh ' . $upload_target[$i];
            # code...
        }
        $arrMoTaHH = preg_split('/\,/', $_POST['MoTaHH']);
        $_POST['Hinh'] = json_encode($upload_target, JSON_UNESCAPED_UNICODE);
        $_POST['MoTaHH'] = json_encode($arrMoTaHH, JSON_UNESCAPED_UNICODE);
        var_dump(json_decode($_POST['MoTaHH'], true));
        try {
            $querry_string = 'INSERT INTO hanghoa(MSHH,TenHH,Gia,SoLuongHang,MaNhom,Hinh,MoTaHH) VALUES (?,?,?,?,?,?,?)';
            $statment = $conn->prepare($querry_string);
            $statment->bind_param('sssssss', $_POST['MSHH'], $_POST['TenHH'], $_POST['Gia'], $_POST['SoLuongHang'], $_POST['MaNhom'], $_POST['Hinh'], $_POST['MoTaHH']);
            $statment->execute();

            alert('thêm sản phẩm thành công');
            //code...
        } catch (\Throwable $th) {
            foreach ($upload_target as $target) {
                unlink($target);
            }
            throw new Error('lưu thât bại');
            //throw $th;
        }

        header('Location: ' . host . '/admin/tatcahanghoa.php');
    } catch (Exception $ex) {
        alert($ex->getMessage());
        echo $ex->getTraceAsString();
        echo $ex->getMessage();
    }
};
$querry_string = "SELECT * FROM nhomhanghoa";

$statment = $conn->prepare($querry_string);
$statment->execute();
$NhomHangHoa = $statment->get_result()->fetch_all(MYSQLI_ASSOC);
$querry_string = "SELECT * FROM chitietdathang where SoDonDH=? ";
$statment = $conn->prepare($querry_string);
$statment->bind_param('s', $_GET['SoDonDH']);
$statment->execute();
$Dondat = $statment->get_result()->fetch_all(MYSQLI_ASSOC);
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
                <form enctype="multipart/form-data" method="POST" action="<?= host ?>/admin/themhanghoa.php">
                    <div class='form mt-5' style="display:flex;flex-direction: column;justify-content:space-evenly;width:  500px; margin: auto; background-color: white; border: solid 1px gainsboro;padding: 20px;border-radius: 5px;height: 500px;">
                        <h1 style="text-align: center;">Thêm Hàng Hóa</h1>
                        <div class="form-item-group">
                            <label for="">Tên hàng hóa:</label>
                            <input class="form-input" type="text" placeholder="tên hàng hóa" name="TenHH" required>
                        </div>
                        <div class="form-item-group">
                            <label for="">Giá hàng hóa:</label>
                            <input class="form-input" type="text" name="Gia" required>
                        </div>
                        <div class="form-item-group">
                            <label for="">Số lượng hàng</label>
                            <input class="form-input" type="text" name="SoLuongHang" required>
                        </div>
                        <div class="form-item-group">
                            <label for="">Hình ảnh hàng hóa</label>
                            <input class="form-input" name="Hinh[]" type="file" multiple="multiple" required />
                        </div>
                        <div class="form-item-group">
                            <label for="">Nhóm hàng hóa</label>
                            <select class="form-select" name="MaNhom" required>
                                <?php
                                foreach ($NhomHangHoa as $key => $value) {
                                    echo '<option value=' . $value['MaNhom'] . '>' . $value['TenNhom'] . ' </option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-item-group">
                            <label for="">Mô tả hàng hóa</label>
                            <input type="text" name="MoTaHH" required>
                        </div>
                        <div class="form-item-group">
                            <label for=""></label>
                            <button class="form-btn btn btn-success" type="submit"> Thêm hàng hóa</button>
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