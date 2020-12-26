<?php
require_once '../config.php';
if (!isset($_GET['page']))
    $_GET['page'] = 0;
$querry_string = "SELECT * FROM hanghoa " . (isset($_GET['categoryid']) ? 'MaNhom = ? ' : '');
$statment = $conn->prepare($querry_string);
$index = $_GET['page'] * 9;

if (isset($_GET['categoryid'])) {
    $statment->bind_param('si', $GET['categoryid'], $index);
}
$statment->execute();
$produces = $statment->get_result()->fetch_all(MYSQLI_ASSOC);

for ($i = 0; $i < count($produces); $i++) {
    $produces[$i]['Hinh'] = json_decode($produces[$i]['Hinh']);
    $produces[$i]['MoTaHH'] = json_decode($produces[$i]['MoTaHH']);
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="B1704786/public/css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Document</title>
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
                    <a class="header-top__right__item" href="<?= host . '/shop/register.php' ?>">Đăng Kí</a>
                    <a class="header-top__right__item" href="<?= host . '/shop/login.php' ?>">Đăng Nhập</a>
                </div>
            </div>
            <div class="header__header-bottom">
                <div class="header-bottom__left">
                    <a href="<?= host ?>/shop" class="header-bottom__index-icon">
                        <img src="<?= host ?>/public/img/icon/index.png" alt="">
                    </a>

                </div>
                <div class="header-bottom__right">
                    <div>êfefe</div>
                    <div>êfefe</div>
                    <div>êfefe</div>
                    <div>êfefe</div>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row main">
            <div class="col-xl-2 main__categorys">
                <div class="categorys__header">
                    <div class="categorys__header__title">Danh Mục</div>
                </div>
                <div class="categorys__list">
                    <div class="categorys__list__item">ề</div>
                    <div class="categorys__list__item">ề</div>
                    <div class="categorys__list__item">ề</div>
                    <div class="categorys__list__item">ề</div>
                    <div class="categorys__list__item">ề</div>
                </div>
            </div>
            <div class="col-xl-10 row main__produces">
                <div class="col-12 produces__header">

                    <div class="produces__header__title">
                        <h1>Sản Phẩm</h1>
                    </div>
                </div>

                <?php foreach ($produces as $produce) : ?>
                    <div class="col-xl-3 produces__produce">
                        <div class="produce__inner">
                            <a href="<?= host ?>/shop/chitiet.php?id=<?= $produce['MSHH'] ?>">
                                <div class="produce__image"><img src="<?= host ?>/public/img/produce_img/03.jpg" alt=""></div>
                                <div class="produce__name"><?= $produce['TenHH'] ?></div>
                                <div class="produce__detail"><?= $produce['MoTaHH'][1] ?></div>
                                <div class="produce__price"><?= $produce['Gia'] ?></div>
                            </a>
                        </div>
                    </div>

                <?php endforeach ?>
            </div>

        </div>

    </div>
    <footer>

    </footer>
</body>

</html>