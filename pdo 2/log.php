<?php
function isAdmin() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}