<?php

namespace app\models\instance;

use Yii;
use app\models\publication\Publication;

/**
 * This is the model class for table "publication_instance".
 *
 * @property string $id
 * @property integer $lost
 * @property integer $in_archive
 * @property integer $given
 * @property string $price
 * @property string $date_add
 * @property string $publication_id
 * @property string $bookshelf_id
 *
 * @property Publication $publication
 */
class PublicationInstance extends \yii\db\ActiveRecord
{
    private $_bookcase;
    public $amount;

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'publication_instance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lost', 'given', 'price', 'publication_id', 'bookshelf_id', 'discipline_id', 'cycle_id', 'amount', 'bookcase'], 'integer'],
            [['date_add'], 'safe'],
            [['in_archive'], 'boolean'],
            [['publication_id', 'amount'], 'required'],
            //[['publication_id'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['publication_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publication::className(), 'targetAttribute' => ['publication_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['publication_id', 'price', 'discipline_id', 'cycle_id', 'bookshelf_id', 'in_archive'];
        return $scenarios;
    }

    public static function listInstancesById($listIds)
    {
        return self::find()->with(['bookshelf.bookcase', 'discipline', 'cycle'])->where(['id' => $listIds])->asArray()->all();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Инв. номер',
            'lost' => 'Утеряна',
            'in_archive' => 'В архиве',
            'given' => 'Выдана',
            'price' => 'Цена',
            'date_add' => 'Дата поступления',
            'publication_id' => 'Издание',
            'bookshelf_id' => 'Номер полки',
            'bookcase' => 'Шкаф',
            'amount' => 'Кол-во',
            'discipline_id' => 'Дисциплина',
            'cycle_id' => 'Учебный цикл'
        ];
    }

    public function getBookcase()
    {
        if ($this->_bookcase === null) {
            $this->_bookcase = empty($this->bookshelf) ? null : $this->bookshelf->getBookcase()->select(['bookcase', 'id'])->indexBy('id')->column();
        }
        return $this->_bookcase;
    }

    public function setBookcase($value)
    {
        $this->_bookcase = $value;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublication()
    {
        return $this->hasOne(Publication::className(), ['id' => 'publication_id']);
    }

    public function getBookshelf()
    {
        return $this->hasOne(Bookshelf::className(), ['id' => 'bookshelf_id']);
    }

    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }

    public function getCycle()
    {
        return $this->hasOne(Cycle::className(), ['id' => 'cycle_id']);
    }
}
