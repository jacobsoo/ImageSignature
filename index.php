<?php
    header("Content-type: image/png");
    Header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    Header('Expires: Thu, 19 Nov 1999 08:52:00 GMT');
    Header('Pragma: no-cache');
    $image = imagecreatefrompng("arteam-crew.png");
    
    if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
        if ($_SERVER["HTTP_CLIENT_IP"]) {
            $proxy = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $proxy = $_SERVER["REMOTE_ADDR"];
        }
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        if ($_SERVER["HTTP_CLIENT_IP"]) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
    }
    
    // Simple OS Detection
    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $os_array = Array (
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/iphone os 6_1_3/i'    =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );
 
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    
    //browser type
    $agent = $_SERVER['HTTP_USER_AGENT'];
    // Browser type
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    // you can add different browsers with the same way ..
    if(preg_match('/(chromium)[ \/]([\w.]+)/', $ua))
            $browser = 'chromium';
    elseif(preg_match('/(chrome)[ \/]([\w.]+)/', $ua))
            $browser = 'chrome';
    elseif(preg_match('/(safari)[ \/]([\w.]+)/', $ua))
            $browser = 'safari';
    elseif(preg_match('/(opera)[ \/]([\w.]+)/', $ua))
            $browser = 'opera';
    elseif(preg_match('/(msie)[ \/]([\w.]+)/', $ua))
            $browser = 'msie';
    elseif(preg_match('/(mozilla)[ \/]([\w.]+)/', $ua))
            $browser = 'mozilla';
 
    preg_match('/('.$browser.')[ \/]([\w]+)/', $ua, $version);
  
    $font_blue = imagecolorallocate($image, 225, 225, 225);
    //($image, fontsize, rightindent, downindent, data, txtcolour)
    $l1= "Your IP is: " . $ip;
    $l2= "Your OS is: " . $os_platform;
    $l3= "Your browser is " . $browser . " " . $version[2];
    $utc_str = gmdate("M d Y H:i:s", time());
    $gmtimenow = "Timestamp: " . $utc_str . "UTC";
    imagestring($image, 2, 12, 3, $l1, $font_blue);  
    imagestring($image, 2, 12, 12, $l2, $font_blue); 
    imagestring($image, 2, 12, 21, $l3, $font_blue);
    imagestring($image, 2, 12, 31, $gmtimenow, $font_blue);
    
    imagepng($image);
    imagedestroy($image);
    
    $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $somecontent = "\n$os_platform\n$ip\n$browser\n$host\n$utc_str\n$ua\n";
    $file = fopen('test.txt', 'a+');
    
    fwrite($file, $somecontent); 
    fclose($file);
?>
