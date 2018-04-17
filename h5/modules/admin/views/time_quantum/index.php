<?php 
    use yii\helpers\Url;
?>
<script src="<?php echo ADMIN_SITE_URL;?>datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo ADMIN_SITE_URL;?>datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<link rel="stylesheet" href="<?php echo ADMIN_SITE_URL;?>datetimepicker/bootstrap-datetimepicker.min.css"/>

<nav class="navbar navbar-default child-nav">
    <h5 class="nav pull-left">时间段设置</h5>
</nav>
<form class="form-horizontal" id="time-quantum">
    <div id="time-quantum-list">
        <?php 
        if($timeQuantum){
        foreach($timeQuantum as $k => $v){?>
            <div class="form-group">
                <label for="luckydraw_begin_time" class="col-sm-2 control-label">时间段</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm form_datetime" name="TimeQuantum[luckydraw_begin_time][]" id="luckydraw_begin_time" placeholder="开始时间" value="<?php echo $v['luckydraw_begin_time']?date('Y-m-d H:i', $v['luckydraw_begin_time']):''?>" readonly style="display: inline-block; width: 35%">
                    ~
                    <input type="text" class="form-control input-sm form_datetime" name="TimeQuantum[luckydraw_end_time][]" id="luckydraw_end_time" placeholder="结束时间" value="<?php echo $v['luckydraw_end_time']?date('Y-m-d H:i', $v['luckydraw_end_time']):''?>" readonly style="display: inline-block; width: 35%">
                    <button type="button" class="btn btn-danger btn-sm del-time-quantum"><span class="glyphicon glyphicon-remove"></span> 删除</button>
                </div>
            </div>
        <?php }}else{?>
            <div class="form-group">
                <label for="luckydraw_begin_time" class="col-sm-2 control-label">时间段</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm form_datetime" name="TimeQuantum[luckydraw_begin_time][]" id="luckydraw_begin_time" placeholder="开始时间" value="" readonly style="display: inline-block; width: 35%">
                    ~
                    <input type="text" class="form-control input-sm form_datetime" name="TimeQuantum[luckydraw_end_time][]" id="luckydraw_end_time" placeholder="结束时间" value="" readonly style="display: inline-block; width: 35%">
                    <button type="button" class="btn btn-danger btn-sm del-time-quantum"><span class="glyphicon glyphicon-remove"></span> 删除</button>
                </div>
            </div>
        <?php }?>
    </div>
    
    <div class="form-group">
        <div class="col-sm-10 col-md-offset-2">
            <button type="button" class="btn btn-info btn-sm" id="add-time-quantum"><span class="glyphicon glyphicon-plus"></span> 增加时间段</button>
            <button type="button" class="btn btn-primary btn-sm" id="mod"><span class="glyphicon glyphicon-ok"></span> 提交</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    /*增加时间段*/
    $('#add-time-quantum').click(function(){
        var tpl = `<div class="form-group">
            <label for="luckydraw_begin_time" class="col-sm-2 control-label">时间段</label>
            <div class="col-sm-10">
                <input type="text" class="form-control input-sm form_datetime" name="TimeQuantum[luckydraw_begin_time][]" id="luckydraw_begin_time" placeholder="开始时间" value="" readonly style="display: inline-block; width: 35%">
                ~
                <input type="text" class="form-control input-sm form_datetime" name="TimeQuantum[luckydraw_end_time][]" id="luckydraw_end_time" placeholder="结束时间" value="" readonly style="display: inline-block; width: 35%">
                <button type="button" class="btn btn-danger btn-sm del-time-quantum"><span class="glyphicon glyphicon-remove"></span> 删除</button>
            </div>
        </div>`;
        $('#time-quantum-list').append(tpl);
        /*创建日期*/
        createDatetimepicker();
    })

    /*删除时间段*/
    $('#time-quantum-list').on('click', '.del-time-quantum', function(){
        $(this).parent().parent().remove(); 
    })

    /*创建日期*/
    createDatetimepicker();
    function createDatetimepicker(){
        $('.form_datetime').datetimepicker({
            language:  'zh-CN',
            format: "yyyy-mm-dd hh:ii",
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            minView: 0,
            maxView: 1
        });
    }

    /*修改*/
    var successUrl = '<?php echo Url::to(['time_quantum/index'])?>';
    $("#mod").click(function(){
        jajax("<?php echo Url::to(['time_quantum/index'])?>", $('#time-quantum').serialize());
    })
</script>