<?php

namespace SepaImporter\Event;

use Thelia\Core\Event\ActionEvent;

class ImportEvent extends ActionEvent
{

    /** @var  \Symfony\Component\DependencyInjection\ContainerInterface */
    protected $container;

    /** @var  int $orderId */
    protected $orderId;

    public function __construct()
    {
        //
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *
     * @return OrderCreationEvent
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param int $orderId
     *
     * @return ImportEvent
     */
    public function setOrderId($orderId)
    {
    	$this->orderId = $orderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
    	return $this->orderId;
    }
}
