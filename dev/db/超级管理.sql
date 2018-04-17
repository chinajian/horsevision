#异常日志
create table `super_exception_log`(
	`id` int unsigned not null auto_increment,
	`error_info` varchar(512) not null default '',#自定义错误信息
	`message` varchar(512) not null default '' comment '异常信息',
	`file` varchar(512) not null default '' comment '异常文件',
	`line` smallint unsigned not null default 0  comment '异常所在行',
	`code` varchar(32) not null default '' comment '异常码',
	`create_time` int unsigned not null default 0 comment '产生时间',
	`comid` mediumint unsigned not null default 0,
	`appid` char(18) not null default '',#每个应用的appid
	primary key (`id`)
) engine=MyISAM default charset=utf8;