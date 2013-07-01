<?php
namespace Movie\Repository;

use Doctrine\ORM\EntityRepository;

class Movie extends EntityRepository
{

	/**
	 * Find movie by freebase Mid without '/m/'
	 * @param string $mid
	 * @return Ambigous <\Movie\Entity\Movie, NULL, unknown>
	 */
	function getByShortenMid($mid)
	{
		return $this->find('/m/'.$mid);
	}

	/**
	 * Find movies by freebase Mids
	 * @param array $mid
	 * @param string $order_col
	 * @param string $order_dir
	 * @return Ambigous <\Movie\Entity\Movie, NULL, unknown>
	 */
	function getByMids($mids, $order_col = null, $order_dir = null)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->andWhere('u.freebase_mid IN (:ids)')
			->setParameter('ids', $mids);

		if($order_col){
			$qb->addOrderBy('u.'.$order_col, $order_dir);
		}

		return $qb->getQuery()->getResult();
	}

	/**
	 * Find movie by IMDB ID
	 * @param string $id
	 * @return Ambigous <\Movie\Entity\Movie, NULL, unknown>
	 */
	function getByImdbId($id)
	{
		return $this->findBy(array('imdb_id' => $id));
	}
	
	/**
	 * Find movie by TMDB ID
	 * @param string $id
	 * @return Ambigous <\Movie\Entity\Movie, NULL, unknown>
	 */
	function getByTmdbId($id)
	{
		return $this->findBy(array('id_tmdb' => $id));
	}

	/**
	 * Find movie by title and year
	 * @param string $title
	 * @param string $year
	 * @return Ambigous <\Movie\Entity\Movie, NULL, unknown>
	 */
	function getByTitleAndYear($title, $year)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->andWhere("u.title = :title AND u.release_date LIKE :year")
		->setParameter('title', $title)
		->setParameter('year', $year.'%');

		return $qb->getQuery()->getResult();
	}

	/**
	 * Search movie
	 * @param string $query
	 */
	function search($query)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->andWhere("u.title LIKE :query2 OR u.alias LIKE :query2")
		->setParameter('query2', '%'.$query.'%');

		return $qb->getQuery()->getResult();
	}

	/**
	 * Suggest movie
	 * @param string $query
	 */
	function suggest($query)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->andWhere("u.title LIKE :query2 OR u.alias LIKE :query2")
		->setParameter('query2', $query.'%')
		->setMaxResults(5);

		return $qb->getQuery()->getResult();
	}

	/**
	 * Get best movies of cast
	 * @param string $cast_id
	 */
	function getBestMoviesOfCast($cast_id)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->andWhere("u.directed_by LIKE :cast_id OR u.starring LIKE :cast_id OR u.story_by LIKE :cast_id OR u.written_by LIKE :cast_id OR u.music_by LIKE :cast_id")
			->setParameter('cast_id', '%'.$cast_id.'%');

		$qb->addOrderBy('u.moviatic_rating', 'DESC');

		return $qb->getQuery()->getResult();
	}

	/**
	 * Find movies by genre
	 * @param string $genreId
	 */
	function findByGenre($genreId)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->andWhere("u.genre LIKE :genre_id")
		->setParameter('genre_id', '%'.$genreId.'%');

		$qb->addOrderBy('u.moviatic_rating', 'DESC');

		return $qb->getQuery();
	}

	/**
	 * Fetch movies by country
	 * @param string $genreId
	 */
	function fetchByGenre($genreId)
	{
		return $this->findByGenre($genreId)->getResult();
	}

	/**
	 * Find movies by country
	 * @param string $genreId
	 */
	function findByCountry($countryId)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->andWhere("u.country LIKE :country_id")
		->setParameter('country_id', '%'.$countryId.'%');

		$qb->addOrderBy('u.moviatic_rating', 'DESC');

		return $qb->getQuery();
	}

	/**
	 * Get best rated movies
	 * @param string $cast_id
	 */
	function findBestRated($offset = null, $limit = null)
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->addOrderBy('u.moviatic_rating', 'DESC');

		if($offset)
			$qb->setFirstResult($offset);

		if(!$limit)
			$qb->setMaxResults(1000);
		else
			$qb->setMaxResults($limit);

		return $qb->getQuery();
	}

	/**
	 * Fetch best rated movies
	 * @param string $cast_id
	 */
	function fetchBestRated($page)
	{
		return $this->findBestRated()->getResult(($page-1)*30, 30);
	}

	/**
	 * Get worst rated movies
	 * @param string $cast_id
	 */
	function findWorstRated()
	{
		$qb = $this->_em->createQueryBuilder();

		$qb->select('u')
		->from('\Movie\Entity\Movie', 'u');

		$qb->addOrderBy('u.moviatic_rating', 'ASC');
		$qb->setMaxResults(1000);

		return $qb->getQuery();
	}

	/**
	 * Fetch movies by country
	 * @param string $genreId
	 */
	function fetchByCountry($countryId)
	{
		return $this->findByCountry($countryId)->getResult();
	}

}