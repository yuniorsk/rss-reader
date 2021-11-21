<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "feed_item".
 *
 * @property int $id
 * @property int $feed_id
 * @property string $uid
 * @property string $url
 * @property string $title
 * @property string|null $author
 * @property string|null $summary
 * @property string|null $published_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property UserFeed $userFeed
 */
class FeedItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'feed_item';
    }

    public function rules()
    {
        return [
            [['url', 'title'], 'required'],
            [['url', 'title', 'author'], 'string', 'max' => 255],
            [['url', 'title', 'author', 'summary'], 'trim'],
            [['summary'], 'string'],
            [['summary'], 'filter', 'filter' => 'strip_tags'],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if($this->published_at instanceof \DateTime)
        {
            $this->published_at = new Expression('FROM_UNIXTIME(:timestamp)', [
                ':timestamp' => $this->published_at->format('U'),
            ]);
        }

        return parent::beforeSave($insert);
    }

    public function getUserFeed()
    {
        return $this->hasOne(UserFeed::class, ['feed_id' => 'feed_id']);
    }
}
