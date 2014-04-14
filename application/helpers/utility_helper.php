<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 



    function send_email($to='', $subject, $content) 
    {
        if(preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/', $to) == FALSE)
        {
            return;
        }
        
        $CI =& get_instance();        
        
        //清除上次寄件者
        $CI->phpmailer->ClearAddresses();
        
        //設定使用SMTP發送
        $CI->phpmailer->IsSMTP();

        //指定SMTP的服務器位址
        $CI->phpmailer->Host = $CI->config->item('host','mail');
        //設定SMTP服務的POST
        $CI->phpmailer->Port = $CI->config->item('port','mail');


        //寄件人Email
        $CI->phpmailer->From = $CI->config->item('sender_mail','mail');
        //寄件人名稱
        $CI->phpmailer->FromName = $CI->config->item('sender_name','mail');

        //收件人Email
        $CI->phpmailer->AddAddress($to);


        //設定信件字元編碼
        $CI->phpmailer->CharSet = $CI->config->item('charset','mail');
        //設定信件編碼，大部分郵件工具都支援此編碼方式
        $CI->phpmailer->Encoding = $CI->config->item('encoding','mail');
        //設置郵件格式為HTML
        $CI->phpmailer->IsHTML($CI->config->item('is_html','mail'));
        //每50自斷行
        $CI->phpmailer->WordWrap = $CI->config->item('word_wrap','mail');


        //郵件標題
        $CI->phpmailer->Subject = $subject;
        //郵件內容
        $CI->phpmailer->Body = $content;

        //寄送郵件
        if(!$CI->phpmailer->Send())
        {
            echo "郵件無法順利寄出!";
            echo "Mailer Error: " . $CI->phpmailer->ErrorInfo;
            //exit;
        }
    }

    
    
    function send_muti_email($to_mails=array(), $subject, $content) 
    {
        
        $CI =& get_instance();        
        
        //清除上次寄件者
        $CI->phpmailer->ClearAddresses();
        
        //設定使用SMTP發送
        $CI->phpmailer->IsSMTP();

        //指定SMTP的服務器位址
        $CI->phpmailer->Host = $CI->config->item('host','mail');
        //設定SMTP服務的POST
        $CI->phpmailer->Port = $CI->config->item('port','mail');


        //寄件人Email
        $CI->phpmailer->From = $CI->config->item('sender_mail','mail');
        //寄件人名稱
        $CI->phpmailer->FromName = $CI->config->item('sender_name','mail');

        //收件人Email
        foreach ($to_mails as $mail) 
        {
            if(preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/', $mail) == TRUE)
            {
               $CI->phpmailer->AddAddress($mail);
            }
        }


        //設定信件字元編碼
        $CI->phpmailer->CharSet = $CI->config->item('charset','mail');
        //設定信件編碼，大部分郵件工具都支援此編碼方式
        $CI->phpmailer->Encoding = $CI->config->item('encoding','mail');
        //設置郵件格式為HTML
        $CI->phpmailer->IsHTML($CI->config->item('is_html','mail'));
        //每50自斷行
        $CI->phpmailer->WordWrap = $CI->config->item('word_wrap','mail');


        //郵件標題
        $CI->phpmailer->Subject = $subject;
        //郵件內容
        $CI->phpmailer->Body = $content;

        //寄送郵件
        if(!$CI->phpmailer->Send())
        {
            echo "郵件無法順利寄出!";
            echo "Mailer Error: " . $CI->phpmailer->ErrorInfo;
            //exit;
        }
    }
    
    
    

    /**
     * 產生隨機密碼
     */
    function randomPassword($len = 8) 
    {

        $ranges = array        
        (        
                1 => array(97, 122), // a-z (lowercase)
                2 => array(48, 57) // 0-9 (numeral)        
                //3 => array(65, 90), // A-Z (uppercase)
                
        );

        $password = "";

        for ($i=0; $i<$len; $i++)
        {
                $r = mt_rand(1,count($ranges));
                $password .= chr(mt_rand($ranges[$r][0], $ranges[$r][1]));
        }

        return $password;
    }
    
    
    function sort_by_study_level($a, $b)
    {
        if($a['study_level'] == $b['study_level']) return 0;
        return ($a['study_level'] > $b['study_level']) ? 1 : -1;
    }

	
    function is_between($given_timestamp=5, $begin_timestamp=0, $end_timestamp=100)
    {
		if ($given_timestamp >= $begin_timestamp
			&& $given_timestamp <= $end_timestamp) {
			return true;
		}
		return false;
    }