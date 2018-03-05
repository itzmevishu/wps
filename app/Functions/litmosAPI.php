<?php
/**
 * Created by PhpStorm.
 * User: irodela
 * Date: 3/16/2015
 * Time: 9:46 AM
 */

namespace App\Functions;


use Illuminate\Support\Facades\Log;

class litmosAPI {

    private static function format_phone_us($phone) {
        // note: making sure we have something
        if(!isset($phone{3})) { return ''; }
        // note: strip out everything but numbers
        $phone = preg_replace("/[^0-9]/", "", $phone);
        $length = strlen($phone);
        switch($length) {
            case 7:
                return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
                break;
            case 10:
                return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
                break;
            case 11:
                return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$-$3-$4", $phone);
                break;
            default:
                return $phone;
                break;
        }
    }

    public static function createUserArray($newUser,$lmsSendMessages,$lmsAccessLevel,$lmsUserActive,$lmsCustomName,$lmsSkipFirstLogin,$lmsPassword)
    {

        $postArray = [
            'Id'=>'',
            'UserName'=>$newUser['email_address'],
            'FirstName'=>$newUser['first_name'],
            'LastName'=>$newUser['last_name'],
            'FullName'=>'',
            'Email'=>$newUser['email_address'],
            'AccessLevel'=>$lmsAccessLevel,
            'DisableMessages'=>$lmsSendMessages,
            'Active'=>$lmsUserActive,
            'Skype'=>'',
            'PhoneWork'=> self::format_phone_us($newUser['work_phone']),
            'PhoneMobile'=>'',
            'LastLogin'=>'',
            'LoginKey'=>'',
            'IsCustomUsername'=>$lmsCustomName,
            'Password'=>$lmsPassword,
            'SkipFirstLogin'=>$lmsSkipFirstLogin,
            'TimeZone'=>$newUser['timezone'],
            'Street1'=>$newUser['address'],
            'Street2'=>'',
            'City'=>$newUser['city'],
            'State'=>$newUser['state'],
            'PostalCode'=>$newUser['zip_code'],
            'Country'=>'',
            'CompanyName'=>$newUser['provider_company'],
            'JobTitle'=>'',
            'CustomField1'=>$newUser['national_provider_identifier'],
            'CustomField2'=>$newUser['provider_transaction_access_number'],
            'CustomField3'=>$newUser['part_a_or_part_b_provider'],
            'CustomField4'=>$newUser['MAC_jurisdiction'],
            'CustomField5'=>$newUser['primary_facility_or_provider_type'],
            'CustomField6'=>$newUser['custom_6'],
            'CustomField7'=>$newUser['custom_7'],
            'CustomField8'=>$newUser['custom_8'],
            'CustomField9'=>$newUser['custom_9'],
            'CustomField10'=>'',
            'Culture'=>''
        ];
        return $postArray;
    }



    public static function createNewAssigned($newUser,$lmsSendMessages,$lmsAccessLevel,$lmsUserActive,$lmsCustomName,$lmsSkipFirstLogin)
    {
        $postArray = [
            'Id'=>'',
            'UserName'=>$newUser['email'],
            'FirstName'=>$newUser['first_name'],
            'LastName'=>$newUser['last_name'],
            'FullName'=>'',
            'Email'=>$newUser['email'],
            'AccessLevel'=>$lmsAccessLevel,
            'DisableMessages'=>$lmsSendMessages,
            'Active'=>$lmsUserActive,
            'Skype'=>'',
            'PhoneWork'=>'',
            'PhoneMobile'=>'',
            'LastLogin'=>'',
            'LoginKey'=>'',
            'IsCustomUsername'=>$lmsCustomName,
            'Password'=>'',
            'SkipFirstLogin'=>$lmsSkipFirstLogin,
            'TimeZone'=>''
        ];
        return $postArray;
    }

