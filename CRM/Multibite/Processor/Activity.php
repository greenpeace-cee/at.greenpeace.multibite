<?php

class CRM_Multibite_Processor_Activity extends CRM_Multibite_Processor_AbstractProcessor {

  /**
   * Parameters for which unsupported multi-byte character should be replaced
   */
  const PARAMS = ['subject', 'details'];

  public static function process(&$params) {
    return self::replaceKeys($params, self::PARAMS);
  }

}
