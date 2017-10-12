<?php

namespace app\controllers;

use app\models\instance\Bookshelf;
use app\utilities\CustomController;
use Yii;
use app\models\instance\Bookcase;
use app\models\instance\BookcaseSearch;
use yii\db\Connection;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ServiceModel;

/**
 * BookcaseController implements the CRUD actions for Bookcase model.
 */
class BookcaseController extends CustomController
{

    /**
     * Lists all Bookcase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookcaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bookcase model.
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
     * Creates a new Bookcase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        $model = new Bookcase();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save(false);
                for ($i = 0; $i < $model->amount_bookshelves; $i++) {
                    $bookshelf = new Bookshelf();
                    $bookshelf->bookshelf = $i + 1;
                    $bookshelf->bookcase_id = $model->id;
                    $bookshelf->save(false);
                }
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }

        return $this->renderAjax('_form', compact('model'));

    }

    /**
     * Updates an existing Bookcase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bookcase model.
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
     * Finds the Bookcase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Bookcase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bookcase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
