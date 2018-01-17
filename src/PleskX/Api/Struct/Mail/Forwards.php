<?php

namespace PleskX\Api\Struct\Mail;

use PleskX\Api\XmlResponse;

class Forwards extends \PleskX\Api\Struct
{
    /** @var integer */
    public $id;

    /** @var string */
    public $host;

    /** @var string */
    public $value;

    /**
     * @param XmlResponse $apiResponse
     * @throws \Exception
     */
    public function __construct(XMLResponse $apiResponse)
    {
        $line = new \stdClass();
        $line->id = $apiResponse->id;
        $line->host = $apiResponse->name;
        $line->value = $apiResponse->forwarding->address;

        $this->_initScalarProperties($line, [
            'id',
            'host',
            'value',
        ]);
    }
}
