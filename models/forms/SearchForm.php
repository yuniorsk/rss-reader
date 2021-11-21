<?php

namespace app\models\forms;

use app\models\FeedItem;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Search form
 */
class SearchForm extends Model
{
    public $title;
    public $feedId;

    public function rules()
    {
        return [
            [['title', 'feedId'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = FeedItem::find()
            ->joinWith('userFeed')
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->orderBy(['published_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate())
            return $dataProvider;

        if ($this->title)
            $query->andFilterWhere(['like', 'title', preg_split('/\s+/', $this->title)]);

        $query->andFilterWhere(['feed_item.feed_id' => $this->feedId]);

        return $dataProvider;
    }

    public function getFeedListOptions()
    {
        return ArrayHelper::map(Yii::$app->user->identity->feeds, 'feed_id', 'user_title');
    }
}
