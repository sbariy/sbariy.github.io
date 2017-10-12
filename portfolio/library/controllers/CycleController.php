<?php

namespace app\controllers;

use app\models\instance\Discipline;
use app\utilities\CustomController;
use Yii;
use app\models\instance\Cycle;
use app\models\instance\CycleSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CycleController implements the CRUD actions for Cycle model.
 */
class CycleController extends CustomController
{

    /**
     * Lists all Cycle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CycleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'disciplines' => Discipline::find()->select(['name', 'id'])->indexBy('id')->column()
        ]);
    }

    /**
     * Displays a single Cycle model.
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
     * Creates a new Cycle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404, 'Page not found');
        }

        $model = new Cycle();

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
                'disciplines' => Discipline::find()->select('*')->orderBy('name')->all()
            ]);
        }
    }

    /**
     * Updates an existing Cycle model.
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
                'disciplines' => Discipline::find()->orderBy('name')->all()
            ]);
        }
    }

    /**
     * Deletes an existing Cycle model.
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
     * Finds the Cycle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Cycle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cycle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
