<?php

function redirect($page) {
    header("Location: $page");
}

function POST_REQUEST() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function GET_REQUEST() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}