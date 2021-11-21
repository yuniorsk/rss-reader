<?php

namespace app\commands;

use app\models\Feed;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Feed controller
 */
class FeedController extends Controller
{
    /**
     * Displays available commands
     */
    public function actionIndex()
    {
        return $this->run('/help', ['feed']);
    }

    /**
     * Import data for new feeds
     *
     * @return int Exit code
     */
    public function actionImportNew()
    {
        $models = Feed::find()
            ->where(['imported_at' => null])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        foreach ($models as $model) {
            $this->stdout("Importing feed {$model->id}");
            $model->import();
            $this->stdout(" - OK" . PHP_EOL);
        }

        return ExitCode::OK;
    }

    /**
     * Import data for all existing feeds
     *
     * @return int Exit code
     */
    public function actionImportAll()
    {
        $models = Feed::find()
            ->where(['not', ['imported_at' => null]])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        foreach ($models as $model) {
            $this->stdout("Importing feed {$model->id}");
            $model->import();
            $this->stdout(" - OK" . PHP_EOL);
        }

        return ExitCode::OK;
    }

    public function afterAction($action, $result)
    {
        echo "\n";
        echo 'Memory peak usage: ' . \Yii::$app->formatter->asShortSize(memory_get_peak_usage()) . "\n";
        echo 'Duration: ' . \Yii::$app->formatter->asDecimal((microtime(true) - YII_BEGIN_TIME)) . " s\n";

        return parent::afterAction($action, $result);
    }
}
