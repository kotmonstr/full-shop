<?php

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE DATABASE shop";

if ($conn->query($sql) === TRUE) {
    echo "DATABASE shop created successfully";
    if ($conn->connect_error) {
        echo("Connection failed: " . $conn->connect_error). '<br />';
    }
} else {
    echo  $conn->error .'<br />';
}
$dbname = "shop";


// add tables;
$conn->close();
$conn = new mysqli($servername, $username, $password, $dbname);



$sql = "CREATE TABLE IF NOT EXISTS `goods` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`item` varchar(255) NOT NULL,
`price` int(11) NOT NULL,
`category_id` int(11) NOT NULL,
`quantity` int(11) NOT NULL,
`rating` int(11) NOT NULL,
`descr` text NOT NULL,
`status` tinyint(4) NOT NULL COMMENT '1-продается, 0- не продается',
`image` varchar(100) NOT NULL,
`brend_id` int(11) DEFAULT NULL,
`best` tinyint(4) DEFAULT NULL COMMENT '0- обычный, 1-рекомендован',
`created_by` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `category_id` (`category_id`),
KEY `brend_id` (`brend_id`),
KEY `brend_id_2` (`brend_id`),
KEY `user_id` (`created_by`),
KEY `user_id_2` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='товары' AUTO_INCREMENT=52 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table goods created" . '<br />';
}else{
    echo "Table goods allredy exist ". '<br />';
}


$sql = "CREATE TABLE IF NOT EXISTS `wishlist` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip` varchar(255) NOT NULL,
`goods_id` int(11) NOT NULL,
`price` int(11) NOT NULL,
`category_id` int(11) NOT NULL,
`brend_id` int(11) DEFAULT NULL,
`created_at` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `goods_id` (`goods_id`),
KEY `category_id` (`category_id`,`brend_id`),
KEY `brend_id` (`brend_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table wishlist created" . '<br />';
}else{
    echo "Table wishlist allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `compare` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip` varchar(255) NOT NULL,
`goods_id` int(11) NOT NULL,
`price` int(11) NOT NULL,
`category_id` int(11) NOT NULL,
`brend_id` int(11) DEFAULT NULL,
`created_at` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `goods_id` (`goods_id`),
KEY `category_id` (`category_id`,`brend_id`),
KEY `brend_id` (`brend_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23";
$conn->query($sql);
if ($conn->error) {
    echo "Table compare created" . '<br />';
}else{
    echo "Table compare allredy exist" . '<br />';
}
$sql = "CREATE TABLE IF NOT EXISTS `cart` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip` varchar(255) NOT NULL,
`goods_id` int(11) NOT NULL,
`quantity` int(11) NOT NULL,
`price` int(11) NOT NULL,
`category_id` int(11) NOT NULL,
`brend_id` int(11) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `goods_id` (`goods_id`),
KEY `category_id` (`category_id`,`brend_id`),
KEY `brend_id` (`brend_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table cart created" . '<br />';
}else{
    echo "Table cart allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `goods_category` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`descr` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='категории товаров' AUTO_INCREMENT=9 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table goods_category created" . '<br />';
}else{
    echo "Table goods_category allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `brend` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table brendy created" . '<br />';
}else{
    echo "Table brend allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `banner` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`created_at` int(11) DEFAULT NULL,
`updated_at` int(11) DEFAULT NULL,
`status` tinyint(4) NOT NULL COMMENT '0-активно, 1- не активно',
`link` varchar(255) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=144 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table banner created" . '<br />';
}else{
    echo "Table banner allredy exist" . '<br />';
}
$sql = "CREATE TABLE IF NOT EXISTS `video` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`youtube_id` varchar(255) NOT NULL,
`title` varchar(255) NOT NULL,
`descr` text,
`created_at` int(11) DEFAULT NULL,
`categoria` int(11) DEFAULT NULL,
`author_id` int(11) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `categoria` (`categoria`),
KEY `author_id` (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='видео ролики' AUTO_INCREMENT=43 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table video created" . '<br />';
}else{
    echo "Table video allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
`password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`role` smallint(6) NOT NULL DEFAULT '10',
`status` smallint(6) NOT NULL DEFAULT '10',
`created_at` int(11) NOT NULL,
`updated_at` int(11) NOT NULL,
`password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table user created" . '<br />';
}else{
    echo "Table user allredy exist" . '<br />';
}
$sql = "CREATE TABLE IF NOT EXISTS `image` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-активно, 1- не активно',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table image created" . '<br />';
}else{
    echo "Table image allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `author` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`descr` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table author created" . '<br />';
}else{
    echo "Table author allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `video_categoria` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='Категории видео' AUTO_INCREMENT=10 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table video_categoria created" . '<br />';
}else{
    echo "Table video_categoria allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `blog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`image` varchar(255) NOT NULL,
`content` longtext NOT NULL,
`created_at` int(11) NOT NULL,
`updated_at` int(11) NOT NULL,
`author` int(11) DEFAULT NULL,
`view` int(11) DEFAULT NULL,
`updater_id` int(11) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `author` (`author`),
KEY `author_2` (`author`),
KEY `updater_id` (`updater_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='статьи' AUTO_INCREMENT=3 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table blog created" . '<br />';
}else{
    echo "Table blog allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `review` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`good_id` int(11) NOT NULL,
`name` varchar(100) NOT NULL,
`email` varchar(100) NOT NULL,
`content` text NOT NULL,
`created_at` int(11) NOT NULL,
`updated_at` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `good_id` (`good_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table review created" . '<br />';
}else{
    echo "Table review allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `goods_photos` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`good_id` int(11) NOT NULL,
`name` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
KEY `good_id` (`good_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='фотографии товара' AUTO_INCREMENT=10 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table goods_photos created" . '<br />';
}else{
    echo "Table goods_photos allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `photo` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`created_at` int(11) DEFAULT NULL,
`updated_at` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table photo created" . '<br />';
}else{
    echo "Table photo allredy exist" . '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip` varchar(255) NOT NULL,
`status` tinyint(4) NOT NULL COMMENT '1-ждет оплаты, 2 доствляется, 3 - выполнен',
`created_at` int(11) NOT NULL,
`country_id` int(11) NOT NULL,
`city_id` int(11) NOT NULL,
`post_index` int(11) NOT NULL,
`first_name` varchar(100) NOT NULL,
`second_name` varchar(100) NOT NULL,
`ser_name` varchar(100) NOT NULL,
`payment_type` tinyint(4) NOT NULL,
`telephone` varchar(255) NOT NULL,
`street` varchar(255) DEFAULT NULL,
`comment` text,
`recall` tinyint(4) NOT NULL DEFAULT '0',
`login` varchar(50) DEFAULT NULL,
`password` varchar(50) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `country_id` (`country_id`),
KEY `city_id` (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table order created" . '<br />';
}else{
    echo "Table order allredy exist" . '<br />';
}


$sql = "CREATE TABLE IF NOT EXISTS `setup` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`param_name` varchar(50) DEFAULT NULL,
`param_value` varchar(255) DEFAULT NULL,
`user_id` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;";
$conn->query($sql);
if ($conn->error) {
    echo "Table setup created". '<br />';
}else{
    echo "Table setup allredy exist". '<br />';
}


$conn->close();
die();
?>



