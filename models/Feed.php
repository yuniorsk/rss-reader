<?php

namespace app\models;

use app\models\source\AbstractSource;
use app\models\source\SourceFactory;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;

/**
 * This is the model class for table "feed".
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property string|null $created_at
 * @property string|null $imported_at
 */
class Feed extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'feed';
    }

    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'string', 'max' => 255],
        ];
    }


    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function import($itemLimit = null)
    {
        $source = $this->downloadData();
        if ($this->isUpToDate($source)) {
            \Yii::info('Import skipped, feed is up to date', __METHOD__);
            return;
        }

        $this->title = $source->getTitle();

        if (!$this->validate()) {
            \Yii::error([
                'url' => $this->url,
                'errors' => $this->getErrors(),
            ], __METHOD__);

            throw new \RuntimeException('Invalid feed data');
        }

        $this->save(false);

        $this->importItems($source, $itemLimit);
    }

    private function downloadData(): AbstractSource
    {
        $client = new Client(['transport' => CurlTransport::class]);
        $response = $client->get($this->url)
            ->setOptions(['timeout' => 10])
            ->send();

        if (!$response->isOk) {
            \Yii::warning([
                'url' => $this->url,
                'statusCode' => $response->statusCode,
                'content' => $response->content,
            ], __METHOD__);

            throw new \RuntimeException('Error downloading feed');
        }

        return SourceFactory::make($response->data);
    }

    private function isUpToDate(AbstractSource $source)
    {
        if (!isset($this->imported_at) || !$source->getUpdateTime())
            return false;

        return $source->getUpdateTime() <= new \DateTime($this->imported_at);
    }

    private function importItems(AbstractSource $source, $itemLimit = null)
    {
        $count = 0;
        foreach ($source->getItems() as $sourceItem) {
            $attributes = ['feed_id' => $this->id, 'uid' => $sourceItem->uid];
            $item = FeedItem::findOne($attributes) ?? new FeedItem($attributes);

            $item->setAttributes([
                'url' => $sourceItem->url,
                'title' => $sourceItem->title,
                'author' => $sourceItem->author,
                'summary' => $sourceItem->summary,
                'published_at' => $sourceItem->date,
            ], false);

            if (!$item->validate()) {
                \Yii::warning([
                    'message' => 'Item is not valid',
                    'data' => $item->attributes,
                    'errors' => $item->getErrors(),
                ]);

                continue;
            }

            $item->save(false);

            if ($itemLimit > 0 && ++$count >= $itemLimit)
                return;
        }

        $this->touch('imported_at');
    }
}
