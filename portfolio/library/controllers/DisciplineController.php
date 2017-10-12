<?php

namespace app\controllers;

use app\models\instance\Cycle;
use app\utilities\CustomController;
use Yii;
use app\models\instance\Discipline;
use app\models\instance\DisciplineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use app\models\ServiceModel;

/**
 * DisciplineController implements the CRUD actions for Discipline model.
 */
class DisciplineController extends CustomController
{

    /**
     * Lists all Discipline models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DisciplineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cycles' => Cycle::find()->select(['name', 'id'])->indexBy('id')->column()
        ]);
    }

    /**
     * Displays a single Discipline model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Discipline model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        $disciplines = [new Discipline];

        if ($disciplines[0]->load(Yii::$app->request->post())) {
            $disciplines = ServiceModel::createMultiple(Discipline::className());

            if (ServiceModel::loadMultiple($disciplines, Yii::$app->request->post())) {

                if (!Discipline::validateMultiple($disciplines))
                    return false;

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($disciplines as $discipline) {
                        if (!$discipline->save(false)) {
                            $transaction->rollBack();
                            return false;
                        }
                    }
                    $transaction->commit();
                    return true;
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return false;
                }
            }
        }

        return $this->renderAjax('_formCreateBatch', compact('disciplines'));
    }

    /**
     * Updates an existing Discipline model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404, 'Page not found');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validate()) {
                return false;
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save(false);
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Discipline model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404, 'Page not found');
        }

        if ( $this->findModel($id)->delete() ) {
            return true;
        }
        return false;

    }

    /**
     * Finds the Discipline model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Discipline the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discipline::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
