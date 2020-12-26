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
            $querry_string = 'INSERT INTO hanghoa VALUES (?,?,?,?,?,?,?)';
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

        // header('Location: ' . host . '/admin/tatcahanghoa.php');
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
var_dump($NhomHangHoa);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        .form {
            display: flex;
            flex-direction: column;

        }

        .form-item-group {
            display: flex;
            flex-direction: column;
        }

        .form-item-group * {
            width: 300px;
        }
    </style>
    <form enctype="multipart/form-data" method="POST" action="<?= host ?>/admin/themhanghoa.php">
        <div class='form'>
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
                <button class="form-btn" type="submit"> esfes</button>
            </div>
        </div>
    </form>
</body>

</html>