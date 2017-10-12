<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.05.2016
 * Time: 22:00
 */

namespace app\utilities;

use app\models\instance\PublicationInstance;
use app\models\publication\PublicationType;
use app\models\publication\Publication;
use app\models\publication\Article;
use app\models\publication\PublicationPeriodical;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use app\models\ServiceModel;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\filters\AccessControl;

class PublicationController extends CustomController
{
    public $recordClass;
    public $recordClassSearch;

    /**
     * @inheritdoc
     */

    public function actionIndex()
    {
        $searchModel = new $this->recordClassSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPublicationList($search = null)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return Publication::getListPublicationForSelect($search, 'publication.name', call_user_func([$this->recordClass, 'className']));
    }

    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        $articles = [new Article];
        $publication = new $this->recordClass;

        if ($publication->load(Yii::$app->request->post())) {
            $articles = ServiceModel::createMultiple(Article::className());

            if (!ServiceModel::loadMultiple($articles, Yii::$app->request->post())) {

                if (!$publication->validate()) {
                    return false;
                }

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $publication->save(false);
                    $transaction->commit();
                    return true;
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return false;
                }
            }

            $valid = $publication->validate();
            $valid = Article::validateMultiple($articles) && $valid;

            if (!$valid) {
                return false;
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$publication->save(false)) {
                    $transaction->rollBack();
                    return false;
                }

                foreach ($articles as $article) {
                    $article->publication_id = $publication->id;
                    if (!$article->save(false)) {
                        $transaction->rollBack();
                        return false;
                    };
                }

                $transaction->commit();
                return true;
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        } else {
            return $this->renderAjax('_form', [
                'publication' => $publication,
                'articles' => $articles,
                'publicationType' => PublicationType::find()->select(['name', 'id'])->indexBy('id')->column(),
            ]);
        }
    }

    public function actionUpdate($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        $publication = $this->findModel($id);
        $articles = $publication->articles;

        if ($publication->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($articles, 'id', 'id');
            $articles = ServiceModel::createMultiple(Article::classname(), $articles);

            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($articles, 'id', 'id')));

            if (!ServiceModel::loadMultiple($articles, Yii::$app->request->post())) {
                if (!$publication->validate()) {
                    return false;
                }

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (! empty($deletedIDs)) {
                        Article::deleteAll(['id' => $deletedIDs]);
                    }
                    $publication->save(false);
                    $transaction->commit();
                    return true;
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return false;
                }
            }

            // validate all models
            $valid = $publication->validate();
            $valid = Article::validateMultiple($articles) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $publication->save(false)) {
                        if (! empty($deletedIDs)) {
                            Article::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($articles as $article) {
                            $article->publication_id = $publication->id;
                            if (! ($flag = $article->save(false))) {
                                $transaction->rollBack();
                                return false;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return true;
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return false;
                }
            }
            return false;
        }

        return $this->renderAjax('_form', [
            'publication' => $publication,
            'articles' => (empty($articles)) ? [new Article] : $articles,
            'publicationType' => PublicationType::find()->select(['name', 'id'])->indexBy('id')->column(),
        ]);
    }

    public function actionInfo($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        return $this->renderAjax('info', [
            'publication' => $this->findModel($id)
        ]);
    }

    public function actionDelete()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        if ($publicationIds = Yii::$app->request->post('ids')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($publicationIds as $key => $id) {
                    if ($sample = PublicationInstance::find()->where(['publication_id' => $id])->count()) {
                        $transaction->rollBack();
                        return false;
                    }
                }
                $rows = Publication::deleteAll(['id' => $publicationIds]);
                $transaction->commit();
                return $rows;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }

        return false;
    }

    /* Action Buttons */
    public function actionInArchive()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(404 , 'Page not found');
        }

        if ($publicationIds = Yii::$app->request->post('ids')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $rows = PublicationInstance::updateAll(['in_archive' => true, 'bookshelf_id' => null], ['publication_id' => $publicationIds, 'lost' => false, 'given' => false]);
                $transaction->commit();
                return $rows;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }

        return false;
    }


    /**
     * Finds the PublicationPeriodical model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PublicationPeriodical the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = call_user_func([$this->recordClass, 'findOne'], $id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}