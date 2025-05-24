<?php

namespace Modules\Core\Packages\SMS;

use Illuminate\Support\Facades\Http;


class SmsBox
{
    public function __construct()
    {
        $this->username              = 'dietxn';
        $this->password              = "Q4o3]}Fu";
    }

    public function send($message, $phone)
    {
        try {
            $data = [
                "username"      => $this->username,
                "password"      => $this->password,
                "type"          => 0,
                "dlr"           => 1,  //0: No delivery report required 1: delivery report required
                "destination"   => $phone, //"96594971095"
                "source"        => "DSectionOTP",
                "message"       => 'your verification code is ' . $message,
            ];
            return $this->request($data);
        } catch (\Exception $e) {
            return ["Result" => "false"];
        }
    }
    public function request($data)
    {
        $response = Http::get('http://api.rmlconnect.net/bulksms/bulksms', $data);
        return $this->parse($response);
    }
    public function parse($result)
    {
        $result = str_replace(["\n", "\r", "\t"], '', $result);
        $result = trim(str_replace('"', "'", $result));
        $result = explode('|', $result);
        $r['status_code'] = $result[0];
        $r['mobile']      = $result[1];
        $r['message_id']  = $result[2];
        $r['Result']      = $r['status_code'] == '1701'; //1701 =>Success
        return $r;
    }
}
