#活动设置
create table `h5_luckydraw_config`(
	`lid` mediumint unsigned not null auto_increment,
	`activity_name` varchar(64) not null default '' comment '活动名称',
	`exchange_code` char(6) not null default '' comment '兑换码',#用于线下兑换的时候，输入兑换码
	`begin_time` int unsigned not null default 0 comment '开始时间',
	`end_time` int unsigned not null default 0 comment '结束时间',
	`is_close` tinyint(1) unsigned not null default 0 comment '是否关闭',#0-活动正常进行中 1-活动已关闭
	`is_test` tinyint(1) unsigned not null default 1 comment '是否测试',#0-正式运营中 1-测试中
	`appid` char(18) not null default '' comment 'appid',#组合规则 'h5ld' + 本次的id + 随机字符串（保证整体18位）
	`comid` mediumint unsigned not null default 0,#单位id
	primary key (`lid`)
) engine=InnoDB default charset=utf8;
insert into h5_luckydraw_config (lid, appid) values(1, "h5ld1gs648e15smt38");

#抽奖时间段,比如5月1日12:00~13:00,5月1日14:00~15:00
create table `h5_luckydraw_time`(
	`tid` mediumint unsigned not null auto_increment,
	`luckydraw_begin_time` int unsigned not null default 0 comment '开始时间',
	`luckydraw_end_time` int unsigned not null default 0 comment '结束时间',
	`lid` mediumint unsigned not null default 0,#h5_luckydraw_config 表中的lid 的外键
	primary key (`tid`)
) engine=InnoDB default charset=utf8;


#奖品信息
create table `h5_luckydraw_prize`(
	`pid` mediumint unsigned not null auto_increment,
	`prize_name` varchar(32) not null default '' comment '奖品名称',
	`prize_img` varchar(512) not null default '' comment '奖品图片',
	`is_red_packet` tinyint(1) unsigned not null default 0 comment '微信红包',#0-普通商品 1-微信红包 （如果是红包，需要调动微信红包接口）
	`red_packet_money` smallint unsigned not null default 0 comment '红包金额',#以分为单位
	`is_thanks` tinyint(1) unsigned not null default 1 comment '谢谢参与奖',#0-中奖了 1-谢谢参与 此项是特殊的奖品，为系统独有，不能删除
	`lid` mediumint unsigned not null default 0,#h5_luckydraw_config 表中的lid 的外键
	primary key (`pid`)
) engine=InnoDB default charset=utf8;
insert into h5_luckydraw_prize (pid, prize_name, is_thanks, lid) values(1, "谢谢参与", 1, 0);

#抽奖配比
create table `h5_luckydraw_ratio`(
	`id` mediumint unsigned not null auto_increment,
	`pid` mediumint unsigned not null default 0,#h5_luckydraw_prize 表中的pid 的外键
	`tid` mediumint unsigned not null default 0,#h5_luckydraw_time 表中的tid 的外键
	`probability` smallint unsigned not null default 0 comment '概率',#比如值为10，就是10/10000的概率
	`total_num` smallint unsigned not null default 0 comment '总数量',#一共的数量
	`out_num` smallint unsigned not null default 0 comment '中出总数量',#中出去的数量
	`sort` mediumint unsigned not null default 0 comment '排序',
	primary key (`id`)
) engine=InnoDB default charset=utf8;

