<?php require_once '../config.php';
$querry_string = "SELECT * FROM hanghoa ";
$statment = $conn->prepare($querry_string);
$statment->execute();
$hanghoa = $statment->get_result()->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $querry_string = "UPDATE dathang SET TrangThai='Đã xử lý' where SoDonDH=?";
    $statment = $conn->prepare($querry_string);
    $statment->bind_param('s', $_POST['SoDonDH']);
    $statment->execute();
    header('Location: ' . host . '/admin/tatcadonhang.php');
}
for ($i = 0; $i < count($hanghoa); $i++) {
    $hanghoa[$i]['Hinh'] = json_decode($hanghoa[$i]['Hinh']);
    $hanghoa[$i]['MoTaHH'] = json_decode($hanghoa[$i]['MoTaHH']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <a class="btn btn-success mt-5 ml-5" href="<?= host ?>/admin/themhanghoa.php">Thêm hàng hóa mới</a>
                <table class="table-item mt-5">
                    <tr>
                        <th class="table-item-title">
                            Mã Hàng Hóa
                        </th>

                        <th class="table-item-title">
                            Tên Hàng Hóa
                        </th>
                        <th class="table-item-title">
                            Mô tả
                        </th>
                        <th class="table-item-title">
                            Số Lượng
                        </th>
                        <th class="table-item-title">
                            Giá
                        </th>
                        <th class="table-item-title">

                        </th>

                    </tr>
                    <?php foreach ($hanghoa as $item) : ?>
                        <tr>
                            <td class="table-item-details">
                                <?= $item['MSHH'] ?>
                            </td>
                            <td class="table-item-details">
                                <?= $item['TenHH'] ?>
                            </td>
                            <td class="table-item-details">
                                <ul>
                                    <?php foreach ($item['MoTaHH'] as $value) : ?>
                                        <li><?= $value ?></li>
                                    <?php endforeach ?>
                                </ul>

                            </td>
                            <td class="table-item-details">
                                <?= $item['SoLuongHang'] ?>
                            </td>
                            <td class="table-item-details">
                                <?= $item['Gia'] ?>
                            </td>
                            <td class="table-item-btn" class="table-item-details">
                                <a class="btn btn-primary btn-sm" href="<?= host ?>/shop/chitiet.php?id=<?= $item['MSHH'] ?>">Xem chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </table>
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