<footer class="bg_footer">
    <div class="container">
        <div class="row">
            <div class="about_footer">
                <div class="footer_title">
                    <p>VỀ CHÚNG TÔI</p>
                </div>
                <p>Nếu bạn đang tìm kiếm một trang web để mua và bán hàng trực tuyến thì chúng tôi là một sự lựa chọn hiệu quả dành cho bạn. Bản chất của Shopee là một social ecommerce platform - nền tảng trang web thương mại điện tử tích hợp mạng xã hội</p>
                <div class="footer_title">
                    <p>MẠNG XÃ HỘI</p>
                </div>
                <ul>
                    <li><i class="fab fa-facebook-f"></i></li>
                    <li><i class="fab fa-twitter"></i></li>
                    <li><i class="fab fa-instagram"></i></li>
                </ul>
            </div>
            <div class="info">
                <div class="footer_title">
                    <p>THANH TOÁN</p>
                </div>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Signin</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="ourwork">
                <div class="footer_title">
                    <p>DANH MỤC HÀNG</p>
                </div>
                <ul>
                    <?php foreach ($NhomHangHoa as $value) : ?>
                        <li><img src="<?= $value['HinhNhom'] ?>"></li>
                    <?php endforeach ?>

                </ul>
            </div>
            <div class="contact">
                <div class="footer_title">
                    <p>LIÊN HỆ</p>
                </div>
                <div class="contact_content">
                    <div class="contact_icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="contact_details">
                        <h4>Số điện thoại</h4>
                        <p>+84 899016864</p>
                    </div>
                    <div class="contact_icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="contact_details">
                        <h4>Địa chỉ Email</h4>
                        <p>tuanb1704786@gmail.m</p>
                    </div>
                    <div class="contact_icon">
                        <i class="fa fa-location-arrow"></i>
                    </div>
                    <div class="contact_details">
                        <h4>Địa chỉ</h4>
                        <p>Cần Thơ</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>