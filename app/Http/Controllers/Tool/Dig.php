<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\DigRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class Dig extends Controller
{
    /**
     * Return Dig DNS lookups
     */
    public function __invoke(DigRequest $request): JsonResponse
    {
        // Create the request url
        $request_url = sprintf('%s/tools/dig', config('app.webhook_url'));

        // Types
        $types = [];

        foreach ($request->get('types') as $type) {
            $types[$type] = true;
        }

        // Service response
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'name'       => (string) $request->get('name'),
                'nameserver' => (string) $request->get('nameserver'),
                'types'      => $types,
            ])
            ->throw()
            ->json();

        return response()->json([
            'output'  => $this->parseResponseJson($response),
            'command' => sprintf('dig %s', $response['command']),
            'success' => $response['success'],
        ]);
    }

    /**
     * Parse and manipulate the response data
     */
    private function parseResponseJson(array $response): array
    {
        // Remove YAML 1.1 types
        $output = str_replace(['!!timestamp'], '', $response['output']);

        // Parse output YAML
        $dig_data = Yaml::parse($output);

        // Records to return
        $records = [];

        // Collect returned records
        foreach ($dig_data as $index => $returned) {
            if ($returned['type'] !== 'MESSAGE')
               continue;

            if (!array_key_exists('response_message_data', $returned['message']))
                continue;

            if (!array_key_exists('ANSWER_SECTION', $returned['message']['response_message_data']))
                continue;

            $answer = $returned['message']['response_message_data']['ANSWER_SECTION'];

            if(!is_array($answer))
                continue;

            array_walk($answer, function($record) use (&$records) {
                $parts = explode(' ', $record);
                $value = implode(' ', array_slice($parts, 4, (sizeof($parts) - 3)));
                $records[] = [
                    'name'  => $parts[0],
                    'ttl'   => $parts[1],
                    'tag'   => $parts[3],
                    'value' => $value,
                    'raw'   => $record,
                ];
            });
        }

        return $records;
    }
}
