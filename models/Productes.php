<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "productes".
 *
 * @property integer $id
 * @property integer $categoria_fk
 * @property string $descripcio
 * @property integer $stock
 * @property integer $pendents
 *
 * @property LiniesComandes[] $liniesComandes
 * @property Categories $categoriaFk
 */
class Productes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoria_fk', 'descripcio', 'stock', 'pendents'], 'required'],
            [['categoria_fk', 'stock', 'pendents'], 'integer'],
            [['descripcio'], 'string', 'max' => 200],
            [['categoria_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['categoria_fk' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoria_fk' => 'Categoria Fk',
            'descripcio' => 'Descripcio',
            'stock' => 'Stock',
            'pendents' => 'Pendents',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLiniesComandes()
    {
        return $this->hasMany(LiniesComandes::className(), ['producte_fk' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaFk()
    {
        return $this->hasOne(Categories::className(), ['id' => 'categoria_fk']);
    }

    public function cacheProductes($id=NULL)
    {
        if($id===NULL)
        {
            $productes = new ActiveDataProvider([
                'query' => Productes::find(),
            ]);

            $llista_productes=array();
            foreach ($productes->getModels() as $key => $value) 
            {
                $llista_productes[$value->id]=$productes->getModels()[$key]->descripcio;
            }
            Yii::$app->cache->set('llista_productes',$llista_productes,300);
            Yii::$app->cache->set('productes',$productes,300);
        }
        else
        {
            $producte=Productes::findOne($id);
            Yii::$app->cache->set('producte'.$id,$producte,300);
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->cacheProductes();
        $this->cacheProductes($this->id);
        parent::afterSave($insert, $changedAttributes);
        return TRUE;
    }


}
