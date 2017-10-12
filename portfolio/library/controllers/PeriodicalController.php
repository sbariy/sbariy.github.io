<?php

namespace app\controllers;

use Yii;

/**
 * PeriodicalController implements the CRUD actions for PublicationPeriodical model.
 */
class PeriodicalController extends \app\utilities\PublicationController
{
    public $recordClass = 'app\models\publication\PublicationPeriodical';
    public $recordClassSearch = 'app\models\publication\PublicationPeriodicalSearch';

    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/
}
