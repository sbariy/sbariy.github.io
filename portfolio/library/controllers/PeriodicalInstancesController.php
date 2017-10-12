<?php

namespace app\controllers;

use app\models\instance\Location;
use Yii;
use app\models\instance\PublicationInstance;
use app\models\instance\PeriodicalInstanceSearch;
use yii\data\ActiveDataProvider;
use app\utilities\InstanceController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * PeriodicalInstancesController implements the CRUD actions for PublicationInstance model.
 */
class PeriodicalInstancesController extends InstanceController
{
    public $typeInstance = 'periodical';
    public $recordClassSearch = 'app\models\instance\PeriodicalInstanceSearch';
}
