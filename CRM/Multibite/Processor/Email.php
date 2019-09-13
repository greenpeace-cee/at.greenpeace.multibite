<?php

class CRM_Multibite_Processor_Email extends CRM_Multibite_Processor_AbstractProcessor {

  /**
   * Replace unsupported multi-byte characters in all text parts of $mail
   *
   * @todo add test coverage
   *
   * @param ezcMail $mail
   *
   * @throws \Exception
   */
  public static function process(&$mail) {
    if (!$mail instanceof ezcMail) {
      throw new Exception('Parameter $mail should be an instance of ezcMail');
    }

    foreach ($mail->fetchParts() as $part) {
      if ($part instanceof ezcMailText) {
        $part->text = CRM_Multibite_Processor_AbstractProcessor::replace($part->text);
      }
    }
  }

}
