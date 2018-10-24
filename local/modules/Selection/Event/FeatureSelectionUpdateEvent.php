<?php
namespace Selection\Event;
use Thelia\Core\Event\ActionEvent;

class FeatureSelectionUpdateEvent extends ActionEvent
{
    /** @var int */
    protected $selection_id;

    /** @var int */
    protected $feature_id;

    protected $feature_value;
    protected $is_text_value;
    protected $locale;

    /**
     * @param int $selection_id
     * @param int $feature_id
     * @param $feature_value
     * @param bool $is_text_value
     */
    public function __construct($selection_id, $feature_id, $feature_value,$locale, $is_text_value = false)
    {
        $this->selection_id = $selection_id;
        $this->feature_id = $feature_id;
        $this->feature_value = $feature_value;
        $this->setIsTextValue($is_text_value);
        $this->setLocale($locale);
    }

    /**
     * @return int the product id
     */
    public function getSelectionId()
    {
        return $this->selection_id;
    }

    /**
     * @param $selection_id
     * @return $this
     */
    public function setSelectionId($selection_id)
    {
        $this->product_id = $selection_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getFeatureId()
    {
        return $this->feature_id;
    }

    /**
     * @param $feature_id
     * @return $this
     */
    public function setFeatureId($feature_id)
    {
        $this->feature_id = $feature_id;

        return $this;
    }

    public function getFeatureValue()
    {
        return $this->feature_value;
    }

    public function setFeatureValue($feature_value)
    {
        $this->feature_value = $feature_value;

        return $this;
    }

    public function getIsTextValue()
    {
        return (bool)$this->is_text_value;
    }

    public function setIsTextValue($is_text_value)
    {
        $this->is_text_value = (bool)$is_text_value;

        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
