<?php

namespace app\models\instance;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "cycle".
 *
 * @property string $id
 * @property string $name
 * @property string $duration
 *
 * @property DisciplineCycle[] $disciplineCycles
 * @property Discipline[] $disciplines
 */
class Cycle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cycle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'year_adoption', 'duration'], 'required'],
            ['duration', 'integer', 'min' => 1, 'max' => 15],
            ['year_adoption', 'integer', 'min' => 2000, 'max' => date('Y')],
            [['name'], 'string', 'max' => 255],
            [['disciplinesArray'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Учебный цикл',
            'duration' => 'Длительность',
            'disciplinesArray' => 'Дисциплины',
            'year_adoption' => 'Год принятия',
            'duration' => 'Длительность (лет)',
            'yearEnding' => 'Год окончания'
        ];
    }

    public function getDisciplinesToString()
    {
        $result = null;
        foreach ($this->disciplines as $discipline) {
            $result .= Html::tag('p', $discipline->name);
        }
        return $result;
    }

    public function getYearEnding()
    {
        return ($this->year_adoption && $this->duration) ? (int) $this->year_adoption + (int) $this->duration : null;
    }

    private $_disciplinesArray;

    public function getDisciplinesArray()
    {
        if ($this->_disciplinesArray === null) {
            $this->_disciplinesArray = $this->getDisciplines()->select('id')->column();
        }
        return $this->_disciplinesArray;
    }

    public function setDisciplinesArray($value)
    {
        $this->_disciplinesArray = (array) $value;
    }

    private function updateDisciplines()
    {
        $currentDisciplinesIds = $this->getDisciplines()->select('id')->column();
        $newDisciplinesIds = $this->getDisciplinesArray();

        foreach (array_filter(array_diff($newDisciplinesIds, $currentDisciplinesIds)) as $disciplineId) {
            /** @var Tag $tag */
            if ($discipline = Discipline::findOne($disciplineId)) {
                $this->link('disciplines', $discipline);
            }
        }
        foreach (array_filter(array_diff($currentDisciplinesIds, $newDisciplinesIds)) as $disciplineId) {
            /** @var Tag $tag */
            if ($discipline = Discipline::findOne($disciplineId)) {
                $this->unlink('disciplines', $discipline, true);
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateDisciplines();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineCycles()
    {
        return $this->hasMany(DisciplineCycle::className(), ['cycle_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplines()
    {
        return $this->hasMany(Discipline::className(), ['id' => 'discipline_id'])->viaTable('discipline_cycle', ['cycle_id' => 'id']);
    }
}
