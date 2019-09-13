<?php

use Civi\Test\Api3TestTrait;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * Test multi-byte replacement processors
 *
 * @group headless
 */
class CRM_Multibite_ProcessorTest extends \PHPUnit\Framework\TestCase implements HeadlessInterface, HookInterface, TransactionalInterface {
  use Api3TestTrait;

  const FIXTURE_PATH = __DIR__ . '/../../../fixtures';

  public function setUpHeadless() {
    return \Civi\Test::headless()
      ->installMe(__DIR__)
      ->apply();
  }

  public function setUp() {
    parent::setUp();
    $domain = $this->callAPISuccess('Domain', 'getvalue', [
      'return'  => 'id',
      'options' => ['limit' => 1],
    ]);
    CRM_Utils_File::cleanDir(self::FIXTURE_PATH . '/maildir');
    mkdir(self::FIXTURE_PATH . '/maildir');
    $this->callAPISuccess('MailSettings', 'create', [
      'name'            => 'local',
      'protocol'        => 'Localdir',
      'source'          => self::FIXTURE_PATH . '/maildir',
      'domain_id'       => $domain,
      'activity_status' => 'Completed',
    ]);

  }

  public function tearDown() {
    CRM_Utils_File::cleanDir(self::FIXTURE_PATH . '/maildir');
    parent::tearDown();
  }

  /**
   * Test that inbound emails are processed correctly
   */
  public function testInboundEmailReplacement() {
    copy(self::FIXTURE_PATH . '/maildir_template/sample.txt', self::FIXTURE_PATH . '/maildir/sample.txt');
    $this->callAPISuccess('job', 'fetch_activities');
    $activity = $this->callAPISuccess('Activity', 'get', [
      'subject' => 'Sample message with � unsupported multi-byte character',
    ]);
    $this->assertEquals(
      1,
      $activity['count'],
      'Should create activity for inbound email'
    );
    $activity = reset($activity['values']);
    $this->assertContains(
      'Message body with � unsupported multi-byte character',
      $activity['details'],
      'Activity should have details with message body and replacement character'
    );
  }

}
