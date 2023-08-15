<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;

use GuzzleHttp\Client;
use Illuminate\Http\Client\HttpClientException;
use function PHPUnit\Framework\isJson;

abstract class AbstractTrello
{
    private Client $client;
    protected string $path;
    public function __construct(
        private readonly string $token,
        private readonly string $key
    )
    {
        $this->client = new Client([
            'base_uri' => config('gestao-projetos.trello_api_url')
        ]);
    }

    protected function request(string $method, array $parameter = []):mixed
    {
        $response = $this->client->request($method, $this->path, [
            'query' => $this->getQuery()
        ]);

        return  json_decode($response->getBody()->getContents());
    }

    private function getQuery():array
    {
        return [
            'key' => $this->key,
            'token' => $this->token
        ];
    }

    abstract public function send(mixed $parameters);

}
