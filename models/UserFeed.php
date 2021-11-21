<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "user_feed".
 *
 * @property int $id
 * @property int $user_id
 * @property int $feed_id
 * @property string|null $user_title
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Feed $source
 */
class UserFeed extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_feed';
    }

    public function rules()
    {
        return [
            ['user_title', 'trim'],
            ['user_title', 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getSource()
    {
        return $this->hasOne(Feed::class, ['id' => 'feed_id']);
    }
}
