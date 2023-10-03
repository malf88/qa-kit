<?php

namespace App\Modules\GestaoProjetos\Libs\Trello;

use App\Modules\GestaoProjetos\Config\TrelloConfig;
use GuzzleHttp\Client;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Arr;
use function PHPUnit\Framework\isJson;

abstract class AbstractTrello
{
    private Client $client;
    protected string $path;
    public function __construct(
        private readonly TrelloConfig $config
    )
    {
        $this->client = new Client([
            'base_uri' => config('gestao-projetos.trello_api_url')
        ]);
    }

    protected function request(string $method, array $parameter = [], array $parametroPath = []):mixed
    {
        $response = $this->client->request($method, $this->trataURL($parametroPath), [
            'query' => $this->getQuery($parameter),
            'body'  => json_encode($parameter),
            'form_params' => $parameter
        ]);

        return  json_decode($response->getBody()->getContents(), true);
    }

    private function getQuery(array $parameters):array
    {
        return [
            'key' => $this->config->getKey(),
            'token' => $this->config->getToken(),
            ...$parameters
        ];
    }
    private function trataURL(array $parametroPath):string
    {
        return str_replace(array_keys($parametroPath),array_values($parametroPath), $this->path);
    }

    abstract public function get(mixed $parameters);

}
