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

    <link rel="stylesheet" href='<?= host ?>/public/css/detail.css'>
</head>

<body>

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

        </div>
</body>

</html>