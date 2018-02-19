<?php
namespace HookKonfigurator\Model;

class Products
{
	/**
     * TableMap class name
     */
    const TABLE_MAP = '\\HookKonfigurator\\Model\\Map\\ProductsTableMap';
	
	
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $oagName;

    /**
     * @var string
     */
    private $productNumber;

    /**
     * @var string
     */
    private $grade;

    /**
     * @var integer
     */
    private $buildYearFrom;

    /**
     * @var integer
     */
    private $buildYearTo;

    /**
     * @var \DateTime
     */
    private $createdat;

    /**
     * @var \DateTime
     */
    private $updatedat;

    /**
     * @var boolean
     */
    private $shtProduct;

    /**
     * @var string
     */
    private $shtId;

    /**
     * @var integer
     */
    private $shtCategory;

    /**
     * @var string
     */
    private $shtText1;

    /**
     * @var string
     */
    private $shtText2;

    /**
     * @var boolean
     */
    private $oagProduct;

    /**
     * @var string
     */
    private $oagId;

    /**
     * @var integer
     */
    private $oagCategory;

    /**
     * @var string
     */
    private $oagText1;

    /**
     * @var string
     */
    private $oagText2;

    /**
     * @var integer
     */
    private $megabildId;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $specificationName;

    /**
     * @var string
     */
    private $labelName;

    /**
     * @var string
     */
    private $waterHeaterEnergyClass;

    /**
     * @var integer
     */
    private $waterHeaterEnergyEfficiency;

    /**
     * @var string
     */
    private $waterHeaterEnergyGrade;

    /**
     * @var integer
     */
    private $spaceHeaterEfficiency;

    /**
     * @var integer
     */
    private $spaceHeaterPower;

    /**
     * @var string
     */
    private $spaceHeaterType;

    /**
     * @var boolean
     */
    private $spaceHeaterLowTemperatureHeatPump;

    /**
     * @var integer
     */
    private $spaceHeaterColderEfficiency;

    /**
     * @var integer
     */
    private $spaceHeaterWarmerEfficiency;

    /**
     * @var string
     */
    private $spaceHeaterLowTemperatureGrade;

    /**
     * @var integer
     */
    private $spaceHeaterLowTemperatureEfficiency;

    /**
     * @var integer
     */
    private $spaceHeaterLowTemperatureColderEfficiency;

    /**
     * @var integer
     */
    private $spaceHeaterLowTemperatureWarmerEfficiency;

    /**
     * @var integer
     */
    private $spaceHeaterLowTemperatureSupplementaryPower;

    /**
     * @var integer
     */
    private $spaceHeaterLowTemperaturePower;

    /**
     * @var string
     */
    private $solarEfficiency;

    /**
     * @var string
     */
    private $solarSize;

    /**
     * @var integer
     */
    private $solarPumpPower;

    /**
     * @var string
     */
    private $storageType;

    /**
     * @var string
     */
    private $storageVolume;

    /**
     * @var string
     */
    private $storageNonSolarVolume;

    /**
     * @var integer
     */
    private $storageWarmthLoss;

    /**
     * @var string
     */
    private $combinationHeaterSpaceHeaterGrade;

    /**
     * @var string
     */
    private $combinationHeaterWaterHeaterGrade;

    /**
     * @var integer
     */
    private $combinedEfficiency;

    /**
     * @var string
     */
    private $temperatureControlStandbyWarmthLoss;

    /**
     * @var string
     */
    private $temperatureControlType;

    /**
     * @var integer
     */
    private $supplementaryPower;

    /**
     * @var integer
     */
    private $montageId;

    /**
     * @var string
     */
    private $price;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Vendors
     */
    private $vendor;

    /**
     * @var \AppBundle\Entity\ProductsTypes
     */
    private $combinedMainHeaterType;

    /**
     * @var \AppBundle\Entity\ProductsTypes
     */
    private $type;

