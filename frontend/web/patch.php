<?php


$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);
$conn->query("SET NAMES 'utf8'");
$conn->query("SET CHARACTER SET 'utf8'");
$conn->query("SET SESSION collation_connection = 'utf8_general_ci'");


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
`status` tinyint(4) NOT NULL COMMENT '1-���������, 0- �� ���������',
`image` varchar(100) NOT NULL,
`brend_id` int(11) DEFAULT NULL,
`best` tinyint(4) DEFAULT NULL COMMENT '0- �������, 1-������������',
`created_by` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `category_id` (`category_id`),
KEY `brend_id` (`brend_id`),
KEY `brend_id_2` (`brend_id`),
KEY `user_id` (`created_by`),
KEY `user_id_2` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='������' AUTO_INCREMENT=52 ;";
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='��������� �������' AUTO_INCREMENT=9 ;";
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
`status` tinyint(4) NOT NULL COMMENT '0-�������, 1- �� �������',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='����� ������' AUTO_INCREMENT=43 ;";
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
`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-�������, 1- �� �������',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='��������� �����' AUTO_INCREMENT=10 ;";
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='������' AUTO_INCREMENT=3 ;";
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='���������� ������' AUTO_INCREMENT=10 ;";
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

$sql = "CREATE TABLE IF NOT EXISTS `geo_country` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name_ru` varchar(100) DEFAULT NULL,
`name_en` varchar(100) DEFAULT NULL,
`code` varchar(2) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `code` (`code`),
KEY `name_en` (`name_en`),
KEY `name_ru` (`name_ru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=248";


$conn->query($sql);
if ($conn->error) {
    echo "Table geo_country created". '<br />';
}else{
    echo "Table geo_country allredy exist". '<br />';
}

$sql = "INSERT INTO `geo_country` (`id`, `name_ru`, `name_en`, `code`) VALUES
(1, '���������', 'Australia', 'AU'),
(2, '��������', 'Malaysia', 'MY'),
(3, '���������� �����', 'Korea', 'KR'),
(4, '�����', 'China', 'CN'),
(5, '������', 'Japan', 'JP'),
(6, '�����', 'India', 'IN'),
(7, '�������', 'Taiwan', 'TW'),
(8, '�������', 'Hong Kong', 'HK'),
(9, '�������', 'Thailand', 'TH'),
(11, '�������', 'Vietnam', 'VN'),
(12, '�������', 'France', 'FR'),
(13, '������', 'Italy', 'IT'),
(14, '������������ �������� �������', 'United Arab Emirates', 'AE'),
(15, '������', 'Sweden', 'SE'),
(16, '���������', 'Kazakhstan', 'KZ'),
(17, '����������', 'Portugal', 'PT'),
(18, '������', 'Greece', 'GR'),
(19, '���������� ������', 'Saudi Arabia', 'SA'),
(20, '������', 'Russian Federation', 'RU'),
(21, '��������������', 'United Kingdom', 'GB'),
(22, '�����', 'Denmark', 'DK'),
(23, '���', 'United States', 'US'),
(24, '������', 'Canada', 'CA'),
(25, '�������', 'Mexico', 'MX'),
(26, '�������', 'Bermuda', 'BM'),
(27, '������ ����', 'Puerto Rico', 'PR'),
(28, '���������� ������� ���', 'Virgin Islands, U.S.', 'VI'),
(29, '��������', 'Germany', 'DE'),
(30, '����', 'Iran', 'IR'),
(31, '�������', 'Bolivia', 'BO'),
(32, '����������', 'Montserrat', 'MS'),
(33, '����������', 'Netherlands', 'NL'),
(34, '�������', 'Israel', 'IL'),
(35, '�������', 'Spain', 'ES'),
(36, '��������� �������', 'Bahamas', 'BS'),
(37, '����-������� � ���������', 'Saint Vincent and the Grenadines', 'VC'),
(38, '����', 'Chile', 'CL'),
(39, '����� ���������', 'New Caledonia', 'NC'),
(40, '���������', 'Argentina', 'AR'),
(41, '��������', 'Dominica', 'DM'),
(42, '��������', 'Singapore', 'SG'),
(43, '�����', 'Nepal', 'NP'),
(44, '���������', 'Philippines', 'PH'),
(45, '���������', 'Indonesia', 'ID'),
(46, '��������', 'Pakistan', 'PK'),
(47, '�������', 'Tokelau', 'TK'),
(48, '����� ��������', 'New Zealand', 'NZ'),
(49, '��������', 'Cambodia', 'KH'),
(50, '�����', 'Macau', 'MO'),
(51, '����� ����� ������', 'Papua New Guinea', 'PG'),
(52, '����������� �������', 'Maldives', 'MV'),
(53, '����������', 'Afghanistan', 'AF'),
(54, '���������', 'Bangladesh', 'BD'),
(55, '��������', 'Ireland', 'IE'),
(56, '�������', 'Belgium', 'BE'),
(57, '�����', 'Belize', 'BZ'),
(58, '��������', 'Brazil', 'BR'),
(59, '���������', 'Switzerland', 'CH'),
(60, '����-����������� ����������', 'South Africa', 'ZA'),
(61, '������', 'Egypt', 'EG'),
(62, '�������', 'Nigeria', 'NG'),
(63, '��������', 'Tanzania', 'TZ'),
(64, '������', 'Zambia', 'ZM'),
(65, '�������', 'Senegal', 'SN'),
(66, '����', 'Ghana', 'GH'),
(67, '�����', 'Sudan', 'SD'),
(68, '�������', 'Cameroon', 'CM'),
(69, '������', 'Malawi', 'MW'),
(70, '������', 'Angola', 'AO'),
(71, '�����', 'Kenya', 'KE'),
(72, '�����', 'Gabon', 'GA'),
(73, '����', 'Mali', 'ML'),
(74, '�����', 'Benin', 'BJ'),
(75, '����������', 'Madagascar', 'MG'),
(76, '���', 'Chad', 'TD'),
(77, '��������', 'Botswana', 'BW'),
(78, '�����', 'Libya', 'LY'),
(79, '����-�����', 'Cape Verde', 'CV'),
(80, '������', 'Rwanda', 'RW'),
(81, '��������', 'Mozambique', 'MZ'),
(82, '������', 'Gambia', 'GM'),
(83, '������', 'Lesotho', 'LS'),
(84, '��������', 'Mauritius', 'MU'),
(85, '�����', 'Congo', 'CG'),
(86, '������', 'Uganda', 'UG'),
(87, '������� ����', 'Burkina Faso', 'BF'),
(88, '������-�����', 'Sierra Leone', 'SL'),
(89, '������', 'Somalia', 'SO'),
(90, '��������', 'Zimbabwe', 'ZW'),
(91, '��������������� ���������� �����', 'Democratic Republic Of The Congo', 'CD'),
(92, '�����', 'Niger', 'NE'),
(93, '����������-����������� ����������', 'Central African Republic', 'CF'),
(94, '���������', 'Swaziland', 'SZ'),
(95, '����', 'Togo', 'TG'),
(96, '������', 'Guinea', 'GN'),
(97, '�������', 'Liberia', 'LR'),
(98, '��������', 'Seychelles', 'SC'),
(99, '�������', 'Morocco', 'MA'),
(100, '�����', 'Algeria', 'DZ'),
(101, '����������', 'Mauritania', 'MR'),
(102, '�������', 'Namibia', 'NA'),
(103, '�������', 'Djibouti', 'DJ'),
(105, '��������� �������', 'Comoros', 'KM'),
(106, '�������', 'Reunion', 'RE'),
(107, '�������������� ������', 'Equatorial Guinea', 'GQ'),
(108, '�����', 'Tunisia', 'TN'),
(109, '������', 'Turkey', 'TR'),
(110, '������', 'Poland', 'PL'),
(111, '������', 'Latvia', 'LV'),
(112, '�������', 'Ukraine', 'UA'),
(113, '��������', 'Belarus', 'BY'),
(114, '�����', 'Czech Republic', 'CZ'),
(115, '���������', 'Palestinian Territory', 'PS'),
(116, '��������', 'Iceland', 'IS'),
(117, '����', 'Cyprus', 'CY'),
(118, '�������', 'Hungary', 'HU'),
(119, '��������', 'Slovakia', 'SK'),
(120, '������', 'Serbia', 'RS'),
(121, '��������', 'Bulgaria', 'BG'),
(122, '����', 'Oman', 'OM'),
(123, '�������', 'Romania', 'RO'),
(124, '������', 'Georgia', 'GE'),
(125, '��������', 'Norway', 'NO'),
(126, '�������', 'Armenia', 'AM'),
(127, '�������', 'Austria', 'AT'),
(128, '�������', 'Albania', 'AL'),
(129, '��������', 'Slovenia', 'SI'),
(130, '������', 'Panama', 'PA'),
(131, '������', 'Brunei Darussalam', 'BN'),
(132, '���-�����', 'Sri Lanka', 'LK'),
(133, '����������', 'Montenegro', 'ME'),
(134, '����������� ����', 'Europe', 'EU'),
(135, '�����������', 'Tajikistan', 'TJ'),
(136, '����', 'Iraq', 'IQ'),
(137, '�����', 'Lebanon', 'LB'),
(138, '�������', 'Moldova', 'MD'),
(139, '���������', 'Finland', 'FI'),
(140, '�������', 'Estonia', 'EE'),
(141, '������ � �����������', 'Bosnia and Herzegovina', 'BA'),
(142, '������', 'Kuwait', 'KW'),
(143, '��������� �������', 'Aland Islands', 'AX'),
(144, '�����', 'Lithuania', 'LT'),
(145, '����������', 'Luxembourg', 'LU'),
(146, '������� � �������', 'Antigua and Barbuda', 'AG'),
(147, '���������', 'Macedonia', 'MK'),
(148, '���-������', 'San Marino', 'SM'),
(149, '������', 'Malta', 'MT'),
(150, '������������ �������', 'Falkland Islands', 'FK'),
(151, '�������', 'Bahrain', 'BH'),
(152, '����������', 'Uzbekistan', 'UZ'),
(153, '�����������', 'Azerbaijan', 'AZ'),
(154, '������', 'Monaco', 'MC'),
(155, '�����', 'Haiti', 'HT'),
(156, '����', 'Guam', 'GU'),
(157, '������', 'Jamaica', 'JM'),
(158, '������� ����� ������� ���', 'United States Minor Outlying Islands', 'UM'),
(159, '����������', 'Micronesia', 'FM'),
(160, '�������', 'Ecuador', 'EC'),
(161, '����', 'Peru', 'PE'),
(162, '��������� �������', 'Cayman Islands', 'KY'),
(163, '��������', 'Colombia', 'CO'),
(164, '��������', 'Honduras', 'HN'),
(165, '���������� �������', 'Netherlands Antilles', 'AN'),
(166, '�����', 'Yemen', 'YE'),
(167, '���������� ���������� �������', 'Virgin Islands, British', 'VG'),
(168, '�����', 'Syria', 'SY'),
(169, '���������', 'Nicaragua', 'NI'),
(170, '������������� ����������', 'Dominican Republic', 'DO'),
(171, '�������', 'Grenada', 'GD'),
(172, '���������', 'Guatemala', 'GT'),
(173, '�����-����', 'Costa Rica', 'CR'),
(174, '���������', 'El Salvador', 'SV'),
(175, '���������', 'Venezuela', 'VE'),
(176, '��������', 'Barbados', 'BB'),
(177, '�������� � ������', 'Trinidad and Tobago', 'TT'),
(178, '����', 'Bouvet Island', 'BV'),
(179, '���������� �������', 'Marshall Islands', 'MH'),
(180, '������� ����', 'Cook Islands', 'CK'),
(181, '���������', 'Gibraltar', 'GI'),
(182, '��������', 'Paraguay', 'PY'),
(247, '����� �����', 'South Sudan', 'SS'),
(184, '�����', 'Samoa', 'WS'),
(185, '���� ���� � �����', 'Saint Kitts and Nevis', 'KN'),
(186, '�����', 'Fiji', 'FJ'),
(187, '�������', 'Uruguay', 'UY'),
(188, '�������� ���������� �������', 'Northern Mariana Islands', 'MP'),
(189, '�����', 'Palau', 'PW'),
(190, '�����', 'Qatar', 'QA'),
(191, '��������', 'Jordan', 'JO'),
(192, '������������ �����', 'American Samoa', 'AS'),
(193, '����� � ������', 'Turks and Caicos Islands', 'TC'),
(194, '������ �����', 'Saint Lucia', 'LC'),
(195, '��������', 'Mongolia', 'MN'),
(196, '�������', 'Holy See', 'VA'),
(197, '�������', 'Aruba', 'AW'),
(198, '������', 'Guyana', 'GY'),
(199, '�������', 'Suriname', 'SR'),
(200, '������ ���', 'Isle of Man', 'IM'),
(201, '�������', 'Vanuatu', 'VU'),
(202, '��������', 'Croatia', 'HR'),
(203, '��������', 'Anguilla', 'AI'),
(204, '���-���� � �������', 'Saint Pierre and Miquelon', 'PM'),
(205, '���������', 'Guadeloupe', 'GP'),
(206, '���-������', 'Saint Martin', 'MF'),
(207, '������', 'Guernsey', 'GG'),
(208, '�������', 'Burundi', 'BI'),
(209, '������������', 'Turkmenistan', 'TM'),
(210, '����������', 'Kyrgyzstan', 'KG'),
(211, '������', 'Myanmar', 'MM'),
(212, '�����', 'Bhutan', 'BT'),
(213, '�����������', 'Liechtenstein', 'LI'),
(214, '��������� �������', 'Faroe Islands', 'FO'),
(215, '�������', 'Ethiopia', 'ET'),
(216, '���������', 'Martinique', 'MQ'),
(217, '������', 'Jersey', 'JE'),
(218, '�������', 'Andorra', 'AD'),
(219, '����������', 'Antarctica', 'AQ'),
(220, '���������� ���������� � ��������� ������', 'British Indian Ocean Territory', 'IO'),
(221, '����������', 'Greenland', 'GL'),
(222, '������-�����', 'Guinea-Bissau', 'GW'),
(223, '�������', 'Eritrea', 'ER'),
(224, '������ � ������', 'Wallis and Futuna', 'WF'),
(225, '����������� ���������', 'French Polynesia', 'PF'),
(226, '����', 'Cuba', 'CU'),
(227, '�����', 'Tonga', 'TO'),
(228, '��������� �����', 'Timor-Leste', 'TL'),
(229, '���-���� � ��������', 'Sao Tome and Principe', 'ST'),
(230, '����������� ������', 'French Guiana', 'GF'),
(231, '���������� �������', 'Solomon Islands', 'SB'),
(232, '������', 'Tuvalu', 'TV'),
(233, '��������', 'Kiribati', 'KI'),
(234, '����', 'Niue', 'NU'),
(235, '�������', 'Norfolk Island', 'NF'),
(236, '�����', 'Nauru', 'NR'),
(237, '�������', 'Mayotte', 'YT'),
(238, '�������', 'Pitcairn Islands', 'PN'),
(239, '���-�''�����', 'Cote D''Ivoire', 'CI'),
(240, '����', 'Lao', 'LA'),
(241, '��������� �������-��������������� ����������', 'Democratic People''s Republic of Korea', 'KP'),
(242, '��������� � ��-�����', 'Svalbard and Jan Mayen', 'SJ'),
(243, '������ ������ �����', 'Saint Helena', 'SH'),
(244, '��������� �������', 'Cocos (Keeling) Islands', 'CC'),
(245, '�������� ������', 'Western Sahara', 'EH');";


$conn->query($sql);
if ($conn->error) {
    echo "Table geo_country added data". '<br />';
}else{
    echo "Table geo_country added data allredy ". '<br />';
}


$sql = "CREATE TABLE IF NOT EXISTS `geo_city` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`country_id` int(11) DEFAULT NULL,
`name_ru` varchar(100) DEFAULT NULL,
`name_en` varchar(100) DEFAULT NULL,
`region` varchar(2) DEFAULT NULL,
`postal_code` varchar(10) DEFAULT NULL,
`latitude` varchar(10) DEFAULT NULL,
`longitude` varchar(10) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `country_id` (`country_id`),
KEY `name_ru` (`name_ru`),
KEY `name_en` (`name_en`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=438354 ;";


$conn->query($sql);
if ($conn->error) {
    echo "Table geo_city created". '<br />';
}else{
    echo "Table geo_city allready exist". '<br />';
}



$sql = "CREATE TABLE IF NOT EXISTS `blog_comments` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`parent_id` int(11) DEFAULT NULL,
`blog_id` int(11) DEFAULT NULL,
`created_at` int(11) DEFAULT NULL,
`author_name` text,
`email` varchar(255) DEFAULT NULL,
`city` varchar(255) DEFAULT NULL,
`text` varchar(255) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";



$conn->query($sql);
if ($conn->error) {
    echo "Table blog_comments created". '<br />';
}else{
    echo "Table blog_comments allredy exist". '<br />';
}
$sql = "CREATE TABLE IF NOT EXISTS `order_items` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`order_id` int(11) NOT NULL,
`ip` varchar(255) NOT NULL,
`goods_id` int(11) NOT NULL,
`quantity` int(11) NOT NULL,
`price` int(11) NOT NULL,
`category_id` int(11) NOT NULL,
`brend_id` int(11) DEFAULT NULL,
`created_at` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `goods_id` (`goods_id`),
KEY `category_id` (`category_id`,`brend_id`),
KEY `brend_id` (`brend_id`),
KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;";



$conn->query($sql);
if ($conn->error) {
    echo "Table order_items created". '<br />';
}else{
    echo "Table order_items allredy exist". '<br />';
}

$sql = "CREATE TABLE IF NOT EXISTS `reqvizit` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`company_name` varchar(100) NOT NULL,
`country` varchar(100) NOT NULL,
`address` varchar(255) NOT NULL,
`mobile` varchar(100) NOT NULL,
`fax` varchar(100) NOT NULL,
`email` varchar(255) NOT NULL,
`schet` varchar(255) NOT NULL,
`inn` varchar(255) NOT NULL,
`zip_code` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";



$conn->query($sql);
if ($conn->error) {
    echo "Table reqvizit created". '<br />';
}else{
    echo "Table reqvizit allredy exist". '<br />';
}


$sql = "INSERT INTO `reqvizit` (`id`, `company_name`, `country`, `address`, `mobile`, `fax`, `email`, `schet`, `inn`, `zip_code`) VALUES
(1, 'kotmonnstr-shop', '������', '����, ����������� ��.������ 2', '+7 789 898 6250', '+7 789 898 6250', 'kotmonstr@ukr.net', '11212344343443434', '4543546665444', 927001);
";



$conn->query($sql);
if ($conn->error) {
    echo "Table reqvizit data added". '<br />';
}else{
    echo "Table reqvizit data added allredy". '<br />';
}


$filename = $_SERVER['DOCUMENT_ROOT'].'/sqls/'.'geo_city.sql';
// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

// Add this line to the current segment
    $templine .= $line;
// If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        // Perform the query
        $conn->query($templine);
        // Reset temp variable to empty
        $templine = '';
    }
}
echo "<br />Table geo_city imported successfully <br />";




$filename = $_SERVER['DOCUMENT_ROOT'].'/sqls/'.'geo_country.sql';
// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

// Add this line to the current segment
    $templine .= $line;
// If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        // Perform the query
        $conn->query($templine);
        // Reset temp variable to empty
        $templine = '';
    }
}
echo "Table geo_country imported successfully<br />";

$filename = $_SERVER['DOCUMENT_ROOT'].'/sqls/'.'order_status.sql';
// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

// Add this line to the current segment
    $templine .= $line;
// If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        // Perform the query
        $conn->query($templine);
        // Reset temp variable to empty
        $templine = '';
    }
}
echo "Table order_status imported successfully<br />";


$sql = "CREATE TABLE IF NOT EXISTS `order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip` varchar(255) NOT NULL,
`status` int(11) NOT NULL COMMENT '1-���� ������, 2 �����������, 3 - ��������',
`created_at` int(11) NOT NULL,
`country_id` int(11) NOT NULL,
`city_id` int(11) NOT NULL,
`post_index` int(11) DEFAULT NULL,
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
KEY `city_id` (`city_id`),
KEY `status` (`status`,`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;";



$conn->query($sql);
if ($conn->error) {
    echo "Table order created". '<br />';
}else{
    echo "Table order allredy exist". '<br />';
}

$sql = "ALTER TABLE `order` ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`status`) REFERENCES `order_status` (`id`);";
$conn->query($sql);
if ($conn->error) {
    echo "order updated". '<br />';
}else{
    echo "order allredy updated". '<br />';
}




$conn->close();
die();
?>
