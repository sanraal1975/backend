<?php

namespace backend\models;

use Yii;
use backend\components\Debug;
use backend\models\Productes;
use backend\models\Comandes;

use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "linies_comandes".
 *
 * @property integer $id
 * @property integer $comanda_fk
 * @property integer $producte_fk
 * @property integer $quantitat_solicitada
 * @property integer $quantitat_servida
 *
 * @property Comandes $comandaFk
 * @property Productes $producteFk
 */
class LiniesComandes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $producte_id=NULL;
    public $getDescripcioProducte=TRUE;

    public static function tableName()
    {
        return 'linies_comandes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comanda_fk', 'producte_fk', 'quantitat_solicitada', 'quantitat_servida'], 'required'],
            [['comanda_fk', 'producte_fk', 'quantitat_solicitada', 'quantitat_servida'], 'integer'],
            [['comanda_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Comandes::className(), 'targetAttribute' => ['comanda_fk' => 'id']],
            [['producte_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Productes::className(), 'targetAttribute' => ['producte_fk' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comanda_fk' => 'Comanda',
            'producte_fk' => 'Producte',
            'quantitat_solicitada' => 'Quantitat Solicitada',
            'quantitat_servida' => 'Quantitat Servida',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComandaFk()
    {
        return $this->hasOne(Comandes::className(), ['id' => 'comanda_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducteFk()
    {
        return $this->hasOne(Productes::className(), ['id' => 'producte_fk']);
    }

    public static function find($id=NULL)
    {
        if(!$id) { return parent::find(); }
        else
        {
            return parent::find()->where(['comanda_fk' => $id]);
        }
    }

    public function afterFind()
    {
        if(Yii::$app->cache['llista_productes']==FALSE) { Productes::cacheProductes(); }
        $this->producte_id=$this->producte_fk;
        $this->producte_fk=Yii::$app->cache['llista_productes'][$this->producte_fk];
        parent::afterFind();
        return TRUE;
    }

    public function beforeSave($insert)
    {
        if($this->quantitat_servida<0) { $this->quantitat_servida=0; }
        if($this->quantitat_servida>$this->quantitat_solicitada) { $this->quantitat_servida=$this->quantitat_solicitada; }
        parent::beforeSave($insert);
        return TRUE;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $linies=new LiniesComandes();
        $incomplertes=$linies::find()->where('comanda_fk='.$this->comanda_fk.' and quantitat_servida<quantitat_solicitada')->count();
        if($incomplertes==0)
        {
            $comanda=Comandes::findOne($this->comanda_fk);
            $comanda->estat_fk=2;
            $comanda->update(FALSE);
        }
        else
        {
            $comanda=Comandes::findOne($this->comanda_fk);
            $comanda->estat_fk=1;
            $comanda->update(FALSE);
        }
        $this->cacheLinies($this->comanda_fk);
        Comandes::cacheComandes();
        Comandes::cacheComandes($this->comanda_fk);
        parent::afterSave($insert, $changedAttributes);
        return TRUE;
    }

    public function cacheLinies($id)
    {
        $liniescomandes = new ActiveDataProvider([
            'query' => LiniesComandes::find($id),
        ]);
        Yii::$app->cache->set('liniescomandes'.$id,$liniescomandes,300);
    }

    public function cacheLinia($id)
    {
        $model=LiniesComandes::findOne($id);
        Yii::$app->cache->set('linia'.$id,$model,300);
    }

}
