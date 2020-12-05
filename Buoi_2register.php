<?php


$_POST['username'];
$_POST['password'];
$_POST['rppassword'];
$_POST['lastname'];
$_POST['firstname'];
$_POST['email'];
$_POST['number'];

$err;
foreach ($_POST as $key => $value) {
    $err[$key] = [];
    if (($value) == '') {
        array_push($err[$key], 'không được bỏ trống');
    }
}

if ($err['username'] == []) {
    if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9]/', $_POST['username'], $matches) || preg_match('/\ /', $_POST['username'], $matches)) {
        array_push($err['username'], 'tài khoản phải bắt đầu bắt kí tự và không có khoảng trắng');
    }
}

if ($err['password'] == []) {
    if (!strlen($_POST['password']) > 8 && !strlen($_POST['password']) < 16)
        array_push($err['password'], 'mật khẩu phải dài hơn 8 và ngắn hơn 16 kí tự');
    else {
        if (!(preg_match('/(?=.*[0-9])(?=.*[a-z])(\S+)/', $_POST['password'], $matches))) {
            array_push($err['password'], 'mật khẩu phải bao gồm kí tự thường, kí tự in hoa kí tự đặt biệt và số');
        }
    }
}

if ($err['rppassword'] == []) {
    if ($_POST['rppassword'] != $_POST['password']) {
        array_push($err['rppassword'], 'nhập lại mật khẩu phải trùng với mật khẩu');
    }
}

if ($err['email'] == []) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        array_push($err['email'], 'email không đúng định dạng');
    } else {
    }
}

if ($err['number'] == []) {
    if (!filter_var($_POST['number'], FILTER_VALIDATE_INT)) {
        array_push($err['number'], 'số điện thoại chỉ bao gồm số');
    }
}

require_once './Buoi_2.php';
$i = 0;
foreach ($err as $key) {
    if ($key != []) {
        $i++;
    }
}

if ($i == 0) echo "<script type='text/javascript'>alert('Đăng kí thành công');</script>";
