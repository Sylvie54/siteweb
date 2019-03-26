<?php

namespace App\Entity;

use Symfony\component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


class PropertySearch {

/**
 * @var int|null
 */    
private $maxPrice;

/**
 * @var int|null
 * @Assert\Range(min=10, max=400)
 */    
private $minSurface;

/**
 * @var ArrayCollection
 */
private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
      
    }


/**
 *  @return int|null
 */
public function getMaxPrice(): ?int 
{
    return $this->maxPrice;
}

/**
 * @param int|null
 * @return PropertySearch
 */
public function setMaxPrice(int $maxPrice): PropertySearch
{
    $this->maxPrice = $maxPrice;
    return $this;
}

/**
 *  @return int|null
 */
public function getMinSurface(): ?int 
{
    return $this->minSurface;
}

/**
 * @param int|null
 * @return PropertySearch
 */
public function setMinSurface(int $minSurface): PropertySearch
{
    $this->minSurface = $minSurface;
    return $this;
}
/**
 * @return ArrayCollection
 */
public function getOptions(): ArrayCollection
{
    return $this->options;
}
/**
 * @param ArrayCollection $options
 */
public function setOptions(ArrayCollection $options):void
{
    $this->options = $options;
}

}