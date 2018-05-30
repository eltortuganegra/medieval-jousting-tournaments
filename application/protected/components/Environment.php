<?php

class Environment
{
    const DOMAIN_OFFICIAL = 'medievaljoustingtournaments.com';
    const SUBDOMAIN_IN_ELTORTUGANEGRA = 'medievaljoustingtournaments.eltortuganegra.com';
    const PREPRODUCTION = 'pre-production.medievaljoustingtournaments.com';

    private $host;
    private $rootPath;
    private $configPath;

    public function __construct($host, $rootPath)
    {
        $this->host = $host;
        $this->rootPath = $rootPath;
    }

    public function buildConfiguration()
    {
        if ($this->isProductionEnvironment()) {
            $this->setConfigPath('/protected/config/production.php');
        } else if ($this->isPreProduction()) {
            $this->setConfigPath('/protected/config/pre-production.php');
            $this->defineConstant();
        } else {
            $this->setConfigPath('/protected/config/development.php');
            $this->defineConstant();
        }
    }

    public function isProductionEnvironment()
    {
        return ($this->host == self::DOMAIN_OFFICIAL
            || $this->host == self::SUBDOMAIN_IN_ELTORTUGANEGRA
        );
    }

    public function isPreProduction()
    {
        return ($this->host == self::PREPRODUCTION);
    }

    public function getConfigPath()
    {
        return $this->config;
    }

    private function setConfigPath($pathToConfigFile)
    {
        $this->configPath = $this->rootPath . $pathToConfigFile;
    }

    private function defineConstant()
    {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
    }

}