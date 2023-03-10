<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

require_once SYSTEMPATH . 'Config/Services.php';

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices{

    public static function AuthService($param = [], $getShared = true){
        if ($getShared){
            return static::getSharedInstance('AuthService', $param);
        }
        return new \App\Services\AuthService($param);
    }
    
    public static function UserService($param = [], $getShared = true){
        if ($getShared){
            return static::getSharedInstance('UserService', $param);
        }
        return new \App\Services\UserService($param);
    }

    public static function WebsiteService($param = [], $getShared = true){
        if ($getShared){
            return static::getSharedInstance('WebsiteService', $param);
        }
        return new \App\Services\WebsiteService($param);
    }

    public static function ConfigArticleService($param = [], $getShared = true){
        if ($getShared){
            return static::getSharedInstance('ConfigArticleService', $param);
        }
        return new \App\Services\ConfigArticleService($param);
    }

    public static function ConfigCatalogueService($param = [], $getShared = true){
        if ($getShared){
            return static::getSharedInstance('ConfigCatalogueService', $param);
        }
        return new \App\Services\ConfigCatalogueService($param);
    }

    public static function CriteriaService($param = [], $getShared = true){
        if ($getShared){
            return static::getSharedInstance('CriteriaService', $param);
        }
        return new \App\Services\CriteriaService($param);
    }

    public static function StatisticService($param = [], $getShared = true){
        if ($getShared){
            return static::getSharedInstance('StatisticService', $param);
        }
        return new \App\Services\StatisticService($param);
    }
}
