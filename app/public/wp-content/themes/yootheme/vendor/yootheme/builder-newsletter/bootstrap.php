<?php

namespace YOOtheme;

use YOOtheme\Builder\Newsletter\CampaignMonitorProvider;
use YOOtheme\Builder\Newsletter\MailChimpProvider;
use YOOtheme\Builder\Newsletter\NewsletterController;

return [

    'theme' => [

        'newsletterProvider' => [
            'mailchimp' => MailChimpProvider::class,
            'cmonitor' => CampaignMonitorProvider::class,
        ],

    ],

    'routes' => [
        ['post', '/theme/newsletter/list', NewsletterController::class . '@lists'],
        ['post', '/theme/newsletter/subscribe', NewsletterController::class . '@subscribe', ['csrf' => false, 'allowed' => true]],
    ],

    'extend' => [

        Builder::class => function (Builder $builder) {
            $builder->addTypePath(Path::get('./elements/*/element.json'));
        },

    ],

    'services' => [

        MailChimpProvider::class => function (Config $config, HttpClientInterface $client, Translator $translator) {
            return new MailChimpProvider($config('~theme.mailchimp_api'), $client, $translator);
        },

        CampaignMonitorProvider::class => function (Config $config, HttpClientInterface $client) {
            return new CampaignMonitorProvider($config('~theme.cmonitor_api'), $client);
        },

    ],

];
