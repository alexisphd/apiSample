<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Randoms;
use yii\base\BaseObject;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;
use yii\web\UploadedFile;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ApiConsoleController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        echo "Here you can do:
- generate rand number with set request (you can also add details with
start and end numbers). You will see it's id. Sample: yii api-console/set 1000 10000
 - retrieve number with get request, putting the id to get the result.
    Sample: yii api-console/get 2";

        return ExitCode::OK;
    }
    /* function to set  the number
    Sample: yii api-console/set 10 120
     * */
    public function actionSet($start, $end){
       if(!is_numeric($start) && !is_numeric($end)){
            echo ('Put only numbers here');
            return ExitCode::CANTCREAT;
        }
        $model = new Randoms();
        $model->generate(array('start'=>$start,'end'=>$end));

        if ($model->save() === false && !$model->hasErrors()) {
            echo ('Cannot save');
            return ExitCode::UNAVAILABLE;
        }
        print_r( [
            'number' => $model->rndNumber,
            'id'=>$model->id,
        ]);
        return ExitCode::OK;

    }

    /* function to get the number by id
Sample: yii api-console/get 2
 * */
    public function actionGet($id){
        if (!is_numeric($id)) {
            echo ('No such id');
            return ExitCode::UNAVAILABLE;
        }

        $model = Randoms::findOne($id);
        if (!$model) {
           print_r( [
                'error' => 'There is no number with this id',
                'code' => 404,
            ]);  return ExitCode::UNAVAILABLE;
        }
        print_r( [
            'number' => $model->rndNumber,
            'id'=>$model->id,
        ]);
        echo ('All ok');
        return ExitCode::OK;

    }
/* function to get the report
Sample: yii api-console/get-all
 report.txt file you can find in web/uploads
 * */
    public function actionGetAll(){
        $model = new Randoms();
        $data = $model->find()->select('rndNumber')->asArray()->all();
        if (!$data) {
            echo ('No data');
            return ExitCode::UNAVAILABLE;
        }
        foreach ( $data as $key=>$value){
            foreach ($value as $key=>$item){
                $newdata[]=$item;
            }
        }
       $alias = \Yii::getAlias("@app/web/uploads/report.txt");
     file_put_contents( $alias,   implode("\n", $newdata));

    }



}

