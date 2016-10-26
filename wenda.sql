-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 05 月 08 日 03:37
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wenda`
--

-- --------------------------------------------------------

--
-- 表的结构 `hd_admin`
--

CREATE TABLE IF NOT EXISTS `hd_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(20) NOT NULL DEFAULT '' COMMENT '管理员帐号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上一次登录时间',
  `loginip` char(20) NOT NULL DEFAULT '' COMMENT '上一次登录的IP',
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:锁定   0:未锁定',
  PRIMARY KEY (`id`),
  KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='后台管理员' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `hd_admin`
--

INSERT INTO `hd_admin` (`id`, `account`, `password`, `logintime`, `loginip`, `lock`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1367973699, '127.0.0.1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `hd_answer`
--

CREATE TABLE IF NOT EXISTS `hd_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '答题内容',
  `adopt` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否被采纳1：已采纳， 0：未采纳',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回答时间',
  `aid` int(10) unsigned NOT NULL COMMENT '所属问题ID',
  `uid` int(10) unsigned NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`id`),
  KEY `adopt` (`adopt`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='答案' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `hd_answer`
--

INSERT INTO `hd_answer` (`id`, `content`, `adopt`, `time`, `aid`, `uid`) VALUES
(2, 'http://www.houdunwang.com', 1, 1367810540, 7, 1),
(4, 'substr()', 0, 1367890861, 3, 1),
(5, 'http://bbs.houdunwang.com', 0, 1367892003, 8, 1);

-- --------------------------------------------------------

--
-- 表的结构 `hd_ask`
--

CREATE TABLE IF NOT EXISTS `hd_ask` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '问题内容',
  `reward` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '奖励金币',
  `solve` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:已解决  0:未解决',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提问时间',
  `answer` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回答数',
  `uid` int(10) unsigned NOT NULL COMMENT '所属用户ID',
  `cid` int(10) unsigned NOT NULL COMMENT '所属分类ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='问题' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `hd_ask`
--

INSERT INTO `hd_ask` (`id`, `content`, `reward`, `solve`, `time`, `answer`, `uid`, `cid`) VALUES
(2, 'php换行符是什么？？', 0, 0, 1367567393, 0, 2, 206),
(3, 'PHP如何截取字符串？', 0, 0, 1367567459, 1, 2, 206),
(4, '为什么我的PHP处理不了图像？？', 0, 0, 1367567521, 1, 2, 206),
(5, 'Linux怎么修改权限？？', 0, 0, 1367567631, 0, 3, 208),
(6, 'MySQL创建表时怎么设置存储引擎？？', 0, 0, 1367567741, 0, 3, 207),
(7, '后盾网网址是多少？？', 0, 1, 1367567897, 1, 3, 1),
(8, '后盾网论坛网址是什么？？？', 0, 0, 1367567935, 1, 3, 1),
(9, '常见的操作系统有哪些？？？', 0, 0, 1367568083, 0, 1, 17);

-- --------------------------------------------------------

--
-- 表的结构 `hd_category`
--

CREATE TABLE IF NOT EXISTS `hd_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID，0：顶级分类',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='问题分类' AUTO_INCREMENT=216 ;

--
-- 转存表中的数据 `hd_category`
--

INSERT INTO `hd_category` (`id`, `name`, `pid`) VALUES
(1, '电脑/网络', 0),
(2, '手机/数码', 0),
(3, '生活', 0),
(4, '游戏', 0),
(5, '体育/运动', 0),
(6, '娱乐明星', 0),
(7, '休闲爱好', 0),
(8, '文化/艺术', 0),
(9, '社会民生', 0),
(10, '教育/科学', 0),
(11, '健康/医疗', 0),
(12, '商业/理财', 0),
(13, '情感/家庭', 0),
(14, '地区问题', 0),
(15, '电脑知识', 1),
(16, '互联网', 1),
(17, '操作系统', 1),
(18, '软件', 1),
(19, '硬件', 1),
(20, '编程开发', 1),
(21, '电脑安全', 1),
(22, '资源分享', 1),
(23, '笔记本电脑', 1),
(24, '手机/通讯', 2),
(25, '平板', 2),
(26, 'MP3/MP4', 2),
(27, '手机品牌', 2),
(28, '其他数码', 2),
(29, '手机系统', 2),
(30, '照相机/摄像机', 2),
(31, '数码品牌', 2),
(32, '购物时尚', 3),
(33, '美容塑身', 3),
(34, '美食', 3),
(35, '生活知识', 3),
(36, '品牌服装', 3),
(37, '出行旅游', 3),
(38, '交通', 3),
(39, '购车保养', 3),
(40, '购房置业', 3),
(41, '房屋装饰', 3),
(42, '风水', 3),
(43, '家电用品', 3),
(44, '烹饪', 3),
(45, '网游', 4),
(46, '单机游戏', 4),
(47, '网页游戏', 4),
(48, '盛大游戏', 4),
(49, '网易', 4),
(50, '九城游戏', 4),
(51, '腾讯游戏', 4),
(52, '完美游戏', 4),
(53, '久游游戏', 4),
(54, '巨人游戏', 4),
(55, '金山游戏', 4),
(56, '网龙游戏', 4),
(57, '电视游戏', 4),
(58, '足球', 5),
(59, '篮球', 5),
(60, '体育明星', 5),
(61, '综合赛事', 5),
(62, '田径', 5),
(63, '跳水游泳', 5),
(64, '小球运动', 5),
(65, '赛车赛事', 5),
(66, '强身健体', 5),
(67, '运动品牌', 5),
(68, '电影电视', 6),
(69, '明星', 6),
(70, '音乐', 6),
(71, '动漫', 6),
(72, '星座', 6),
(73, '摄影摄像', 7),
(74, '收藏', 7),
(75, '宠物', 7),
(76, '脑筋急转弯', 7),
(77, '谜语', 7),
(78, '幽默搞笑', 7),
(79, '起名', 7),
(80, '园艺艺术', 7),
(81, '花鸟鱼虫', 7),
(82, '茶艺', 7),
(83, '国内外文学', 8),
(84, '美术', 8),
(85, '舞蹈', 8),
(86, '散文/小说', 8),
(87, '图书音像', 8),
(88, '器乐/声乐', 8),
(89, '小品相声', 8),
(90, '戏剧戏曲', 8),
(91, '时事政治', 9),
(92, '舆论', 9),
(93, '就业/职场', 9),
(94, '历史话题', 9),
(95, '军事国防', 9),
(96, '节日假期', 9),
(97, '民族风情', 9),
(98, '法律知识', 9),
(99, '宗教', 9),
(100, '礼仪', 9),
(101, '学习辅助', 10),
(102, '考研/考证', 10),
(103, '外语', 10),
(104, '菁菁校园', 10),
(105, '人文学', 10),
(106, '理工学', 10),
(107, '公务员', 10),
(108, '留学/出国', 10),
(109, '健康知识', 11),
(110, '孕育/家教', 11),
(111, '内科', 11),
(112, '心理健康', 11),
(113, '外科', 11),
(114, '妇产科', 11),
(115, '儿科', 11),
(116, '皮肤科', 11),
(117, '五官科', 11),
(118, '男科', 11),
(119, '美容整形', 11),
(120, '中医', 11),
(121, '药品', 11),
(122, '心血管科', 11),
(123, '传染科', 11),
(124, '其它疾病', 11),
(125, '健康体检', 11),
(126, '医院', 11),
(127, '创业', 12),
(128, '企业管理', 12),
(129, '财务税务', 12),
(130, '银行', 12),
(131, '股票', 12),
(132, '金融/期货', 12),
(133, '基金债券', 12),
(134, '保险', 12),
(135, '贸易', 12),
(136, '外贸', 12),
(137, '商务文书', 12),
(138, '国民经济', 12),
(139, '个人理财', 12),
(140, '恋爱', 13),
(141, '朋友', 13),
(142, '婚嫁', 13),
(143, '两性', 13),
(144, '家庭', 13),
(145, '孩子教育', 13),
(146, '北京', 14),
(147, '上海', 14),
(148, '天津', 14),
(149, '重庆', 14),
(150, '黑龙江', 14),
(151, '吉林', 14),
(152, '辽宁', 14),
(153, '河北', 14),
(154, '内蒙古', 14),
(155, '山西', 14),
(156, '陕西', 14),
(157, '宁夏', 14),
(158, '甘肃', 14),
(159, '青海', 14),
(160, '新疆', 14),
(161, '西藏', 14),
(162, '四川', 14),
(163, '贵州', 14),
(164, '云南', 14),
(165, '河南', 14),
(166, '湖北', 14),
(167, '湖南', 14),
(168, '山东', 14),
(169, '江苏', 14),
(170, '浙江', 14),
(171, '安徽', 14),
(172, '江西', 14),
(173, '福建', 14),
(174, '广东', 14),
(175, '广西', 14),
(176, '海南', 14),
(177, '香港', 14),
(178, '澳门', 14),
(179, '台湾', 14),
(180, '海外地区', 14),
(181, '电脑配置', 15),
(182, '电脑日常维护', 15),
(183, '上网问题', 16),
(184, '新浪', 16),
(185, '腾讯', 16),
(186, 'Windows XP', 17),
(187, 'windows 7', 17),
(188, 'Windows Vista', 17),
(189, 'Windows 8', 17),
(190, '办公软件', 18),
(191, '网络软件', 18),
(192, '图像处理', 18),
(193, '系统软件', 18),
(194, '多媒体软件', 18),
(195, '硬盘', 19),
(196, '显示设备', 19),
(197, 'CPU', 19),
(198, '显卡', 19),
(199, '内存', 19),
(200, '主板', 19),
(201, '键盘/鼠标', 19),
(202, 'HTML', 20),
(203, 'DIV+CSS', 20),
(204, 'JavaScript', 20),
(205, 'jQuery', 20),
(206, 'PHP', 20),
(207, 'MySQL', 20),
(208, 'Linux', 20),
(209, 'Objective-C', 20),
(210, 'Java', 20),
(211, 'C/C++', 20);

-- --------------------------------------------------------

--
-- 表的结构 `hd_user`
--

CREATE TABLE IF NOT EXISTS `hd_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(20) NOT NULL DEFAULT '' COMMENT '用户帐号',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `face` varchar(60) NOT NULL DEFAULT '' COMMENT '用户头像',
  `answer` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回答数',
  `adopt` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '答案采纳数',
  `ask` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提问数',
  `point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金币',
  `exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上一次的登录时间',
  `loginip` char(20) NOT NULL DEFAULT '' COMMENT '上一次的登录IP',
  `registime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1：锁定，2：未锁定',
  PRIMARY KEY (`id`),
  KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='前台用户' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `hd_user`
--

INSERT INTO `hd_user` (`id`, `account`, `username`, `password`, `face`, `answer`, `adopt`, `ask`, `point`, `exp`, `logintime`, `loginip`, `registime`, `lock`) VALUES
(1, 'admin01', '后盾网', '18c6d818ae35a3e8279b5330eda01498', '', 3, 1, 3, 0, 18, 1367916837, '127.0.0.1', 1367481467, 0),
(2, 'admin02', '后盾论坛', '6e60a28384bc05fa5b33cc579d040c56', '', 1, 1, 3, 8, 10, 1367893182, '127.0.0.1', 1367567371, 0),
(3, 'admin03', '后盾视频', '7dc2466ad3ff5911f6a5e47e043e0abc', '', 1, 0, 4, 1, 12, 1367889207, '127.0.0.1', 1367567571, 0),
(4, 'admin04', '后盾学习社区', '499c208ceafb4fbba162f077060955bd', '', 0, 0, 0, 0, 0, 1367978258, '127.0.0.1', 1367978258, 0);
