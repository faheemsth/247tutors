<?php
namespace App\Services;

use GuzzleHttp\Client;

class Zoom
{
    protected $accessToken;
    protected $client;
    protected $account_id;
    protected $client_id;
    protected $client_secret;

        // public function __construct()
        // {
        //     $this->client_id = "DC3c0Yf6SBqWJQnxdwbuGg";
        //     $this->client_secret = "u2pRmq1w4LCPUbbrjj0waFlu5cGsBVZM";
        //     $this->account_id = "W-tVnx5ZRkS9BVDklP3oLQ";
        //     // dd(env('ZOOM_CLIENT_SECRET
        //     $this->accessToken = $this->getAccessToken();

        //     $this->client = new Client([
        //         'base_uri' => 'https://api.zoom.us/v2/',
        //         'headers' => [
        //             'Authorization' => 'Bearer ' . $this->accessToken,
        //             'Content-Type' => 'application/json',
        //         ],
        //     ]);
        // }

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

    // get meeting
    public function getMeeting(string $meetingId)
    {
        try {
            $response = $this->client->request('GET', 'meetings/' . $meetingId);
            $data = json_decode($response->getBody(), true);
            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    // get all meetings
    public function getAllMeeting()
    {
        try {
            $response = $this->client->request('GET', 'users/me/meetings');
            $data = json_decode($response->getBody(), true);
            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    // get upcoming meetings
    public function getUpcomingMeeting()
    {
        try {
            $response = $this->client->request('GET', 'users/me/meetings?type=upcoming');

            $data = json_decode($response->getBody(), true);
            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    // get previous meetings
    public function getPreviousMeetings()
    {
        try {
            $meetings = $this->getAllMeeting();

            $previousMeetings = [];

            foreach ($meetings['meetings'] as $meeting) {
                $start_time = strtotime($meeting['start_time']);

                if ($start_time < time()) {
                    $previousMeetings[] = $meeting;
                }
            }

            return [
                'status' => true,
                'data' => $previousMeetings]
            ;

        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    // get rescheduling meeting
    public function rescheduleMeeting(string $meetingId, array $data)
    {
        try {
            $response = $this->client->request('PATCH', 'meetings/' . $meetingId, [
                'json' => $data,
            ]);
            if ($response->getStatusCode() === 204) {
                return [
                    'status' => true,
                    'message' => 'Meeting Rescheduled Successfully',
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Something went wrong',
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    // end meeting
    public function endMeeting($meetingId)
    {
        try {
            $response = $this->client->request('PUT', 'meetings/' . $meetingId . '/status', [
                'json' => [
                    'action' => 'end',
                ],
            ]);
            if ($response->getStatusCode() === 204) {
                return [
                    'status' => true,
                    'message' => 'Meeting Ended Successfully',
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Something went wrong',
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    // delete meeting
    public function deleteMeeting(string $meetingId)
    {
        try {
            $response = $this->client->request('DELETE', 'meetings/' . $meetingId);
            if ($response->getStatusCode() === 204) {
                return [
                    'status' => true,
                    'message' => 'Meeting Deleted Successfully',
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Something went wrong',
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }

    }

    // recover meeting
    public function recoverMeeting($meetingId)
    {
        try {
            $response = $this->client->request('PUT', 'meetings/' . $meetingId . '/status', [
                'json' => [
                    'action' => 'recover',
                ],
            ]);

            if ($response->getStatusCode() === 204) {
                return [
                    'status' => true,
                    'message' => 'Meeting Recovered Successfully',
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Something went wrong',
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    // get users list
    public function getUsers($data)
    {
        try {
            $response = $this->client->request('GET', 'users', [
                'query' => [
                    'page_size' => @$data['page_size'] ?? 300,
                    'status' => @$data['status'] ?? 'active',
                    'page_number' => @$data['page_number'] ?? 1,
                ],
            ]);
            $responseData = json_decode($response->getBody(), true);
            $data = [];
            $data['current_page'] = $responseData['page_number'];
            $data['profile'] = $responseData['users'][0];
            $data['last_page'] = $responseData['page_count'];
            $data['per_page'] = $responseData['page_size'];
            $data['total'] = $responseData['total_records'];
            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }

    }

    public function inviteGuestToMeeting($meetingId, $guestEmail)
    {
        $data = [
            'first_name' => 'test',
            'email' => $guestEmail,
            'action' => 'invite',
        ];

        try {
            $response = $this->client->request('POST', 'meetings/'.$meetingId.'/registrants', [
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

        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $this->generateJwtToken(),
        // ])->post("https://api.zoom.us/v2/meetings/{$meetingId}/registrants", $data);

        // return $response->json();
    }
}
