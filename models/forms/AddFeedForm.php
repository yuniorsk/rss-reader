<?php

namespace app\models\forms;

use app\models\Feed;
use app\models\User;
use app\models\UserFeed;
use yii\base\Model;

/**
 * Add feed form
 */
class AddFeedForm extends Model
{
    public $url;

    private $_user;
    private $_userFeedId;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['url', 'required'],
            ['url', 'trim'],
            ['url', 'url']
        ];
    }

    public function addFeed()
    {
        if (!$this->validate())
            return false;

        try {
            $feed = $this->createFeed();
            $userFeed = $this->createUserFeed($feed);
            $this->_userFeedId = $userFeed->id;

            return true;
        } catch (\Exception $e) {
            \Yii::error([
                'message' => $e->getMessage(),
                'url' => $this->url,
            ], __METHOD__);

            $this->addError('url', $e->getMessage());
            return false;
        }
    }

    private function createFeed()
    {
        $feed = Feed::findOne(['url' => $this->url]);
        if ($feed !== null)
            return $feed;

        $feed = new Feed(['url' => $this->url]);
        $feed->import(20);

        return $feed;
    }

    private function createUserFeed(Feed $feed)
    {
        $userFeed = UserFeed::findOne([
            'user_id' => $this->_user->id,
            'feed_id' => $feed->id,
        ]);

        if ($userFeed !== null)
            return $userFeed;

        $userFeed = new UserFeed([
            'user_id' => $this->_user->id,
            'feed_id' => $feed->id,
            'user_title' => $feed->title,
        ]);

        $userFeed->save(false);

        return $userFeed;
    }

    public function getUserFeedId()
    {
        return $this->_userFeedId;
    }
}
