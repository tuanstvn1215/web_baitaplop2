<?php
require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    array_push($_SESSION['cart'], $_POST);
    header('Location: ' . host . '/shop/giohang.php');
}

$querry_string = "SELECT * FROM nhomhanghoa";
$statment = $conn->prepare($querry_string);
$statment->execute();
$NhomHangHoa = $statment->get_result()->fetch_all(MYSQLI_ASSOC);

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
    <?php require_once './block/header.php' ?>
    <form action="<?= host ?>/shop/chitiet.php" method="post">
        <div class="container mt-5">
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
                <div class="details-right pl-3">
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
                                <ul class="content-describes-item mt-3  ">
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
                            <input name="MSHH" value="<?= $HangHoa['MSHH'] ?>" style="display: none;">
                            <input name="Hinh" value="<?= $HangHoa['Hinh'][0] ?>" style="display: none;">
                            <input name="TenHH" value="<?= $HangHoa['TenHH'] ?>" style="display: none;">
                            <input name="MotaHH" value="<?= $HangHoa['MoTaHH'][0] ?>" style="display: none;">
                            <input name="Gia" value="<?= $HangHoa['Gia'] ?>" style="display: none;">
                            <input class="number" type="number" name="Soluong" id="Produce-number" value="1" min="0">
                            <div class="span">
                                <div onclick="Produce_number_plus()" id="Produce-number-+">+</div>
                            </div>
                        </div>
                        <button class="btn btn-success ml-5">Thêm vào giỏ hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php require_once './block/footer.php' ?>
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