<?php

namespace app\modules\admin\models;

use Yii;

class TimeQuantum extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%time_quantum}}';
    }

    public function rules()
    {
        return [
            ['luckydraw_begin_time', 'required', 'message' => '活动开始时间不能为空'],
            ['luckydraw_begin_time', 'integer', 'message' => '活动开始时间必须为正整数'],
            ['luckydraw_end_time', 'required', 'message' => '活动结束时间不能为空'],
            ['luckydraw_end_time', 'integer', 'message' => '活动结束时间必须为正整数'],
            ['lid', 'integer', 'message' => '应用ID必须为正整数'],
        ];
    }

    /*
    更新 抽奖时间段
    $index  更新第几条数据
    */
    public function set($data, $index)
    {
        /*根据索引，取出对应的价格区间*/
        $timeQuantum = self::find()->where('lid = :lid', [':lid' => Yii::$app->params['lid']])->orderBy(['tid' => SORT_ASC])->offset($index)->limit(1)->one();

        if(!empty($timeQuantum)){
            if(isset($data['TimeQuantum']['luckydraw_begin_time']) and !empty($data['TimeQuantum']['luckydraw_begin_time'])){
                $data['TimeQuantum']['luckydraw_begin_time'] = strtotime($data['TimeQuantum']['luckydraw_begin_time']);
            }else{
                unset($data['TimeQuantum']['luckydraw_begin_time']);
            }
            if(isset($data['TimeQuantum']['luckydraw_end_time']) and !empty($data['TimeQuantum']['luckydraw_end_time'])){
                $data['TimeQuantum']['luckydraw_end_time'] = strtotime($data['TimeQuantum']['luckydraw_end_time']);
            }else{
                unset($data['TimeQuantum']['luckydraw_end_time']);
            }
            
            if($index){//必须要第二个才需要判断，第一个不需要判断
                /*查询上一条数据，为了判断是否跟上一条数据，时间是否重合，必须要在上一条数据的时间下面*/
                $timeQuantumPrev = self::find()->where('lid = :lid', [':lid' => Yii::$app->params['lid']])->offset($index-1)->limit(1)->one();
                if($timeQuantumPrev->luckydraw_end_time > $data['TimeQuantum']['luckydraw_begin_time']){
                    $this->addError('luckydraw_begin_time', '不能早于上一个时间段');
                    return false;
                }
            }

            /*修改数据*/
            $timeQuantum->luckydraw_begin_time = $data['TimeQuantum']['luckydraw_begin_time'];
            $timeQuantum->luckydraw_end_time = $data['TimeQuantum']['luckydraw_end_time'];
            if($timeQuantum->validate()){
                if($timeQuantum->save(false)){
                    return true;
                }
            }

        }else{
            /*说明之前没有，需要添加新的数据*/
            if($this->add($data)){
                return true;
            }
        }
    }


    /*增加时间段*/
    public function add($data)
    {
        if(isset($data['TimeQuantum']['luckydraw_begin_time']) and !empty($data['TimeQuantum']['luckydraw_begin_time'])){
            $data['TimeQuantum']['luckydraw_begin_time'] = strtotime($data['TimeQuantum']['luckydraw_begin_time']);
        }else{
            unset($data['TimeQuantum']['luckydraw_begin_time']);
        }
        if(isset($data['TimeQuantum']['luckydraw_end_time']) and !empty($data['TimeQuantum']['luckydraw_end_time'])){
            $data['TimeQuantum']['luckydraw_end_time'] = strtotime($data['TimeQuantum']['luckydraw_end_time']);
        }else{
            unset($data['TimeQuantum']['luckydraw_end_time']);
        }
        // P($data);
        if($this->load($data) and $this->validate()){
            if($this->save(false)){
                return true;
            }
        }
        return false;

    }


}
