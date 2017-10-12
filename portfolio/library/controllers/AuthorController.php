<?php

namespace app\controllers;

use Yii;
use app\models\publication\Author;
use app\models\publication\AuthorSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ServiceModel;
use yii\web\HttpException;
use yii\web\Response;
use app\utilities\CustomController;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends CustomController
{


    public function actionAuthorList($search = null)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return Author::getListAuthorsForSelect($search, 'author.initials', Author::className());
    }

    /**
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Author model.
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
            throw new HttpException(404 , 'Page not found');
        }

        $authors = [new Author];

        if ($authors[0]->load(Yii::$app->request->post())) {
            $authors = ServiceModel::createMultiple(Author::className());

            if (ServiceModel::loadMultiple($authors, Yii::$app->request->post())) {

                if (!Author::validateMultiple($authors))
                    return false;

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach ($authors as $author) {
                        if (!$author->save(false)) {
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

        return $this->renderAjax('_formCreateBatch', compact('authors'));
    }


    /**
     * Updates an existing Author model.
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
     * Deletes an existing Author model.
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
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
