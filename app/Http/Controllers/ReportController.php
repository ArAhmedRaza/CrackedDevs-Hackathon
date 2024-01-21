<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use GuzzleHttp\Client;

class ReportController extends Controller
{
    public function assistant(Request $request)
    {
        $ApiKey = config('openai.api_key');
        $client = OpenAI::client($ApiKey);
        $assistantId = config('openai.assistant_id');
        $threadId = $request->session()->get('openai_thread_id');
        if (!$threadId) {
            $response = $client->threads()->create([]);
            $threadId = $response->id;
            $request->session()->put('openai_thread_id', $threadId);
        }
        $response = $client->threads()->retrieve($threadId);
        $thread = $response;
        // Send the message to the assistant and get the response
        $userAnswers = implode(" ", $request->input('answers'));
        $message = [
            'role' => 'user',
            'content' => $userAnswers,
        ];
        $threadRun = [
            'assistant_id' => $assistantId,
        ];

        $response = $client->threads()->messages()->create($threadId, $message);
        $response = $client->threads()->runs()->create($threadId, $threadRun);

        $threadMessages = $client->threads()->messages()->list($threadId);
        $latestMessage = $threadMessages->data;
        $assistantResponse = "";
        foreach ($latestMessage as $data) {
            if ($data->role == 'assistant') {
                $assistantResponse = $data->content[0]->text->value;
            }
        }
        return $assistantResponse;
    }
    
    public function getJobs()
    {
        // Replace 'your-api-key' with the actual API key you have
        $apiKey = '433f388b-bc61-467a-aef7-e8f1a91d53eb';

        // API endpoint
        $endpoint = 'https://api.crackeddevs.com/api/get-jobs';

        // Optional query parameters
        $queryParams = [
            'limit' => 10,
            'page' => 1,
            // Add other parameters as needed
        ];

        // Set headers
        $headers = [
            'api-key' => $apiKey,
        ];

        // Initialize Guzzle client
        $client = new Client();

        // Make the GET request
        try {
            $response = $client->request('GET', $endpoint, [
                'headers' => $headers,
                'query' => $queryParams,
            ]);

            // Get and decode the response body
            $data = json_decode($response->getBody(), true);

            // Handle the response data as needed
            // For example, you can return it or process it further
            return response()->json($data);

        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
