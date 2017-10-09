<?php

namespace backend\controllers;

use Yii;
use backend\models\Productes;
use backend\models\Categories;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\Debug;
use backend\components\Encrypter;

/**
 * ProductesController implements the CRUD actions for Productes model.
 */
class ProductesController extends SiteController
{

    private $encrypter;

    public function init()
    {
        parent::init();
        if(!array_key_exists("isAdmin",$_SESSION))
        {
            $this->redirect("/");
        }
        $this->layout="main_productes.php";
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
     * Lists all Productes models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->cache['productes']==FALSE) { Productes::cacheProductes(); }
        $dataProvider=Yii::$app->cache['productes'];


        if(Yii::$app->cache['llista_categories']==FALSE) { Categories::cacheCategories(); }
        $llista_categories=Yii::$app->cache['llista_categories'];

        foreach ($dataProvider->getModels() as $key => $value) 
        {
            $dataProvider->getModels()[$key]->categoria_fk=$llista_categories[$dataProvider->getModels()[$key]->categoria_fk];
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => $llista_categories,
        ]);
    }

    /**
     * Displays a single Productes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->cache['producte'.$id]==FALSE) { Productes::cacheProductes($id); }
        $model=Yii::$app->cache['producte'.$id];

        if(Yii::$app->cache['llista_categories']==FALSE) { Categories::cacheCategories(); }
        $llista_categories=Yii::$app->cache['llista_categories'];

        $model->categoria_fk=$llista_categories[$model->categoria_fk];

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Productes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Productes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            if(Yii::$app->cache['llista_categories']==FALSE) { Categories::cacheCategories(); }
            $llista_categories=Yii::$app->cache['llista_categories'];

            return $this->render('create', [
                'model' => $model,
                'categories' => $llista_categories,
            ]);
        }
    }

    /**
     * Updates an existing Productes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        if(Yii::$app->cache['producte'.$id]==FALSE) { Productes::cacheProductes($id); }
        $model=Yii::$app->cache['producte'.$id];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            if(Yii::$app->cache['llista_categories']==FALSE) { Categories::cacheCategories(); }
            $llista_categories=Yii::$app->cache['llista_categories'];

            return $this->render('update', [
                'model' => $model,
                'categories' => $llista_categories,
            ]);
        }
    }

    /**
     * Deletes an existing Productes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->cache['producte'.id]==FALSE) { Productes::cacheProductes($id); }
        $model=Yii::$app->cache['producte'.id];
        $model->delete();
        Productes::cacheProductes();        

        return $this->redirect(['index']);
    }

    /**
     * Finds the Productes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Productes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
