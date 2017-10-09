<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "estat_comandes".
 *
 * @property integer $id
 * @property string $descripcio
 *
 * @property Comandes[] $comandes
 */
class EstatComandes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estat_comandes';
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
    public function getComandes()
    {
        return $this->hasMany(Comandes::className(), ['estat_fk' => 'id']);
    }

    public function cacheEstats()
    {
        $estatcomandes = new ActiveDataProvider([
            'query' => EstatComandes::find(),
        ]);

        $llista_estats=array();
        foreach ($estatcomandes->getModels() as $key => $value) 
        {
            $llista_estats[$value->id]=$estatcomandes->getModels()[$key]->descripcio;
        }
        Yii::$app->cache->set('llista_estats',$llista_estats,300);
    }
}
