<?php
namespace app\controllers;

use app\models\Randoms;
use Yii;
use yii\db\Exception;
use yii\rest\ActiveController;

class RandNumberController extends ActiveController
{
    public $modelClass = 'app\models\Randoms';

    public function actionShow()
    {
        return <<<HTML
Here you can do:
- generate rand number with GET or POST request (you can also add details with
start and end numbers). You will see it's id.
- retrieve number with get request, putting the id to get the result.
HTML;

    }

    public function actionGenerate()
    {
        $requestBody = Yii::$app->request->getBodyParams();

        $model = new Randoms();
        $model->generate($requestBody);

        if ($model->save() === false && !$model->hasErrors()) {
            throw new Exception('Cannot save the number.');
        }

        return $model;
    }



    public function actionRetrieve($id)
    {
        if (!is_numeric($id)) {
            throw new Exception('Please send correct id.');
        }

        $model = Randoms::findOne($id);
        if (!$model) {
            return [
                'error' => 'There is no number with this id',
                'code' => 404,
            ];
        }
        return [
            'number' => $model->rndNumber,
            'id'=>$model->id,
        ];
    }


    public function verbs()
    {
        return [
            'show' => ['get'],
            'generate' => ['get', 'post'],
            'retrieve' => ['get'],
        ];
    }
}
