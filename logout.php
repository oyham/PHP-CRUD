<?php
session_start();

session_unset();

session_destroy();

// header('Location: /taskusers');
header('Location: /index.php');

