<?php

namespace Service;

class ServiceContainer {
  private static $instance = null;

    private array $container;
  
  private function __construct(){
      $this->container = [
          "Parser" => new Parser(),
          "EvaluationService" => new EvaluationService(),
          "DynamicQuizService" => new DynamicQuizService()
          ];
  }
 
  public static function getInstance(){
    if (self::$instance == null){
      self::$instance = new ServiceContainer();
    }
 
    return self::$instance;
  }
  
  public function get($service_id) {
      return $this->container[$service_id] ?? null;
  }
}
