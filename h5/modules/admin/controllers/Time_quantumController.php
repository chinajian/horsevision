<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\admin\controllers\BasicController;
use app\modules\admin\models\TimeQuantum;
use app\modules\admin\models\SysLog;


class Time_quantumController extends BasicController
{
    /**
     * 抽奖时间段设置
     */
    public function actionIndex()
    {
    	/*如果有数据，进行修改*/
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            // P($post);
            $transaction = Yii::$app->db->beginTransaction();//事物处理
            try{
                if(isset($post['TimeQuantum']['luckydraw_begin_time'])){
                    foreach($post['TimeQuantum']['luckydraw_begin_time'] as $k => $v){
                        $timeQuantumModel = new TimeQuantum;
                        $newData['TimeQuantum'] = '';
                        $newData['TimeQuantum']['luckydraw_begin_time'] = $post['TimeQuantum']['luckydraw_begin_time'][$k];
                        $newData['TimeQuantum']['luckydraw_end_time'] = $post['TimeQuantum']['luckydraw_end_time'][$k];
                        $newData['TimeQuantum']['lid'] = Yii::$app->params['lid'];
                        if(!$timeQuantumModel->set($newData, $k)){
                            if($timeQuantumModel->hasErrors()){
                                return ShowRes(30010, $timeQuantumModel->getErrors());
                            }else{
                                return ShowRes(30000, '修改失败');
                            }
                        }
                    }

                    /*
                    删除之前多余的时间段，比如之前有3条记录，现在只有2条记录
                    */
                    $timeQuantum = TimeQuantum::find()->where('lid = :lid', [':lid' => Yii::$app->params['lid']])->offset($k+1)->all();
                    foreach($timeQuantum as $k => $v){
                        $timeQuantum[$k]->delete();
                    }

                }

                $transaction->commit();
                /*写入日志*/
                SysLog::addLog('设置时间段成功');
                return ShowRes(0, '设置成功');
            }catch(\Exception $e){
                $transaction->rollback();
                if(YII_DEBUG){
                    return ShowRes(30020, '异常信息：'.$e->getMessage().'异常文件：'.$e->getFile().'异常所在行：'.$e->getLine().'异常码：'.$e->getCode());
                }else{
                    // throw new \Exception();
                    return ShowRes(30020, '异常杯具');
                }
                return false;
            };
            return;
        }

        $timeQuantum = TimeQuantum::find()->where('lid = :lid', [':lid' => Yii::$app->params['lid']])->asArray()->all();
        // P($timeQuantum);
    	return $this->render('index', [
            'timeQuantum' => $timeQuantum
        ]);

    }


}
