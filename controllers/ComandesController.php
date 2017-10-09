<?php

namespace backend\controllers;

use Yii;
use backend\models\Comandes;
use backend\models\LiniesComandes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\Debug;
use backend\components\Encrypter;

/**
 * ComandesController implements the CRUD actions for Comandes model.
 */
class ComandesController extends Controller
{

    private $encrypter;

    public function init()
    {
        if(!array_key_exists("isAdmin",$_SESSION))
        {
            $this->redirect("/");
        }
        $this->layout="/main2.php";
        $this->encrypter=new Encrypter();
    }
    /**
     * @inheritdoc
     */
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
     * Lists all Comandes models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->cache['comandes']==FALSE) { Comandes::cacheComandes(); }

        return $this->render('index', [
            'dataProvider' => Yii::$app->cache['comandes'],
        ]);
    }

    /**
     * Displays a single Comandes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->cache['comanda'.$id]==FALSE) { Comandes::cacheComandes($id); }
        if(Yii::$app->cache['liniescomandes'.$id]==FALSE) { LiniesComandes::cacheLinies($id); }

        return $this->render('view', [
            'model' => Yii::$app->cache['comanda'.$id],
            'linies' => Yii::$app->cache['liniescomandes'.$id],
        ]);
    }

    /**
     * Creates a new Comandes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comandes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Comandes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->cache['comanda'.$id]==FALSE) { Comandes::cacheComandes($id); }
        $model = Yii::$app->cache['comanda'.$id];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Comandes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->cache['comanda'.$id]==FALSE) { Comandes::cacheComandes($id); }
        $model = Yii::$app->cache['comanda'.$id];
        $model->delete();
        Comandes::cacheComandes();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Comandes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comandes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comandes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
