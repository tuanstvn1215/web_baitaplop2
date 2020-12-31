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

                    <?php if (isset($_SESSION['MSKH']) || isset($_SESSION['MSNV'])) : ?>
                        <a href="giohang.php" class="header-bottom__menu-item">Giỏ Hàng</a>
                        <a href="<?= host ?>/shop/lichsudonhang.php" class="header-bottom__menu-item"> Lịch sử đơn hàng</a>
                        <a href="<?= host ?>/shop/thongtin.php" class="header-bottom__menu-item">Thông Tin</a>
                    <?php endif ?>
                    <?php if (isset($_SESSION['MSNV'])) : ?>
                        <a href="<?= host ?>/admin/tatcadonhang.php" class="header-bottom__menu-item">Admin</a>
                    <?php endif ?>
                </div>

            </div>
            <div class="header-bottom__right">
                <?php if (isset($_SESSION['MSKH']) || isset($_SESSION['MSNV'])) : ?>
                    <div> <a href="<?= host ?>/shop/dangxuat.php" class="btn btn-danger"> Đăng xuất</a></div>
                <?php endif ?>

            </div>

        </div>
    </div>
</div>