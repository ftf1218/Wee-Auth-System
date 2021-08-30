<?php
/*
 * @FilePath: /Wee-Auth-System/manager/header.php
 * @author: Wibus
 * @Date: 2021-08-29 00:26:20
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-30 14:02:07
 * Coding With IU
 */
@header('Content-Type: text/html; charset=UTF-8');
include_once("../config.php");
include_once("./functions.php");
?>
<!DOCTYPE html>
<html lang="zh-CH">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?=$title?> - STY</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <style>
        .form-label{
            margin: .5rem;
        }
    </style>
</head>