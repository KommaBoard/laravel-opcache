<?php

namespace KommaBoard\OPCache;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Console\Command;
use Illuminate\Hashing\BcryptHasher;
use Psr\Log\LoggerInterface;

class OPCacheCommand extends Command
{
    protected $signature = 'opcache:clear';
    protected $description = 'Clear the PHP OPcache';

    private $hasher;
    private $logger;

    public function __construct(BcryptHasher $hasher, LoggerInterface $logger)
    {
        parent::__construct();
        $this->hasher = $hasher;
        $this->logger = $logger;
    }

    public function handle()
    {
        $client = new Client(['base_uri' => config('app.url'), 'timeout' => 5.0]);

        try {
            $response = $client->request('POST', '/opcache/clear/', [
                'form_params' => [
                    'token' => $this->hasher->make(config('opcache.salt') . config('app.key'))
                ]
            ]);

            $result = json_decode($response->getBody());

            $this->line($result->message);
            $this->logger->info('OPCache clear command: ' . $result->message);
        }
        catch (ServerException $e) {
            $this->handleException($e);
        }
        catch (ClientException $e)
        {
            $this->handleException($e);
        }
    }

    private function handleException($e)
    {
        $result = json_decode($e->getResponse()->getBody());
        dd($result);
        $this->line('Error ' . $e->getCode() . ': ' . $result->message);
        // $this->logger->error('OPCache clear command: ' . $result->message);
    }
}
