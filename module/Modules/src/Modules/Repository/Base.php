<?php
namespace Modules\Repository;

use Doctrine\ORM\EntityRepository;

class Base extends EntityRepository
{

	function findModuleItems($orderColumn = null, $orderDirection = null)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from($this->getEntityName(), 'u');

		$qb->andWhere('u.parent_entity IS NULL');

		if(!$orderColumn){
			$qb->orderBy('u.id', 'DESC');
		} else {
			$qb->orderBy('u.'.$orderColumn, $orderDirection);
		}

		return $qb->getQuery();
	}

}