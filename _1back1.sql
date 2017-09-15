/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : _1back1

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-09-15 10:54:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jc_activity_log
-- ----------------------------
DROP TABLE IF EXISTS `jc_activity_log`;
CREATE TABLE `jc_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `date` date DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_activity_log
-- ----------------------------

-- ----------------------------
-- Table structure for jc_ad
-- ----------------------------
DROP TABLE IF EXISTS `jc_ad`;
CREATE TABLE `jc_ad` (
  `ad_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `ad_name` varchar(255) DEFAULT NULL COMMENT '广告名称',
  `ad_content` text COMMENT '广告内容',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`ad_id`),
  KEY `ad_name` (`ad_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_ad
-- ----------------------------

-- ----------------------------
-- Table structure for jc_album
-- ----------------------------
DROP TABLE IF EXISTS `jc_album`;
CREATE TABLE `jc_album` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_album
-- ----------------------------
INSERT INTO `jc_album` VALUES ('1', 'Article专辑');
INSERT INTO `jc_album` VALUES ('2', 'Article专辑');
INSERT INTO `jc_album` VALUES ('3', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('4', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('5', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('6', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('7', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('8', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('9', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('10', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('11', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('12', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('13', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('14', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('15', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('16', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('17', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('18', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('19', 'Mall专辑');
INSERT INTO `jc_album` VALUES ('20', 'Mall专辑');

-- ----------------------------
-- Table structure for jc_apply
-- ----------------------------
DROP TABLE IF EXISTS `jc_apply`;
CREATE TABLE `jc_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '留言者姓名',
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL COMMENT '留言者邮箱',
  `address` varchar(255) DEFAULT NULL,
  `content` text COMMENT '留言内容',
  `add_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_apply
-- ----------------------------

-- ----------------------------
-- Table structure for jc_article
-- ----------------------------
DROP TABLE IF EXISTS `jc_article`;
CREATE TABLE `jc_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `cate_id` int(10) unsigned NOT NULL DEFAULT '0',
  `img` int(4) NOT NULL DEFAULT '0',
  `bimg` int(4) NOT NULL DEFAULT '0',
  `file_id` int(4) NOT NULL DEFAULT '0',
  `album_id` int(6) NOT NULL DEFAULT '0',
  `add_time` datetime DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  `del_time` datetime DEFAULT NULL,
  `sort_order` int(10) NOT NULL DEFAULT '0',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0',
  `is_top` tinyint(4) NOT NULL DEFAULT '0',
  `is_best` tinyint(4) NOT NULL DEFAULT '0',
  `hits` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-待审核 1-已审核',
  `title` varchar(255) DEFAULT NULL,
  `pretitle` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `orig` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `abst` text,
  `info` text,
  `m_info` text,
  `author` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  `date` date DEFAULT NULL,
  `test` text,
  PRIMARY KEY (`id`),
  KEY `is_best` (`is_best`),
  KEY `add_time` (`add_time`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_article
-- ----------------------------
INSERT INTO `jc_article` VALUES ('32', '1', '32', '0', '0', '0', '0', '2017-09-06 09:48:21', '2017-09-06 10:57:13', null, '1', '0', '0', '0', '0', '1', '第十三期新塘街道高桥路南延伸段长期被小摊小贩占据问题整改完成报告', null, null, null, '', null, '', '<p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 30px; padding: 0px; border: none; line-height: 32px; color: rgb(102, 102, 102); text-indent: 2em; font-family: &quot;microsoft yahei&quot;, Arial, Helvetica, sans-serif; white-space: normal;\">房屋使用安全关系人民群众生命财产安全。加强房屋，特别是危旧房管理，是政府的重要职责。从萧山看，近年来城市化建设进度加快， 但城乡危房的存量也不少。随着全省治危拆违工作的推进，特别是我区提出要推进三化联动，建设体现世界名城风貌的现代化国际城区，危旧房 治理，既是城市品质提升、环境面貌改善的客观需要，也是关乎人民群众切身利益的根本要求。建议我区要进一步完善制度建设，落实资金保障， 优化监管方式，切实加强危旧房治理。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 30px; padding: 0px; border: none; line-height: 32px; color: rgb(102, 102, 102); text-indent: 2em; font-family: &quot;microsoft yahei&quot;, Arial, Helvetica, sans-serif; white-space: normal;\"><img src=\"http://localhost/zjhxgcgl.com/data/upload/ueditor/20170901/59a8b9dc740a4.jpg\" alt=\"\"/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 30px; padding: 0px; border: none; line-height: 32px; color: rgb(102, 102, 102); text-indent: 2em; font-family: &quot;microsoft yahei&quot;, Arial, Helvetica, sans-serif; white-space: normal;\">一是完善制度。建立健全房屋使用安全管理工作机制，一旦建筑被鉴定为危房，必须落实房屋安全巡查制度，属地镇街对房屋安全巡查实施 网格化管理，委托有相应资质的专业技术人员进行定期检查和实时响应服务。要强化应急处置，特别对经鉴定为D级危旧住房且处理意见为停止使 用的房屋，属地镇街应立即发布公告并通知房屋所有人或使用人停止使用、限期搬迁并妥善处置。</p>', null, null, '', '', '', null, null);
INSERT INTO `jc_article` VALUES ('33', '1', '32', '0', '0', '0', '0', '2017-09-06 09:48:27', '2017-09-06 10:57:00', null, '33', '0', '0', '0', '0', '1', '第二十四期03省道河上段江家桥村路段垃圾成堆影响周边环境的整改完成情况报告', null, null, null, '', null, '', '<p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 30px; padding: 0px; border: none; line-height: 32px; color: rgb(102, 102, 102); text-indent: 2em; font-family: &quot;microsoft yahei&quot;, Arial, Helvetica, sans-serif; white-space: normal;\">房屋使用安全关系人民群众生命财产安全。加强房屋，特别是危旧房管理，是政府的重要职责。从萧山看，近年来城市化建设进度加快， 但城乡危房的存量也不少。随着全省治危拆违工作的推进，特别是我区提出要推进三化联动，建设体现世界名城风貌的现代化国际城区，危旧房 治理，既是城市品质提升、环境面貌改善的客观需要，也是关乎人民群众切身利益的根本要求。建议我区要进一步完善制度建设，落实资金保障， 优化监管方式，切实加强危旧房治理。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 30px; padding: 0px; border: none; line-height: 32px; color: rgb(102, 102, 102); text-indent: 2em; font-family: &quot;microsoft yahei&quot;, Arial, Helvetica, sans-serif; white-space: normal;\"><img src=\"http://localhost/zjhxgcgl.com/data/upload/ueditor/20170901/59a8b9dc740a4.jpg\" alt=\"\"/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 30px; padding: 0px; border: none; line-height: 32px; color: rgb(102, 102, 102); text-indent: 2em; font-family: &quot;microsoft yahei&quot;, Arial, Helvetica, sans-serif; white-space: normal;\">一是完善制度。建立健全房屋使用安全管理工作机制，一旦建筑被鉴定为危房，必须落实房屋安全巡查制度，属地镇街对房屋安全巡查实施 网格化管理，委托有相应资质的专业技术人员进行定期检查和实时响应服务。要强化应急处置，特别对经鉴定为D级危旧住房且处理意见为停止使 用的房屋，属地镇街应立即发布公告并通知房屋所有人或使用人停止使用、限期搬迁并妥善处置。</p>', null, null, '', '', '', null, null);

-- ----------------------------
-- Table structure for jc_article_cate
-- ----------------------------
DROP TABLE IF EXISTS `jc_article_cate`;
CREATE TABLE `jc_article_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `alias_template` varchar(255) DEFAULT NULL,
  `pid` int(10) NOT NULL DEFAULT '0',
  `parentspath` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `sort_order` int(10) NOT NULL DEFAULT '0',
  `record_nums` int(10) NOT NULL DEFAULT '0',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  `img` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `abst` text,
  `info` text,
  `remark` text,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_article_cate
-- ----------------------------
INSERT INTO `jc_article_cate` VALUES ('32', '1', '1', '', '', '0', '0,', '1', '0', '0', '', '', '', '', null, null, null, null, '', '', null, '2017-09-06 09:48:13', '2017-09-06 09:48:13');

-- ----------------------------
-- Table structure for jc_article_en
-- ----------------------------
DROP TABLE IF EXISTS `jc_article_en`;
CREATE TABLE `jc_article_en` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `pretitle` varchar(255) DEFAULT '',
  `subtitle` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `orig` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `abst` text,
  `info` text,
  `m_info` text,
  `author` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_article_en
-- ----------------------------
INSERT INTO `jc_article_en` VALUES ('32', '', '', null, null, '', null, '', '', null, null, null, null, null);
INSERT INTO `jc_article_en` VALUES ('33', '', '', null, null, '', null, '', '', null, null, null, null, null);

-- ----------------------------
-- Table structure for jc_asset
-- ----------------------------
DROP TABLE IF EXISTS `jc_asset`;
CREATE TABLE `jc_asset` (
  `aid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户 id',
  `key` varchar(50) NOT NULL COMMENT '资源 key',
  `filename` varchar(50) DEFAULT NULL COMMENT '文件名',
  `filesize` int(11) DEFAULT NULL COMMENT '文件大小,单位Byte',
  `filepath` varchar(200) NOT NULL COMMENT '文件路径，相对于 upload 目录，可以为 url',
  `uploadtime` int(11) NOT NULL COMMENT '上传时间',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1：可用，0：删除，不可用',
  `meta` text COMMENT '其它详细信息，JSON格式',
  `suffix` varchar(50) DEFAULT NULL COMMENT '文件后缀名，不包括点',
  `download_times` int(11) NOT NULL DEFAULT '0' COMMENT '下载次数',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资源表';

-- ----------------------------
-- Records of jc_asset
-- ----------------------------

-- ----------------------------
-- Table structure for jc_auth_access
-- ----------------------------
DROP TABLE IF EXISTS `jc_auth_access`;
CREATE TABLE `jc_auth_access` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(255) NOT NULL COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) DEFAULT NULL COMMENT '权限规则分类，请加应用前缀,如admin_',
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- ----------------------------
-- Records of jc_auth_access
-- ----------------------------
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/default', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/userdefault', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/userinfo', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/userinfo_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/password', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/password_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/site', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/site_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/ban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/open', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/route/listorders', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/upload', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/upload_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/clearcache', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/default', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/main', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/cate', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/article/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/articlecate/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/articlecate/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/articlecate/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/articlecate/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/articlecate/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/articlecate/add_all', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/articlecate/update_num', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'api/guestbookadmin/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'api/guestbookadmin/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/listorders', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/toggle', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/link/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/default2', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/listorders', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/toggle', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/ban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/cancelban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slide/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slidecat/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slidecat/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slidecat/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slidecat/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slidecat/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/slidecat/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/setting/contact', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/dafault', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/main', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/prop', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/cate', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mall/update_num', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/menu/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mallcate/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mallcate/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mallcate/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mallcate/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mallcate/sort_order', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mallcate/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/mallcate/add_all', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/default', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/main', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/loadout', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/loadin', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheet/get_tmpl', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/edit_field', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/add_field', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheettmpl/delete_field', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/sort_order', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/add_all', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/design', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/edit_field', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/add_field', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/sheetcate/delete_field', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'user/indexadmin/default', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'user/adminuser/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'user/adminuser/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'user/adminuser/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'user/adminuser/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'user/adminuser/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/menu/default', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/navcat/default1', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/listorders', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/add_all', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/nav/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/navcat/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/navcat/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/navcat/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/navcat/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/navcat/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/navcat/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/index/default1', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'user/indexadmin/default3', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/member', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/authorize', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/authorize_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/roleedit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/roleedit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/roledelete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/roleadd', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/rbac/roleadd_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/ban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/cancelban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('5', 'admin/user/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/default', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/default2', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/main', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/cate', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/articlecate/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/articlecate/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/articlecate/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/articlecate/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/articlecate/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/articlecate/add_all', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/articlecate/update_num', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/article/autoload', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'api/guestbookadmin/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'api/guestbookadmin/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/listorders', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/toggle', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/link/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/default2', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/listorders', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/toggle', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/ban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/cancelban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slide/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slidecat/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slidecat/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slidecat/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slidecat/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slidecat/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/slidecat/add_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/setting/contact', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/dafault', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/main', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/prop', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/cate', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mall/update_num', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/menu/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mallcate/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mallcate/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mallcate/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mallcate/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mallcate/sort_order', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mallcate/status', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/mallcate/add_all', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/index/default1', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'user/indexadmin/default3', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/member', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/authorize', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/authorize_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/roleedit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/roleedit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/roledelete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/roleadd', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/rbac/roleadd_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/index', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/ban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/cancelban', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/delete', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/edit', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/edit_post', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/add', 'admin_url');
INSERT INTO `jc_auth_access` VALUES ('6', 'admin/user/add_post', 'admin_url');

-- ----------------------------
-- Table structure for jc_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `jc_auth_rule`;
CREATE TABLE `jc_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` varchar(30) NOT NULL DEFAULT '1' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `param` varchar(255) DEFAULT NULL COMMENT '额外url参数',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=414 DEFAULT CHARSET=utf8 COMMENT='权限规则表';

-- ----------------------------
-- Records of jc_auth_rule
-- ----------------------------
INSERT INTO `jc_auth_rule` VALUES ('1', 'Admin', 'admin_url', 'admin/content/default', null, '内容管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('2', 'Api', 'admin_url', 'api/guestbookadmin/index', null, '所有留言', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('3', 'Api', 'admin_url', 'api/guestbookadmin/delete', null, '删除网站留言', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('4', 'Comment', 'admin_url', 'comment/commentadmin/index', null, '评论管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('5', 'Comment', 'admin_url', 'comment/commentadmin/delete', null, '删除评论', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('6', 'Comment', 'admin_url', 'comment/commentadmin/check', null, '评论审核', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('7', 'Portal', 'admin_url', 'portal/adminpost/index', null, '文章管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('8', 'Portal', 'admin_url', 'portal/adminpost/listorders', null, '文章排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('9', 'Portal', 'admin_url', 'portal/adminpost/top', null, '文章置顶', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('10', 'Portal', 'admin_url', 'portal/adminpost/recommend', null, '文章推荐', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('11', 'Portal', 'admin_url', 'portal/adminpost/move', null, '批量移动', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('12', 'Portal', 'admin_url', 'portal/adminpost/check', null, '文章审核', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('13', 'Portal', 'admin_url', 'portal/adminpost/delete', null, '删除文章', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('14', 'Portal', 'admin_url', 'portal/adminpost/edit', null, '编辑文章', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('15', 'Portal', 'admin_url', 'portal/adminpost/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('16', 'Portal', 'admin_url', 'portal/adminpost/add', null, '添加文章', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('17', 'Portal', 'admin_url', 'portal/adminpost/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('18', 'Portal', 'admin_url', 'portal/adminterm/index', null, '分类管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('19', 'Portal', 'admin_url', 'portal/adminterm/listorders', null, '文章分类排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('20', 'Portal', 'admin_url', 'portal/adminterm/delete', null, '删除分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('21', 'Portal', 'admin_url', 'portal/adminterm/edit', null, '编辑分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('22', 'Portal', 'admin_url', 'portal/adminterm/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('23', 'Portal', 'admin_url', 'portal/adminterm/add', null, '添加分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('24', 'Portal', 'admin_url', 'portal/adminterm/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('25', 'Portal', 'admin_url', 'portal/adminpage/index', null, '页面管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('26', 'Portal', 'admin_url', 'portal/adminpage/listorders', null, '页面排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('27', 'Portal', 'admin_url', 'portal/adminpage/delete', null, '删除页面', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('28', 'Portal', 'admin_url', 'portal/adminpage/edit', null, '编辑页面', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('29', 'Portal', 'admin_url', 'portal/adminpage/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('30', 'Portal', 'admin_url', 'portal/adminpage/add', null, '添加页面', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('31', 'Portal', 'admin_url', 'portal/adminpage/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('32', 'Admin', 'admin_url', 'admin/recycle/default', null, '回收站', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('33', 'Portal', 'admin_url', 'portal/adminpost/recyclebin', null, '文章回收', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('34', 'Portal', 'admin_url', 'portal/adminpost/restore', null, '文章还原', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('35', 'Portal', 'admin_url', 'portal/adminpost/clean', null, '彻底删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('36', 'Portal', 'admin_url', 'portal/adminpage/recyclebin', null, '页面回收', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('37', 'Portal', 'admin_url', 'portal/adminpage/clean', null, '彻底删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('38', 'Portal', 'admin_url', 'portal/adminpage/restore', null, '页面还原', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('39', 'Admin', 'admin_url', 'admin/extension/default', null, '扩展工具', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('40', 'Admin', 'admin_url', 'admin/backup/default', null, '备份管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('41', 'Admin', 'admin_url', 'admin/backup/restore', null, '数据还原', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('42', 'Admin', 'admin_url', 'admin/backup/index', null, '数据备份', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('43', 'Admin', 'admin_url', 'admin/backup/index_post', null, '提交数据备份', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('44', 'Admin', 'admin_url', 'admin/backup/download', null, '下载备份', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('45', 'Admin', 'admin_url', 'admin/backup/del_backup', null, '删除备份', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('46', 'Admin', 'admin_url', 'admin/backup/import', null, '数据备份导入', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('47', 'Admin', 'admin_url', 'admin/plugin/index', null, '插件管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('48', 'Admin', 'admin_url', 'admin/plugin/toggle', null, '插件启用切换', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('49', 'Admin', 'admin_url', 'admin/plugin/setting', null, '插件设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('50', 'Admin', 'admin_url', 'admin/plugin/setting_post', null, '插件设置提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('51', 'Admin', 'admin_url', 'admin/plugin/install', null, '插件安装', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('52', 'Admin', 'admin_url', 'admin/plugin/uninstall', null, '插件卸载', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('53', 'Admin', 'admin_url', 'admin/slide/index', null, '幻灯片', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('54', 'Admin', 'admin_url', 'admin/slide/default2', null, '幻灯片管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('55', 'Admin', 'admin_url', 'admin/slide/listorders', null, '幻灯片排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('56', 'Admin', 'admin_url', 'admin/slide/toggle', null, '幻灯片显示切换', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('57', 'Admin', 'admin_url', 'admin/slide/delete', null, '删除幻灯片', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('58', 'Admin', 'admin_url', 'admin/slide/edit', null, '编辑幻灯片', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('59', 'Admin', 'admin_url', 'admin/slide/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('60', 'Admin', 'admin_url', 'admin/slide/add', null, '添加幻灯片', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('61', 'Admin', 'admin_url', 'admin/slide/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('62', 'Admin', 'admin_url', 'admin/slidecat/index', null, '幻灯片分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('63', 'Admin', 'admin_url', 'admin/slidecat/delete', null, '删除分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('64', 'Admin', 'admin_url', 'admin/slidecat/edit', null, '编辑分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('65', 'Admin', 'admin_url', 'admin/slidecat/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('66', 'Admin', 'admin_url', 'admin/slidecat/add', null, '添加分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('67', 'Admin', 'admin_url', 'admin/slidecat/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('68', 'Admin', 'admin_url', 'admin/ad/index', null, '网站广告', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('69', 'Admin', 'admin_url', 'admin/ad/toggle', null, '广告显示切换', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('70', 'Admin', 'admin_url', 'admin/ad/delete', null, '删除广告', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('71', 'Admin', 'admin_url', 'admin/ad/edit', null, '编辑广告', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('72', 'Admin', 'admin_url', 'admin/ad/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('73', 'Admin', 'admin_url', 'admin/ad/add', null, '添加广告', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('74', 'Admin', 'admin_url', 'admin/ad/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('75', 'Admin', 'admin_url', 'admin/link/index', null, '友情链接', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('76', 'Admin', 'admin_url', 'admin/link/listorders', null, '友情链接排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('77', 'Admin', 'admin_url', 'admin/link/toggle', null, '友链显示切换', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('78', 'Admin', 'admin_url', 'admin/link/delete', null, '删除友情链接', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('79', 'Admin', 'admin_url', 'admin/link/edit', null, '编辑友情链接', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('80', 'Admin', 'admin_url', 'admin/link/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('81', 'Admin', 'admin_url', 'admin/link/add', null, '添加友情链接', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('82', 'Admin', 'admin_url', 'admin/link/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('83', 'Api', 'admin_url', 'api/oauthadmin/setting', null, '第三方登陆', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('84', 'Api', 'admin_url', 'api/oauthadmin/setting_post', null, '提交设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('85', 'Admin', 'admin_url', 'admin/menu/default', null, '菜单管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('86', 'Admin', 'admin_url', 'admin/navcat/default1', null, '前台菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('87', 'Admin', 'admin_url', 'admin/nav/index', null, '菜单管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('88', 'Admin', 'admin_url', 'admin/nav/listorders', null, '前台导航排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('89', 'Admin', 'admin_url', 'admin/nav/delete', null, '删除菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('90', 'Admin', 'admin_url', 'admin/nav/edit', null, '编辑菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('91', 'Admin', 'admin_url', 'admin/nav/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('92', 'Admin', 'admin_url', 'admin/nav/add', null, '添加菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('93', 'Admin', 'admin_url', 'admin/nav/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('94', 'Admin', 'admin_url', 'admin/navcat/index', null, '菜单分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('95', 'Admin', 'admin_url', 'admin/navcat/delete', null, '删除分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('96', 'Admin', 'admin_url', 'admin/navcat/edit', null, '编辑分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('97', 'Admin', 'admin_url', 'admin/navcat/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('98', 'Admin', 'admin_url', 'admin/navcat/add', null, '添加分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('99', 'Admin', 'admin_url', 'admin/navcat/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('100', 'Admin', 'admin_url', 'admin/menu/index', null, '菜单列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('101', 'Admin', 'admin_url', 'admin/menu/add', null, '添加菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('102', 'Admin', 'admin_url', 'admin/menu/add_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('103', 'Admin', 'admin_url', 'admin/menu/listorders', null, '后台菜单排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('104', 'Admin', 'admin_url', 'admin/menu/export_menu', null, '菜单备份', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('105', 'Admin', 'admin_url', 'admin/menu/edit', null, '编辑菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('106', 'Admin', 'admin_url', 'admin/menu/edit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('107', 'Admin', 'admin_url', 'admin/menu/delete', null, '删除菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('108', 'Admin', 'admin_url', 'admin/menu/lists', null, '所有菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('109', 'Admin', 'admin_url', 'admin/setting/default', null, '设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('110', 'Admin', 'admin_url', 'admin/setting/userdefault', null, '个人信息', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('111', 'Admin', 'admin_url', 'admin/user/userinfo', null, '修改信息', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('112', 'Admin', 'admin_url', 'admin/user/userinfo_post', null, '修改信息提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('113', 'Admin', 'admin_url', 'admin/setting/password', null, '修改密码', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('114', 'Admin', 'admin_url', 'admin/setting/password_post', null, '提交修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('115', 'Admin', 'admin_url', 'admin/setting/site', null, '网站设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('116', 'Admin', 'admin_url', 'admin/setting/site_post', null, '提交修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('117', 'Admin', 'admin_url', 'admin/route/index', null, '路由列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('118', 'Admin', 'admin_url', 'admin/route/add', null, '路由添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('119', 'Admin', 'admin_url', 'admin/route/add_post', null, '路由添加提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('120', 'Admin', 'admin_url', 'admin/route/edit', null, '路由编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('121', 'Admin', 'admin_url', 'admin/route/edit_post', null, '路由编辑提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('122', 'Admin', 'admin_url', 'admin/route/delete', null, '路由删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('123', 'Admin', 'admin_url', 'admin/route/ban', null, '路由禁止', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('124', 'Admin', 'admin_url', 'admin/route/open', null, '路由启用', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('125', 'Admin', 'admin_url', 'admin/route/listorders', null, '路由排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('126', 'Admin', 'admin_url', 'admin/mailer/default', null, '邮箱配置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('127', 'Admin', 'admin_url', 'admin/mailer/index', null, 'SMTP配置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('128', 'Admin', 'admin_url', 'admin/mailer/index_post', null, '提交配置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('129', 'Admin', 'admin_url', 'admin/mailer/active', null, '注册邮件模板', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('130', 'Admin', 'admin_url', 'admin/mailer/active_post', null, '提交模板', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('131', 'Admin', 'admin_url', 'admin/setting/clearcache', null, '清除缓存', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('132', 'User', 'admin_url', 'user/indexadmin/default', null, '用户管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('133', 'User', 'admin_url', 'user/indexadmin/default1', null, '用户组', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('134', 'User', 'admin_url', 'user/indexadmin/index', null, '所有用户列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('135', 'User', 'admin_url', 'user/indexadmin/ban', null, '拉黑会员', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('136', 'User', 'admin_url', 'user/indexadmin/cancelban', null, '启用会员', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('137', 'User', 'admin_url', 'user/oauthadmin/index', null, '第三方用户', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('138', 'User', 'admin_url', 'user/oauthadmin/delete', null, '第三方用户解绑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('139', 'User', 'admin_url', 'user/indexadmin/default3', null, '管理组', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('140', 'Admin', 'admin_url', 'admin/rbac/index', null, '角色管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('141', 'Admin', 'admin_url', 'admin/rbac/member', null, '成员管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('142', 'Admin', 'admin_url', 'admin/rbac/authorize', null, '权限设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('143', 'Admin', 'admin_url', 'admin/rbac/authorize_post', null, '提交设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('144', 'Admin', 'admin_url', 'admin/rbac/roleedit', null, '编辑角色', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('145', 'Admin', 'admin_url', 'admin/rbac/roleedit_post', null, '提交编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('146', 'Admin', 'admin_url', 'admin/rbac/roledelete', null, '删除角色', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('147', 'Admin', 'admin_url', 'admin/rbac/roleadd', null, '添加角色', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('148', 'Admin', 'admin_url', 'admin/rbac/roleadd_post', null, '提交添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('149', 'Admin', 'admin_url', 'admin/user/index', null, '管理员', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('150', 'Admin', 'admin_url', 'admin/user/delete', null, '删除管理员', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('151', 'Admin', 'admin_url', 'admin/user/edit', null, '管理员编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('152', 'Admin', 'admin_url', 'admin/user/edit_post', null, '编辑提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('153', 'Admin', 'admin_url', 'admin/user/add', null, '管理员添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('154', 'Admin', 'admin_url', 'admin/user/add_post', null, '添加提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('155', 'Admin', 'admin_url', 'admin/plugin/update', null, '插件更新', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('156', 'Admin', 'admin_url', 'admin/storage/index', null, '文件存储', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('157', 'Admin', 'admin_url', 'admin/storage/setting_post', null, '文件存储设置提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('158', 'Admin', 'admin_url', 'admin/slide/ban', null, '禁用幻灯片', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('159', 'Admin', 'admin_url', 'admin/slide/cancelban', null, '启用幻灯片', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('160', 'Admin', 'admin_url', 'admin/user/ban', null, '禁用管理员', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('161', 'Admin', 'admin_url', 'admin/user/cancelban', null, '启用管理员', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('162', 'Demo', 'admin_url', 'demo/adminindex/index', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('163', 'Demo', 'admin_url', 'demo/adminindex/last', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('166', 'Admin', 'admin_url', 'admin/mailer/test', null, '测试邮件', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('167', 'Admin', 'admin_url', 'admin/setting/upload', null, '上传设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('168', 'Admin', 'admin_url', 'admin/setting/upload_post', null, '上传设置提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('169', 'Portal', 'admin_url', 'portal/adminpost/copy', null, '文章批量复制', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('170', 'Admin', 'admin_url', 'admin/menu/backup_menu', null, '备份菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('171', 'Admin', 'admin_url', 'admin/menu/export_menu_lang', null, '导出后台菜单多语言包', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('172', 'Admin', 'admin_url', 'admin/menu/restore_menu', null, '还原菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('173', 'Admin', 'admin_url', 'admin/menu/getactions', null, '导入新菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('174', 'Admin', 'admin_url', 'admin/test/default', null, '测试菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('175', 'Admin', 'admin_url', 'admin/test/default1', null, '测试一级', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('176', 'Admin', 'admin_url', 'admin/test/index', null, '测试首页', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('177', 'Admin', 'admin_url', 'admin/index/default1', null, '后台管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('178', 'Admin', 'admin_url', 'admin/organization/index', null, '组织架构', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('179', 'Admin', 'admin_url', 'admin/organization/delete', null, '组织删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('188', 'Admin', 'admin_url', 'admin/articlecate/edit', null, '分类编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('180', 'Admin', 'admin_url', 'admin/article/default', null, '资讯管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('181', 'Admin', 'admin_url', 'admin/article/main', null, '综合管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('182', 'Admin', 'admin_url', 'admin/articlecate/index', null, '分类列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('183', 'Admin', 'admin_url', 'admin/articlecate/add', null, '分类添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('184', 'Admin', 'admin_url', 'admin/articlecate/add_post', null, '分类添加提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('185', 'Admin', 'admin_url', 'admin/organization/update', null, '会员表更新', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('186', 'Admin', 'admin_url', 'admin/organization/findchildids', null, '寻找子节点', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('187', 'Admin', 'admin_url', 'admin/organization/listorders', null, '组织排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('189', 'Admin', 'admin_url', 'admin/articlecate/edit_post', null, '分类编辑提交', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('190', 'Admin', 'admin_url', 'admin/articlecate/delete', null, '分类删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('191', 'Admin', 'admin_url', 'admin/articlecate/setstatus', null, '分类设置状态', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('192', 'Admin', 'admin_url', 'admin/articlecate/sort_order', null, '分类排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('193', 'Admin', 'admin_url', 'admin/articlecate/status', null, '分类修改字段', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('194', 'Admin', 'admin_url', 'admin/articlecate/add_all', null, '分类快速添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('195', 'Admin', 'admin_url', 'admin/article/index', null, '文章列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('196', 'Admin', 'admin_url', 'admin/article/cate', null, '文章菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('197', 'Admin', 'admin_url', 'admin/article/add', null, '文章添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('198', 'Admin', 'admin_url', 'admin/article/edit', null, '文章编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('199', 'Admin', 'admin_url', 'admin/article/delete', null, '文章删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('200', 'Admin', 'admin_url', 'admin/article/display_tree', null, 'display_tree', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('201', 'Admin', 'admin_url', 'admin/article/status', null, '文章状态修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('202', 'Admin', 'admin_url', 'admin/articlecate/update_num', null, '更新资讯数', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('203', 'Admin', 'admin_url', 'admin/article/test', null, 'test', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('204', 'Admin', 'admin_url', 'admin/organization/add', null, '党组织添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('205', 'Admin', 'admin_url', 'admin/organization/edit', null, '党组织编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('206', 'Admin', 'admin_url', 'admin/organization/geichilds', null, 'geiChilds', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('207', 'Admin', 'admin_url', 'admin/organization/status', null, 'status', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('208', 'Admin', 'admin_url', 'admin/setting/contact', null, '网站信息', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('209', 'Admin', 'admin_url', 'admin/organization/finddistrict', null, 'findDistrict', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('210', 'Admin', 'admin_url', 'admin/article/zytg', null, '重要通告', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('211', 'User', 'admin_url', 'user/adminuser/main', null, '用户列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('212', 'Admin', 'admin_url', 'admin/mallcate/index', null, '产品分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('213', 'Admin', 'admin_url', 'admin/mallcate/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('214', 'Admin', 'admin_url', 'admin/mallcate/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('215', 'Admin', 'admin_url', 'admin/mallcate/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('216', 'Admin', 'admin_url', 'admin/mallcate/sort_order', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('217', 'Admin', 'admin_url', 'admin/mallcate/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('218', 'Admin', 'admin_url', 'admin/mallcate/add_all', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('219', 'Admin', 'admin_url', 'admin/mall/index', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('220', 'Admin', 'admin_url', 'admin/mall/main', null, '产品综合', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('221', 'Admin', 'admin_url', 'admin/mall/cate', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('222', 'Admin', 'admin_url', 'admin/mall/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('223', 'Admin', 'admin_url', 'admin/mall/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('224', 'Admin', 'admin_url', 'admin/mall/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('225', 'Admin', 'admin_url', 'admin/mall/display_tree', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('226', 'Admin', 'admin_url', 'admin/mall/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('227', 'Admin', 'admin_url', 'admin/mall/update_num', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('228', 'Admin', 'admin_url', 'admin/mall/zytg', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('229', 'Admin', 'admin_url', 'admin/menu/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('230', 'Admin', 'admin_url', 'admin/mall/dafault', null, '产品管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('231', 'Admin', 'admin_url', 'admin/video/menu1', null, '办公议事中心', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('232', 'Admin', 'admin_url', 'admin/video/main', null, '视频列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('233', 'Admin', 'admin_url', 'admin/video/main2', null, '微型党课', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('234', 'Admin', 'admin_url', 'admin/book/index', null, '党建书店', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('235', 'Admin', 'admin_url', 'admin/video/main3', null, '推荐资源', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('236', 'Admin', 'admin_url', 'admin/nav/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('237', 'Admin', 'admin_url', 'admin/portalcate/index', null, '资讯分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('238', 'Admin', 'admin_url', 'admin/portalcate/add', null, '分类添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('239', 'Admin', 'admin_url', 'admin/portalcate/edit', null, '分类修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('240', 'Admin', 'admin_url', 'admin/portalcate/delete', null, '分类删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('241', 'Admin', 'admin_url', 'admin/portalcate/sort_order', null, '分类排序', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('242', 'Admin', 'admin_url', 'admin/portalcate/status', null, '分类状态修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('243', 'Admin', 'admin_url', 'admin/portalcate/add_all', null, '分类快速添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('244', 'Admin', 'admin_url', 'admin/portal/index', null, '列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('245', 'Admin', 'admin_url', 'admin/portal/main', null, '资讯列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('246', 'Admin', 'admin_url', 'admin/portal/cate', null, '菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('247', 'Admin', 'admin_url', 'admin/portal/add', null, '添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('248', 'Admin', 'admin_url', 'admin/portal/edit', null, '编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('249', 'Admin', 'admin_url', 'admin/portal/delete', null, '删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('250', 'Admin', 'admin_url', 'admin/portal/display_tree', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('251', 'Admin', 'admin_url', 'admin/portal/status', null, '状态修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('252', 'Admin', 'admin_url', 'admin/portalcate/update_num', null, '更新资讯数', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('253', 'Admin', 'admin_url', 'admin/videocate/index', null, '视频分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('254', 'Admin', 'admin_url', 'admin/videocate/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('255', 'Admin', 'admin_url', 'admin/videocate/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('256', 'Admin', 'admin_url', 'admin/videocate/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('257', 'Admin', 'admin_url', 'admin/videocate/sort_order', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('258', 'Admin', 'admin_url', 'admin/videocate/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('259', 'Admin', 'admin_url', 'admin/videocate/add_all', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('260', 'User', 'admin_url', 'user/adminuser/cate', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('261', 'User', 'admin_url', 'user/adminuser/ajaxgetorgmenu', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('262', 'User', 'admin_url', 'user/adminuser/index', null, '前台用户列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('263', 'User', 'admin_url', 'user/adminuser/test', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('264', 'User', 'admin_url', 'user/adminuser/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('265', 'User', 'admin_url', 'user/adminuser/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('266', 'Admin', 'admin_url', 'admin/portal/default', null, '文章管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('267', 'Admin', 'admin_url', 'admin/developcate/index', null, '步骤流程', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('268', 'Admin', 'admin_url', 'admin/video/index', null, '视频列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('269', 'Admin', 'admin_url', 'admin/activity/index', null, '活动列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('270', 'Admin', 'admin_url', 'admin/transfer/index', null, '组织转接审核', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('271', 'User', 'admin_url', 'user/adminuser/apply_index', null, '用户注册审核', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('272', 'Admin', 'admin_url', 'admin/talk/index', null, '专题列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('281', 'User', 'admin_url', 'user/adminuser/become_index', null, '党员转正审核', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('282', 'Admin', 'admin_url', 'admin/order/default', null, '订单管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('283', 'Admin', 'admin_url', 'admin/order/waitsendlist', null, '等待发货', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('284', 'Admin', 'admin_url', 'admin/order/index', null, '订单列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('285', 'Admin', 'admin_url', 'admin/order/refundlist', null, '退货列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('286', 'Admin', 'admin_url', 'admin/order/refundmoneylist', null, '退款列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('287', 'Admin', 'admin_url', 'admin/activity/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('288', 'Admin', 'admin_url', 'admin/activity/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('289', 'Admin', 'admin_url', 'admin/activity/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('290', 'Admin', 'admin_url', 'admin/activity/display_tree', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('291', 'Admin', 'admin_url', 'admin/activity/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('292', 'Admin', 'admin_url', 'admin/activityorder/index', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('293', 'Admin', 'admin_url', 'admin/activityorder/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('294', 'Admin', 'admin_url', 'admin/activityorder/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('295', 'Admin', 'admin_url', 'admin/activityorder/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('296', 'Admin', 'admin_url', 'admin/activityorder/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('297', 'Admin', 'admin_url', 'admin/activityorder/cancelsign', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('298', 'Admin', 'admin_url', 'admin/activityorder/sign', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('299', 'Admin', 'admin_url', 'admin/activityorder/leave', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('300', 'Admin', 'admin_url', 'admin/activityorder/updatestatus', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('301', 'Admin', 'admin_url', 'admin/developcate/geichilds', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('302', 'Admin', 'admin_url', 'admin/developcate/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('303', 'Admin', 'admin_url', 'admin/developcate/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('304', 'Admin', 'admin_url', 'admin/developcate/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('305', 'Admin', 'admin_url', 'admin/developcate/upload_file', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('306', 'Admin', 'admin_url', 'admin/developcate/download_file', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('307', 'Admin', 'admin_url', 'admin/developcate/remove_file', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('308', 'Admin', 'admin_url', 'admin/developcate/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('309', 'Admin', 'admin_url', 'admin/mall/prop', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('310', 'Admin', 'admin_url', 'admin/order/agreerefundgoods', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('311', 'Admin', 'admin_url', 'admin/order/agreerefundmoney', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('312', 'Admin', 'admin_url', 'admin/order/alirefund', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('313', 'Admin', 'admin_url', 'admin/order/rejectrefund', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('314', 'Admin', 'admin_url', 'admin/order/sendgoods', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('315', 'Admin', 'admin_url', 'admin/order/showorder', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('316', 'Admin', 'admin_url', 'admin/order/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('317', 'Admin', 'admin_url', 'admin/order/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('318', 'Admin', 'admin_url', 'admin/order/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('319', 'Admin', 'admin_url', 'admin/order/display_tree', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('320', 'Admin', 'admin_url', 'admin/order/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('321', 'Admin', 'admin_url', 'admin/talk/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('322', 'Admin', 'admin_url', 'admin/talk/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('323', 'Admin', 'admin_url', 'admin/talk/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('324', 'Admin', 'admin_url', 'admin/talk/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('325', 'Admin', 'admin_url', 'admin/transfer/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('326', 'Admin', 'admin_url', 'admin/transfer/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('327', 'Admin', 'admin_url', 'admin/transfer/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('328', 'Admin', 'admin_url', 'admin/transfer/apply_check', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('329', 'Admin', 'admin_url', 'admin/transfer/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('330', 'Admin', 'admin_url', 'admin/video/cate', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('331', 'Admin', 'admin_url', 'admin/video/add', null, '添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('332', 'Admin', 'admin_url', 'admin/video/edit', null, '修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('333', 'Admin', 'admin_url', 'admin/video/delete', null, '删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('334', 'Admin', 'admin_url', 'admin/video/display_tree', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('335', 'Admin', 'admin_url', 'admin/video/status', null, '状态修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('336', 'User', 'admin_url', 'user/adminuser/become', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('337', 'User', 'admin_url', 'user/adminuser/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('338', 'User', 'admin_url', 'user/adminuser/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('339', 'Admin', 'admin_url', 'admin/category/default', null, '类型管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('340', 'Admin', 'admin_url', 'admin/category/index', null, '类型列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('341', 'Admin', 'admin_url', 'admin/categorytype/index', null, '类型分类', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('342', 'Admin', 'admin_url', 'admin/category/add', null, '类型添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('343', 'Admin', 'admin_url', 'admin/category/edit', null, '类型编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('344', 'Admin', 'admin_url', 'admin/category/status', null, '类型状态修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('345', 'Admin', 'admin_url', 'admin/category/delete', null, '类型删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('346', 'Admin', 'admin_url', 'admin/categorytype/add', null, '分类添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('347', 'Admin', 'admin_url', 'admin/categorytype/edit', null, '分类编辑', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('348', 'Admin', 'admin_url', 'admin/categorytype/status', null, '分类状态修改', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('349', 'Admin', 'admin_url', 'admin/categorytype/delete', null, '分类删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('350', 'Admin', 'admin_url', 'admin/order/alipaymobilerefund', null, 'alipayMobileRefund', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('351', 'Admin', 'admin_url', 'admin/whitelist/site', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('352', 'Admin', 'admin_url', 'admin/whitelist/site_post', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('353', 'Admin', 'admin_url', 'admin/whitelist/password', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('354', 'Admin', 'admin_url', 'admin/whitelist/password_post', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('355', 'Admin', 'admin_url', 'admin/whitelist/upload', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('356', 'Admin', 'admin_url', 'admin/whitelist/upload_post', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('357', 'Admin', 'admin_url', 'admin/whitelist/clearcache', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('358', 'Admin', 'admin_url', 'admin/whitelist/contact', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('359', 'Admin', 'admin_url', 'admin/simplepage/default', null, '单页管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('360', 'Admin', 'admin_url', 'admin/simplepage/index', null, '单页列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('361', 'Admin', 'admin_url', 'admin/form/default', null, '表单管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('362', 'Admin', 'admin_url', 'admin/form/index', null, '表单列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('363', 'Admin', 'admin_url', 'admin/apply/index', null, '廉政投诉', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('364', 'Admin', 'admin_url', 'admin/apply/delete', null, '删除', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('365', 'Admin', 'admin_url', 'admin/apply/show', null, '详情查看', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('366', 'Admin', 'admin_url', 'admin/article/autoload', null, '批量添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('367', 'Admin', 'admin_url', 'admin/mall/autoload', null, '批量添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('368', 'Admin', 'admin_url', 'admin/nav/add_all', null, '批量添加', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('369', 'Admin', 'admin_url', 'admin/video/default', null, '党建视频', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('370', 'User', 'admin_url', 'user/adminuser/tax_list', null, '党费缴纳', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('371', 'User', 'admin_url', 'user/adminuser/tax_show', null, '党员缴费详细', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('372', 'Admin', 'admin_url', 'admin/menu/default1', null, '后台菜单', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('373', 'Admin', 'admin_url', 'admin/menu/setting', null, '菜单设置', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('374', 'Admin', 'admin_url', 'admin/menu/commend', null, '菜单推荐', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('375', 'Admin', 'admin_url', 'admin/picture/index', null, '图片管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('376', 'Admin', 'admin_url', 'admin/database/index', null, '备份管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('377', 'Admin', 'admin_url', 'admin/database/optimize', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('378', 'Admin', 'admin_url', 'admin/database/repair', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('379', 'Admin', 'admin_url', 'admin/database/del', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('380', 'Admin', 'admin_url', 'admin/database/export', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('381', 'Admin', 'admin_url', 'admin/database/import', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('382', 'Admin', 'admin_url', 'admin/menu/display_menu', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('383', 'Admin', 'admin_url', 'admin/picture/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('384', 'Admin', 'admin_url', 'admin/sheetcate/index', null, '表单列表', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('385', 'Admin', 'admin_url', 'admin/sheetcate/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('386', 'Admin', 'admin_url', 'admin/sheetcate/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('387', 'Admin', 'admin_url', 'admin/sheetcate/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('388', 'Admin', 'admin_url', 'admin/sheetcate/sort_order', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('389', 'Admin', 'admin_url', 'admin/sheetcate/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('390', 'Admin', 'admin_url', 'admin/sheetcate/add_all', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('391', 'Admin', 'admin_url', 'admin/sheetcate/design', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('392', 'Admin', 'admin_url', 'admin/sheetcate/edit_field', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('393', 'Admin', 'admin_url', 'admin/sheetcate/add_field', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('394', 'Admin', 'admin_url', 'admin/sheetcate/delete_field', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('395', 'Admin', 'admin_url', 'admin/sheet/index', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('396', 'Admin', 'admin_url', 'admin/sheet/main', null, '表单管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('397', 'Admin', 'admin_url', 'admin/sheet/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('398', 'Admin', 'admin_url', 'admin/sheet/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('399', 'Admin', 'admin_url', 'admin/sheet/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('400', 'Admin', 'admin_url', 'admin/sheet/loadout', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('401', 'Admin', 'admin_url', 'admin/sheet/loadin', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('402', 'Admin', 'admin_url', 'admin/sheet/get_tmpl', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('403', 'Admin', 'admin_url', 'admin/sheettmpl/index', null, '表单模版', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('404', 'Admin', 'admin_url', 'admin/sheettmpl/add', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('405', 'Admin', 'admin_url', 'admin/sheettmpl/edit', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('406', 'Admin', 'admin_url', 'admin/sheettmpl/delete', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('407', 'Admin', 'admin_url', 'admin/sheettmpl/status', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('408', 'Admin', 'admin_url', 'admin/sheettmpl/edit_field', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('409', 'Admin', 'admin_url', 'admin/sheettmpl/add_field', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('410', 'Admin', 'admin_url', 'admin/sheettmpl/delete_field', null, '', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('411', 'Admin', 'admin_url', 'admin/database/default', null, '备份管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('412', 'Admin', 'admin_url', 'admin/sheet/default', null, '表单管理', '1', '');
INSERT INTO `jc_auth_rule` VALUES ('413', 'Admin', 'admin_url', 'admin/article/default2', null, '文章管理', '1', '');

-- ----------------------------
-- Table structure for jc_category
-- ----------------------------
DROP TABLE IF EXISTS `jc_category`;
CREATE TABLE `jc_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kid` int(10) NOT NULL,
  `type_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `alias_template` varchar(255) DEFAULT NULL,
  `pid` int(10) NOT NULL DEFAULT '0',
  `parentspath` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '1',
  `sort_order` int(10) NOT NULL DEFAULT '0',
  `record_nums` int(10) NOT NULL DEFAULT '0',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  `img` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `abst` text,
  `info` text,
  `remark` text,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kid-type` (`kid`,`type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1091 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_category
-- ----------------------------
INSERT INTO `jc_category` VALUES ('1001', '1', '1', '博士', 'doctor', '', '', '0', '0,', '1', '0', '0', null, null, null, '0', null, null, null, null, '', '', null, '2017-02-20 15:08:55', '2017-07-04 09:42:15');
INSERT INTO `jc_category` VALUES ('1002', '2', '1', '硕士', '', '', '', '0', '0,', '1', '0', '0', null, null, null, '', null, null, null, null, '', null, null, '2017-02-20 15:09:01', '2017-02-20 15:09:01');
INSERT INTO `jc_category` VALUES ('1003', '3', '1', '本科', '', '', '', '0', '0,', '1', '0', '0', null, null, null, '', null, null, null, null, '', null, null, '2017-02-20 15:09:06', '2017-02-20 15:09:06');
INSERT INTO `jc_category` VALUES ('1004', '4', '1', '大专', '', '', '', '0', '0,', '1', '0', '0', null, null, null, '', null, null, null, null, '', null, null, '2017-02-20 15:09:11', '2017-03-15 10:14:24');
INSERT INTO `jc_category` VALUES ('1005', '5', '1', '中专', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, '2017-02-20 15:09:11', '2017-02-20 15:09:11');
INSERT INTO `jc_category` VALUES ('1006', '6', '1', '高中', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, '2017-02-20 15:09:11', '2017-02-20 15:09:11');
INSERT INTO `jc_category` VALUES ('1007', '7', '1', '初中', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, '2017-02-20 15:09:11', '2017-02-20 15:09:11');
INSERT INTO `jc_category` VALUES ('1008', '8', '1', '小学', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, '2017-02-20 15:09:11', '2017-02-20 15:09:11');
INSERT INTO `jc_category` VALUES ('1009', '9', '1', '文盲', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, '2017-02-20 15:09:11', '2017-02-20 15:09:11');
INSERT INTO `jc_category` VALUES ('1010', '10', '1', '中技', '', '', '', '0', '0,', '1', '0', '0', null, null, null, '', null, null, null, null, '', '', null, '2017-02-20 15:09:11', '2017-07-04 10:43:14');
INSERT INTO `jc_category` VALUES ('1011', '1', '2', '汉族', null, null, null, '0', '0,', '1', '1', '0', null, null, null, null, null, null, '1', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1012', '2', '2', '蒙古族', null, null, null, '0', '0,', '1', '2', '0', null, null, null, null, null, null, '2', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1013', '3', '2', '回族', null, null, null, '0', '0,', '1', '3', '0', null, null, null, null, null, null, '3', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1014', '4', '2', '藏族', null, null, null, '0', '0,', '1', '4', '0', null, null, null, null, null, null, '4', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1015', '5', '2', '维吾尔族', null, null, null, '0', '0,', '1', '5', '0', null, null, null, null, null, null, '5', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1016', '6', '2', '苗族', null, null, null, '0', '0,', '1', '6', '0', null, null, null, null, null, null, '6', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1017', '7', '2', '彝族', null, null, null, '0', '0,', '1', '7', '0', null, null, null, null, null, null, '7', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1018', '8', '2', '壮族', null, null, null, '0', '0,', '1', '8', '0', null, null, null, null, null, null, '8', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1019', '9', '2', '布依族', null, null, null, '0', '0,', '1', '9', '0', null, null, null, null, null, null, '9', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1020', '10', '2', '朝鲜族', null, null, null, '0', '0,', '1', '10', '0', null, null, null, null, null, null, '10', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1021', '11', '2', '满族', null, null, null, '0', '0,', '1', '11', '0', null, null, null, null, null, null, '11', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1022', '12', '2', '侗族', null, null, null, '0', '0,', '1', '12', '0', null, null, null, null, null, null, '12', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1023', '13', '2', '瑶族', null, null, null, '0', '0,', '1', '13', '0', null, null, null, null, null, null, '13', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1024', '14', '2', '白族', null, null, null, '0', '0,', '1', '14', '0', null, null, null, null, null, null, '14', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1025', '15', '2', '土家族', null, null, null, '0', '0,', '1', '15', '0', null, null, null, null, null, null, '15', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1026', '16', '2', '哈尼族', null, null, null, '0', '0,', '1', '16', '0', null, null, null, null, null, null, '16', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1027', '17', '2', '哈萨克族', null, null, null, '0', '0,', '1', '17', '0', null, null, null, null, null, null, '17', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1028', '18', '2', '傣族', null, null, null, '0', '0,', '1', '18', '0', null, null, null, null, null, null, '18', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1029', '19', '2', '黎族', null, null, null, '0', '0,', '1', '19', '0', null, null, null, null, null, null, '19', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1030', '20', '2', '傈僳族', null, null, null, '0', '0,', '1', '20', '0', null, null, null, null, null, null, '20', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1031', '21', '2', '佤族', null, null, null, '0', '0,', '1', '21', '0', null, null, null, null, null, null, '21', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1032', '22', '2', '畲族', null, null, null, '0', '0,', '1', '22', '0', null, null, null, null, null, null, '22', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1033', '23', '2', '高山族', null, null, null, '0', '0,', '1', '23', '0', null, null, null, null, null, null, '23', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1034', '24', '2', '拉祜族', null, null, null, '0', '0,', '1', '24', '0', null, null, null, null, null, null, '24', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1035', '25', '2', '水族', null, null, null, '0', '0,', '1', '25', '0', null, null, null, null, null, null, '25', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1036', '26', '2', '东乡族', null, null, null, '0', '0,', '1', '26', '0', null, null, null, null, null, null, '26', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1037', '27', '2', '纳西族', null, null, null, '0', '0,', '1', '27', '0', null, null, null, null, null, null, '27', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1038', '28', '2', '景颇族', null, null, null, '0', '0,', '1', '28', '0', null, null, null, null, null, null, '28', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1039', '29', '2', '柯尔克孜族', null, null, null, '0', '0,', '1', '29', '0', null, null, null, null, null, null, '29', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1040', '30', '2', '土族', null, null, null, '0', '0,', '1', '30', '0', null, null, null, null, null, null, '30', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1041', '31', '2', '达斡尔族', null, null, null, '0', '0,', '1', '31', '0', null, null, null, null, null, null, '31', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1042', '32', '2', '仫佬族', null, null, null, '0', '0,', '1', '32', '0', null, null, null, null, null, null, '32', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1043', '33', '2', '羌族', null, null, null, '0', '0,', '1', '33', '0', null, null, null, null, null, null, '33', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1044', '34', '2', '布朗族', null, null, null, '0', '0,', '1', '34', '0', null, null, null, null, null, null, '34', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1045', '35', '2', '撒拉族', null, null, null, '0', '0,', '1', '35', '0', null, null, null, null, null, null, '35', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1046', '36', '2', '毛南族', null, null, null, '0', '0,', '1', '36', '0', null, null, null, null, null, null, '36', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1047', '37', '2', '仡佬族', null, null, null, '0', '0,', '1', '37', '0', null, null, null, null, null, null, '37', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1048', '38', '2', '锡伯族', null, null, null, '0', '0,', '1', '38', '0', null, null, null, null, null, null, '38', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1049', '39', '2', '阿昌族', null, null, null, '0', '0,', '1', '39', '0', null, null, null, null, null, null, '39', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1050', '40', '2', '普米族', null, null, null, '0', '0,', '1', '40', '0', null, null, null, null, null, null, '40', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1051', '41', '2', '塔吉克族', null, null, null, '0', '0,', '1', '41', '0', null, null, null, null, null, null, '41', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1052', '42', '2', '怒族', null, null, null, '0', '0,', '1', '42', '0', null, null, null, null, null, null, '42', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1053', '43', '2', '乌孜别克族', null, null, null, '0', '0,', '1', '43', '0', null, null, null, null, null, null, '43', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1054', '44', '2', '俄罗斯族', null, null, null, '0', '0,', '1', '44', '0', null, null, null, null, null, null, '44', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1055', '45', '2', '鄂温克族', null, null, null, '0', '0,', '1', '45', '0', null, null, null, null, null, null, '45', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1056', '46', '2', '德昂族', null, null, null, '0', '0,', '1', '46', '0', null, null, null, null, null, null, '46', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1057', '47', '2', '保安族', null, null, null, '0', '0,', '1', '47', '0', null, null, null, null, null, null, '47', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1058', '48', '2', '裕固族', null, null, null, '0', '0,', '1', '48', '0', null, null, null, null, null, null, '48', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1059', '49', '2', '京族', null, null, null, '0', '0,', '1', '49', '0', null, null, null, null, null, null, '49', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1060', '50', '2', '塔塔尔族', null, null, null, '0', '0,', '1', '50', '0', null, null, null, null, null, null, '50', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1061', '51', '2', '独龙族', null, null, null, '0', '0,', '1', '51', '0', null, null, null, null, null, null, '51', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1062', '52', '2', '鄂伦春族', null, null, null, '0', '0,', '1', '52', '0', null, null, null, null, null, null, '52', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1063', '53', '2', '赫哲族', null, null, null, '0', '0,', '1', '53', '0', null, null, null, null, null, null, '53', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1064', '54', '2', '门巴族', null, null, null, '0', '0,', '1', '54', '0', null, null, null, null, null, null, '54', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1065', '55', '2', '珞巴族', null, null, null, '0', '0,', '1', '55', '0', null, null, null, null, null, null, '55', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1066', '56', '2', '基诺族', null, null, null, '0', '0,', '1', '56', '0', null, null, null, null, null, null, '56', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1067', '57', '2', '其他', null, null, null, '0', '0,', '1', '57', '0', null, null, null, null, null, null, '57', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1068', '58', '2', '外国血统', null, null, null, '0', '0,', '1', '58', '0', null, null, null, null, null, null, '58', null, null, null, null, '2017-02-20 15:09:11', null);
INSERT INTO `jc_category` VALUES ('1070', '1', '3', '服饰内衣', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1071', '2', '3', '美容彩妆', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1072', '3', '3', '鞋包配饰', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1073', '4', '3', '母婴用品', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1074', '5', '3', '日用百货', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1075', '6', '3', '食品保健', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1076', '7', '3', '珠宝手表', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1077', '8', '3', '3C数码', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1078', '9', '3', '家居家纺', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1079', '10', '3', '家电办公', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1080', '11', '3', '家具建材', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1081', '12', '3', '汽车摩托', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1082', '13', '3', '户外运动', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1083', '14', '3', '本地生活', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1084', '15', '3', '文化娱乐', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1085', '16', '3', '玩乐爱好', null, null, null, '0', '0,', '1', '0', '0', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `jc_category` VALUES ('1088', '19', '3', '计算机', '', '', '', '16', '0,16,', '1', '0', '0', null, null, null, '', null, null, null, null, '', '', null, '2017-02-28 09:27:48', '2017-07-04 09:52:56');
INSERT INTO `jc_category` VALUES ('1089', '20', '3', '台式', '', '', '', '19', '0,16,19,', '1', '0', '0', null, null, null, '', null, null, null, null, '', '', null, '2017-02-28 09:28:46', '2017-07-04 09:49:09');
INSERT INTO `jc_category` VALUES ('1090', '21', '3', '笔记本', '', '', '', '19', '0,16,19,', '1', '0', '0', null, null, null, '', null, null, null, null, '', '', null, '2017-02-28 09:28:52', '2017-07-04 10:44:59');

-- ----------------------------
-- Table structure for jc_category_type
-- ----------------------------
DROP TABLE IF EXISTS `jc_category_type`;
CREATE TABLE `jc_category_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `label` varchar(255) NOT NULL COMMENT '分类标识',
  `remark` text COMMENT '分类备注',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`id`),
  KEY `cat_idname` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='幻灯片分类表';

-- ----------------------------
-- Records of jc_category_type
-- ----------------------------
INSERT INTO `jc_category_type` VALUES ('1', '学历分类', 'degree', '', '1');
INSERT INTO `jc_category_type` VALUES ('2', '民族分类', 'nation', '', '1');
INSERT INTO `jc_category_type` VALUES ('3', '商品类型分类', 'product', '', '1');

-- ----------------------------
-- Table structure for jc_common_action_log
-- ----------------------------
DROP TABLE IF EXISTS `jc_common_action_log`;
CREATE TABLE `jc_common_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) DEFAULT '0' COMMENT '用户id',
  `object` varchar(100) DEFAULT NULL COMMENT '访问对象的id,格式：不带前缀的表名+id;如posts1表示xx_posts表里id为1的记录',
  `action` varchar(50) DEFAULT NULL COMMENT '操作名称；格式规定为：应用名+控制器+操作名；也可自己定义格式只要不发生冲突且惟一；',
  `count` int(11) DEFAULT '0' COMMENT '访问次数',
  `last_time` int(11) DEFAULT '0' COMMENT '最后访问的时间戳',
  `ip` varchar(15) DEFAULT NULL COMMENT '访问者最后访问ip',
  PRIMARY KEY (`id`),
  KEY `user_object_action` (`user`,`object`,`action`),
  KEY `user_object_action_ip` (`user`,`object`,`action`,`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='访问记录表';

-- ----------------------------
-- Records of jc_common_action_log
-- ----------------------------

-- ----------------------------
-- Table structure for jc_default_cate
-- ----------------------------
DROP TABLE IF EXISTS `jc_default_cate`;
CREATE TABLE `jc_default_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `alias_template` varchar(255) NOT NULL,
  `pid` int(10) NOT NULL DEFAULT '0',
  `parentspath` varchar(255) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '0',
  `sort_order` int(4) NOT NULL DEFAULT '0',
  `img` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_default_cate
-- ----------------------------

-- ----------------------------
-- Table structure for jc_file
-- ----------------------------
DROP TABLE IF EXISTS `jc_file`;
CREATE TABLE `jc_file` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `extend_id` int(10) NOT NULL DEFAULT '0',
  `module_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ext` varchar(255) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_file
-- ----------------------------

-- ----------------------------
-- Table structure for jc_form
-- ----------------------------
DROP TABLE IF EXISTS `jc_form`;
CREATE TABLE `jc_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_form
-- ----------------------------

-- ----------------------------
-- Table structure for jc_form_field
-- ----------------------------
DROP TABLE IF EXISTS `jc_form_field`;
CREATE TABLE `jc_form_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `catetype_id` int(11) NOT NULL DEFAULT '0',
  `is_require` tinyint(255) NOT NULL DEFAULT '0',
  `add_time` datetime DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_form_field
-- ----------------------------

-- ----------------------------
-- Table structure for jc_good_attr
-- ----------------------------
DROP TABLE IF EXISTS `jc_good_attr`;
CREATE TABLE `jc_good_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_id` varchar(255) DEFAULT NULL,
  `property` varchar(255) DEFAULT NULL,
  `property_value` varchar(255) DEFAULT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_good_attr
-- ----------------------------
INSERT INTO `jc_good_attr` VALUES ('1', '1', '2', '52', '0');
INSERT INTO `jc_good_attr` VALUES ('2', '1', '2', '53', '0');

-- ----------------------------
-- Table structure for jc_good_property
-- ----------------------------
DROP TABLE IF EXISTS `jc_good_property`;
CREATE TABLE `jc_good_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_good_property
-- ----------------------------
INSERT INTO `jc_good_property` VALUES ('1', '颜色');
INSERT INTO `jc_good_property` VALUES ('2', '尺寸');
INSERT INTO `jc_good_property` VALUES ('3', '种类');
INSERT INTO `jc_good_property` VALUES ('4', '套件');
INSERT INTO `jc_good_property` VALUES ('5', '规格');
INSERT INTO `jc_good_property` VALUES ('6', '容量');
INSERT INTO `jc_good_property` VALUES ('7', '电池');

-- ----------------------------
-- Table structure for jc_good_property_value
-- ----------------------------
DROP TABLE IF EXISTS `jc_good_property_value`;
CREATE TABLE `jc_good_property_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_good_property_value
-- ----------------------------
INSERT INTO `jc_good_property_value` VALUES ('1', '红色');
INSERT INTO `jc_good_property_value` VALUES ('2', '黑色');
INSERT INTO `jc_good_property_value` VALUES ('3', '绿色');
INSERT INTO `jc_good_property_value` VALUES ('4', '蓝色');
INSERT INTO `jc_good_property_value` VALUES ('6', 'L');
INSERT INTO `jc_good_property_value` VALUES ('7', 'M');
INSERT INTO `jc_good_property_value` VALUES ('8', 'S');
INSERT INTO `jc_good_property_value` VALUES ('9', 'XL');
INSERT INTO `jc_good_property_value` VALUES ('10', '男士');
INSERT INTO `jc_good_property_value` VALUES ('11', '女士');
INSERT INTO `jc_good_property_value` VALUES ('13', '紫色');
INSERT INTO `jc_good_property_value` VALUES ('14', '测试');
INSERT INTO `jc_good_property_value` VALUES ('15', '不测试');
INSERT INTO `jc_good_property_value` VALUES ('26', 'XXL');
INSERT INTO `jc_good_property_value` VALUES ('30', '黄色');
INSERT INTO `jc_good_property_value` VALUES ('31', '大');
INSERT INTO `jc_good_property_value` VALUES ('32', '小');
INSERT INTO `jc_good_property_value` VALUES ('33', 'XXXL');
INSERT INTO `jc_good_property_value` VALUES ('34', '七彩印花');
INSERT INTO `jc_good_property_value` VALUES ('35', '豹纹');
INSERT INTO `jc_good_property_value` VALUES ('36', '迷彩蓝');
INSERT INTO `jc_good_property_value` VALUES ('37', '上衣');
INSERT INTO `jc_good_property_value` VALUES ('38', '下衣');
INSERT INTO `jc_good_property_value` VALUES ('44', 'X');
INSERT INTO `jc_good_property_value` VALUES ('48', '500');
INSERT INTO `jc_good_property_value` VALUES ('49', '600');
INSERT INTO `jc_good_property_value` VALUES ('50', '七号');
INSERT INTO `jc_good_property_value` VALUES ('51', '五号');
INSERT INTO `jc_good_property_value` VALUES ('52', '12');
INSERT INTO `jc_good_property_value` VALUES ('53', '13');

-- ----------------------------
-- Table structure for jc_good_sku
-- ----------------------------
DROP TABLE IF EXISTS `jc_good_sku`;
CREATE TABLE `jc_good_sku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_id` varchar(255) DEFAULT NULL,
  `properies` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_good_sku
-- ----------------------------
INSERT INTO `jc_good_sku` VALUES ('1', '1', '2:52', '0.01', '1000');
INSERT INTO `jc_good_sku` VALUES ('2', '1', '2:53', '0.01', '1200');

-- ----------------------------
-- Table structure for jc_guestbook
-- ----------------------------
DROP TABLE IF EXISTS `jc_guestbook`;
CREATE TABLE `jc_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) DEFAULT NULL COMMENT '留言者姓名',
  `tel` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL COMMENT '留言者邮箱',
  `address` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '留言标题',
  `msg` text COMMENT '留言内容',
  `createtime` datetime DEFAULT NULL COMMENT '留言时间',
  `status` smallint(2) NOT NULL DEFAULT '1' COMMENT '留言状态，1：正常，0：删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='留言表';

-- ----------------------------
-- Records of jc_guestbook
-- ----------------------------
INSERT INTO `jc_guestbook` VALUES ('4', 'test', '111', '111', '446107014@qq.com', 'test', 'test', 'test', '2017-06-26 15:54:12', '1');
INSERT INTO `jc_guestbook` VALUES ('5', 'dsad', 'dsad', 'dsa', 'dsa', 'dsa', 'dsa', 'dsa', null, '1');

-- ----------------------------
-- Table structure for jc_images
-- ----------------------------
DROP TABLE IF EXISTS `jc_images`;
CREATE TABLE `jc_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ext` varchar(255) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `bg_color` varchar(60) DEFAULT '#FFFFFF',
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_images
-- ----------------------------

-- ----------------------------
-- Table structure for jc_links
-- ----------------------------
DROP TABLE IF EXISTS `jc_links`;
CREATE TABLE `jc_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL COMMENT '友情链接地址',
  `link_name` varchar(255) NOT NULL COMMENT '友情链接名称',
  `link_image` varchar(255) DEFAULT NULL COMMENT '友情链接图标',
  `link_target` varchar(25) NOT NULL DEFAULT '_blank' COMMENT '友情链接打开方式',
  `link_description` text NOT NULL COMMENT '友情链接描述',
  `link_status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  `link_rating` int(11) NOT NULL DEFAULT '0' COMMENT '友情链接评级',
  `link_rel` varchar(255) DEFAULT NULL COMMENT '链接与网站的关系',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of jc_links
-- ----------------------------

-- ----------------------------
-- Table structure for jc_mall
-- ----------------------------
DROP TABLE IF EXISTS `jc_mall`;
CREATE TABLE `jc_mall` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `cate_id` int(4) unsigned NOT NULL DEFAULT '0',
  `img` int(10) NOT NULL DEFAULT '0',
  `bimg` int(10) NOT NULL DEFAULT '0',
  `file_id` int(10) NOT NULL DEFAULT '0',
  `album_id` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `model` varchar(200) DEFAULT '1',
  `add_time` datetime DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  `del_time` datetime DEFAULT NULL,
  `sort_order` int(4) NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `is_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_best` tinyint(1) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-待审核 1-已审核',
  `title` varchar(255) DEFAULT NULL,
  `pretitle` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `orig` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `abst` text,
  `info` text,
  `author` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  `album` int(10) NOT NULL DEFAULT '0',
  `banner_img` int(10) NOT NULL DEFAULT '0',
  `background` int(10) NOT NULL DEFAULT '0',
  `attr_id` varchar(255) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `is_best` (`is_best`),
  KEY `add_time` (`add_time`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_mall
-- ----------------------------
INSERT INTO `jc_mall` VALUES ('1', '1', '1', '3', '0', '0', '20', '0.00', '', '2017-09-11 09:33:33', '2017-09-11 09:46:31', null, '1', '0', '0', '0', '0', '4', '1', '3', null, null, null, null, null, '', '', null, null, null, null, '0', '0', '0', null, '1');

-- ----------------------------
-- Table structure for jc_mall_cate
-- ----------------------------
DROP TABLE IF EXISTS `jc_mall_cate`;
CREATE TABLE `jc_mall_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `abst` text,
  `abst_en` text,
  `alias` varchar(255) DEFAULT NULL,
  `alias_template` varchar(255) DEFAULT NULL,
  `pid` int(10) NOT NULL DEFAULT '0',
  `parentspath` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '0',
  `sort_order` int(4) NOT NULL DEFAULT '0',
  `record_nums` int(10) NOT NULL DEFAULT '0',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  `img` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `info` text,
  `remark` text,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `is_best` tinyint(4) NOT NULL DEFAULT '0',
  `is_index` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_mall_cate
-- ----------------------------
INSERT INTO `jc_mall_cate` VALUES ('1', '111', '', '', null, '', '', '0', '0,', '1', '0', '0', '', '', '', '', null, null, null, null, '', null, '2017-09-11 09:29:06', '2017-09-11 09:29:06', '0', '1');

-- ----------------------------
-- Table structure for jc_mall_en
-- ----------------------------
DROP TABLE IF EXISTS `jc_mall_en`;
CREATE TABLE `jc_mall_en` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `pretitle` varchar(255) DEFAULT '',
  `subtitle` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `orig` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `abst` text,
  `info` text,
  `author` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  `album` int(10) NOT NULL DEFAULT '0',
  `banner_img` int(10) NOT NULL DEFAULT '0',
  `background` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_mall_en
-- ----------------------------
INSERT INTO `jc_mall_en` VALUES ('1', '3', '', null, null, null, null, '', '', null, null, null, null, '0', '0', '0');

-- ----------------------------
-- Table structure for jc_menu
-- ----------------------------
DROP TABLE IF EXISTS `jc_menu`;
CREATE TABLE `jc_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `app` varchar(30) NOT NULL DEFAULT '' COMMENT '应用名称app',
  `model` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作名称',
  `data` varchar(50) NOT NULL DEFAULT '' COMMENT '额外参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  `commend` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`),
  KEY `model` (`model`)
) ENGINE=InnoDB AUTO_INCREMENT=419 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of jc_menu
-- ----------------------------
INSERT INTO `jc_menu` VALUES ('2', '193', 'Api', 'Guestbookadmin', 'index', '', '1', '1', '所有留言', '', '', '20', '0');
INSERT INTO `jc_menu` VALUES ('3', '2', 'Api', 'Guestbookadmin', 'delete', '', '0', '1', '删除网站留言', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('39', '0', 'Admin', 'Extension', 'default', '', '1', '1', '扩展工具', 'cloud', '', '40', '0');
INSERT INTO `jc_menu` VALUES ('47', '39', 'Admin', 'Plugin', 'index', '', '1', '1', '插件管理', '', '', '12', '0');
INSERT INTO `jc_menu` VALUES ('48', '47', 'Admin', 'Plugin', 'toggle', '', '0', '1', '插件启用切换', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('49', '47', 'Admin', 'Plugin', 'setting', '', '0', '1', '插件设置', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('50', '49', 'Admin', 'Plugin', 'setting_post', '', '0', '1', '插件设置提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('51', '47', 'Admin', 'Plugin', 'install', '', '0', '1', '插件安装', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('52', '47', 'Admin', 'Plugin', 'uninstall', '', '0', '1', '插件卸载', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('53', '193', 'Admin', 'Slide', 'index', '', '1', '1', '幻灯片', '', '', '30', '0');
INSERT INTO `jc_menu` VALUES ('54', '53', 'Admin', 'Slide', 'default2', '', '0', '1', '幻灯片管理', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('55', '54', 'Admin', 'Slide', 'listorders', '', '0', '1', '幻灯片排序', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('56', '54', 'Admin', 'Slide', 'toggle', '', '0', '1', '幻灯片显示切换', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('57', '54', 'Admin', 'Slide', 'delete', '', '0', '1', '删除幻灯片', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('58', '54', 'Admin', 'Slide', 'edit', '', '0', '1', '编辑幻灯片', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('59', '58', 'Admin', 'Slide', 'edit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('60', '54', 'Admin', 'Slide', 'add', '', '0', '1', '添加幻灯片', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('61', '60', 'Admin', 'Slide', 'add_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('62', '53', 'Admin', 'Slidecat', 'index', '', '0', '1', '幻灯片分类', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('63', '62', 'Admin', 'Slidecat', 'delete', '', '0', '1', '删除分类', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('64', '62', 'Admin', 'Slidecat', 'edit', '', '0', '1', '编辑分类', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('65', '64', 'Admin', 'Slidecat', 'edit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('66', '62', 'Admin', 'Slidecat', 'add', '', '0', '1', '添加分类', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('67', '66', 'Admin', 'Slidecat', 'add_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('68', '39', 'Admin', 'Ad', 'index', '', '1', '1', '网站广告', '', '', '11', '0');
INSERT INTO `jc_menu` VALUES ('69', '68', 'Admin', 'Ad', 'toggle', '', '0', '1', '广告显示切换', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('70', '68', 'Admin', 'Ad', 'delete', '', '0', '1', '删除广告', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('71', '68', 'Admin', 'Ad', 'edit', '', '0', '1', '编辑广告', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('72', '71', 'Admin', 'Ad', 'edit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('73', '68', 'Admin', 'Ad', 'add', '', '0', '1', '添加广告', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('74', '73', 'Admin', 'Ad', 'add_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('75', '193', 'Admin', 'Link', 'index', '', '1', '1', '友情链接', '', '', '25', '0');
INSERT INTO `jc_menu` VALUES ('76', '75', 'Admin', 'Link', 'listorders', '', '0', '1', '友情链接排序', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('77', '75', 'Admin', 'Link', 'toggle', '', '0', '1', '友链显示切换', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('78', '75', 'Admin', 'Link', 'delete', '', '0', '1', '删除友情链接', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('79', '75', 'Admin', 'Link', 'edit', '', '0', '1', '编辑友情链接', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('80', '79', 'Admin', 'Link', 'edit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('81', '75', 'Admin', 'Link', 'add', '', '0', '1', '添加友情链接', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('82', '81', 'Admin', 'Link', 'add_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('83', '39', 'Api', 'Oauthadmin', 'setting', '', '1', '1', '第三方登陆', 'leaf', '', '13', '0');
INSERT INTO `jc_menu` VALUES ('84', '83', 'Api', 'Oauthadmin', 'setting_post', '', '0', '1', '提交设置', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('85', '0', 'Admin', 'Menu', 'default', '', '1', '1', '菜单管理', 'list', '', '25', '0');
INSERT INTO `jc_menu` VALUES ('86', '85', 'Admin', 'Navcat', 'default1', '', '1', '1', '前台菜单', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('87', '86', 'Admin', 'Nav', 'index', '', '1', '1', '菜单管理', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('88', '87', 'Admin', 'Nav', 'listorders', '', '0', '1', '前台导航排序', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('89', '87', 'Admin', 'Nav', 'delete', '', '0', '1', '删除菜单', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('90', '87', 'Admin', 'Nav', 'edit', '', '0', '1', '编辑菜单', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('91', '90', 'Admin', 'Nav', 'edit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('92', '87', 'Admin', 'Nav', 'add', '', '0', '1', '添加菜单', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('93', '92', 'Admin', 'Nav', 'add_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('94', '86', 'Admin', 'Navcat', 'index', '', '1', '1', '菜单分类', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('95', '94', 'Admin', 'Navcat', 'delete', '', '0', '1', '删除分类', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('96', '94', 'Admin', 'Navcat', 'edit', '', '0', '1', '编辑分类', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('97', '96', 'Admin', 'Navcat', 'edit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('98', '94', 'Admin', 'Navcat', 'add', '', '0', '1', '添加分类', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('99', '98', 'Admin', 'Navcat', 'add_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('100', '378', 'Admin', 'Menu', 'index', '', '1', '1', '菜单列表', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('101', '100', 'Admin', 'Menu', 'add', '', '0', '1', '添加菜单', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('102', '101', 'Admin', 'Menu', 'add_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('103', '100', 'Admin', 'Menu', 'listorders', '', '0', '1', '后台菜单排序', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('104', '100', 'Admin', 'Menu', 'export_menu', '', '0', '1', '菜单备份', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('105', '100', 'Admin', 'Menu', 'edit', '', '0', '1', '编辑菜单', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('106', '105', 'Admin', 'Menu', 'edit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('107', '100', 'Admin', 'Menu', 'delete', '', '0', '1', '删除菜单', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('108', '100', 'Admin', 'Menu', 'lists', '', '0', '1', '所有菜单', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('109', '0', 'Admin', 'Setting', 'default', '', '1', '1', '设置', 'cogs', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('110', '109', 'Admin', 'Setting', 'userdefault', '', '1', '1', '个人信息', '', '', '1', '0');
INSERT INTO `jc_menu` VALUES ('111', '110', 'Admin', 'User', 'userinfo', '', '1', '1', '修改信息', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('112', '111', 'Admin', 'User', 'userinfo_post', '', '0', '1', '修改信息提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('113', '110', 'Admin', 'Setting', 'password', '', '1', '1', '修改密码', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('114', '113', 'Admin', 'Setting', 'password_post', '', '0', '1', '提交修改', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('115', '109', 'Admin', 'Setting', 'site', '', '1', '1', '网站设置', '', '', '2', '0');
INSERT INTO `jc_menu` VALUES ('116', '115', 'Admin', 'Setting', 'site_post', '', '0', '1', '提交修改', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('117', '115', 'Admin', 'Route', 'index', '', '0', '1', '路由列表', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('118', '115', 'Admin', 'Route', 'add', '', '0', '1', '路由添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('119', '118', 'Admin', 'Route', 'add_post', '', '0', '1', '路由添加提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('120', '115', 'Admin', 'Route', 'edit', '', '0', '1', '路由编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('121', '120', 'Admin', 'Route', 'edit_post', '', '0', '1', '路由编辑提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('122', '115', 'Admin', 'Route', 'delete', '', '0', '1', '路由删除', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('123', '115', 'Admin', 'Route', 'ban', '', '0', '1', '路由禁止', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('124', '115', 'Admin', 'Route', 'open', '', '0', '1', '路由启用', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('125', '115', 'Admin', 'Route', 'listorders', '', '0', '1', '路由排序', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('126', '109', 'Admin', 'Mailer', 'default', '', '1', '1', '邮箱配置', '', '', '4', '0');
INSERT INTO `jc_menu` VALUES ('127', '126', 'Admin', 'Mailer', 'index', '', '1', '1', 'SMTP配置', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('128', '127', 'Admin', 'Mailer', 'index_post', '', '0', '1', '提交配置', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('129', '126', 'Admin', 'Mailer', 'active', '', '1', '1', '注册邮件模板', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('130', '129', 'Admin', 'Mailer', 'active_post', '', '0', '1', '提交模板', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('131', '109', 'Admin', 'Setting', 'clearcache', '', '1', '1', '清除缓存', '', '', '6', '0');
INSERT INTO `jc_menu` VALUES ('132', '0', 'User', 'Indexadmin', 'default', '', '1', '1', '用户管理', 'group', '', '20', '0');
INSERT INTO `jc_menu` VALUES ('133', '190', 'User', 'Indexadmin', 'default1', '', '1', '1', '用户组', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('134', '132', 'User', 'Indexadmin', 'index', '', '1', '1', '所有用户列表', 'leaf', '', '6', '0');
INSERT INTO `jc_menu` VALUES ('135', '134', 'User', 'Indexadmin', 'ban', '', '0', '1', '拉黑会员', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('136', '134', 'User', 'Indexadmin', 'cancelban', '', '0', '1', '启用会员', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('137', '133', 'User', 'Oauthadmin', 'index', '', '1', '1', '第三方用户', 'leaf', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('138', '137', 'User', 'Oauthadmin', 'delete', '', '0', '1', '第三方用户解绑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('139', '190', 'User', 'Indexadmin', 'default3', '', '1', '1', '管理组', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('140', '139', 'Admin', 'Rbac', 'index', '', '1', '1', '角色管理', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('141', '140', 'Admin', 'Rbac', 'member', '', '0', '1', '成员管理', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('142', '140', 'Admin', 'Rbac', 'authorize', '', '0', '1', '权限设置', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('143', '142', 'Admin', 'Rbac', 'authorize_post', '', '0', '1', '提交设置', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('144', '140', 'Admin', 'Rbac', 'roleedit', '', '0', '1', '编辑角色', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('145', '144', 'Admin', 'Rbac', 'roleedit_post', '', '0', '1', '提交编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('146', '140', 'Admin', 'Rbac', 'roledelete', '', '0', '1', '删除角色', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('147', '140', 'Admin', 'Rbac', 'roleadd', '', '0', '1', '添加角色', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('148', '147', 'Admin', 'Rbac', 'roleadd_post', '', '0', '1', '提交添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('149', '139', 'Admin', 'User', 'index', '', '1', '1', '管理员', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('150', '149', 'Admin', 'User', 'delete', '', '0', '1', '删除管理员', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('151', '149', 'Admin', 'User', 'edit', '', '0', '1', '管理员编辑', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('152', '151', 'Admin', 'User', 'edit_post', '', '0', '1', '编辑提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('153', '149', 'Admin', 'User', 'add', '', '0', '1', '管理员添加', '', '', '1000', '0');
INSERT INTO `jc_menu` VALUES ('154', '153', 'Admin', 'User', 'add_post', '', '0', '1', '添加提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('155', '47', 'Admin', 'Plugin', 'update', '', '0', '1', '插件更新', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('156', '109', 'Admin', 'Storage', 'index', '', '1', '1', '文件存储', '', '', '5', '0');
INSERT INTO `jc_menu` VALUES ('157', '156', 'Admin', 'Storage', 'setting_post', '', '0', '1', '文件存储设置提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('158', '54', 'Admin', 'Slide', 'ban', '', '0', '1', '禁用幻灯片', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('159', '54', 'Admin', 'Slide', 'cancelban', '', '0', '1', '启用幻灯片', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('160', '149', 'Admin', 'User', 'ban', '', '0', '1', '禁用管理员', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('161', '149', 'Admin', 'User', 'cancelban', '', '0', '1', '启用管理员', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('166', '127', 'Admin', 'Mailer', 'test', '', '0', '1', '测试邮件', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('167', '109', 'Admin', 'Setting', 'upload', '', '1', '1', '上传设置', '', '', '3', '0');
INSERT INTO `jc_menu` VALUES ('168', '167', 'Admin', 'Setting', 'upload_post', '', '0', '1', '上传设置提交', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('174', '100', 'Admin', 'Menu', 'backup_menu', '', '0', '1', '备份菜单', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('175', '100', 'Admin', 'Menu', 'export_menu_lang', '', '0', '1', '导出后台菜单多语言包', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('176', '100', 'Admin', 'Menu', 'restore_menu', '', '0', '1', '还原菜单', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('177', '100', 'Admin', 'Menu', 'getactions', '', '0', '1', '导入新菜单', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('190', '0', 'Admin', 'Index', 'default1', '', '1', '1', '后台管理', 'tasks', '', '50', '0');
INSERT INTO `jc_menu` VALUES ('191', '132', 'Admin', 'Organization', 'index', '', '1', '1', '组织架构', 'university', '', '10', '0');
INSERT INTO `jc_menu` VALUES ('192', '191', 'Admin', 'Organization', 'delete', '', '0', '1', '组织删除', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('193', '0', 'Admin', 'Article', 'default', '', '1', '1', '资讯管理', 'newspaper-o', '', '5', '0');
INSERT INTO `jc_menu` VALUES ('194', '418', 'Admin', 'Article', 'main', '', '1', '1', '综合管理', 'th', '', '1', '1');
INSERT INTO `jc_menu` VALUES ('195', '418', 'Admin', 'ArticleCate', 'index', '', '1', '1', '分类列表', '', '', '10', '0');
INSERT INTO `jc_menu` VALUES ('196', '195', 'Admin', 'ArticleCate', 'add', '', '0', '1', '分类添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('198', '191', 'Admin', 'Organization', 'update', '', '0', '1', '会员表更新', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('200', '191', 'Admin', 'Organization', 'listorders', '', '0', '1', '组织排序', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('201', '195', 'Admin', 'ArticleCate', 'edit', '', '0', '1', '分类编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('203', '195', 'Admin', 'ArticleCate', 'delete', '', '0', '1', '分类删除', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('206', '195', 'Admin', 'ArticleCate', 'status', '', '0', '1', '分类修改字段', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('207', '195', 'Admin', 'ArticleCate', 'add_all', '', '0', '1', '分类快速添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('208', '194', 'Admin', 'Article', 'index', '', '0', '1', '文章列表', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('209', '194', 'Admin', 'Article', 'cate', '', '0', '1', '文章菜单', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('210', '194', 'Admin', 'Article', 'add', '', '0', '1', '文章添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('211', '194', 'Admin', 'Article', 'edit', '', '0', '1', '文章编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('212', '194', 'Admin', 'Article', 'delete', '', '0', '1', '文章删除', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('214', '194', 'Admin', 'Article', 'status', '', '0', '1', '文章状态修改', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('215', '195', 'Admin', 'ArticleCate', 'update_num', '', '0', '1', '更新资讯数', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('217', '191', 'Admin', 'Organization', 'add', '', '0', '1', '党组织添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('218', '191', 'Admin', 'Organization', 'edit', '', '0', '1', '党组织编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('219', '191', 'Admin', 'Organization', 'geiChilds', '', '0', '1', 'geiChilds', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('220', '191', 'Admin', 'Organization', 'status', '', '0', '1', 'status', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('221', '193', 'Admin', 'Setting', 'contact', '', '1', '1', '网站信息', '', '', '35', '1');
INSERT INTO `jc_menu` VALUES ('222', '191', 'Admin', 'Organization', 'findDistrict', '', '0', '1', 'findDistrict', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('226', '132', 'User', 'AdminUser', 'index', '', '1', '1', '前台用户列表', 'user', '', '4', '0');
INSERT INTO `jc_menu` VALUES ('227', '245', 'Admin', 'MallCate', 'index', '', '1', '1', '产品分类', '', '', '3', '0');
INSERT INTO `jc_menu` VALUES ('228', '227', 'Admin', 'MallCate', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('229', '227', 'Admin', 'MallCate', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('230', '227', 'Admin', 'MallCate', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('231', '227', 'Admin', 'MallCate', 'sort_order', '', '0', '1', 'sort_order', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('232', '227', 'Admin', 'MallCate', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('233', '227', 'Admin', 'MallCate', 'add_all', '', '0', '1', 'add_all', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('234', '235', 'Admin', 'Mall', 'index', '', '0', '1', 'index', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('235', '245', 'Admin', 'Mall', 'main', '', '1', '1', '产品综合', 'shopping-cart', '', '2', '0');
INSERT INTO `jc_menu` VALUES ('236', '235', 'Admin', 'Mall', 'cate', '', '0', '1', 'cate', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('237', '235', 'Admin', 'Mall', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('238', '235', 'Admin', 'Mall', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('239', '235', 'Admin', 'Mall', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('241', '235', 'Admin', 'Mall', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('242', '235', 'Admin', 'Mall', 'update_num', '', '0', '1', 'update_num', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('244', '235', 'Admin', 'Menu', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('245', '0', 'Admin', 'Mall', 'dafault', '', '1', '1', '产品管理', 'shopping-cart', '', '10', '0');
INSERT INTO `jc_menu` VALUES ('251', '87', 'Admin', 'Nav', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('268', '373', 'Admin', 'VideoCate', 'index', '', '1', '1', '视频分类', '', '', '2', '0');
INSERT INTO `jc_menu` VALUES ('269', '268', 'Admin', 'VideoCate', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('270', '268', 'Admin', 'VideoCate', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('271', '268', 'Admin', 'VideoCate', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('272', '268', 'Admin', 'VideoCate', 'sort_order', '', '0', '1', 'sort_order', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('273', '268', 'Admin', 'VideoCate', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('274', '268', 'Admin', 'VideoCate', 'add_all', '', '0', '1', 'add_all', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('279', '226', 'User', 'AdminUser', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('280', '226', 'User', 'AdminUser', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('282', '373', 'Admin', 'Video', 'main', '', '1', '1', '视频列表', '', '', '1', '0');
INSERT INTO `jc_menu` VALUES ('296', '245', 'Admin', 'Order', 'default', '', '1', '1', '订单管理', '', '', '4', '0');
INSERT INTO `jc_menu` VALUES ('297', '296', 'Admin', 'Order', 'waitSendList', '', '1', '1', '等待发货', '', '', '2', '0');
INSERT INTO `jc_menu` VALUES ('298', '296', 'Admin', 'Order', 'index', '', '1', '1', '订单列表', '', '', '1', '0');
INSERT INTO `jc_menu` VALUES ('299', '296', 'Admin', 'Order', 'refundList', '', '1', '1', '退货列表', '', '', '3', '0');
INSERT INTO `jc_menu` VALUES ('300', '296', 'Admin', 'Order', 'refundMoneyList', '', '1', '1', '退款列表', '', '', '4', '0');
INSERT INTO `jc_menu` VALUES ('323', '235', 'Admin', 'Mall', 'prop', '', '0', '1', 'prop', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('324', '298', 'Admin', 'Order', 'agreeRefundGoods', '', '0', '1', 'agreeRefundGoods', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('325', '298', 'Admin', 'Order', 'agreeRefundMoney', '', '0', '1', 'agreeRefundMoney', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('326', '298', 'Admin', 'Order', 'aliRefund', '', '0', '1', 'aliRefund', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('327', '298', 'Admin', 'Order', 'rejectRefund', '', '0', '1', 'rejectRefund', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('328', '298', 'Admin', 'Order', 'sendGoods', '', '0', '1', 'sendGoods', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('329', '298', 'Admin', 'Order', 'showOrder', '', '0', '1', 'showOrder', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('330', '298', 'Admin', 'Order', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('331', '298', 'Admin', 'Order', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('332', '298', 'Admin', 'Order', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('333', '298', 'Admin', 'Order', 'display_tree', '', '0', '1', 'display_tree', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('334', '298', 'Admin', 'Order', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('345', '282', 'Admin', 'Video', 'cate', '', '0', '0', 'cate', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('346', '282', 'Admin', 'Video', 'add', '', '0', '1', '添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('347', '282', 'Admin', 'Video', 'edit', '', '0', '1', '修改', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('348', '282', 'Admin', 'Video', 'delete', '', '0', '1', '删除', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('350', '282', 'Admin', 'Video', 'status', '', '0', '1', '状态修改', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('352', '226', 'User', 'AdminUser', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('353', '226', 'User', 'AdminUser', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('354', '193', 'Admin', 'Category', 'default', '', '1', '1', '类型管理', '', '', '60', '0');
INSERT INTO `jc_menu` VALUES ('355', '354', 'Admin', 'Category', 'index', '', '1', '1', '类型列表', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('356', '354', 'Admin', 'CategoryType', 'index', '', '1', '1', '类型分类', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('357', '355', 'Admin', 'Category', 'add', '', '1', '0', '类型添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('358', '355', 'Admin', 'Category', 'edit', '', '1', '0', '类型编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('359', '355', 'Admin', 'Category', 'status', '', '1', '0', '类型状态修改', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('360', '355', 'Admin', 'Category', 'delete', '', '1', '0', '类型删除', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('361', '356', 'Admin', 'CategoryType', 'add', '', '1', '0', '分类添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('362', '356', 'Admin', 'CategoryType', 'edit', '', '1', '0', '分类编辑', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('363', '356', 'Admin', 'CategoryType', 'status', '', '1', '0', '分类状态修改', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('364', '356', 'Admin', 'CategoryType', 'delete', '', '1', '0', '分类删除', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('367', '193', 'Admin', 'Apply', 'index', '', '1', '1', '廉政投诉', '', '', '100', '0');
INSERT INTO `jc_menu` VALUES ('368', '367', 'Admin', 'Apply', 'delete', '', '0', '1', '删除', '', '', '1', '0');
INSERT INTO `jc_menu` VALUES ('369', '367', 'Admin', 'Apply', 'show', '', '0', '1', '详情查看', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('370', '418', 'Admin', 'Article', 'autoload', '', '1', '1', '批量添加', '', '', '101', '0');
INSERT INTO `jc_menu` VALUES ('371', '245', 'Admin', 'Mall', 'autoload', '', '1', '1', '批量添加', '', '', '5', '0');
INSERT INTO `jc_menu` VALUES ('372', '87', 'Admin', 'Nav', 'add_all', '', '0', '1', '批量添加', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('373', '193', 'Admin', 'Video', 'default', '', '1', '1', '党建视频', '', '', '15', '0');
INSERT INTO `jc_menu` VALUES ('374', '132', 'User', 'AdminUser', 'tax_list', '', '1', '1', '党费缴纳', '', '', '5', '0');
INSERT INTO `jc_menu` VALUES ('375', '282', 'Admin', 'Video', 'index', '', '0', '1', '视频列表', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('377', '374', 'User', 'AdminUser', 'tax_show', '', '0', '1', '党员缴费详细', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('378', '85', 'Admin', 'Menu', 'default1', '', '1', '1', '后台菜单', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('379', '378', 'Admin', 'Menu', 'setting', '', '1', '1', '菜单设置', '', '', '0', '0');
INSERT INTO `jc_menu` VALUES ('380', '193', 'Admin', 'Picture', 'index', '', '1', '1', '图片管理', '', '', '50', '0');
INSERT INTO `jc_menu` VALUES ('381', '39', 'Admin', 'Database', 'index', 'type=export', '1', '1', '备份管理', 'upload', '', '10', '0');
INSERT INTO `jc_menu` VALUES ('382', '381', 'Admin', 'Database', 'optimize', '', '0', '1', 'optimize', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('383', '381', 'Admin', 'Database', 'repair', '', '0', '1', 'repair', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('384', '381', 'Admin', 'Database', 'del', '', '0', '1', 'del', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('385', '381', 'Admin', 'Database', 'export', '', '0', '1', 'export', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('386', '381', 'Admin', 'Database', 'import', '', '0', '1', 'import', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('387', '100', 'Admin', 'Menu', 'display_menu', '', '0', '1', 'display_menu', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('388', '380', 'Admin', 'Picture', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('389', '417', 'Admin', 'SheetCate', 'index', '', '0', '1', '表单列表', '', '', '5', '0');
INSERT INTO `jc_menu` VALUES ('390', '389', 'Admin', 'SheetCate', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('391', '389', 'Admin', 'SheetCate', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('392', '389', 'Admin', 'SheetCate', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('393', '389', 'Admin', 'SheetCate', 'sort_order', '', '0', '1', 'sort_order', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('394', '389', 'Admin', 'SheetCate', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('395', '389', 'Admin', 'SheetCate', 'add_all', '', '0', '1', 'add_all', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('396', '389', 'Admin', 'SheetCate', 'design', '', '0', '1', 'design', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('397', '389', 'Admin', 'SheetCate', 'edit_field', '', '0', '1', 'edit_field', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('398', '389', 'Admin', 'SheetCate', 'add_field', '', '0', '1', 'add_field', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('399', '389', 'Admin', 'SheetCate', 'delete_field', '', '0', '1', 'delete_field', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('400', '401', 'Admin', 'Sheet', 'index', '', '0', '1', 'index', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('401', '417', 'Admin', 'Sheet', 'main', '', '1', '1', '表单管理', 'database', '', '3', '0');
INSERT INTO `jc_menu` VALUES ('402', '401', 'Admin', 'Sheet', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('403', '401', 'Admin', 'Sheet', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('404', '401', 'Admin', 'Sheet', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('405', '401', 'Admin', 'Sheet', 'loadout', '', '0', '1', 'loadout', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('406', '401', 'Admin', 'Sheet', 'loadin', '', '0', '1', 'loadin', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('407', '401', 'Admin', 'Sheet', 'get_tmpl', '', '0', '1', 'get_tmpl', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('408', '417', 'Admin', 'SheetTmpl', 'index', '', '1', '1', '表单模版', '', '', '4', '0');
INSERT INTO `jc_menu` VALUES ('409', '408', 'Admin', 'SheetTmpl', 'add', '', '0', '1', 'add', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('410', '408', 'Admin', 'SheetTmpl', 'edit', '', '0', '1', 'edit', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('411', '408', 'Admin', 'SheetTmpl', 'delete', '', '0', '1', 'delete', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('412', '408', 'Admin', 'SheetTmpl', 'status', '', '0', '1', 'status', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('413', '408', 'Admin', 'SheetTmpl', 'edit_field', '', '0', '1', 'edit_field', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('414', '408', 'Admin', 'SheetTmpl', 'add_field', '', '0', '1', 'add_field', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('415', '408', 'Admin', 'SheetTmpl', 'delete_field', '', '0', '1', 'delete_field', null, '', '0', '0');
INSERT INTO `jc_menu` VALUES ('417', '0', 'Admin', 'Sheet', 'default', '', '1', '1', '表单管理', 'cubes', '', '15', '0');
INSERT INTO `jc_menu` VALUES ('418', '193', 'Admin', 'Article', 'default2', '', '1', '1', '文章管理', '', '', '0', '0');

-- ----------------------------
-- Table structure for jc_mobile_code_log
-- ----------------------------
DROP TABLE IF EXISTS `jc_mobile_code_log`;
CREATE TABLE `jc_mobile_code_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(255) DEFAULT NULL,
  `send_time` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `expire_time` int(11) NOT NULL DEFAULT '0',
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_mobile_code_log
-- ----------------------------

-- ----------------------------
-- Table structure for jc_nav
-- ----------------------------
DROP TABLE IF EXISTS `jc_nav`;
CREATE TABLE `jc_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL COMMENT '导航分类 id',
  `parentid` int(11) NOT NULL COMMENT '导航父 id',
  `label` varchar(255) DEFAULT NULL COMMENT '导航标题',
  `sub_label` varchar(255) DEFAULT NULL,
  `target` varchar(50) DEFAULT NULL COMMENT '打开方式',
  `href` varchar(255) DEFAULT NULL COMMENT '导航链接',
  `params` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL COMMENT '导航图标',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  `listorder` int(6) DEFAULT '0' COMMENT '排序',
  `path` varchar(255) DEFAULT '0' COMMENT '层级关系',
  `top_extend` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台导航表';

-- ----------------------------
-- Records of jc_nav
-- ----------------------------

-- ----------------------------
-- Table structure for jc_nav_cat
-- ----------------------------
DROP TABLE IF EXISTS `jc_nav_cat`;
CREATE TABLE `jc_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '导航分类名',
  `active` int(1) NOT NULL DEFAULT '1' COMMENT '是否为主菜单，1是，0不是',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`navcid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='前台导航分类表';

-- ----------------------------
-- Records of jc_nav_cat
-- ----------------------------
INSERT INTO `jc_nav_cat` VALUES ('1', '主导航', '1', '');

-- ----------------------------
-- Table structure for jc_oauth_user
-- ----------------------------
DROP TABLE IF EXISTS `jc_oauth_user`;
CREATE TABLE `jc_oauth_user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `from` varchar(20) NOT NULL COMMENT '用户来源key',
  `name` varchar(30) NOT NULL COMMENT '第三方昵称',
  `head_img` varchar(200) NOT NULL COMMENT '头像',
  `uid` int(20) NOT NULL COMMENT '关联的本站用户id',
  `create_time` datetime DEFAULT NULL COMMENT '绑定时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(16) NOT NULL COMMENT '最后登录ip',
  `login_times` int(6) NOT NULL COMMENT '登录次数',
  `status` tinyint(2) NOT NULL,
  `access_token` varchar(512) NOT NULL,
  `expires_date` int(11) NOT NULL COMMENT 'access_token过期时间',
  `openid` varchar(40) NOT NULL COMMENT '第三方用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方用户表';

-- ----------------------------
-- Records of jc_oauth_user
-- ----------------------------

-- ----------------------------
-- Table structure for jc_options
-- ----------------------------
DROP TABLE IF EXISTS `jc_options`;
CREATE TABLE `jc_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL COMMENT '配置名',
  `option_value` longtext NOT NULL COMMENT '配置值',
  `autoload` int(2) NOT NULL DEFAULT '1' COMMENT '是否自动加载',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='全站配置表';

-- ----------------------------
-- Records of jc_options
-- ----------------------------
INSERT INTO `jc_options` VALUES ('1', 'member_email_active', '{\"qq1\":\"446107014\",\"qq2\":\"\",\"qq3\":\"\",\"qq4\":\"\",\"qq5\":\"\",\"tel\":\"0571-87951917\",\"template\":\"\"}', '1');
INSERT INTO `jc_options` VALUES ('6', 'site_options', '{\"site_name\":\"\\u5de8\\u521b\\u7f51\\u7edc\",\"site_admin_url_password\":\"\",\"site_tpl\":\"simplebootx\",\"mobile_tpl_enabled\":\"1\",\"site_adminstyle\":\"zhenye\",\"html_cache_on\":\"1\",\"site_icp\":\"\",\"site_admin_email\":\"\",\"site_tongji\":\"\",\"site_copyright\":\"\",\"site_seo_title\":\"\",\"site_seo_keywords\":\"\",\"site_seo_description\":\"\",\"urlmode\":\"1\",\"html_suffix\":\"\",\"comment_time_interval\":\"60\"}', '1');
INSERT INTO `jc_options` VALUES ('7', 'cmf_settings', '{\"banned_usernames\":\"\",\"admin_allow_list\":\"\",\"admin_allow_enabled\":0}', '1');
INSERT INTO `jc_options` VALUES ('8', 'cdn_settings', '{\"cdn_static_root\":\"\"}', '1');
INSERT INTO `jc_options` VALUES ('10', 'upload_setting', '{\"image\":{\"upload_max_filesize\":\"10240\",\"extensions\":\"jpg,jpeg,png,gif,bmp4\"},\"video\":{\"upload_max_filesize\":\"1024000\",\"extensions\":\"mp4,avi,wmv,rm,rmvb,mkv\"},\"audio\":{\"upload_max_filesize\":\"102400\",\"extensions\":\"mp3,wma,wav\"},\"file\":{\"upload_max_filesize\":\"102400\",\"extensions\":\"txt,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,mp4,avi,wmv,rm,rmvb,mkv\"}}', '1');
INSERT INTO `jc_options` VALUES ('11', 'contact_setting', '{\"img\":\"0\",\"title\":\"\",\"key\":\"\",\"desc\":\"\",\"page_num_news\":\"1\",\"page_num_pro\":\"1\",\"banquan\":\"\",\"zhichi\":\"\",\"map\":\"120.171966,30.249596,19\"}', '1');
INSERT INTO `jc_options` VALUES ('12', 'menu_setting', '{\"is_menu_frap\":0}', '1');

-- ----------------------------
-- Table structure for jc_order
-- ----------------------------
DROP TABLE IF EXISTS `jc_order`;
CREATE TABLE `jc_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_sn` varchar(25) NOT NULL DEFAULT '' COMMENT '交易订单号',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建订单的用户',
  `area_ids` varchar(255) DEFAULT '0' COMMENT '收件地址ID',
  `address` varchar(10) DEFAULT NULL COMMENT '收件详细地址',
  `name` varchar(255) DEFAULT NULL COMMENT '收货人姓名',
  `mobile` varchar(255) DEFAULT NULL COMMENT '收货人联系方式',
  `zip_code` varchar(255) DEFAULT NULL COMMENT '收货地址邮政编码',
  `is_invoice` tinyint(255) NOT NULL DEFAULT '1' COMMENT '不开发票:0|个人发票:1|企业发票:2',
  `invoice_title` varchar(255) DEFAULT NULL COMMENT '发票title',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `message` varchar(255) DEFAULT '' COMMENT '给卖家的留言',
  `pay_type` varchar(60) DEFAULT '' COMMENT '支付类型',
  `pay_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单实际支付的金额',
  `pay_time` datetime DEFAULT NULL,
  `pay_json` text,
  `send_express` varchar(255) DEFAULT NULL,
  `send_express_sn` varchar(255) DEFAULT NULL,
  `trade_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_sn`) USING BTREE,
  KEY `user_id` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_order
-- ----------------------------

-- ----------------------------
-- Table structure for jc_order_product
-- ----------------------------
DROP TABLE IF EXISTS `jc_order_product`;
CREATE TABLE `jc_order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '数量',
  `props` text COMMENT 'attr下单时数据',
  `shouhou` tinyint(4) NOT NULL DEFAULT '0',
  `refund_id` int(11) NOT NULL DEFAULT '0',
  `one_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sum_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_order_product
-- ----------------------------

-- ----------------------------
-- Table structure for jc_order_refund
-- ----------------------------
DROP TABLE IF EXISTS `jc_order_refund`;
CREATE TABLE `jc_order_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `pack_id` int(11) NOT NULL DEFAULT '0',
  `step_id` int(11) NOT NULL DEFAULT '1',
  `type_id` tinyint(4) NOT NULL DEFAULT '1',
  `is_receive` tinyint(4) NOT NULL DEFAULT '1',
  `return_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(255) NOT NULL DEFAULT '',
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `express` varchar(255) DEFAULT NULL,
  `express_sn` varchar(255) DEFAULT NULL,
  `reject_reason` varchar(255) DEFAULT NULL,
  `refund_sn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_order_refund
-- ----------------------------

-- ----------------------------
-- Table structure for jc_organization
-- ----------------------------
DROP TABLE IF EXISTS `jc_organization`;
CREATE TABLE `jc_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL DEFAULT '0',
  `rank_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `parents_path` varchar(255) DEFAULT NULL,
  `likes` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `level` int(4) NOT NULL DEFAULT '0',
  `sort` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_organization
-- ----------------------------

-- ----------------------------
-- Table structure for jc_plugins
-- ----------------------------
DROP TABLE IF EXISTS `jc_plugins`;
CREATE TABLE `jc_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) NOT NULL COMMENT '插件名，英文',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '插件名称',
  `description` text COMMENT '插件描述',
  `type` tinyint(2) DEFAULT '0' COMMENT '插件类型, 1:网站；8;微信',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态；1开启；',
  `config` text COMMENT '插件配置',
  `hooks` varchar(255) DEFAULT NULL COMMENT '实现的钩子;以“，”分隔',
  `has_admin` tinyint(2) DEFAULT '0' COMMENT '插件是否有后台管理界面',
  `author` varchar(50) DEFAULT '' COMMENT '插件作者',
  `version` varchar(20) DEFAULT '' COMMENT '插件版本号',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `listorder` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of jc_plugins
-- ----------------------------
INSERT INTO `jc_plugins` VALUES ('1', 'BaiduMap', '百度地图坐标定位', '百度地图坐标定位', '0', '1', '[]', 'BaiduMap', '0', 'lhb', '0.1', '0', '0');
INSERT INTO `jc_plugins` VALUES ('5', 'J_China_City', '', '每个系统都需要的一个中国省市区三级联动插件。', '1', '1', null, 'ChinaCity', '0', '', '', '0', '0');

-- ----------------------------
-- Table structure for jc_role
-- ----------------------------
DROP TABLE IF EXISTS `jc_role`;
CREATE TABLE `jc_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父角色ID',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of jc_role
-- ----------------------------
INSERT INTO `jc_role` VALUES ('1', '超级管理员', '0', '1', '拥有网站最高管理员权限！', '1329633709', '1329633709', '0');
INSERT INTO `jc_role` VALUES ('5', '网站管理员', null, '1', '网站后台管理员权限！', '1479775194', '1505440787', '0');
INSERT INTO `jc_role` VALUES ('6', '二级管理员(测试)', null, '1', '网站管理员(测试二级)', '1505439467', '0', '0');

-- ----------------------------
-- Table structure for jc_role_user
-- ----------------------------
DROP TABLE IF EXISTS `jc_role_user`;
CREATE TABLE `jc_role_user` (
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色 id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
-- Records of jc_role_user
-- ----------------------------
INSERT INTO `jc_role_user` VALUES ('5', '3');
INSERT INTO `jc_role_user` VALUES ('6', '63');

-- ----------------------------
-- Table structure for jc_route
-- ----------------------------
DROP TABLE IF EXISTS `jc_route`;
CREATE TABLE `jc_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `full_url` varchar(255) DEFAULT NULL COMMENT '完整url， 如：portal/list/index?id=1',
  `url` varchar(255) DEFAULT NULL COMMENT '实际显示的url',
  `listorder` int(5) DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1：启用 ;0：不启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='url路由表';

-- ----------------------------
-- Records of jc_route
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_attr
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_attr`;
CREATE TABLE `jc_sheet_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `attr_type` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cate-name` (`cate_id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_attr
-- ----------------------------
INSERT INTO `jc_sheet_attr` VALUES ('19', '2', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('20', '2', 'number', '件号', '2', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('21', '2', 'cate', '分类号', '3', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('22', '2', 'author', '责任者', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('23', '2', 'title_num', '文号', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('24', '2', 'title', '文件标题', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('25', '2', 'time', '成文日期', '7', 'date', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('26', '2', 'page', '页数', '8', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('27', '2', 'limit_time', '保管期限', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('28', '2', 'remark', '备注', '10', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('29', '4', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('30', '4', 'no', '案卷号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('31', '4', 'jiguan', '机关名称', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('32', '4', 'name', '案卷名称', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('33', '4', 'date', '起止日期', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('34', '4', 'limit', '保管期限', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('35', '4', 'page_num', '卷内张数', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('36', '4', 'author', '立卷人', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('37', '4', 'other', '其它情况', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('38', '5', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('39', '5', 'no', '案卷号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('40', '5', 'jiguan', '机关名称', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('41', '5', 'name', '案卷名称', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('42', '5', 'date', '起止日期', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('43', '5', 'limit', '保管期限', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('44', '5', 'page_num', '卷内张数', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('45', '5', 'author', '立卷人', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('46', '5', 'other', '其它情况', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('47', '6', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('48', '6', 'no', '案卷号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('49', '6', 'jiguan', '机关名称', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('50', '6', 'name', '案卷名称', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('51', '6', 'date', '起止日期', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('52', '6', 'limit', '保管期限', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('53', '6', 'page_num', '卷内张数', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('54', '6', 'author', '立卷人', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('55', '6', 'other', '其它情况', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('56', '7', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('57', '7', 'no', '案卷号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('58', '7', 'jiguan', '机关名称', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('59', '7', 'name', '案卷名称', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('60', '7', 'date', '起止日期', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('61', '7', 'limit', '保管期限', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('62', '7', 'page_num', '卷内张数', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('63', '7', 'author', '立卷人', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('64', '7', 'other', '其它情况', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('65', '9', 'sn', '档号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('66', '9', 'number', '件号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('67', '9', 'cate', '分类号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('68', '9', 'author', '责任者', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('69', '9', 'title_num', '文号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('70', '9', 'title', '文件标题', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('71', '9', 'time', '成文日期', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('72', '9', 'page', '页数', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('73', '9', 'limit_time', '保管期限', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('74', '9', 'remark', '备注', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('75', '10', 'no', '案卷号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('76', '10', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('77', '10', 'title', '案卷题名', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('78', '10', 'num', '文件件数', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('79', '10', 'page_num', '总页数', '5', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('80', '10', 'start_date', '起止日期', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('81', '10', 'danwei', '编制单位', '13', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('82', '10', 'limit', '保管期限', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('83', '10', 'cate_num', '分类号', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('84', '10', 'author', '立卷人', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('85', '10', 'guidang_time', '归档时间', '11', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('86', '10', 'secret', '密级', '12', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('87', '10', 'bianzhi_date', '编制日期', '14', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('88', '10', 'check_person', '检查人', '10', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('89', '10', 'type', '载体类型', '18', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('90', '10', 'guige', '规格', '19', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('91', '10', 'remark', '备注', '15', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('92', '10', 'dagsd', '档案馆室代', '16', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('93', '10', 'suowei_num', '缩微号', '17', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('94', '10', 'top', '附注', '20', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('95', '10', 'theme', '主题词', '21', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('96', '10', 'address', '存放地点', '22', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('97', '11', 'no', '案卷号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('98', '11', 'sn', '档号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('99', '11', 'title', '案卷题名', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('100', '11', 'num', '文件件数', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('101', '11', 'page_num', '总页数', '5', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('102', '11', 'start_date', '起止日期', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('103', '11', 'danwei', '编制单位', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('104', '11', 'limit', '保管期限', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('105', '11', 'cate_num', '分类号', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('106', '11', 'author', '立卷人', '10', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('107', '11', 'guidang_time', '归档时间', '11', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('108', '11', 'secret', '密级', '12', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('109', '11', 'bianzhi_date', '编制日期', '13', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('110', '11', 'check_person', '检查人', '14', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('111', '11', 'type', '载体类型', '15', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('112', '11', 'guige', '规格', '16', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('113', '11', 'remark', '备注', '17', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('114', '11', 'dagsd', '档案馆室代', '18', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('115', '11', 'suowei_num', '缩微号', '19', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('116', '11', 'top', '附注', '20', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('117', '11', 'theme', '主题词', '21', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('118', '11', 'address', '存放地点', '22', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('121', '13', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('122', '13', 'inner_sn', '卷内顺序号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('123', '13', 'title', '文件材料名', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('124', '13', 'num', '文件编号', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('125', '13', 'date', '日期', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('126', '13', 'author', '责任者', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('127', '13', 'limit', '保管期限', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('128', '13', 'remark', '备注', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('129', '13', 'secret', '密级', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('130', '13', 'cate_num', '分类号', '10', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('131', '13', 'location', '存放位置', '11', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('132', '13', 'page_num', '页数', '12', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_attr` VALUES ('133', '4', 'img', '图片', '10', 'img', '0000-00-00 00:00:00', '1');

-- ----------------------------
-- Table structure for jc_sheet_cate
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_cate`;
CREATE TABLE `jc_sheet_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `alias_template` varchar(255) DEFAULT NULL,
  `pid` int(10) NOT NULL DEFAULT '0',
  `parentspath` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '1',
  `sort_order` int(4) NOT NULL DEFAULT '0',
  `img` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_cate
-- ----------------------------
INSERT INTO `jc_sheet_cate` VALUES ('1', '文书档案', '', '', '0', '0,', '1', '2', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null);
INSERT INTO `jc_sheet_cate` VALUES ('2', '党群行政类', '', '', '0', '0,', '1', '1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', null);
INSERT INTO `jc_sheet_cate` VALUES ('3', '会计档案', '', '', '0', '0,', '1', '3', '', '2017-07-14 08:30:37', '2017-07-14 08:30:37', null);
INSERT INTO `jc_sheet_cate` VALUES ('4', '其它', '', '', '0', '0,', '1', '4', '', '2017-07-14 08:30:55', '2017-07-14 08:30:55', null);
INSERT INTO `jc_sheet_cate` VALUES ('5', '报表', '', '', '0', '0,', '1', '5', '', '2017-07-14 08:36:44', '2017-07-14 08:36:44', null);
INSERT INTO `jc_sheet_cate` VALUES ('6', '账册', '', '', '0', '0,', '1', '6', '', '2017-07-14 08:39:02', '2017-07-14 08:39:02', null);
INSERT INTO `jc_sheet_cate` VALUES ('7', '凭证', '', '', '0', '0,', '1', '7', '', '2017-07-14 08:39:57', '2017-07-14 08:39:57', null);
INSERT INTO `jc_sheet_cate` VALUES ('8', '科技档案', '', '', '0', '0,', '1', '8', '', '2017-07-14 08:40:15', '2017-07-14 08:40:15', null);
INSERT INTO `jc_sheet_cate` VALUES ('9', '设备类', '', '', '0', '0,', '1', '9', '', '2017-07-14 08:41:55', '2017-07-14 08:41:55', null);
INSERT INTO `jc_sheet_cate` VALUES ('10', '设备案卷级', '', '', '0', '0,', '1', '10', '', '2017-07-14 08:42:12', '2017-07-14 08:42:12', null);
INSERT INTO `jc_sheet_cate` VALUES ('11', '基建案卷', '', '', '0', '0,', '1', '11', '', '2017-07-14 08:42:47', '2017-07-14 08:42:47', null);
INSERT INTO `jc_sheet_cate` VALUES ('13', '基建卷内', '', '', '0', '0,', '1', '12', '', '2017-07-14 10:57:57', '2017-07-14 10:57:57', null);

-- ----------------------------
-- Table structure for jc_sheet_table1
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table1`;
CREATE TABLE `jc_sheet_table1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table1
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table10
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table10`;
CREATE TABLE `jc_sheet_table10` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `num` varchar(255) DEFAULT NULL,
  `page_num` int(10) NOT NULL DEFAULT '0',
  `start_date` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `cate_num` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `check_person` varchar(255) DEFAULT NULL,
  `guidang_time` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `danwei` varchar(255) DEFAULT NULL,
  `bianzhi_date` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `dagsd` varchar(255) DEFAULT NULL,
  `suowei_num` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `guige` varchar(255) DEFAULT NULL,
  `top` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table10
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table11
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table11`;
CREATE TABLE `jc_sheet_table11` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(255) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `num` varchar(255) DEFAULT NULL,
  `page_num` int(10) NOT NULL DEFAULT '0',
  `start_date` varchar(255) DEFAULT NULL,
  `danwei` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `cate_num` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `guidang_time` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `bianzhi_date` varchar(255) DEFAULT NULL,
  `check_person` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `guige` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `dagsd` varchar(255) DEFAULT NULL,
  `suowei_num` varchar(255) DEFAULT NULL,
  `top` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table11
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table13
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table13`;
CREATE TABLE `jc_sheet_table13` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `inner_sn` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `num` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `cate_num` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `page_num` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table13
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table2
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table2`;
CREATE TABLE `jc_sheet_table2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `number` int(10) NOT NULL DEFAULT '0',
  `cate` int(10) NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `title_num` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `time` date DEFAULT NULL,
  `page` int(10) NOT NULL DEFAULT '0',
  `limit_time` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table2
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table3
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table3`;
CREATE TABLE `jc_sheet_table3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table3
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table4
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table4`;
CREATE TABLE `jc_sheet_table4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `jiguan` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `page_num` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `img` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table4
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table5
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table5`;
CREATE TABLE `jc_sheet_table5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `jiguan` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `page_num` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table5
-- ----------------------------
INSERT INTO `jc_sheet_table5` VALUES ('1', '1', '1', '1', '1-1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for jc_sheet_table6
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table6`;
CREATE TABLE `jc_sheet_table6` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `jiguan` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `page_num` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table6
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table7
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table7`;
CREATE TABLE `jc_sheet_table7` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `jiguan` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `limit` varchar(255) DEFAULT NULL,
  `page_num` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table7
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table8
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table8`;
CREATE TABLE `jc_sheet_table8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table8
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_table9
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_table9`;
CREATE TABLE `jc_sheet_table9` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `cate` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `title_num` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `limit_time` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_table9
-- ----------------------------

-- ----------------------------
-- Table structure for jc_sheet_tmpl
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_tmpl`;
CREATE TABLE `jc_sheet_tmpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_tmpl
-- ----------------------------
INSERT INTO `jc_sheet_tmpl` VALUES ('1', '一文一件库', '2017-08-04 10:52:53', '1');
INSERT INTO `jc_sheet_tmpl` VALUES ('2', '教师业务', '2017-07-13 16:13:10', '1');
INSERT INTO `jc_sheet_tmpl` VALUES ('3', '学生业务', '2017-07-13 09:39:49', '1');
INSERT INTO `jc_sheet_tmpl` VALUES ('4', '基建卷内', '2017-07-14 11:30:54', '1');
INSERT INTO `jc_sheet_tmpl` VALUES ('5', '案卷库模版', '2017-07-13 14:39:10', '1');
INSERT INTO `jc_sheet_tmpl` VALUES ('6', '照片档案', '2017-07-13 15:05:24', '1');
INSERT INTO `jc_sheet_tmpl` VALUES ('7', '会计档案', '2017-07-13 16:30:12', '1');
INSERT INTO `jc_sheet_tmpl` VALUES ('8', '实物档案', '2017-09-04 15:38:46', '1');

-- ----------------------------
-- Table structure for jc_sheet_tmpl_attr
-- ----------------------------
DROP TABLE IF EXISTS `jc_sheet_tmpl_attr`;
CREATE TABLE `jc_sheet_tmpl_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `attr_type` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cate-name` (`cate_id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_sheet_tmpl_attr
-- ----------------------------
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('1', '4', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('2', '4', 'inner_sn', '卷内顺序号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('3', '4', 'title', '文件材料名', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('4', '4', 'num', '文件编号', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('5', '4', 'date', '日期', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('6', '4', 'author', '责任者', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('7', '4', 'limit', '保管期限', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('8', '4', 'remark', '备注', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('9', '4', 'secret', '密级', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('10', '4', 'cate_num', '分类号', '10', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('11', '4', 'location', '存放位置', '11', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('12', '4', 'page_num', '页数', '12', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('13', '5', 'no', '案卷号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('14', '5', 'sn', '档号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('15', '5', 'title', '案卷题名', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('16', '5', 'num', '文件件数', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('17', '5', 'page_num', '总页数', '5', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('18', '5', 'start_date', '起止日期', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('19', '5', 'danwei', '编制单位', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('20', '5', 'limit', '保管期限', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('21', '5', 'cate_num', '分类号', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('22', '5', 'author', '立卷人', '10', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('23', '5', 'guidang_time', '归档时间', '11', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('24', '5', 'secret', '密级', '12', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('25', '5', 'bianzhi_date', '编制日期', '13', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('26', '5', 'check_person', '检查人', '14', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('27', '5', 'type', '载体类型', '15', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('28', '5', 'guige', '规格', '16', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('29', '5', 'remark', '备注', '17', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('30', '5', 'dagsd', '档案馆室代', '18', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('31', '5', 'suowei_num', '缩微号', '19', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('32', '5', 'top', '附注', '20', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('33', '5', 'theme', '主题词', '21', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('34', '5', 'address', '存放地点', '22', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('35', '1', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('36', '1', 'number', '件号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('37', '1', 'cate', '分类号', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('38', '1', 'author', '责任者', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('39', '1', 'title_num', '文号', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('40', '1', 'title', '文件标题', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('41', '1', 'time', '成文日期', '7', 'date', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('42', '1', 'page', '页数', '8', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('43', '1', 'limit_time', '保管期限', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('44', '1', 'remark', '备注', '10', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('45', '2', 'name', '姓名', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('46', '2', 'sn', '档号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('47', '2', 'num', '教师编号', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('48', '2', 'title', '题名', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('49', '2', 'author', '责任者', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('50', '2', 'page_num', '页数', '6', 'num', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('51', '2', 'date', '日期', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('52', '3', 'sn', '档号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('53', '3', 'name', '姓名', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('54', '3', 'cate', '分类号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('55', '3', 'sex', '性别', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('56', '3', 'bianzhi_date', '编制日期', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('57', '3', 'remark', '备注', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('58', '3', 'out_time', '转出时间', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('59', '3', 'box_num', '盒号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('60', '6', 'zhaopian_num', '照片号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('61', '6', 'dipian_num', '底片号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('62', '6', 'title', '照片标题', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('63', '6', 'address', '拍摄地点', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('64', '6', 'abst', '文字说明', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('65', '6', 'author', '摄影者', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('66', '6', 'time', '拍摄时间', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('67', '6', 'limit', '保管期限', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('68', '6', 'secret', '密级', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('69', '6', 'page_num', '照片页号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('70', '6', 'dipian_location', '底片位置', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('71', '6', 'remark', '备注', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('72', '6', 'reason', '事由', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('73', '6', 'people', '人物', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('74', '6', 'background', '背景', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('75', '6', 'canjian_num', '参见号', '0', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('76', '7', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('77', '7', 'no', '案卷号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('78', '7', 'jiguan', '机关名称', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('79', '7', 'name', '案卷名称', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('80', '7', 'date', '起止日期', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('81', '7', 'limit', '保管期限', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('82', '7', 'page_num', '卷内张数', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('84', '7', 'author', '立卷人', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('85', '7', 'other', '其它情况', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('87', '8', 'sn', '档号', '1', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('88', '8', 'no', '卷内顺序号', '2', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('89', '8', 'num', '编号', '3', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('90', '8', 'title', '题名', '4', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('91', '8', 'author', '责任者', '5', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('92', '8', 'type', '类别', '6', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('93', '8', 'date', '日期', '7', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('94', '8', 'limit', '保管期限', '8', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('95', '8', 'remark', '备注', '9', 'text', '0000-00-00 00:00:00', '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('96', '1', 'img', '图片', '11', 'img', null, '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('97', '1', 'file', '附件', '12', 'file', null, '1');
INSERT INTO `jc_sheet_tmpl_attr` VALUES ('98', '8', 'field9', '新增字段9', '10', 'img', null, '1');

-- ----------------------------
-- Table structure for jc_shop_cart
-- ----------------------------
DROP TABLE IF EXISTS `jc_shop_cart`;
CREATE TABLE `jc_shop_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID（相同用户ID的数据为同一个购物车）',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `info` text COMMENT '加入购物车时商品的信息',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `update_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `props` text COMMENT '加入购物车时attr信息',
  `num` int(3) unsigned NOT NULL DEFAULT '1' COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_shop_cart
-- ----------------------------
INSERT INTO `jc_shop_cart` VALUES ('84', '64', '19', null, '1', '2017-08-01 16:17:43', '2017-08-01 16:17:43', '1:1|2:6|4:14', '1');

-- ----------------------------
-- Table structure for jc_slide
-- ----------------------------
DROP TABLE IF EXISTS `jc_slide`;
CREATE TABLE `jc_slide` (
  `slide_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slide_cid` int(11) NOT NULL COMMENT '幻灯片分类 id',
  `slide_name` varchar(255) NOT NULL COMMENT '幻灯片名称',
  `slide_pic` varchar(255) DEFAULT NULL COMMENT '幻灯片图片',
  `slide_middle_pic` varchar(255) DEFAULT NULL,
  `slide_big_pic` varchar(255) DEFAULT NULL,
  `slide_url` varchar(255) DEFAULT NULL COMMENT '幻灯片链接',
  `slide_des` varchar(255) DEFAULT NULL COMMENT '幻灯片描述',
  `slide_content` text COMMENT '幻灯片内容',
  `slide_status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  `listorder` int(10) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`slide_id`),
  KEY `slide_cid` (`slide_cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='幻灯片表';

-- ----------------------------
-- Records of jc_slide
-- ----------------------------

-- ----------------------------
-- Table structure for jc_slide_cat
-- ----------------------------
DROP TABLE IF EXISTS `jc_slide_cat`;
CREATE TABLE `jc_slide_cat` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL COMMENT '幻灯片分类',
  `cat_idname` varchar(255) NOT NULL COMMENT '幻灯片分类标识',
  `cat_remark` text COMMENT '分类备注',
  `cat_status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`cid`),
  KEY `cat_idname` (`cat_idname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='幻灯片分类表';

-- ----------------------------
-- Records of jc_slide_cat
-- ----------------------------

-- ----------------------------
-- Table structure for jc_tax
-- ----------------------------
DROP TABLE IF EXISTS `jc_tax`;
CREATE TABLE `jc_tax` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `year` int(10) unsigned NOT NULL COMMENT '年份',
  `date` date NOT NULL COMMENT '缴费日期',
  `user_id` int(10) unsigned NOT NULL COMMENT '缴费党员ID',
  `uid` int(10) unsigned NOT NULL COMMENT '添加记录用户ID',
  `price` float unsigned NOT NULL COMMENT '缴费金额',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '扣款成功',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `month` int(10) unsigned NOT NULL COMMENT '月份',
  `card` varchar(255) NOT NULL COMMENT '缴费银行卡号',
  `pay_cate` int(10) unsigned NOT NULL COMMENT '支付方式',
  `order_id` varchar(255) NOT NULL COMMENT '订单ID',
  `pay_type` varchar(60) DEFAULT '' COMMENT '支付类型',
  `pay_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单实际支付的金额',
  `pay_time` datetime DEFAULT NULL,
  `pay_json` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_tax
-- ----------------------------

-- ----------------------------
-- Table structure for jc_users
-- ----------------------------
DROP TABLE IF EXISTS `jc_users`;
CREATE TABLE `jc_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) DEFAULT '' COMMENT '登录密码；sp_password加密',
  `user_nicename` varchar(50) DEFAULT '' COMMENT '用户美名',
  `user_email` varchar(100) DEFAULT '' COMMENT '登录邮箱',
  `user_url` varchar(100) DEFAULT '' COMMENT '用户个人网站',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像，相对于upload/avatar目录',
  `sex` smallint(1) DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `signature` varchar(255) DEFAULT NULL COMMENT '个性签名',
  `last_login_ip` varchar(16) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime DEFAULT '2000-01-01 00:00:00' COMMENT '最后登录时间',
  `create_time` datetime DEFAULT '2000-01-01 00:00:00' COMMENT '注册时间',
  `update_time` datetime DEFAULT NULL,
  `user_activation_key` varchar(60) DEFAULT '' COMMENT '激活码',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `user_type` smallint(1) DEFAULT '2' COMMENT '用户类型，1:admin ;2:会员',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `mobile` varchar(20) DEFAULT '' COMMENT '手机号',
  `org_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '2',
  `sessionID` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of jc_users
-- ----------------------------
INSERT INTO `jc_users` VALUES ('1', 'master', '###4fad1d49cb8e2fda7be5e50e23cdad7f', '超级管理员', 'master@qq.com', '', null, '0', null, '', '0.0.0.0', '2017-09-15 09:36:05', '2014-10-27 08:40:35', null, '', '1', '0', '1', '0', '', '0', '1', null);
INSERT INTO `jc_users` VALUES ('3', 'admin', '###4fad1d49cb8e2fda7be5e50e23cdad7f', '网站管理员', 'admin@qq.com', '', null, '0', null, '', '0.0.0.0', '2017-09-15 09:26:34', '2016-11-22 08:40:20', '2017-07-01 10:25:05', '', '1', '0', '1', '0', '', '0', '1', null);
INSERT INTO `jc_users` VALUES ('63', 'test', '###ac51e235ac48e92c77086f49525a8283', 'test', 'test@qq.com', '', null, '0', null, null, '127.0.0.1', '2017-07-01 10:32:22', '2017-07-01 10:25:37', '2017-09-15 09:38:36', '', '1', '0', '1', '0', '', '0', '2', null);
INSERT INTO `jc_users` VALUES ('65', 'qwe', '###4fad1d49cb8e2fda7be5e50e23cdad7f', 'qwe', '', '', null, '1', '2017-07-01', null, null, '2000-01-01 00:00:00', '2017-07-01 11:06:25', '2017-09-15 09:52:21', '', '1', '0', '2', '0', '13587418155', '0', '2', null);

-- ----------------------------
-- Table structure for jc_users_info
-- ----------------------------
DROP TABLE IF EXISTS `jc_users_info`;
CREATE TABLE `jc_users_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcard` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `nation` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `join_time` date DEFAULT NULL,
  `become_time` date DEFAULT NULL,
  `work_address` varchar(255) DEFAULT NULL,
  `record` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_users_info
-- ----------------------------
INSERT INTO `jc_users_info` VALUES ('65', '', '', '1', '', null, null, '', '', '', '');

-- ----------------------------
-- Table structure for jc_user_address
-- ----------------------------
DROP TABLE IF EXISTS `jc_user_address`;
CREATE TABLE `jc_user_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `area_ids` varchar(255) NOT NULL DEFAULT '0',
  `address` varchar(800) NOT NULL DEFAULT '' COMMENT '详细地址',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `usage_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用次数',
  `default` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认使用这条为收件地址',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '联系电话',
  `zip_code` varchar(255) NOT NULL DEFAULT '' COMMENT '邮政编码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_user_address
-- ----------------------------

-- ----------------------------
-- Table structure for jc_user_favorites
-- ----------------------------
DROP TABLE IF EXISTS `jc_user_favorites`;
CREATE TABLE `jc_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL COMMENT '用户 id',
  `title` varchar(255) DEFAULT NULL COMMENT '收藏内容的标题',
  `url` varchar(255) DEFAULT NULL COMMENT '收藏内容的原文地址，不带域名',
  `description` varchar(500) DEFAULT NULL COMMENT '收藏内容的描述',
  `table` varchar(50) DEFAULT NULL COMMENT '收藏实体以前所在表，不带前缀',
  `object_id` int(11) DEFAULT NULL COMMENT '收藏内容原来的主键id',
  `createtime` int(11) DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收藏表';

-- ----------------------------
-- Records of jc_user_favorites
-- ----------------------------

-- ----------------------------
-- Table structure for jc_user_group
-- ----------------------------
DROP TABLE IF EXISTS `jc_user_group`;
CREATE TABLE `jc_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_user_group
-- ----------------------------
INSERT INTO `jc_user_group` VALUES ('1', '正式党员', '1');
INSERT INTO `jc_user_group` VALUES ('2', '入党积极分子', '1');
INSERT INTO `jc_user_group` VALUES ('3', '其它', '1');

-- ----------------------------
-- Table structure for jc_video
-- ----------------------------
DROP TABLE IF EXISTS `jc_video`;
CREATE TABLE `jc_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cate_id` char(50) NOT NULL COMMENT '分类',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `img` varchar(255) NOT NULL COMMENT '图片',
  `hits` int(10) unsigned NOT NULL COMMENT '点击量',
  `is_best` tinyint(2) NOT NULL COMMENT '是否推荐',
  `is_hot` tinyint(2) NOT NULL COMMENT '是否热门',
  `is_top` tinyint(2) NOT NULL COMMENT '是否置顶',
  `seo_title` varchar(255) NOT NULL COMMENT 'SEO标题',
  `seo_keys` varchar(255) NOT NULL COMMENT 'SEO关键词',
  `seo_desc` varchar(255) NOT NULL COMMENT 'SEO描述',
  `subject_cate` tinyint(2) NOT NULL COMMENT '课程性质',
  `study_time` float NOT NULL COMMENT '学分',
  `subject_info` varchar(255) NOT NULL COMMENT '课程简介',
  `video` varchar(255) NOT NULL COMMENT '视频地址',
  `album` varchar(255) NOT NULL COMMENT '专辑名',
  `video_time` int(10) unsigned NOT NULL COMMENT '视频时长',
  `speaker` varchar(255) NOT NULL COMMENT '主讲人',
  `studyEndNum` int(10) unsigned NOT NULL COMMENT '学完人数',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `status` tinyint(2) NOT NULL COMMENT '状态',
  `edit_time` datetime NOT NULL COMMENT '修改时间',
  `sort_order` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_video
-- ----------------------------

-- ----------------------------
-- Table structure for jc_video_cate
-- ----------------------------
DROP TABLE IF EXISTS `jc_video_cate`;
CREATE TABLE `jc_video_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `alias_template` varchar(255) DEFAULT NULL,
  `pid` int(10) NOT NULL DEFAULT '0',
  `parentspath` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '0',
  `sort_order` int(4) NOT NULL DEFAULT '0',
  `record_nums` int(10) NOT NULL DEFAULT '0',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keys` varchar(255) DEFAULT NULL,
  `seo_desc` text,
  `img` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `abst` text,
  `info` text,
  `remark` text,
  `add_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jc_video_cate
-- ----------------------------

-- ----------------------------
-- Table structure for jc_video_score
-- ----------------------------
DROP TABLE IF EXISTS `jc_video_score`;
CREATE TABLE `jc_video_score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `year` int(10) unsigned NOT NULL COMMENT '学习年份',
  `bixiu` float unsigned NOT NULL COMMENT '必修课学分',
  `xuanxiu` float unsigned NOT NULL COMMENT '选修课学分',
  `score` float unsigned NOT NULL COMMENT '总学分',
  `bixiu_status` tinyint(2) NOT NULL COMMENT '必修课状态',
  `xuanxiu_status` tinyint(2) NOT NULL COMMENT '选修课状态',
  `org_id` int(10) unsigned NOT NULL COMMENT '组织ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_video_score
-- ----------------------------

-- ----------------------------
-- Table structure for jc_video_time
-- ----------------------------
DROP TABLE IF EXISTS `jc_video_time`;
CREATE TABLE `jc_video_time` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `video_id` int(10) unsigned NOT NULL COMMENT '视频ID',
  `time` int(10) unsigned NOT NULL COMMENT '时间（秒）',
  `isend` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否看完',
  `is_choose` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否选课',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_video` (`uid`,`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of jc_video_time
-- ----------------------------
