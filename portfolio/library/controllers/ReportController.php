<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.06.2016
 * Time: 14:29
 */

namespace app\controllers;

use app\models\instance\PublicationInstanceReport;
use kartik\mpdf\Pdf;

class ReportController extends \app\utilities\CustomController
{
    public function actionIndex()
    {
        $model = new PublicationInstanceReport();

        if ($query = $model->report(\Yii::$app->request->post())) {
            $rows = $query->asArray()->all();
            $type = \Yii::$app->request->post('PublicationInstanceReport')['_type'];
            $addedFrom = \Yii::$app->request->post('PublicationInstanceReport')['addedFrom'];
            $addedTo = \Yii::$app->request->post('PublicationInstanceReport')['addedTo'];
            $amount = $query->count();
            $total = $query->sum('price');
            $view = $this->renderPartial('instance-report', compact('rows', 'type', 'addedFrom', 'addedTo', 'amount', 'total'));

            $pdf = \Yii::$app->pdf;
            $pdf->filename = 'report-instances.pdf';
            $pdf->content = $view;
            return $pdf->render();

            //return \Yii::$app->response->sendContentAsFile($view, ($type ?: 'book') . '.html');
        }

        return $this->render('index', compact('model'));
    }

    public function actionPeriodical()
    {

    }
}