<?php

namespace CronDashboard\Events;

use CronDashboard\Model\CronJobs;
use Thelia\Core\Event\ActionEvent;

class CronJobEvent extends ActionEvent
{
	/** @var int */
    protected $id = null;

    /** @var Comment */
    protected $cronJob = null;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Comment|null
     */
    public function getCronJob()
    {
        return $this->cronJob;
    }

    /**
     * @param Comment $comment
     */
    public function setCronJob(CronJobs $cronJob)
    {
        $this->cronJob = $cronJob;

        return $this;
    }
}