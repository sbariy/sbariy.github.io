<?php

namespace app\models\instance;

use Yii;

/**
 * This is the model class for table "discipline_cycle".
 *
 * @property string $discipline_id
 * @property string $cycle_id
 *
 * @property Discipline $discipline
 * @property Cycle $cycle
 */
class DisciplineCycle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discipline_cycle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discipline_id', 'cycle_id'], 'required'],
            [['discipline_id', 'cycle_id'], 'integer'],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
            [['cycle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cycle::className(), 'targetAttribute' => ['cycle_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discipline_id' => 'Discipline ID',
            'cycle_id' => 'Cycle ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCycle()
    {
        return $this->hasOne(Cycle::className(), ['id' => 'cycle_id']);
    }
}
