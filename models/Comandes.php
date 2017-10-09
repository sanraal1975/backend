<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use backend\components\Debug;

/**
 * This is the model class for table "comandes".
 *
 * @property integer $id
 * @property integer $client_fk
 * @property string $data
 * @property integer $estat_fk
 *
 * @property Clients $clientFk
 * @property EstatComandes $estatFk
 * @property LiniesComandes[] $liniesComandes
 */
class Comandes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $client_id=NULL;

    public static function tableName()
    {
        return 'comandes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_fk', 'estat_fk'], 'required'],
            [['client_fk', 'estat_fk'], 'integer'],
            [['data'], 'safe'],
            [['client_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_fk' => 'id']],
            [['estat_fk'], 'exist', 'skipOnError' => true, 'targetClass' => EstatComandes::className(), 'targetAttribute' => ['estat_fk' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_fk' => 'Client',
            'data' => 'Data',
            'estat_fk' => 'Estat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientFk()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstatFk()
    {
        return $this->hasOne(EstatComandes::className(), ['id' => 'estat_fk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLiniesComandes()
    {
        return $this->hasMany(LiniesComandes::className(), ['comanda_fk' => 'id']);
    }

    public static function find($id=NULL)
    {
        if(!$id) { return parent::find(); }
        else
        {
            return parent::find()->where(['client_fk' => $id]);
        }
    }

    public function afterFind()
    {
        if(Yii::$app->cache['llista_estats']==FALSE) { EstatComandes::cacheEstats(); }
        $this->estat_fk=Yii::$app->cache['llista_estats'][$this->estat_fk];

        if(Yii::$app->cache['llista_clients']==FALSE) { Clients::cacheClients(); }
        $this->client_id=$this->client_fk;
        $this->client_fk=Yii::$app->cache['llista_clients'][$this->client_fk];

        parent::afterFind();
        return true;
    }

    public function beforeSave($insert)
    {
        if($this->client_id!==NULL) { $this->client_fk=$this->client_id; }
        parent::beforeSave($insert);
        return TRUE;
    }

    public function cacheComandes($id=NULL)
    {
        if($id===NULL)
        {
            $dataProvider = new ActiveDataProvider([
                'query' => Comandes::find(),
            ]);
            Yii::$app->cache->set('comandes',$dataProvider,300);
        }
        else
        {
            $comanda=Comandes::findOne($id);
            Yii::$app->cache->set('comanda'.$id,$comanda,300);
        }        
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->cacheComandes();
        $this->cacheComandes($this->id);
        parent::afterSave($insert, $changedAttributes);
        return TRUE;
    }
}
