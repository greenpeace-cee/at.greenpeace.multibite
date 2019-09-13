<?php

abstract class CRM_Multibite_Processor_AbstractProcessor {

  /**
   * Regex to match unsupported multi-byte characters
   */
  const UNSUPPORTED_MULTIBYTE_REGEX = '/[\x{10000}-\x{10FFFF}]/u';

  /**
   * Replacement symbol for
   */
  const REPLACEMENT_CHARACTER = "\xEF\xBF\xBD";

  abstract public static function process(&$params);

  public static function replaceKeys(&$params, $keys) {
    foreach ($keys as $key) {
      if (!empty($params[$key])) {
        $params[$key] = self::replace($params[$key]);
      }
    }
  }

  public static function replace($value) {
    return preg_replace(
      self::UNSUPPORTED_MULTIBYTE_REGEX,
      Civi::settings()->get('multibite_replacement_character'),
      $value
    );
  }

}
