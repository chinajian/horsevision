<?php 
    use yii\helpers\Url;
?>
<nav class="navbar navbar-default child-nav">
	<h5 class="nav pull-left">奖品配比列表</h5>
	<div class="nav pull-right">
		<a href="<?php echo yii\helpers\Url::to(['ratio/add-ratio'])?>" type="button" class="btn btn-info btn-xs" style='margin-top: 9px;'><span class="glyphicon glyphicon-plus"></span> 添加奖品配比</a>
	</div>
</nav>
<div class="clearfix" style="margin: -10px 0 10px 0;">
	<form class="form-inline" id="searchForm">
		<div class="form-group">
			<label for="sid" class="control-label">选择场次：</label>
			<select class="form-control input-sm" name="sid" id="sid">
				<option value="0">全部场次</option>
				<?php foreach($seasonList as $k => $v){?>
					<option value="<?php echo $v['sid'];?>" <?php if(isset($get['sid']) and ($get['sid'] === $v['sid'])){?>selected<?php }?>><?php echo $v['season_name'];?>（<?php echo date('Y-m-d H:i:s', $v['luckydraw_begin_time']);?> ~ <?php echo date('Y-m-d H:i:s', $v['luckydraw_end_time']);?>）</option>
				<?php }?>
			</select>
		</div>
		<button type="button" class="btn btn-info btn-sm" id="search">搜索</button>
	</form>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-condensed table-striped">
		<thead>
			<tr class="active">
				<th class="text-center width-50">ID</th>
				<th>奖品名称</th>
				<th>奖品图片</th>
				<th>微信红包</th>
				<th>场次</th>
				<th>概率</th>
				<th>中奖数量/总数量</th>
				<th class="text-center width-150">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($ratioList as $k => $v){?>	
			<tr>
				<td class="text-center"><?php echo $v['id'];?></td>
				<td><?php echo $v['prize']['prize_name'];?></td>
				<td>
					<?php if($v['prize']['prize_img']){?>
						<div class='table-img'><img src='<?php echo explode(',', $v['prize']['prize_img'])[0];?>'></div>
					<?php }?>
				</td>
				<td>
					<?php if($v['prize']['is_red_packet']){?>
						<span class="glyphicon glyphicon-usd text-danger"></span><?php echo $v['prize']['red_packet_money'];?>
					<?php }?>
				</td>
				<td><?php echo $v['season']['season_name'];?>（<?php echo date('Y-m-d H:i:s', $v['season']['luckydraw_begin_time']);?> ~ <?php echo date('Y-m-d H:i:s', $v['season']['luckydraw_end_time']);?>）</td>
				<td><?php echo $v['probability'];?>/10000</td>
				<td><?php echo $v['out_num'];?>/<?php echo $v['total_num'];?></td>
				<td class="text-center" data-id="<?php echo $v['id'];?>">
					<button type="button" class="btn btn-danger btn-xs del"><span class="glyphicon glyphicon-remove"></span> 删除</button>
					<a href="<?php echo Url::to(['ratio/mod-ratio', 'id' => $v['id']])?>" type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"></span> 修改</a>
				</td>
			</tr>
			<?php }?>
		</tbody>
		<tfoot class="pages">
			<tr>
				<td class="pagelist noselect text-right" colspan="9"></td>
			</tr>
		</tfoot>
	</table>
</div>
<script type="text/javascript">
	/*搜索*/
	$("#search").click(function(){
        window.location.href = '<?php echo Url::to(['ratio/ratio-list'])?>&' + $('#searchForm').serialize();
    })



	/*删除配比*/
	confirmation($('.del'), function(){
		var self = $(".popover").prev();
		self.confirmation('hide');
		var id = self.parent().data("id");
		if(id){
			var data = {
				'id': id
			}
			jajax('<?php echo Url::to(['ratio/del-ratio'])?>', data);
		}
	});

	/*分页*/
	var page = new Paging();
	page.init({
		target: $('.pagelist'),
		pagesize: <?php echo $pageInfo['pageSize']?$pageInfo['pageSize']:1;?>,
		count: <?php echo $pageInfo['count']?>,
		// toolbar: true,
		hash: true,
		current: <?php echo $pageInfo['currPage']?>,
		pageSizeList: [5, 10, 15, 20 ,50],
		changePagesize: function(currPage){
			window.location.href = "<?php echo Url::to(['ratio/ratio-list'])?>?page=" + currPage;
		},
		callback: function (currPage, size, count) {
			// jajax("<?php echo Url::to(['ratio/ratio-list'])?>?page=" + currPage);
			window.location.href = "<?php echo Url::to(['ratio/ratio-list'])?>?page=" + currPage;
		}
	});
</script>