<?php
require_once '../config.php';
session_unset($_SESSION['MSKH']);
session_unset($_SESSION['MSNV']);
header('Location: ' . host . '/shop/index.php');
alert('Đăng xuất thành công');