    /**
     * Constructor
     */
    public function __construct()
    {
      //  $this->component = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Products
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set oagName
     *
     * @param string $oagName
     * @return Products
     */
    public function setOagName($oagName)
    {
        $this->oagName = $oagName;

        return $this;
    }

    /**
     * Get oagName
     *
     * @return string 
     */
    public function getOagName()
    {
        return $this->oagName;
    }

    /**
     * Set productNumber
     *
     * @param string $productNumber
     * @return Products
     */
    public function setProductNumber($productNumber)
    {
        $this->productNumber = $productNumber;

        return $this;
    }

    /**
     * Get productNumber
     *
     * @return string 
     */
    public function getProductNumber()
    {
        return $this->productNumber;
    }

    /**
     * Set grade
     *
     * @param string $grade
     * @return Products
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return string 
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set buildYearFrom
     *
     * @param integer $buildYearFrom
     * @return Products
     */
    public function setBuildYearFrom($buildYearFrom)
    {
        $this->buildYearFrom = $buildYearFrom;

        return $this;
    }

    /**
     * Get buildYearFrom
     *
     * @return integer 
     */
    public function getBuildYearFrom()
    {
        return $this->buildYearFrom;
    }

    /**
     * Set buildYearTo
     *
     * @param integer $buildYearTo
     * @return Products
     */
    public function setBuildYearTo($buildYearTo)
    {
        $this->buildYearTo = $buildYearTo;

        return $this;
    }

    /**
     * Get buildYearTo
     *
     * @return integer 
     */
    public function getBuildYearTo()
    {
        return $this->buildYearTo;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     * @return Products
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime 
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * Set updatedat
     *
     * @param \DateTime $updatedat
     * @return Products
     */
    public function setUpdatedat($updatedat)
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    /**
     * Get updatedat
     *
     * @return \DateTime 
     */
    public function getUpdatedat()
    {
        return $this->updatedat;
    }

    /**
     * Set shtProduct
     *
     * @param boolean $shtProduct
     * @return Products
     */
    public function setShtProduct($shtProduct)
    {
        $this->shtProduct = $shtProduct;

        return $this;
    }

    /**
     * Get shtProduct
     *
     * @return boolean 
     */
    public function getShtProduct()
    {
        return $this->shtProduct;
    }

    /**
     * Set shtId
     *
     * @param string $shtId
     * @return Products
     */
    public function setShtId($shtId)
    {
        $this->shtId = $shtId;

        return $this;
    }

    /**
     * Get shtId
     *
     * @return string 
     */
    public function getShtId()
    {
        return $this->shtId;
    }

    /**
     * Set shtCategory
     *
     * @param integer $shtCategory
     * @return Products
     */
    public function setShtCategory($shtCategory)
    {
        $this->shtCategory = $shtCategory;

        return $this;
    }

    /**
     * Get shtCategory
     *
     * @return integer 
     */
    public function getShtCategory()
    {
        return $this->shtCategory;
    }

    /**
     * Set shtText1
     *
     * @param string $shtText1
     * @return Products
     */
    public function setShtText1($shtText1)
    {
        $this->shtText1 = $shtText1;

        return $this;
    }

    /**
     * Get shtText1
     *
     * @return string 
     */
    public function getShtText1()
    {
        return $this->shtText1;
    }

    /**
     * Set shtText2
     *
     * @param string $shtText2
     * @return Products
     */
    public function setShtText2($shtText2)
    {
        $this->shtText2 = $shtText2;

        return $this;
    }

    /**
     * Get shtText2
     *
     * @return string 
     */
    public function getShtText2()
    {
        return $this->shtText2;
    }

    /**
     * Set oagProduct
     *
     * @param boolean $oagProduct
     * @return Products
     */
    public function setOagProduct($oagProduct)
    {
        $this->oagProduct = $oagProduct;

        return $this;
    }

    /**
     * Get oagProduct
     *
     * @return boolean 
     */
    public function getOagProduct()
    {
        return $this->oagProduct;
    }

    /**
     * Set oagId
     *
     * @param string $oagId
     * @return Products
     */
    public function setOagId($oagId)
    {
        $this->oagId = $oagId;

        return $this;
    }

    /**
     * Get oagId
     *
     * @return string 
     */
    public function getOagId()
    {
        return $this->oagId;
    }

    /**
     * Set oagCategory
     *
     * @param integer $oagCategory
     * @return Products
     */
    public function setOagCategory($oagCategory)
    {
        $this->oagCategory = $oagCategory;

        return $this;
    }

    /**
     * Get oagCategory
     *
     * @return integer 
     */
    public function getOagCategory()
    {
        return $this->oagCategory;
    }

    /**
     * Set oagText1
     *
     * @param string $oagText1
     * @return Products
     */
    public function setOagText1($oagText1)
    {
        $this->oagText1 = $oagText1;

        return $this;
    }

    /**
     * Get oagText1
     *
     * @return string 
     */
    public function getOagText1()
    {
        return $this->oagText1;
    }

    /**
     * Set oagText2
     *
     * @param string $oagText2
     * @return Products
     */
    public function setOagText2($oagText2)
    {
        $this->oagText2 = $oagText2;

        return $this;
    }

    /**
     * Get oagText2
     *
     * @return string 
     */
    public function getOagText2()
    {
        return $this->oagText2;
    }

    /**
     * Set megabildId
     *
     * @param integer $megabildId
     * @return Products
     */
    public function setMegabildId($megabildId)
    {
        $this->megabildId = $megabildId;

        return $this;
    }

    /**
     * Get megabildId
     *
     * @return integer 
     */
    public function getMegabildId()
    {
        return $this->megabildId;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Products
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set specificationName
     *
     * @param string $specificationName
     * @return Products
     */
    public function setSpecificationName($specificationName)
    {
        $this->specificationName = $specificationName;

        return $this;
    }

    /**
     * Get specificationName
     *
     * @return string 
     */
    public function getSpecificationName()
    {
        return $this->specificationName;
    }

    /**
     * Set labelName
     *
     * @param string $labelName
     * @return Products
     */
    public function setLabelName($labelName)
    {
        $this->labelName = $labelName;

        return $this;
    }

    /**
     * Get labelName
     *
     * @return string 
     */
    public function getLabelName()
    {
        return $this->labelName;
    }

    /**
     * Set waterHeaterEnergyClass
     *
     * @param string $waterHeaterEnergyClass
     * @return Products
     */
    public function setWaterHeaterEnergyClass($waterHeaterEnergyClass)
    {
        $this->waterHeaterEnergyClass = $waterHeaterEnergyClass;

        return $this;
    }

    /**
     * Get waterHeaterEnergyClass
     *
     * @return string 
     */
    public function getWaterHeaterEnergyClass()
    {
        return $this->waterHeaterEnergyClass;
    }

    /**
     * Set waterHeaterEnergyEfficiency
     *
     * @param integer $waterHeaterEnergyEfficiency
     * @return Products
     */
    public function setWaterHeaterEnergyEfficiency($waterHeaterEnergyEfficiency)
    {
        $this->waterHeaterEnergyEfficiency = $waterHeaterEnergyEfficiency;

        return $this;
    }

    /**
     * Get waterHeaterEnergyEfficiency
     *
     * @return integer 
     */
    public function getWaterHeaterEnergyEfficiency()
    {
        return $this->waterHeaterEnergyEfficiency;
    }

    /**
     * Set waterHeaterEnergyGrade
     *
     * @param string $waterHeaterEnergyGrade
     * @return Products
     */
    public function setWaterHeaterEnergyGrade($waterHeaterEnergyGrade)
    {
        $this->waterHeaterEnergyGrade = $waterHeaterEnergyGrade;

        return $this;
    }

    /**
     * Get waterHeaterEnergyGrade
     *
     * @return string 
     */
    public function getWaterHeaterEnergyGrade()
    {
        return $this->waterHeaterEnergyGrade;
    }

    /**
     * Set spaceHeaterEfficiency
     *
     * @param integer $spaceHeaterEfficiency
     * @return Products
     */
    public function setSpaceHeaterEfficiency($spaceHeaterEfficiency)
    {
        $this->spaceHeaterEfficiency = $spaceHeaterEfficiency;

        return $this;
    }

    /**
     * Get spaceHeaterEfficiency
     *
     * @return integer 
     */
    public function getSpaceHeaterEfficiency()
    {
        return $this->spaceHeaterEfficiency;
    }

    /**
     * Set spaceHeaterPower
     *
     * @param integer $spaceHeaterPower
     * @return Products
     */
    public function setSpaceHeaterPower($spaceHeaterPower)
    {
        $this->spaceHeaterPower = $spaceHeaterPower;

        return $this;
    }

    /**
     * Get spaceHeaterPower
     *
     * @return integer 
     */
    public function getSpaceHeaterPower()
    {
        return $this->spaceHeaterPower;
    }

    /**
     * Set spaceHeaterType
     *
     * @param string $spaceHeaterType
     * @return Products
     */
    public function setSpaceHeaterType($spaceHeaterType)
    {
        $this->spaceHeaterType = $spaceHeaterType;

        return $this;
    }

    /**
     * Get spaceHeaterType
     *
     * @return string 
     */
    public function getSpaceHeaterType()
    {
        return $this->spaceHeaterType;
    }

    /**
     * Set spaceHeaterLowTemperatureHeatPump
     *
     * @param boolean $spaceHeaterLowTemperatureHeatPump
     * @return Products
     */
    public function setSpaceHeaterLowTemperatureHeatPump($spaceHeaterLowTemperatureHeatPump)
    {
        $this->spaceHeaterLowTemperatureHeatPump = $spaceHeaterLowTemperatureHeatPump;

        return $this;
    }

    /**
     * Get spaceHeaterLowTemperatureHeatPump
     *
     * @return boolean 
     */
    public function getSpaceHeaterLowTemperatureHeatPump()
    {
        return $this->spaceHeaterLowTemperatureHeatPump;
    }

    /**
     * Set spaceHeaterColderEfficiency
     *
     * @param integer $spaceHeaterColderEfficiency
     * @return Products
     */
    public function setSpaceHeaterColderEfficiency($spaceHeaterColderEfficiency)
    {
        $this->spaceHeaterColderEfficiency = $spaceHeaterColderEfficiency;

        return $this;
    }

    /**
     * Get spaceHeaterColderEfficiency
     *
     * @return integer 
     */
    public function getSpaceHeaterColderEfficiency()
    {
        return $this->spaceHeaterColderEfficiency;
    }

    /**
     * Set spaceHeaterWarmerEfficiency
     *
     * @param integer $spaceHeaterWarmerEfficiency
     * @return Products
     */
    public function setSpaceHeaterWarmerEfficiency($spaceHeaterWarmerEfficiency)
    {
        $this->spaceHeaterWarmerEfficiency = $spaceHeaterWarmerEfficiency;

        return $this;
    }

    /**
     * Get spaceHeaterWarmerEfficiency
     *
     * @return integer 
     */
    public function getSpaceHeaterWarmerEfficiency()
    {
        return $this->spaceHeaterWarmerEfficiency;
    }

    /**
     * Set spaceHeaterLowTemperatureGrade
     *
     * @param string $spaceHeaterLowTemperatureGrade
     * @return Products
     */
    public function setSpaceHeaterLowTemperatureGrade($spaceHeaterLowTemperatureGrade)
    {
        $this->spaceHeaterLowTemperatureGrade = $spaceHeaterLowTemperatureGrade;

        return $this;
    }

    /**
     * Get spaceHeaterLowTemperatureGrade
     *
     * @return string 
     */
    public function getSpaceHeaterLowTemperatureGrade()
    {
        return $this->spaceHeaterLowTemperatureGrade;
    }

    /**
     * Set spaceHeaterLowTemperatureEfficiency
     *
     * @param integer $spaceHeaterLowTemperatureEfficiency
     * @return Products
     */
    public function setSpaceHeaterLowTemperatureEfficiency($spaceHeaterLowTemperatureEfficiency)
    {
        $this->spaceHeaterLowTemperatureEfficiency = $spaceHeaterLowTemperatureEfficiency;

        return $this;
    }

    /**
     * Get spaceHeaterLowTemperatureEfficiency
     *
     * @return integer 
     */
    public function getSpaceHeaterLowTemperatureEfficiency()
    {
        return $this->spaceHeaterLowTemperatureEfficiency;
    }

    /**
     * Set spaceHeaterLowTemperatureColderEfficiency
     *
     * @param integer $spaceHeaterLowTemperatureColderEfficiency
     * @return Products
     */
    public function setSpaceHeaterLowTemperatureColderEfficiency($spaceHeaterLowTemperatureColderEfficiency)
    {
        $this->spaceHeaterLowTemperatureColderEfficiency = $spaceHeaterLowTemperatureColderEfficiency;

        return $this;
    }

    /**
     * Get spaceHeaterLowTemperatureColderEfficiency
     *
     * @return integer 
     */
    public function getSpaceHeaterLowTemperatureColderEfficiency()
    {
        return $this->spaceHeaterLowTemperatureColderEfficiency;
    }

    /**
     * Set spaceHeaterLowTemperatureWarmerEfficiency
     *
     * @param integer $spaceHeaterLowTemperatureWarmerEfficiency
     * @return Products
     */
    public function setSpaceHeaterLowTemperatureWarmerEfficiency($spaceHeaterLowTemperatureWarmerEfficiency)
    {
        $this->spaceHeaterLowTemperatureWarmerEfficiency = $spaceHeaterLowTemperatureWarmerEfficiency;

        return $this;
    }

    /**
     * Get spaceHeaterLowTemperatureWarmerEfficiency
     *
     * @return integer 
     */
    public function getSpaceHeaterLowTemperatureWarmerEfficiency()
    {
        return $this->spaceHeaterLowTemperatureWarmerEfficiency;
    }

    /**
     * Set spaceHeaterLowTemperatureSupplementaryPower
     *
     * @param integer $spaceHeaterLowTemperatureSupplementaryPower
     * @return Products
     */
    public function setSpaceHeaterLowTemperatureSupplementaryPower($spaceHeaterLowTemperatureSupplementaryPower)
    {
        $this->spaceHeaterLowTemperatureSupplementaryPower = $spaceHeaterLowTemperatureSupplementaryPower;

        return $this;
    }

    /**
     * Get spaceHeaterLowTemperatureSupplementaryPower
     *
     * @return integer 
     */
    public function getSpaceHeaterLowTemperatureSupplementaryPower()
    {
        return $this->spaceHeaterLowTemperatureSupplementaryPower;
    }

    /**
     * Set spaceHeaterLowTemperaturePower
     *
     * @param integer $spaceHeaterLowTemperaturePower
     * @return Products
     */
    public function setSpaceHeaterLowTemperaturePower($spaceHeaterLowTemperaturePower)
    {
        $this->spaceHeaterLowTemperaturePower = $spaceHeaterLowTemperaturePower;

        return $this;
    }

    /**
     * Get spaceHeaterLowTemperaturePower
     *
     * @return integer 
     */
    public function getSpaceHeaterLowTemperaturePower()
    {
        return $this->spaceHeaterLowTemperaturePower;
    }

    /**
     * Set solarEfficiency
     *
     * @param string $solarEfficiency
     * @return Products
     */
    public function setSolarEfficiency($solarEfficiency)
    {
        $this->solarEfficiency = $solarEfficiency;

        return $this;
    }

    /**
     * Get solarEfficiency
     *
     * @return string 
     */
    public function getSolarEfficiency()
    {
        return $this->solarEfficiency;
    }

    /**
     * Set solarSize
     *
     * @param string $solarSize
     * @return Products
     */
    public function setSolarSize($solarSize)
    {
        $this->solarSize = $solarSize;

        return $this;
    }

    /**
     * Get solarSize
     *
     * @return string 
     */
    public function getSolarSize()
    {
        return $this->solarSize;
    }

    /**
     * Set solarPumpPower
     *
     * @param integer $solarPumpPower
     * @return Products
     */
    public function setSolarPumpPower($solarPumpPower)
    {
        $this->solarPumpPower = $solarPumpPower;

        return $this;
    }

    /**
     * Get solarPumpPower
     *
     * @return integer 
     */
    public function getSolarPumpPower()
    {
        return $this->solarPumpPower;
    }

    /**
     * Set storageType
     *
     * @param string $storageType
     * @return Products
     */
    public function setStorageType($storageType)
    {
        $this->storageType = $storageType;

        return $this;
    }

    /**
     * Get storageType
     *
     * @return string 
     */
    public function getStorageType()
    {
        return $this->storageType;
    }

    /**
     * Set storageVolume
     *
     * @param string $storageVolume
     * @return Products
     */
    public function setStorageVolume($storageVolume)
    {
        $this->storageVolume = $storageVolume;

        return $this;
    }

    /**
     * Get storageVolume
     *
     * @return string 
     */
    public function getStorageVolume()
    {
        return $this->storageVolume;
    }

    /**
     * Set storageNonSolarVolume
     *
     * @param string $storageNonSolarVolume
     * @return Products
     */
    public function setStorageNonSolarVolume($storageNonSolarVolume)
    {
        $this->storageNonSolarVolume = $storageNonSolarVolume;

        return $this;
    }

    /**
     * Get storageNonSolarVolume
     *
     * @return string 
     */
    public function getStorageNonSolarVolume()
    {
        return $this->storageNonSolarVolume;
    }

    /**
     * Set storageWarmthLoss
     *
     * @param integer $storageWarmthLoss
     * @return Products
     */
    public function setStorageWarmthLoss($storageWarmthLoss)
    {
        $this->storageWarmthLoss = $storageWarmthLoss;

        return $this;
    }

    /**
     * Get storageWarmthLoss
     *
     * @return integer 
     */
    public function getStorageWarmthLoss()
    {
        return $this->storageWarmthLoss;
    }

    /**
     * Set combinationHeaterSpaceHeaterGrade
     *
     * @param string $combinationHeaterSpaceHeaterGrade
     * @return Products
     */
    public function setCombinationHeaterSpaceHeaterGrade($combinationHeaterSpaceHeaterGrade)
    {
        $this->combinationHeaterSpaceHeaterGrade = $combinationHeaterSpaceHeaterGrade;

        return $this;
    }

    /**
     * Get combinationHeaterSpaceHeaterGrade
     *
     * @return string 
     */
    public function getCombinationHeaterSpaceHeaterGrade()
    {
        return $this->combinationHeaterSpaceHeaterGrade;
    }

    /**
     * Set combinationHeaterWaterHeaterGrade
     *
     * @param string $combinationHeaterWaterHeaterGrade
     * @return Products
     */
    public function setCombinationHeaterWaterHeaterGrade($combinationHeaterWaterHeaterGrade)
    {
        $this->combinationHeaterWaterHeaterGrade = $combinationHeaterWaterHeaterGrade;

        return $this;
    }

    /**
     * Get combinationHeaterWaterHeaterGrade
     *
     * @return string 
     */
    public function getCombinationHeaterWaterHeaterGrade()
    {
        return $this->combinationHeaterWaterHeaterGrade;
    }

    /**
     * Set combinedEfficiency
     *
     * @param integer $combinedEfficiency
     * @return Products
     */
    public function setCombinedEfficiency($combinedEfficiency)
    {
        $this->combinedEfficiency = $combinedEfficiency;

        return $this;
    }

    /**
     * Get combinedEfficiency
     *
     * @return integer 
     */
    public function getCombinedEfficiency()
    {
        return $this->combinedEfficiency;
    }

    /**
     * Set temperatureControlStandbyWarmthLoss
     *
     * @param string $temperatureControlStandbyWarmthLoss
     * @return Products
     */
    public function setTemperatureControlStandbyWarmthLoss($temperatureControlStandbyWarmthLoss)
    {
        $this->temperatureControlStandbyWarmthLoss = $temperatureControlStandbyWarmthLoss;

        return $this;
    }

    /**
     * Get temperatureControlStandbyWarmthLoss
     *
     * @return string 
     */
    public function getTemperatureControlStandbyWarmthLoss()
    {
        return $this->temperatureControlStandbyWarmthLoss;
    }

    /**
     * Set temperatureControlType
     *
     * @param string $temperatureControlType
     * @return Products
     */
    public function setTemperatureControlType($temperatureControlType)
    {
        $this->temperatureControlType = $temperatureControlType;

        return $this;
    }

    /**
     * Get temperatureControlType
     *
     * @return string 
     */
    public function getTemperatureControlType()
    {
        return $this->temperatureControlType;
    }

    /**
     * Set supplementaryPower
     *
     * @param integer $supplementaryPower
     * @return Products
     */
    public function setSupplementaryPower($supplementaryPower)
    {
        $this->supplementaryPower = $supplementaryPower;

        return $this;
    }

    /**
     * Get supplementaryPower
     *
     * @return integer 
     */
    public function getSupplementaryPower()
    {
        return $this->supplementaryPower;
    }

    /**
     * Set montageId
     *
     * @param integer $montageId
     * @return Products
     */
    public function setMontageId($montageId)
    {
        $this->montageId = $montageId;

        return $this;
    }

    /**
     * Get montageId
     *
     * @return integer 
     */
    public function getMontageId()
    {
        return $this->montageId;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set vendor
     *
     * @param \AppBundle\Entity\Vendors $vendor
     * @return Products
     */
    public function setVendor(\AppBundle\Entity\Vendors $vendor = null)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \AppBundle\Entity\Vendors 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set combinedMainHeaterType
     *
     * @param \AppBundle\Entity\ProductsTypes $combinedMainHeaterType
     * @return Products
     */
    public function setCombinedMainHeaterType(\AppBundle\Entity\ProductsTypes $combinedMainHeaterType = null)
    {
        $this->combinedMainHeaterType = $combinedMainHeaterType;

        return $this;
    }

    /**
     * Get combinedMainHeaterType
     *
     * @return \AppBundle\Entity\ProductsTypes 
     */
    public function getCombinedMainHeaterType()
    {
        return $this->combinedMainHeaterType;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\ProductsTypes $type
     * @return Products
     */
    public function setType(\AppBundle\Entity\ProductsTypes $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\ProductsTypes 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add component
     *
     * @param \AppBundle\Entity\Products $component
     * @return Products
     */
    public function addComponent(\AppBundle\Entity\Products $component)
    {
        $this->component[] = $component;

        return $this;
    }

    //updatedat={$this->updatedat->format('Y-m-d H:i:s')},
    public function __toString(){
    	return "Product:id={$this->id},name={$this->name}</br>,oagName={$this->oagName},
    	productNumber={$this->productNumber},grade=".($this->grade == null? "Not graded" : $this->grade).",
    	
    	shtText1={$this->shtText1},shtText2={$this->shtText2},
    	oagText1={$this->oagText1},oagText2={$this->oagText2},image={$this->image},
    	specification_name={$this->specificationName},label_name={$this->labelName},
    	montageId={$this->montageId},price={$this->price}";
    }
}
