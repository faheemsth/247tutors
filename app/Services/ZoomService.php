<?

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ZoomService
{
    protected string $accessToken;
    protected $client;
    protected $account_id;
    protected $client_id;
    protected $client_secret;protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->client_id = env('ZOOM_CLIENT_KEY');
        $this->client_secret = env('ZOOM_CLIENT_SECRET');
        $this->account_id = env('ZOOM_ACCOUNT_ID');
        
        $this->accessToken = $this->getAccessToken();

        $this->client = new Client([
            'base_uri' => 'https://api.zoom.us/v2/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    protected function getAccessToken()
    {

        $client = new Client([
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->client_id . ':' . $this->client_secret),
                'Host' => 'zoom.us',
            ],
        ]);

        $response = $client->request('POST', "https://zoom.us/oauth/token", [
            'form_params' => [
                'grant_type' => 'account_credentials',
                'account_id' => $this->account_id,
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody['access_token'];
    }

     // create meeting
     public function createMeeting(array $data)
     {
         try {
             $response = $this->client->request('POST', 'users/me/meetings', [
                 'json' => $data,
             ]);
             $res = json_decode($response->getBody(), true);
             return [
                 'status' => true,
                 'data' => $res,
             ];
         } catch (\Throwable $th) {
             return [
                 'status' => false,
                 'message' => $th->getMessage(),
             ];
         }
     }
 
     // update meeting
     public function updateMeeting(string $meetingId, array $data)
     {
         try {
             $response = $this->client->request('PATCH', 'meetings/' . $meetingId, [
                 'json' => $data,
             ]);
             $res = json_decode($response->getBody(), true);
             return [
                 'status' => true,
                 'data' => $res,
             ];
         } catch (\Throwable $th) {
             return [
                 'status' => false,
                 'message' => $th->getMessage(),
             ];
         }
     }

   
}
