<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "randoms".
 *
 * @property int $id
 * @property int $rndNumber
 */
class Randoms extends \yii\db\ActiveRecord
{
    const START = 0;
    const END=100;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'randoms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rndNumber'], 'required'],
            [['rndNumber'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rndNumber' => 'Rnd Number',
        ];
    }

    public function fields()
    {
        return ['id'=>'id'];
    }

    public function extraFields()
    {
        return [
            'rndNumber'=>'rndNumber'
        ];
    }

    public function generate($params)
    {
        $start = self::START;
        $end = self::END;

        if (isset($params['start']) && is_numeric($params['start'])) {
            if ($start<=$params['start']){
            $start = $params['start'];}

            if (isset($params['end']) && is_numeric($params['end'])) {
                if ($end <= $params['end']) {
                    $end = $params['end'];
                }
            }
        }
        $rand = mt_rand($start, $end);

        $this->rndNumber = $rand;
    }


}
