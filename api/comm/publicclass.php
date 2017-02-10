<?php
class memcaches{
	function __construct($port){
		$this->memcache=new Memcache();
		$this->memcache->connect("localhost",$port);
	}
	function set($key,$value){
		$result=$this->memcache->get("/");
		$result[$key]=$value;
		$this->memcache->set("/",$result);
	}
	function get($key){
		$result=$this->memcache->get("/");
		return $result[$key];
	}
	function getall(){
		$result=$this->memcache->get("/");
		return $result;
	}
	function delete($key){
		$result=$this->memcache->get("/");
		unset($result[$key]);
		$this->memcache->set("/",$result);
	}
	function flush(){
		$this->memcache->flush();
	}
	function __destruct(){
		$this->memcache->close();
	}
}
