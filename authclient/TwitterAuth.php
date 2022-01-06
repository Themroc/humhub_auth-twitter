<?php

namespace humhubContrib\auth\twitter\authclient;

use yii\authclient\clients\Twitter;

/**
 * Twitter allows authentication via Twitter OAuth.
 */
class TwitterAuth extends Twitter
{

    function __construct() {
        parent::__construct();
        $this->attributeParams['include_email'] = 'true';
    }

    /**
     * @inheritdoc
     */
    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
            'cssIcon' => 'fa fa-twitter',
            'buttonBackgroundColor' => '#e0492f',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'username' => 'screen_name',
            'email' => 'email',
            'url' => 'url',
            'about' => 'description',

            /* These are not used atm, but soon they hopefully will be */
            'avatar' => function ($attributes) {
                if (isset($attributes['profile_image_url_https'])) {
                    return $attributes['profile_image_url_https'];
                } else if (isset($attributes['profile_image_url'])) {
                    return $attributes['profile_image_url'];
                } else {
                    return '';
                }
            },
            'banner' => 'profile_banner_url',
        ];
    }
}
