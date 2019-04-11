<?php
session_start();

unset($_SESSION['user']);

header("Location: _db_index.php");