<?php

namespace Selection\Event;

use Thelia\Core\Event\ActionEvent;

class FeatureSelectionDeleteEvent extends ActionEvent
{

    /** @var int */
    protected $id;

    /** @var int */
    protected $selection_id;

    /** @var int */
    protected $feature_id;

    /** @var int */
    protected $feature_av_id;

    /**
     * FeatureProductDeleteEvent constructor.
     *
     * @param int $selection_id
     * @param int $feature_id
     * @param int $feature_av_id
     */
    public function __construct($selection_id, $feature_id, $feature_av_id = null)
    {

        $this->selection_id = $selection_id;
        $this->feature_id   = $feature_id;
        $this->feature_av_id=$feature_av_id;        
        return $this;
    }

    public function getSelectionId()
    {
        return $this->selection_id;
    }

    public function setSelectionId($selection_id)
    {
        $this->$selection_id = $selection_id;

        return $this;
    }

    public function getFeatureId()
    {
        return $this->feature_id;
    }

    public function setFeatureId($feature_id)
    {
        $this->feature_id = $feature_id;

        return $this;
    }
    
     public function getFeatureAvId()
    {
        return $this->feature_id;
    }

    public function setFeatureAvId($feature_id)
    {
        $this->feature_id = $feature_id;

        return $this;
    }
    
     public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->feature_id = $id;

        return $this;
    }


}
