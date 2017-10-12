<?php

namespace app\models\instance;

use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "discipline".
 *
 * @property string $id
 * @property string $name
 *
 * @property DisciplineCycle[] $disciplineCycles
 * @property Cycle[] $cycles
 * @property PublicationInstance[] $publicationInstances
 */
class Discipline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discipline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Дисциплина',
        ];
    }

    public function setDisciplinesArray($value)
    {
        $this->_disciplinesArray = (array) $value;
    }

    public function getCyclesToString()
    {
        $result = null;
        foreach ($this->cycles as $cycle) {
            $result .= Html::tag('p', $cycle->name);
        }
        return $result;
    }

    // переписать
    public static function getDisciplinesByCycle($cycle_id)
    {
        if (!$cycle = Cycle::findOne(['id' => $cycle_id])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $cycle->getDisciplines()->select(['name', 'id'])->indexBy('id')->column();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineCycles()
    {
        return $this->hasMany(DisciplineCycle::className(), ['discipline_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCycles()
    {
        return $this->hasMany(Cycle::className(), ['id' => 'cycle_id'])->viaTable('discipline_cycle', ['discipline_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicationInstances()
    {
        return $this->hasMany(PublicationInstance::className(), ['discipline_id' => 'id']);
    }
}
