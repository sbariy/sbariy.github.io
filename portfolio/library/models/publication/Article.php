<?php

namespace app\models\publication;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $name
 * @property string $pages
 * @property string $publication_id
 *
 * @property Publication $publication
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pages'], 'required'],
            [['publication_id'], 'integer'],
            [['name', 'pages'], 'string', 'max' => 255],
            [['publication_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publication::className(), 'targetAttribute' => ['publication_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'pages' => 'Страницы',
            'publication_id' => 'Издание ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublication()
    {
        return $this->hasOne(Publication::className(), ['id' => 'publication_id']);
    }
}
