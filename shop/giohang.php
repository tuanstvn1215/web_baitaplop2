<?php
require_once '../config.php';

$tong = 0;
if (isset($_SESSION['cart']))
    foreach ($_SESSION['cart'] as $item) {
        $tong +=  $item['Gia'] * $item['Soluong'];
    };

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['cart'])) {
        header('Location: ' . host . '/shop/index.php');
    }
    try {
        $SoDonDH = uniqid("");
        $MSKH = $_SESSION['MSKH'];
        $TrangThai = "chua xu ly";
        $querry_string = 'INSERT into dathang (SoDonDH,MSKH,TrangThai) value(?,?,?)';
        $statment = $conn->prepare($querry_string);
        $statment->bind_param('sss', $SoDonDH, $MSKH, $TrangThai);
        $statment->execute();
        foreach ($_SESSION['cart'] as $item) {
            $querry_string = 'INSERT into chitietdathang (SoDonDH,MSHH,Soluong,GiaDatHang) value(?,?,?,?)';
            $statment = $conn->prepare($querry_string);
            $statment->bind_param('ssii', $SoDonDH, $item['MSHH'], $item['Soluong'], $item['Gia']);
            $statment->execute();
        }
        unset($_SESSION['cart']);
    } catch (Throwable $th) {
        $th->getMessage();
    }
}
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
    <link rel="stylesheet" href="<?= host ?>/public/css/giohang.css">
</head>

<body>
    <?php require_once './block/header.php' ?>
    <h2 class="text-center">Giỏ Hàng</h2>
    <div class="container">
        <table id="cart" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th style="width:50%">Tên sản phẩm</th>
                    <th style="width:10%">Giá</th>
                    <th style="width:8%">Số lượng</th>
                    <th style="width:22%" class="text-center">Thành tiền</th>
                    <th style="width:10%"> </th>
                </tr>
                  
            </thead>
              <tbody>
                <?php if (isset($_SESSION['cart'])) : ?>
                    <?php foreach ($_SESSION['cart'] as $item) : ?>
                        <tr>
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-2 hidden-xs">
                                        <img src="<?= $item['Hinh'] ?>" alt="" class="img-responsive" width="80px">
                                    </div>
                                    <div class="col-sm-10">
                                        <h4 class="nomargin"><?= $item['TenHH'] ?></h4>
                                        <p><?= $item['MotaHH'] ?></p>
                                    </div>

                                </div>
                            </td>
                            <td data-th="Price"><?= $item['Gia'] ?> đ</td>
                            <td data-th="Quantity"><?= $item['Soluong'] ?>
                            </td>
                            <td data-th="Subtotal" class="text-center"><?= $item['Gia'] * $item['Soluong'] ?></td>
                            <!-- <td class="actions" data-th="">
                                <button class="btn btn-info btn-sm"><i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                </button>
                            </td>    -->
                        </tr>  

                    <?php endforeach ?>
                <?php endif ?>

            </tbody>
            <tfoot>
                   <tr>
                        <td><a href="<?= host ?>/shop/index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Tiếp tục mua hàng</a>
                            </td>
                        <td colspan="2" class="hidden-xs"> </td>
                        <td class="hidden-xs text-center"><strong><?php if (isset($tong)) echo $tong ?> đ</strong>
                            </td>
                        <td>
                        <form action="<?= host ?>/shop/giohang.php" method="post">
                            <button class="btn btn-success btn-block" type="submit">Thanh toán <i class="fa fa-angle-right"></i></button>
                        </form>

                            
                    </td>
                       </tr>
                  </tfoot>
             
        </table>
    </div>
    <?php require_once './block/footer.php' ?>
</body>

</html>