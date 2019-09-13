<?php

/**
 * Class CRM_Multibite_Listener
 *
 * Listen for Civi events that need replacement of unsupported multi-byte chars
 */
class CRM_Multibite_Listener {

  /**
   * Process certain pre events
   *
   * @param \Civi\Core\Event\PreEvent $event
   */
  public static function pre(\Civi\Core\Event\PreEvent $event) {
    if ($event->action == 'create' && $event->entity == 'Activity') {
      CRM_Multibite_Processor_Activity::process($event->params);
    }
  }

  /**
   * Process email events
   *
   * @param \Civi\Core\Event\GenericHookEvent $event
   *
   * @throws \Exception
   */
  public static function emailProcessor(\Civi\Core\Event\GenericHookEvent $event) {
    CRM_Multibite_Processor_Email::process($event->mail);
  }

}
