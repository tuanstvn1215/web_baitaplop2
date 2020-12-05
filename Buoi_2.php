<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Đăng kí</title>
</head>

<body>
    <link rel="stylesheet" href="<?= host ?>/public/signup.css">
    <div class="container">
        <form id="register-form" action="./Buoi_2register.php" method="post">
            <div class="register-title">Đăng Kí</div>
            <div>
                <div class="register-form-item">
                    <label for="">Tên đăng nhập:<span>(*)</span></label>
                    <input id="username" name="username" type="text">
                </div>
                <?php if (isset($err['username'])) : ?>
                    <div class='err'>
                        <?= join($err['username']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <div class=" register-form-item">
                    <label for="">Password:<span>(*)</span></label>
                    <input id='password' name='password' type="password">
                </div>
                <?php if (isset($err['password'])) : ?>
                    <div class='err'>
                        <?= join($err['password']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <div class="register-form-item">
                    <label for="">Nhập lại mật khẩu:<span>(*)</span></label>
                    <input id='rppassword' name='rppassword' type="password">
                </div>
                <?php if (isset($err['rppassword'])) : ?>
                    <div class='err'>
                        <?= join($err['rppassword']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>

                <div class="register-form-item">
                    <label for="">Họ của bạn:<span>(*)</span></label>
                    <input id="lastname" name='lastname' type="text">
                </div>
                <?php if (isset($err['lastname'])) : ?>
                    <div class='err'>
                        <?= join($err['lastname']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <div class="register-form-item">
                    <label for="">Tên của bạn:<span>(*)</span></label>
                    <input id='firstname' name='firstname' type="text">
                </div>

                <?php if (isset($err['firstname'])) : ?>
                    <div class='err'>
                        <?= join($err['firstname']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <div class="register-form-item">
                    <label for="">Email:<span>(*)</span></label>
                    <input id='email' name='email' type="text">
                </div>
                <?php if (isset($err['email'])) : ?>
                    <div class='err'>
                        <?= join($err['email']) ?>
                    </div>
                <?php endif ?>
            </div>

            <div>
                <div class="register-form-item">
                    <label for="">Số điện thoại:<span>(*)</span></label>
                    <input id='number' name='number' type="text">
                </div>
                <?php if (isset($err['number'])) : ?>
                    <div class='err'>
                        <?= join($err['number']) ?>
                    </div>
                <?php endif ?>
            </div>
            <button type="submit" class="register-form-submit ">Đăng kí</button>
        </form>
    </div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,100&display=swap');

        body {
            background-color: gainsboro;
            font-family: 'Roboto', sans-serif;
        }

        input:focus {
            border: none;
            outline: none;
        }

        .container {
            align-content: center;
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        .register-title {
            font-weight: bold;
            font-size: xx-large;
            text-align: center;
            padding-bottom: 10px;
        }

        #register-form {
            border-radius: 20px;
            background-color: white;
            padding: 40px;
            width: 400px;
            border: solid 1px gainsboro;
            height: 450px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .register-form-item {
            display: flex;
            width: 330px;
            flex-direction: row;
            justify-content: space-between;
        }

        .register-form-item input {
            border: 1px solid black;
        }



        .register-form-submit {
            color: black;
            width: 330px;
            height: 50px;
            border: none;
            font-weight: 600;
            font-size: larger;
            background: linear-gradient(to bottom, #ffff00 0%, #ff0000 100%);


        }

        .register-form-submit:hover {
            cursor: pointer;
            background: linear-gradient(to bottom, #ffff66 0%, #ff3300 100%);
        }

        .err {
            color: red;
        }
    </style>
</body>

</html>