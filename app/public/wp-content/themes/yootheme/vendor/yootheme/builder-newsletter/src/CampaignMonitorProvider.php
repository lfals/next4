<?php

namespace YOOtheme\Builder\Newsletter;

class CampaignMonitorProvider extends AbstractProvider
{
    protected $apiEndpoint = 'https://api.createsend.com/api/v3.1';

    /**
     * {@inheritdoc}
     */
    public function lists($provider)
    {
        $lists = [];
        if ($result = $this->get('clients.json') and $result['success']) {

            $clients = array_map(function ($client) {
                return ['value' => $client['ClientID'], 'text' => $client['Name']];
            }, $result['data']);

            if ($client_id = $provider['client_id'] ?: $clients[0]['value']) {

                if ($result = $this->get("/clients/$client_id/lists.json") and $result['success']) {
                    $lists = array_map(function ($client) {
                        return ['value' => $client['ListID'], 'text' => $client['Name']];
                    }, $result['data']);
                }
            }
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
            $name = (!empty($data['first_name']) ? $data['first_name'] . ' ' : '') . $data['last_name'];
            $result = $this->post("subscribers/{$provider['list_id']}.json", [
                'EmailAddress' => $email,
                'Name' => $name,
                'Resubscribe' => true,
                'RestartSubscriptionBasedAutoresponders' => true,
            ]);

            if (!$result['success']) {
                throw new \Exception($result['data']);
            }

            return true;
        }

        throw new \Exception('No list selected.');

    }

    /**
     * {@inheritdoc}
     */
    protected function getHeaders()
    {
        return parent::getHeaders() + [
            'Authorization' => 'Basic ' . base64_encode("{$this->apiKey}:nopass"),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function findError($response, $formattedResponse)
    {
        return isset($formattedResponse['Message'])
            ? sprintf('%d: %s', $formattedResponse['Code'], $formattedResponse['Message'])
            : parent::findError($response, $formattedResponse);
    }
}
