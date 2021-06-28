<?php

namespace YOOtheme\Builder\Newsletter;

use function YOOtheme\trans;
use YOOtheme\HttpClientInterface;
use YOOtheme\Str;
use YOOtheme\Translator;

class MailChimpProvider extends AbstractProvider
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param string              $apiKey
     * @param HttpClientInterface $client
     *
     * @throws \Exception
     */
    public function __construct($apiKey, HttpClientInterface $client)
    {
        parent::__construct($apiKey, $client);

        if (strpos($apiKey, '-') === false) {
            throw new \Exception('Invalid API key.');
        }

        list(, $dataCenter) = explode('-', $apiKey);

        $this->apiEndpoint = "https://{$dataCenter}.api.mailchimp.com/3.0";
    }

    /**
     * {@inheritdoc}
     */
    public function lists($provider)
    {
        $clients = [];

        if ($result = $this->get('lists', ['count' => '100']) and $result['success']) {
            $lists = array_map(function ($list) {
                return ['value' => $list['id'], 'text' => $list['name']];
            }, $result['data']['lists']);
        } else {
            throw new \Exception($result['data']);
        }

        return compact('lists', 'clients');
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe($email, $data, $provider)
    {
        if (!empty($provider['list_id'])) {

            $mergeFields = [];
            if (isset($data['first_name'])) {
                $mergeFields['FNAME'] = $data['first_name'];
            }
            if (isset($data['last_name'])) {
                $mergeFields['LNAME'] = $data['last_name'];
            }

            // Deprecated
            if (!isset($provider['double_optin'])) {
                $provider['double_optin'] = true;
            }

            $result = $this->post("lists/{$provider['list_id']}/members", [
                'email_address' => $email,
                'status' => $provider['double_optin'] ? 'pending' : 'subscribed',
                'merge_fields' => $mergeFields,
            ]);

            if (!$result['success']) {

                if (Str::contains($result['data'], 'already a list member')) {
                    throw new \Exception(sprintf(trans('%s is already a list member.'), htmlspecialchars($email)));
                }
                if (Str::contains($result['data'], 'was permanently deleted and cannot be re-imported. The contact must re-subscribe to get back on the list')) {
                    throw new \Exception(sprintf(trans('%s was permanently deleted and cannot be re-imported. The contact must re-subscribe to get back on the list.'), htmlspecialchars($email)));
                }
                if ($result['data'] === 'Please provide a valid email address.') {
                    throw new \Exception(trans('Please provide a valid email address.'));
                }

                throw new \Exception($result['data']);

            }

            return true;
        }

        throw new \Exception(trans('No list selected.'));

    }

    /**
     * {@inheritdoc}
     */
    protected function getHeaders()
    {
        return parent::getHeaders() + [
            'Authorization' => "apikey {$this->apiKey}",
        ];
    }
}
