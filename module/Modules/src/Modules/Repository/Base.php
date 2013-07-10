<?php
namespace Modules\Repository;

use Doctrine\ORM\EntityRepository;

class Base extends EntityRepository
{

	function findModuleItems()
	{
		$qb = $this->_em->createQueryBuilder();
		
		$qb->select('u')
		->from($this->getEntityName(), 'u');
		
		$qb->andWhere('u.parent_entity IS NULL');
		
		return $qb->getQuery();
	}

}