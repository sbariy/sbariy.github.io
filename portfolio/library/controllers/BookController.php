<?php

namespace app\controllers;

use Yii;
use app\models\publication\PublicationBook;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for PublicationBook model.
 */
class BookController extends \app\utilities\PublicationController
{
    public $recordClass = 'app\models\publication\PublicationBook';
    public $recordClassSearch = 'app\models\publication\PublicationBookSearch';

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
