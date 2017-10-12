<?php

namespace app\utilities;

use app\models\instance\Bookcase;
use app\models\instance\Bookshelf;
use app\models\instance\Cycle;
use app\models\publication\Publication;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\instance\PublicationInstance;
use yii\web\HttpException;
use app\models\instance\Discipline;


/**
 * PeriodicalController implements the CRUD actions for PublicationMaterial model.
 */
class InstanceController extends CustomController
{
    public $typeInstance;
    public $recordClassSearch;

    public function actions()
    {
        return [
            'bookshelf' => [
                'class' => \kartik\depdrop\DepDropAction::className(),
                'outputCallback' => function ($selectedId, $params) {
                    $out = [];
                    foreach (Bookshelf::getBookshelvesByBookcase($selectedId) as $key => $bookshelf) {
                        $out[] = [
                            'id' => $key,
                            'name' => $bookshelf,
                        ];
                    }
                    return $out;
                }
            ],
            'discipline' => [
                'class' => \kartik\depdrop\DepDropAction::className(),
                'outputCallback' => function ($selectedId, $params) {
                    $out = [];
                    foreach (Discipline::getDisciplinesByCycle($selectedId) as $key => $bookshelf) {
                        $out[] = [
                            'id' => $key,
                            'name' => $bookshelf,
                        ];
                    }
                    return $out;
                }
            ],
        ];
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionInfo($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        return $this->renderAjax('info', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new $this->recordClassSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bookcases' => Bookcase::find()->select(['bookcase', 'id'])->indexBy('id')->column(),
            'cycles' => Cycle::find()->all()
        ]);
    }

    public function actionUpdate($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return true;
        } else {
            return $this->renderAjax('/instance/_formComing', [
                'model' => $model,
                'publications' => Publication::find()->where(['type' => $this->typeInstance])->all(),
                'bookcases' => Bookcase::find()->select(['bookcase', 'id'])->indexBy('id')->column(),
                'cycles' => Cycle::find()->all()
            ]);
        }
    }

    public function actionComingInstances()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        $model = new PublicationInstance();

        if ($model->load($post = Yii::$app->request->post())) {
            if (!$model->validate()) return false;

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $listIds = $this->listIdsSavedRecords($model, $post);
                $rows = PublicationInstance::listInstancesById($listIds);

                $transaction->commit();
                return $this->renderPartial('/instance/_listComingInstances', compact('rows'));

            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }

        } else {
            return $this->renderAjax('/instance/_formComing', [
                'model' => $model,
                'typeInstance' => $this->typeInstance,
                'bookcases' => Bookcase::find()->select(['bookcase', 'id'])->indexBy('id')->column(),
                'cycles' => Cycle::find()->all()
            ]);
        }
    }

    protected function listIdsSavedRecords($model, $post)
    {
        $listIds = [];
        for ($i = 0; $i < $model->amount; $i++) {
            $model->save(false);
            $listIds[] = $model->id;

            if ($i + 1 < $model->amount) {
                $model = new PublicationInstance();
                $model->load($post);
            }
        }

        return $listIds;
    }




    /* Action Buttons */
    public function actionInArchive()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        if ($instanceIds = Yii::$app->request->post('ids')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $rows = PublicationInstance::updateAll(['in_archive' => true, 'bookshelf_id' => null], ['id' => $instanceIds, 'lost' => false, 'given' => false]);
                $transaction->commit();
                return $rows;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }

        return false;
    }
    public function actionOutArchive()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        if ($instanceIds = Yii::$app->request->post('ids')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $rows = PublicationInstance::updateAll(['in_archive' => false], ['id' => $instanceIds, 'lost' => false, 'given' => false]);
                $transaction->commit();
                return $rows;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }

        return false;
    }
    public function actionLost()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        if ($instanceIds = Yii::$app->request->post('ids')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $rows = PublicationInstance::updateAll(['lost' => true, 'bookshelf_id' => null, 'in_archive' => false, 'given' => false], ['id' => $instanceIds, 'lost' => false]);
                $transaction->commit();
                return $rows;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }

        return false;
    }
    public function actionFound()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        if ($instanceIds = Yii::$app->request->post('ids')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $rows = PublicationInstance::updateAll(['lost' => false], ['id' => $instanceIds, 'lost' => true]);
                $transaction->commit();
                return $rows;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }
        return false;
    }
    public function actionDelete()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        if ($instanceIds = Yii::$app->request->post('ids')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $rows = PublicationInstance::deleteAll(['id' => $instanceIds, 'lost' => false, 'given' => false]);
                $transaction->commit();
                return $rows;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }
    }



    /**
     * Finds the PublicationInstance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PublicationInstance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PublicationInstance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
