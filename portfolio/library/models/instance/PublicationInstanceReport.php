<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.06.2016
 * Time: 16:33
 */

namespace app\models\instance;

use yii\db\Query;

class PublicationInstanceReport extends PublicationInstance
{
    public $_type;
    public $addedFrom;
    public $addedTo;

    public function attributeLabels()
    {
        return [
            'addedFrom' => 'Добавлено от',
            'addedTo' => 'Добавлено до',
            '_type' => 'Тип издания'
        ];
    }

    public function rules()
    {
        return [
            [['_type', 'addedFrom'], 'required'],
            [['addedTo'], 'safe']
        ];
    }

    public function report($params)
    {
        if (!$this->load($params) || !$this->validate()) {
            return false;
        }

        $query = PublicationInstance::find()
            ->joinWith([
                'publication.publisher',
                'publication.publicationType',
                'discipline',
                'cycle'
            ])
            ->where([
                'type' => $this->_type])
            ->andWhere(['>=', 'publication_instance.date_add', $this->addedFrom])
            ->andFilterWhere(['<=', 'publication_instance.date_add', $this->addedTo]);

        return $query;
    }
}