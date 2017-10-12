<?php

namespace app\controllers;

use app\utilities\CustomController;
use Yii;
use app\models\publication\PublicationType;
use app\models\publication\PublicationTypeSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;
use app\models\ServiceModel;

/**
 * PublicationTypeController implements the CRUD actions for PublicationType model.
 */
class PublicationTypeController extends CustomController
{
    public function actionPublicationTypeList($search = null)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ServiceModel::getListForSelect($search, 'name', PublicationType::className());
    }

    /**
     * Lists all PublicationType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublicationTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PublicationType model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException('404', 'Page not found');
        }

        $types = [new PublicationType];

        if ($types[0]->load(Yii::$app->request->post())) {
            $types = ServiceModel::createMultiple(PublicationType::className());

            if (ServiceModel::loadMultiple($types, Yii::$app->request->post())) {

                if (!PublicationType::validateMultiple($types))
                    return false;

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($types as $type) {
                        if (!$type->save(false)) {
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

        return $this->renderAjax('_formCreateBatch', compact('types'));
    }

    /**
     * Updates an existing PublicationType model.
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
     * Deletes an existing PublicationType model.
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
     * Finds the PublicationType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PublicationType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PublicationType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
