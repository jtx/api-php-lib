<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH.

namespace PleskX\Api\Operator;
use PleskX\Api\Client;
use PleskX\Api\Struct\Mail as Struct;

class Mail extends \PleskX\Api\Operator
{
    /**
     * @param string $name
     * @param int $siteId
     * @param string $forwardAddress
     * @return Struct\Info
     */
    public function create(string $name, int $siteId, string $forwardAddress): Struct\Info
    {
        $packet = $this->_client->getPacket();
        $info = $packet->addChild($this->_wrapperTag)->addChild('create');

        $filter = $info->addChild('filter');
        $filter->addChild('site-id', $siteId);
        $mailname = $filter->addChild('mailname');
        $mailname->addChild('name', $name);

        $forwarding = $mailname->addChild('forwarding');
        $forwarding->addChild('enabled', 'true');
        $forwarding->addChild('address', $forwardAddress);

        $response = $this->_client->request($packet);

        return new Struct\Info($response->mailname);
    }

    /**
     * @param int $siteId
     * @return array
     */
    public function get(int $siteId): array
    {
        $packet = $this->_client->getPacket();
        $info = $packet->addChild($this->_wrapperTag)->addChild('get_info');
        $filter = $info->addChild('filter');
        $filter->addChild('site-id', $siteId);
        $info->addChild('forwarding');

        $response = $this->_client->request($packet, Client::RESPONSE_FULL);

        $forwards = [];
        foreach ($response->mail->get_info->result as $forwardInfo) {
            $forwards[] = new Struct\Forwards($forwardInfo->mailname);
        }

        return $forwards;
    }

    /**
     * @param string $field
     * @param integer|string $value
     * @param integer $siteId
     * @return bool
     */
    public function delete($field, $value, $siteId): bool
    {
        $packet = $this->_client->getPacket();
        $filter = $packet->addChild($this->_wrapperTag)->addChild('remove')->addChild('filter');
        $filter->addChild('site-id', $siteId);
        $filter->addChild($field, $value);
        $response = $this->_client->request($packet);

        return 'ok' === (string)$response->status;
    }
}
