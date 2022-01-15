<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_ extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}

	public function ws_random_jokes($count)
	{
		$list = $this->get_random_jokes($count);

		echo json_encode($list);


	}

	public function print_random_jokes($count)
	{

		$list = $this->get_random_jokes($count);

		$data["list"] = $list;

		$this->load->view('chuck_list',$data);
	}

	public function get_random_jokes($count)
	{

		$list = $this->multiple_2d_try($count);
		if (count($list)< $count) {
			while (count($list) < $count) {
				// code...
				$list_to_complete =  $this->multiple_2d_try($list - $count);
				$list = array_merge($list_to_complete,$list);
			}
		}
		return $list;
	}


	public function multiple(){

		$config = [];

		for ($i=0; $i < 15 ; $i++) {
			// Crea dos recursos cURL
			$config["ch".$i] = curl_init();

			curl_setopt($config["ch".$i], CURLOPT_URL, "https://api.chucknorris.io/jokes/random");
			curl_setopt($config["ch".$i], CURLOPT_HEADER, 0);
		}
		$mh = curl_multi_init();
		for ($i=0; $i < 15 ; $i++) {
			// Añade los dos recursos
			curl_multi_add_handle($mh,$config["ch".$i]);
		}


		$active=null;
		// Ejecuta los recursos
		do {

			$mrc = curl_multi_exec($mh, $active);

		} while ($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active && $mrc == CURLM_OK) {
			if (curl_multi_select($mh) != -1) {
				do {

					$mrc = curl_multi_exec($mh, $active);
					// $mrc = curl_multi_getcontent($active);

					// $return = json_decode($mrc, false);

				} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		for ($i=0; $i < 15 ; $i++) {
			// Crea dos recursos cURL
			curl_multi_remove_handle($mh, $config["ch".$i]);
		}
		curl_multi_close($mh);

	}

	public function multiple_2d_try($nodes){

		$config = [];
		$url = "https://api.chucknorris.io/jokes/random";
		$node_count = $nodes;


		$curl_arr = array();
		$master = curl_multi_init();

		$curl_arr[0] = curl_init($url);
		$this->set_option($curl_arr[0], $url);
		curl_multi_add_handle($master, $curl_arr[0]);


		$i = 1;
		do {
			if ($i!==0){

				$curl_arr[$i] = curl_init($url);
				$this->set_option($curl_arr[$i], $url);
				curl_multi_add_handle($master, $curl_arr[$i]);
			}
			$i++;
		}while($i < $node_count);

		$running = NULL;
		do {
			curl_multi_exec($master,$running);
		} while($running);

		$results = array();
		$q = 0;
		do{
			 $response = curl_multi_getcontent($curl_arr[$q]);
			$response = json_decode($response,true);
			$results[$response["id"]] = $response;
			curl_multi_remove_handle($master, $curl_arr[$q]);
			$q++;
		}while($q < $node_count);

		return $results;
	}


	function set_option($x, $y){
		curl_setopt($x, CURLOPT_URL,  $y);
		curl_setopt($x, CURLOPT_HEADER, 0);
		curl_setopt($x, CURLOPT_RETURNTRANSFER, TRUE);
	}

}
