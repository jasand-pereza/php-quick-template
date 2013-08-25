<?php

Class QuickTemplate {
  public static $patterns;
  
  
  /**
   * Uses output buffer in callback function to return a string of new values
   * @param array $data 
   * @param function $callback    
   * @param bool $return_content (returned by reference)      
   * @return string 
   */
  public static function create($data, $callback, &$return_content=false) {
    ob_start(function($buffer) use ($data, &$return_content) {
      $self = __CLASS__;
      $updated = $self::template_iterator($data, $buffer);
      if(is_null($return_content)) {
        $return_content = $updated;
      } else {
        return $updated;
      }
    });
    $callback();
    ob_end_flush();
  }


  /**
   * Iterate over array and replace placeholders with values
   * @param array $data 
   * @param string $buffer    
   * @return string 
   */
  public static function template_iterator($data, $buffer) {
    $tinc = 0; $inc = 0;

    /* [REPLACE] - anonymous that replaces keys from an array */
    $replace_parts = function($k, $v, $buffer, $tinc) {
      $patterns = array("/\%$k\%/","/\%key\%/","/\%value\%/","/\%item\%/","/\%inc\%/");
      $replacements = array($v, $k, $v, $v, 'tinc-' . $tinc);
      $replaced = preg_replace($patterns, $replacements, $buffer);
      return $replaced;
    };
    
    /* [2] - anonymous function that replaces keys of a multidimensional array */
    $sub_iterate = function($array, $buffer, $tinc) {
      $parts = array();
      foreach($array as $k => $v) {
        $patterns = array("/\%$k\%/","/\%key\%/","/\%value\%/","/\%inc\%/");
        $replacements = array($v, $k, $v, 'tinc-' . $tinc);
        $parts[current($array)] = preg_replace(
          $patterns, 
          $replacements, 
          ($inc > 0) 
          ? $parts[current($array)] 
          : $buffer
        );
        $inc++;
      };
      return implode('', $parts);
    };
    
    /* [1] - iterates over array, checks array depth, and calls the appropriate function */
    $templates = array();
    foreach($data as $key => $value) {
      $templates[$key] = (!is_array($data[$key])) 
        ? $replace_parts($key, $value, $buffer, $tinc)
        : $sub_iterate($data[$key], $buffer, $tinc);
      $tinc++;
    }
    
    /* finally - flatten templates and return html as a string 
    but remove any stragglers from the buffer that don't get defined in the data array */
    if(count($templates) > 0) $buffer = implode('', $templates);
    return(preg_replace("/\%(.*)\%/", '', $buffer));
  }
}