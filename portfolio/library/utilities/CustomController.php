<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.2016
 * Time: 12:13
 */

namespace app\utilities;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CustomController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index', 'publication-list', 'create', 'update', 'info', 'delete', 'in-archive'],
                'rules' => [
                    [
                        'allow' => false,
                        //'actions' => $this->actions,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }
}