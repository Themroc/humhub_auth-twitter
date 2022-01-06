<?php

namespace humhubContrib\auth\twitter\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use humhubContrib\auth\twitter\Module;

/**
 * The module configuration model
 */
class ConfigureForm extends Model
{
    /**
     * @var boolean Enable this authclient
     */
    public $enabled;

    /**
     * @var string the client id provided by Twitter (they call it "client key")
     */
    public $consumerKey;

    /**
     * @var string the client secret provided by Twitter
     */
    public $consumerSecret;

    /**
     * @var string readonly
     */
    public $redirectUri;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consumerKey', 'consumerSecret'], 'required'],
            [['enabled'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'enabled' => Yii::t('AuthTwitterModule.base', 'Enabled'),
            'consumerKey' => Yii::t('AuthTwitterModule.base', 'Client key'),
            'consumerSecret' => Yii::t('AuthTwitterModule.base', 'Client secret'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
        ];
    }

    /**
     * Loads the current module settings
     */
    public function loadSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('auth-twitter');

        $settings = $module->settings;

        $this->enabled = (boolean)$settings->get('enabled');
        $this->consumerKey = $settings->get('consumerKey');
        $this->consumerSecret = $settings->get('consumerSecret');

        $this->redirectUri = Url::to(['/user/auth/external'], true);
#        $this->redirectUri = Url::to(['/user/auth/external', 'authclient' => 'twitter'], true);
    }

    /**
     * Saves module settings
     */
    public function saveSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('auth-twitter');

        $module->settings->set('enabled', (boolean)$this->enabled);
        $module->settings->set('consumerKey', $this->consumerKey);
        $module->settings->set('consumerSecret', $this->consumerSecret);

        return true;
    }

    /**
     * Returns a loaded instance of this configuration model
     */
    public static function getInstance()
    {
        $config = new static;
        $config->loadSettings();

        return $config;
    }

}
