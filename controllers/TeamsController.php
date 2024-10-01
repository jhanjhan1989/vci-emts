<?php

namespace app\controllers;

use app\models\teams;
use app\models\TeamsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamsController implements the CRUD actions for teams model.
 */
class TeamsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all teams models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TeamsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single teams model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new teams model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new teams([
            "author_id" => Yii::$app->user->identity->id,
            "created_at" => date("Y-m-d H:i:s"),
            "is_active" => true,
            "is_deleted" => false,
        ]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', [
                    'text'              => 'Team saved!.',
                    'title'             => 'Success!',
                    'type'              => 'success',
                    'timer'             => 3000,
                    'showConfirmButton' => false
                ]);
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing teams model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = date("Y-m-d H:i:s");
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', [
                'text'              => 'Team updated!.',
                'title'             => 'Success!',
                'type'              => 'success',
                'timer'             => 3000,
                'showConfirmButton' => false
            ]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing teams model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('success', [
                'text'              => 'Team deleted!.',
                'title'             => 'Success!',
                'type'              => 'success',
                'timer'             => 3000,
                'showConfirmButton' => false
            ]);
            return $this->redirect(['index']);
        } catch (yii\db\IntegrityException $e) {
            Yii::$app->getSession()->setFlash('error', [
                'text'              => 'This record is linked to other data. Remove all related data and try again.',
                'title'             => 'Error!',
                'type'              => 'error',
                'timer'             => 3000,
                'showConfirmButton' => false
            ]);
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the teams model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return teams the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = teams::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
