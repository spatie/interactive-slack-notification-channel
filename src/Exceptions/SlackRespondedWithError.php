<?php

namespace Spatie\InteractiveSlackNotificationChannel\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;

class SlackRespondedWithError extends RuntimeException
{
    public Response $response;

    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

    public static function make(Response $response)
    {
        return (new static('Unexpected response from Slack: '.$response->body()))
            ->setResponse($response);
    }
}
