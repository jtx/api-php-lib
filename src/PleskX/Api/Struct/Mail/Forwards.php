<?php

namespace PleskX\Api\Struct\Mail;

use PleskX\Api\XmlResponse;

class Forwards extends \PleskX\Api\Struct
{
    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $address;

    /**
     * @param XmlResponse $apiResponse
     * @throws \Exception
     */
    public function __construct(XMLResponse $apiResponse)
    {
        $line = new \stdClass();
        $line->id = $apiResponse->id;
        $line->name = $apiResponse->name;
        $line->address = $apiResponse->forwarding->address;

        $this->_initScalarProperties($line, [
            'id',
            'name',
            'address',
        ]);
    }
}
