<?php

namespace Sujip\PayPal\Notification\Contracts;

interface Payload
{
    /**
     * @return \Sujip\PayPal\Notification\Payload
     */
    public function create(): \Sujip\PayPal\Notification\Payload;
}
