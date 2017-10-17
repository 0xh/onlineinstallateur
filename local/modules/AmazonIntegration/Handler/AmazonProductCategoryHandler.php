<?php
namespace AmazonIntegration\Handler;

use AmazonIntegration\AmazonIntegration;
use AmazonIntegration\Model\AmazonProductCategoryQuery;


class AmazonProductCategoryHandler
{
	
	public function getProductCategories($categoryId)
	{
	
		$amazonProductCategories = AmazonProductCategoryQuery::create()->find();
		$hierarchy = '';
		$categoryHierarchy = '';
		
		foreach($amazonProductCategories as $i => $category) {
			$categories[$i]['category_id'] =  $category->getCategoryId();
			$categories[$i]['parent_id'] =  $category->getParentId();
			$categories[$i]['name'] =  $category->getName();
			
			if($categoryId == $category->getCategoryId())  {
				$hierarchy = $category->getName();
				$parentId =  $category->getParentId();
			}
		}
		
		if($categoryId !== 'home_improvement_display_on_website') 
			$categoryHierarchy = $this->getParent($parentId, $categories, $hierarchy);
		
		return $categoryHierarchy;
	}
	
	public function getParent($parentId, $categories, $hierarchy) 
	{
		if($parentId == 0) 
			return $hierarchy;
		else 
			foreach($categories as $category) {
				
				 if($category['category_id'] == $parentId) {
				 	
				 	$hierarchy = $hierarchy.'/'.$category['name'];
				 	return $this->getParent($category['parent_id'], $categories, $hierarchy);
				} 
			}
	}

}
