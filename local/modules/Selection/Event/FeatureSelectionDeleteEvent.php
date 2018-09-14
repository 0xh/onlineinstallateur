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

    /**
     * FeatureProductDeleteEvent constructor.
     *
     * @param int $selection_id
     * @param int $feature_id
     */
    public function __construct($selection_id, $feature_id)
    {
        
//        parent::__construct(null);
        
        $this->selection_id = $selection_id;
        $this->feature_id = $feature_id;
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
}
