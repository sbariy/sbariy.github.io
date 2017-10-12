<?php

namespace app\controllers;


use app\models\instance\PeriodicalInstanceSearch;
use app\models\instance\PublicationInstance;
use app\models\publication\PublicationBook;
use app\models\publication\PublicationPeriodical;
use app\models\publication\PublicationPeriodicalSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\user\LoginForm;
use app\utilities\CustomController;
use app\models\instance\BookInstanceSearch;

class SiteController extends CustomController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $pModel = new PeriodicalInstanceSearch();
        $bModel = new BookInstanceSearch();
        $label = 'Инв. номер';

        if ($periodicalAttribute = Yii::$app->request->getQueryParam('p-attribute')) {
            switch ($periodicalAttribute)
            {
                case 'id' : $label = 'Инв. номер'; break;
                case 'publication.name' : $label = $pModel->getAttributeLabel('publication.name'); break;
                case 'publication.issn' : $label = $pModel->getAttributeLabel('publication.issn'); break;
                case 'publication.article.name' : $label = $pModel->getAttributeLabel('publication.article.name'); break;
                default : $label = 'Инв. номер'; break;
            }
        }
        if ($bookAttribute = Yii::$app->request->getQueryParam('b-attribute')) {
            switch ($bookAttribute)
            {
                case 'id' : $label = 'Инв. номер'; break;
                case 'publication.name' : $label = $bModel->getAttributeLabel('publication.name'); break;
                case 'publication.isbn' : $label = $bModel->getAttributeLabel('publication.isbn'); break;
                case 'publication.bbk' : $label = $bModel->getAttributeLabel('publication.bbk'); break;
                case 'publication.author.initials' : $label = $bModel->getAttributeLabel('publication.author.initials'); break;
                default : $label = 'Инв. номер'; break;
            }
        }

        return $this->render('index', [
            'bModel' => $bModel,
            'pModel' => $pModel,
            'periodicalAttribute' => $periodicalAttribute,
            'bookAttribute' => $bookAttribute,
            'label' => $label,
            'pCountPublication' => PublicationPeriodical::find()->count(),
            'bCountPublication' => PublicationBook::find()->count(),
            'pCountPublicationMonth' => PublicationPeriodical::find()->where(['>=', 'publication.date_add', new \yii\db\Expression('DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)')])->count(),
            'bCountPublicationMonth' => PublicationBook::find()->where(['>=', 'publication.date_add', new \yii\db\Expression('DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)')])->count(),
            'pCountInstance' => PublicationInstance::find()->joinWith('publication', false)->where(['publication.type' => 'periodical'])->count(),
            'bCountInstance' => PublicationInstance::find()->joinWith('publication', false)->where(['publication.type' => 'book'])->count(),
            'pCountInstanceMonth' => PublicationInstance::find()->joinWith('publication', false)->where(['>=', 'publication_instance.date_add', new \yii\db\Expression('DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)')])->andWhere(['publication.type' => 'periodical'])->count(),
            'bCountInstanceMonth' => PublicationInstance::find()->joinWith('publication', false)->where(['>=', 'publication_instance.date_add', new \yii\db\Expression('DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)')])->andWhere(['publication.type' => 'book'])->count()
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        return $this->renderAjax('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
