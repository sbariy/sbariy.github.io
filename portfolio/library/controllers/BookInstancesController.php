<?php

namespace app\controllers;

use Yii;
use app\models\instance\PublicationInstance;
use yii\data\ActiveDataProvider;
use app\utilities\InstanceController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookInstancesController implements the CRUD actions for PublicationInstance model.
 */
class BookInstancesController extends InstanceController
{
    public $typeInstance = 'book';
    public $recordClassSearch = 'app\models\instance\BookInstanceSearch';
}
