<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use InstagramAPI\Instagram;

class Insta extends Model
{
    public static $username = 'badiekremix';
    public static $password = 'Acer123ert';
    public static $my_user_id = '3418730320';

    public static $debug = false;
    public static $truncatedDebug = false;
    // public function __construct()
    // {
    // }

    public static function Login()
    {
        Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $ig = new Instagram(self::$debug, self::$truncatedDebug);
        try {
            $ig->login(self::$username, self::$password);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $ig;
    }

    public static function getInbox()
    {
        $ig = self::Login();
        $json = $ig->direct->getInbox();
        return $json;
    }

    public static function getThread($mid)
    {
        $ig = self::Login();
        $json = $ig->direct->getThread($mid);
        return $json;
    }

    public static function follow($profile_id)
    {
        $ig = self::Login();
        $json =  $ig->people->follow($profile_id);
        return $json;
    }

    public static function sendText($recipients, $msg)
    {
        $ig = self::Login();
        $json =  $ig->direct->sendText($recipients,  $msg);
        return $json;
    }

    public static function getUserIdForName($user_name)
    {
        $ig = self::Login();
        $json =  $ig->people->getUserIdForName($user_name);
        return $json;
    }

    public static function hideThread($mid)
    {
        $ig = self::Login();
        $json =  $ig->direct->hideThread($mid);
        return $json;
    }

    public static function getComments($mid,$options)
    {
        $ig = self::Login();
        $json =  $ig->media->getComments($mid,$options);
        return $json;
    }

    public static function getInfoByName($username)
    {
        $ig = self::Login();
        $json =  $ig->people->getInfoByName($username);
        return $json;
    }
}
