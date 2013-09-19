<?php

namespace Application\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

/**
 * Class CustomAdapterFactory
 *
 * @author  Tony
 * @package Application\Model
 */
class CustomAdapterFactory implements FactoryInterface
{

    /**
     * @var
     */
    protected $configKey;

    /**
     * @param $key
     */
    public function __construct($key)
    {
        $this->configKey = $key;
    }

    /**
     * Configuration to be available
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Adapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new Adapter($config[$this->configKey]);
    }
}