    public static function updateUserArray($editUser,$litmosid,$lmsSendMessages,$lmsAccessLevel,$lmsUserActive,$lmsCustomName,$lmsSkipFirstLogin,$lmsPassword)
    {
        if($lmsPassword <> ''){
            $postArray = [
                'Id'=>$litmosid,
                'UserName'=>$editUser['email'],
                'FirstName'=>$editUser['first_name'],
                'LastName'=>$editUser['last_name'],
                'FullName'=>'',
                'Email'=>$editUser['email'],
                'AccessLevel'=>$lmsAccessLevel,
                'DisableMessages'=>$lmsSendMessages,
                'Active'=>$lmsUserActive,
                'PhoneWork'=>'',
                'LastLogin'=>'',
                'LoginKey'=>'',
                'IsCustomUsername'=>$lmsCustomName,
                'Password'=>$lmsPassword,
                'SkipFirstLogin'=>$lmsSkipFirstLogin,
                'TimeZone'=>''
            ];
        }else{
            $postArray = [
                'Id'=>$litmosid,
                'UserName'=>$editUser['email'],
                'FirstName'=>$editUser['first_name'],
                'LastName'=>$editUser['last_name'],
                'FullName'=>'',
                'Email'=>$editUser['email'],
                'AccessLevel'=>$lmsAccessLevel,
                'DisableMessages'=>$lmsSendMessages,
                'Active'=>$lmsUserActive,
                'PhoneWork'=>'',
                'LastLogin'=>'',
                'LoginKey'=>'',
                'IsCustomUsername'=>$lmsCustomName,
                'SkipFirstLogin'=>$lmsSkipFirstLogin,
                'TimeZone'=>$editUser['']
            ];
        }

        return $postArray;
    }

     public static function apiUserExists($userEmail)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest =$client->request('GET','users/'.$userEmail,
            [
                'query' =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source' => env('LITMOS_SOURCE')
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        return $createRequest;
    }

     public static function apiUserCreate($newUserArray,$sendMessage)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest = $client->request('POST','users',
            [
                'query' =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source' => env('LITMOS_SOURCE'),
                        'sendmessage' => $sendMessage
                    ],
                'json' => $newUserArray,
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);


        return $createRequest;
    }

    public static function apiUserUpdate($updateUserArray,$litmosID)
    {

        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest = $client->request('PUT','users/'.$litmosID,
            [
                'query' =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source' => env('LITMOS_SOURCE')
                    ],
                'body' => json_encode($updateUserArray),
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors'=> false
            ]);


