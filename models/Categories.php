<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use backend\components\Debug;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $descripcio
 *
 * @property Productes[] $productes
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcio'], 'required'],
            [['descripcio'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcio' => 'Descripcio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductes()
    {
        return $this->hasMany(Productes::className(), ['categoria_fk' => 'id']);
    }

    public function cacheCategories($id=NULL)
    {
        if($id==NULL)
        {
            $categories = new ActiveDataProvider([
                'query' => Categories::find(),
            ]);

            $llista_categories=array();
            foreach ($categories->getModels() as $key => $value) 
            {
                $llista_categories[$value->id]=$categories->getModels()[$key]->descripcio;
            }
            Yii::$app->cache->set('llista_categories',$llista_categories,300);
            Yii::$app->cache->set('categories',$categories,300);
        }
        else
        {
            $categoria=Categories::findOne($id);
            Yii::$app->cache->set('categoria'.$id,$categoria,300);
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->cacheCategories();
        $this->cacheCategories($this->id);
        parent::afterSave($insert, $changedAttributes);
        return TRUE;
    }


}
