<?php

namespace app\controllers;

use app\models\forms\AddFeedForm;
use app\models\User;
use app\models\UserFeed;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * User feed controller
 */
class UserFeedController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        /* @var User $user */
        $user = Yii::$app->user->identity;

        $dataProvider = new ActiveDataProvider([
            'query' => $user->getFeeds(),
            'sort' => false,
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new AddFeedForm(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post()) && $model->addFeed()) {
            Yii::$app->session->setFlash('success', 'Feed successfully added.');

            return $this->redirect(['update', 'id' => $model->getUserFeedId()]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Feed successfully updated.');

            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Feed successfully removed.');

        return $this->redirect(['index']);
    }

    private function findModel($id)
    {
        $model = UserFeed::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
        if ($model === null)
            throw new NotFoundHttpException();

        return $model;
    }
}
