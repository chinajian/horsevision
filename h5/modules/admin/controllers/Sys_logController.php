<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\admin\controllers\BasicController;
use app\modules\admin\models\SysLog;


class Sys_logController extends BasicController
{
    /**
     * 操作日志
     */
    public function actionIndex()
    {
    	$get = Yii::$app->request->get();
        if(isset($get['page'])){
            $currPage = (int)$get['page']?$get['page']:1;
        }else{
            $currPage = 1;
        }
        $sysLogModel = SysLog::find();
        $count = $sysLogModel->count();
        $pageSize = Yii::$app->params['pageSize'];
        $sysLogList = $sysLogModel->offset($pageSize*($currPage-1))->limit($pageSize)->orderBy(['log_id'=>SORT_DESC])->all();
    	// P($sysLogList);
        return $this->render('index', [
            'sysLogList' => $sysLogList,
    		'pageInfo' => [
                'count' => $count,
                'currPage' => $currPage,
                'pageSize' => $pageSize,
            ]
    	]);
    }



}
