<?php

namespace app\models;

use app\models\publication\Publication;
use app\models\publication\PublicationPeriodical;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Html;

class ServiceModel extends \yii\base\Model
{
    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

    /*public static function validateMultiple($models, $unique_attribute, $msg_repeat_err)
    {
        $valid = parent::validateMultiple($models);

        foreach ($models as $key => $model) {
            $count = 0;
            foreach ($models as $k => $m) {
                if ($model->{$unique_attribute} == $m->{$unique_attribute})
                    $count++;
            }

            if ($count > 1) {
                $model->addError($unique_attribute, $msg_repeat_err);
                $valid = false;
            }
        }

        unset($model);

        // return an error when Ajax validation in a separate action
        if (Yii::$app->response->format == Response::FORMAT_JSON) {
            $result = [];
            foreach ($models as $i => $model)
                foreach ($model->getErrors() as $attribute => $errors)
                    $result[Html::getInputId($model, "[$i]" . $attribute)] = $errors;
            return $result;
        }

        return $valid;
    }*/

    public static function getListForSelect($search, $attribute, $modelName)
    {
        $results = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($search)) {
            $query = $modelName::find()->select(['id', 'text' => $attribute])->orderBy([$attribute => SORT_ASC]);
            if (preg_match('/^[*]+$/', $search)) {
                $records = $query->asArray()->all();
            } else {
                $records = $query->where(['like', $attribute, $search])->asArray()->all();
            }

            $results['results'] = array_values($records);
        }
        return $results;
    }
}