        return $createRequest;
    }

    public static function createCourseArray($courseIdArray)
    {

        //loop $courseIdArray create

        $newCourseArray = array();

        foreach ($courseIdArray as $courseIds){

            $courseInfo = Cart::get($courseIds);

            $array = array(
                'Id' => $courseInfo['id']
            );

            array_push($newCourseArray,$array);
        }
        return $newCourseArray;

    }


    public static function createSingleCourseXML($courseId)
    {

        $newCourseXML = '<Courses>';
        $newCourseXML .= '<Course>';
        $newCourseXML .= '<Id>';
        $newCourseXML .= $courseId;
        $newCourseXML .= '</Id>';
        $newCourseXML .= '</Course>';
        $newCourseXML .= '</Courses>';

        return $newCourseXML;

    }

    public static function apiAssignCourseSession($course,$sendMessage,$lmsUserID)
    {
       $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest =  $client->request('POST','users/'.$lmsUserID.'/courses',
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE'),
                        'sendmessage'=>$sendMessage
                    ],
                'body' => $course,
                'headers' => ['Content-Type' => 'text/xml'],
                'http_errors'=> false
            ]);

        return $createRequest;
    }

    public static function apiSessionRegistration($courseId,$moduleId,$sessionId,$lmsUserID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);
        Log::info('courses/'.$courseId.'/modules/'.$moduleId.'/sessions/'.$sessionId.'/users/'.$lmsUserID.'/register');
        $createRequest =  $client->request('POST','courses/'.$courseId.'/modules/'.$moduleId.'/sessions/'.$sessionId.'/users/'.$lmsUserID.'/register',
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE')
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors'=> false
            ]);

        return $createRequest;
    }


    public static function apiAssignCourse($courseArray,$sendMessage,$lmsUserID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest =  $client->request('POST','users/'.$lmsUserID.'/courses',
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE'),
                        'sendmessage'=>$sendMessage
                    ],
                'body' => json_encode($courseArray),
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors'=> false
            ]);

        return $createRequest;
    }


    public static function apiSSO($lmsUserID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest =$client->request('GET','users/'.$lmsUserID,
            [
                'query' =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source' => env('LITMOS_SOURCE')
                    ],
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        return $createRequest;
    }


    public static function apiGetSingleCourse($input,$courseID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $postURI = 'courses/'.$courseID;

        $courseRequest =  $client->get($postURI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE'),
                        'limit'=> 1000,
                        'sort'=> 'name'
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
            'http_errors' => false
            ]);

        $createJson=  json_decode($courseRequest->getBody());

        return $createJson;
    }

    public static function apiCheckIfSession($input,$courseID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $postURI = 'courses/'.$courseID.'/modules/ilt';

        $courseRequest =  $client->get($postURI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE'),
                        'limit'=> 1000,
                        'sort'=> 'name'
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        $createJson=  json_decode($courseRequest->getBody());

        return $createJson;
    }

    public static function apiGetSessionInfo($input,$courseID,$moduleID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $postURI = 'courses/'.$courseID.'/modules/'.$moduleID.'/sessions';

        $courseRequest =  $client->request('GET',$postURI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE'),
                        'limit'=> 1000,
                        'sort'=> 'name'
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        $createJson=  json_decode($courseRequest->getBody());

        return $createJson;
    }

    public static function apiGetASession($courseID,$moduleID,$sessionID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $postURI = 'courses/'.$courseID.'/modules/'.$moduleID.'/sessions/'.$sessionID;

        $courseRequest =  $client->request('GET',$postURI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE')
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        $createJson=  json_decode($courseRequest->getBody());

        return $createJson;
    }

    public static function apiLitmosCourseID($courseID)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $postURI = 'courses/'.$courseID;

        $courseRequest =  $client->request('GET',$postURI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE')
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        $createJson=  json_decode($courseRequest->getBody());

        return $createJson;
    }

    public static function apiLitmosCourseBySku($refCode)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $postURI = 'courses';

        $courseRequest =  $client->request('GET',$postURI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE'),
                        'limit'=> 1000,
                        'search'=> $refCode
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        $createJson=  json_decode($courseRequest->getBody());

        //$createJson= $createJson=[''];

        return $createJson;
    }

    public static function getUserCourses($limit,$start)
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $postURI = 'courses';

        $courseRequest =  $client->request('GET',$postURI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE'),
                        'limit'=> $limit,
                        'start'=> $start
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);

        $createJson=  json_decode($courseRequest->getBody());

        return $createJson;
    }

    public static function getTeamID($teamCode)
    {
       $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest =  $client->request('GET','teams',
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source' => env('LITMOS_SOURCE'),
                        'search'=>$teamCode
                    ],
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors'=> false
            ]);

        return $createRequest;
    }


    public static function createTeamArray($userID)
    {

        $newTeamXML = '<Users>'; 
        $newTeamXML .= '<User>';
        $newTeamXML .= '<Id>';
        $newTeamXML .= $userID;
        $newTeamXML .= '</Id>';
        $newTeamXML .= '<UserName></UserName>';
        $newTeamXML .= '<FirstName></FirstName>';
        $newTeamXML .= '<LastName></LastName>';
        $newTeamXML .= '</User>';
        $newTeamXML .= '</Users>';

        return $newTeamXML;

    }


    public static function apiAssignTeams($teamArray,$teamID)
    {
       $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest =  $client->request('POST','teams/'.$teamID.'/users',
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source' => env('LITMOS_SOURCE'),
                        'sendmessage'=>'false'
                    ],
                'body' => $teamArray,
                'headers' => ['Content-Type' => 'text/xml'],
                'http_errors'=> false
            ]);

        return $createRequest;
    }

    public static function getFutureSessionList()
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $URI = '/v1.svc/sessions/future';

        $courseRequest =  $client->request('GET',$URI,
            [
                'query'   =>
                    [
                        'apikey' => env('LITMOS_KEY'),
                        'source'=> env('LITMOS_SOURCE')
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => true
            ]);

        $createJson =  json_decode($courseRequest->getBody());
        return $createJson;
    }
}


