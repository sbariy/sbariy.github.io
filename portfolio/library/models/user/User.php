<?php

namespace app\models\user;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $name
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $newPassword;

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';

    public function scenarios()
    {
        return [
            self::SCENARIO_UPDATE => ['password', 'name', 'newPassword'],
            self::SCENARIO_CREATE => ['username', 'name', 'password'],
        ];
    }

    public function rules()
    {
        return [
            [['username', 'name', 'password'], 'required'],
            [['username', 'password', 'name', 'auth_key', 'newPassword'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    public static function tableName()
    {
        return 'user';
    }

    public function beforeSave($insert)
    {
        $return = parent::beforeSave($insert);
        if ($this->newPassword) {
            $this->password = $this->newPassword;
        }

        if ($this->isAttributeChanged('password')) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomKey($length = 255);
        }

        return $return;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('You сап only login Ьу username/password pair for now. ');
    }

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'name' => 'Имя',
        ];
    }
}
