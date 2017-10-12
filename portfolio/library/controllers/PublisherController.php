<?php

namespace app\controllers;

use app\utilities\CustomController;
use Yii;
use app\models\publication\Publisher;
use app\models\publication\PublisherSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use app\models\ServiceModel;
use yii\web\Response;

/**
 * PublisherController implements the CRUD actions for Publisher model.
 */
class PublisherController extends CustomController
{

    public function actionPublisherList($search = null)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ServiceModel::getListForSelect($search, 'name', Publisher::className());
    }

    /**
     * Lists all Publisher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublisherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Publisher model.
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
     * Creates a new Publisher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        $publishers = [new Publisher];

        if ($publishers[0]->load(Yii::$app->request->post())) {
            $publishers = ServiceModel::createMultiple(Publisher::className());

            if (ServiceModel::loadMultiple($publishers, Yii::$app->request->post())) {

                if (!Publisher::validateMultiple($publishers))
                    return false;

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($publishers as $publisher) {
                        if (!$publisher->save(false)) {
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

        return $this->renderAjax('_formCreateBatch', compact('publishers'));
    }

    /**
     * Updates an existing Publisher model.
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
     * Deletes an existing Publisher model.
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
     * Finds the Publisher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Publisher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Publisher::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
