<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );


// send sms the application
function send_sms($mobile, $txt) {

    //Getting SMS report Start here
    $ci       = & get_instance();
    $totalSms = config_item("total_sms");
    $sendSMS  = $ci->db->query("SELECT IFNULL(SUM(total_messages), 0) AS total FROM sms_record WHERE delivery_report='1'")->row()->total;
    
    $smsBalance = $totalSms - $sendSMS;
    
    $mobile = str_replace('-', '', trim($mobile));
    $mobile = str_replace('_', '', $mobile);
    
    if ($smsBalance > 0 && strlen($mobile) == 11 && strlen(trim($txt)) > 2) {
        
        $apiUrl = 'https://portal.adnsms.com/api/v1/secure/send-sms';
        
        $data = [
            'api_key'      => 'KEY-s8fsan58aqsndxaxn00rv382nyl5gdu2',
            'api_secret'   => '9ll4BN95LB8GbXBO',
            'request_type' => 'single_sms',
            'message_type' => 'UNICODE',
            'mobile'       => $mobile,
            'message_body' => $txt
        ];
        
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //return "cURL Error #:" . $err;
            return false;
        } else {
            //return $response;
            return 1;
        }
    }else{
        return false;
    }
}



// send sms the application
/*function send_sms($gsm, $txt) {

    //Getting SMS report Start here
    $CI = & get_instance();
    $CI->load->model("action");
    $sent_sms = 0;
    
    $total_sms = config_item("total_sms");
    $sent_sms_data = $CI->action->read("sms_record",array("delivery_report"=>"1"));
    foreach($sent_sms_data as $key=>$value){
      $sent_sms += $value->total_messages;
    }
    
    //Getting SMS report End here

    $username = "LogicPoint";
    $password = "LogicPoint123";
    $mobile = trim($gsm);
    $url = "https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl";

    if ($sent_sms < $total_sms) {
        //Sending Request Start here
        try{
            $soapClient = new SoapClient($url);
            $paramArray = array(
                'userName'		=> $username,
                'userPassword'	=> $password,
                'mobileNumber'	=> $mobile,
                'smsText'		=> $txt,
                'type'			=> "TEXT",
                'maskName'		=> "",
                'campaignName'	=> ""
            );
            $value = $soapClient->__call("OneToOne", array($paramArray));

            if($value->OneToOneResult == 1900){
                return true;
            }

            return false;
        } catch (Exception $e) {
            echo $e;
        }
        //Sending Request End here
    }else{
        return false;
    }
}*/  