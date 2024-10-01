<?php

namespace app\controllers;

use app\models\venues;
use app\models\VenuesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VenuesController implements the CRUD actions for venues model.
 */
class VenuesController extends Controller
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
     * Lists all venues models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VenuesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single venues model.
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
     * Creates a new venues model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new venues([
            "author_id" => Yii::$app->user->identity->id,
            "created_at" => date("Y-m-d H:i:s"),
            "is_active" => true,
            "is_deleted" => false,
        ]);
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', [
                    'text'              => 'Venue info saved!.',
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
     * Updates an existing venues model.
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
                'text'              => 'Venue info updated!.',
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
     * Deletes an existing venues model.
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
                'text'              => 'Record deleted!.',
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
     * Finds the venues model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return venues the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = venues::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
