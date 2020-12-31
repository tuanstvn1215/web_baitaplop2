<div class="navbar">
    <div class="navbar-left">
        <div class="navbar-left-item">
            <a href="<?= host ?>/shop/index.php">
                <div>Trang Chủ</div>
            </a>
        </div>

    </div>
    <div class="navbar-right">
        <div class="navbar-right-item">
            <div class="notification-icon" onclick="notification()">
                <i class="far fa-bell"></i>
                <span class="notification-icon-circle"></span>
            </div>
            <div id='notification' class="notification-hidden">
                <div class="notification-title">Thông báo</div>
                <div class="notification-item">Tin nhắn mới</div>
                <div class="notification-item"></div>
                <div class="notification-item"></div>
            </div>
        </div>
        <div class="navbar-right-item"><a class="sign-out" href="<?= host ?>/shop/dangxuat.php"><i class="fas fa-sign-out-alt"></i></a>
        </div>
        <div class="navbar-right-item"></div>
    </div>
</div>