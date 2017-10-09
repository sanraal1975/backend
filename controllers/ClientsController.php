<?php

namespace backend\controllers;

use Yii;
use backend\models\Clients;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\Debug;
use backend\components\Encrypter;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends Controller
{
    /**
     * @inheritdoc
     */

    private $encrypter;

    public function init()
    {
        if(!array_key_exists("isAdmin",$_SESSION))
        {
            $this->redirect("/");
        }
        $this->layout="main2.php";
        $this->encrypter=new Encrypter();
        if(Yii::$app->cache['llista_clients']==FALSE) { Clients::cacheClients(); }
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->cache['clients']==FALSE) { Clients::cacheClients(); }
        return $this->render('index', [
            'dataProvider' => Yii::$app->cache['clients'],
        ]);
    }

    /**
     * Displays a single Clients model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->cache['client'.$id]==FALSE) { Clients::cacheClients($id); }
        return $this->render('view', [
            'model' => Yii::$app->cache['client'.$id],
        ]);
    }

    /**
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clients();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->cache['client'.$id]==FALSE) { Clients::cacheClients($id); }
        $model=Yii::$app->cache['client'.$id];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Clients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->cache['client'.$id]==FALSE) { Clients::cacheClients($id); }
        $model=Yii::$app->cache['client'.$id];
        $model->delete();
        Clients::cacheClients();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clients::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
