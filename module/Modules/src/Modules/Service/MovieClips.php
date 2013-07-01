<?php
namespace Movie\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MovieClips implements ServiceLocatorAwareInterface
{

	protected $serviceLocator;

	public function __construct()
	{
		// construct
	}

	public function getClips($movieImdbId)
	{
		$imageService = $this->getServiceLocator()->get('viewhelpermanager')->get('image');

		$success = false;
		$result = array();
		$cache = $this->getServiceLocator()->get('cache');
		$key    = 'movieclips-' . $movieImdbId;

		$meta = $cache->getMetadata($key);
		//var_dump(file_get_contents($meta['filespec'].".dat"));
		
		$result = $cache->getItem($key, $success);

		if (!$success) {
			// TODO CACHE THIS !
			$ch = curl_init("http://api.movieclips.com/v2/movies/".$movieImdbId."/videos?id_type=movie-imdb-id");
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$xml_raw = curl_exec($ch);
			if($xml_raw) {
				libxml_use_internal_errors(true);
				try {
					$movieclips = simplexml_load_string($xml_raw);

					$moviaticClips = array();

					/*
					 * Loop through simplexml data and resave as array of objects
					*/
					if(sizeof($movieclips) && isset($movieclips->entry)){
						foreach($movieclips->entry as $clip){
							$my_clip = array();
							$my_clip['title'] = (string)$clip->title;
							$mediaGroup = $clip->children('http://search.yahoo.com/mrss/');
							$attr = $mediaGroup->group->player->attributes();
							$my_clip['url'] = (string)$attr['url'];

							$my_clip['restriction'] = (string)$mediaGroup->group->restriction;
							//var_dump((string)$mediaGroup->group->restriction);exit();

							$attr = $mediaGroup->group->thumbnail[1]->attributes();

							$filepath = $imageService->getPath(str_replace('_', '', $this->GetFilename($attr['url'])));

							if(!file_exists($filepath)){
								$curl = curl_init($attr['url']);
								curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
								$result = curl_exec($curl);
								curl_close($curl);

								if (!is_dir(dirname($filepath))) {
									mkdir(dirname($filepath), 0777, true);
								}

								file_put_contents($filepath, $result);
							}

							$my_clip['thumbnail'] = str_replace('_', '', $this->GetFilename($attr['url']));

							$attr = $mediaGroup->group->content->attributes();
							$dur = $attr['duration'];
							$my_clip['duration'] = (string)$dur;
							$moviaticClips[] = $my_clip;
						}
					}

					//$result['movieclips'] = $moviaticClips;
					//print_r($moviaticClips);exit();
				} catch (\Exception $e) {

				}

			} else {
				$moviaticClips =  false;
			}
			// bloody hell
			//error_reporting(E_ALL ^ E_NOTICE);
			$result['movieclips'] = $moviaticClips;
			$cache->setItem($key, $result);

			//return $this->getClips($movieImdbId);
		}
		//print_r($result);
		//exit();
		//print_r($result);


		// TOHLE ZDRŽUJE

		/*
		if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$url = "http://api.hostip.info/country.php?ip=".$ip;

		// fetch with curl
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$country = curl_exec($ch);

		curl_close ($ch);

		//var_dump($country);

		if(is_array($result['movieclips'])) foreach($result['movieclips'] as $key => $item){
			if(isset($item['restriction']) && strpos($item['restriction'], strtolower($country)))
				unset($result['movieclips'][$key]);
		}
		*/

		//print_r($result);exit();

		// TMDB clips
		/*
		if($this->trailers){
			if(isset($this->trailers['tmdb'])){
				// remove wrong video links
				foreach($this->trailers['tmdb']['youtube'] as $key => $trailer){
					$ch = curl_init("http://gdata.youtube.com/feeds/api/videos/".$trailer['source']);
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$xml_raw = curl_exec($ch);
					if($xml_raw=='Video not found' || $xml_raw=='Invalid id' || $xml_raw=='Private video'){
						unset($this->trailers['tmdb']['youtube'][$key]);
					}
				}
				$result['tmdb'] = $this->trailers['tmdb'];
			}
			if(isset($this->trailers['trailer_addict']))
				$result['trailer_addict'] = $this->trailers['trailer_addict'];
		}*/

		return $result;

		//return $movieImdbId;
	}

	public function GetFilename($file) {
		$filename = substr($file, strrpos($file,'/')+1,strlen($file)-strrpos($file,'/'));
		$filename = str_replace('.jpg', '', $filename);
		return $filename;
	}

	/**
	 * Interface methods
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}

	public function getServiceLocator() {
		return $this->serviceLocator;
	}

}