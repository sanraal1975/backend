<?php

namespace backend\models;

use Yii;
use backend\components\Encrypter;
use backend\components\Debug;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $nom
 * @property string $login
 * @property string $password
 *
 * @property Comandes[] $comandes
 */
class Clients extends \yii\db\ActiveRecord
{

    private $encrypter;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nom', 'login', 'password'], 'required'],
            [['nom', 'login', 'password'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
            'login' => 'Login',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComandes()
    {
        return $this->hasMany(Comandes::className(), ['client_fk' => 'id']);
    }


    public function beforesave($insert)
    {
        $this->encrypter=new Encrypter();
        $this->nom=$this->encrypter->encrypt($this->nom);
        $this->login=$this->encrypter->encrypt($this->login);
        return true;
    }

    public function afterFind()
    {
        $this->encrypter=new Encrypter();
        $this->nom=$this->encrypter->decrypt($this->nom);
        $this->login=$this->encrypter->decrypt($this->login);
        parent::afterFind();
        return true;
    }

    public function decodePassword()
    {
        $this->encrypter=new Encrypter();
        $this->password=$this->encrypter->decrypt($this->password);
    }

    public function encodePassword()
    {
        $this->encrypter=new Encrypter();
        $this->password=$this->encrypter->encrypt($this->password);
    }

    public function findByLoginPassword()
    {
        $this->encrypter=new Encrypter();
        $login=$this->encrypter->encrypt($this->login);
        $password=$this->encrypter->encrypt($this->password);
        $trobat=parent::findOne(array('login'=>$login,'password'=>$password));
        if($trobat)
        {
            $_SESSION['isUser']=true;
            $_SESSION['usuari']['id']=$trobat->id;
            $_SESSION['usuari']['nom']=$trobat->nom;
            $_SESSION['usuari']['login']=$this->login;
        }
        return (bool) $trobat;
    }

    public function cacheClients($id=NULL)
    {
        if($id===NULL)
        {
            $clients = new ActiveDataProvider([
                'query' => Clients::find(),
            ]);

            $llista_clients=array();
            foreach ($clients->getModels() as $key => $value) 
            {
                $llista_clients[$value->id]=$clients->getModels()[$key]->nom;
            }
            Yii::$app->cache->set('llista_clients',$llista_clients,300);
            Yii::$app->cache->set('clients',$clients,300);
        }
        else
        {
            $client=Clients::findOne($id);
            Yii::$app->cache->set('client'.$id,$client,300);
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->cacheClients();
        $this->cacheClients($this->id);
        parent::afterSave($insert, $changedAttributes);
        return TRUE;
    }

}
