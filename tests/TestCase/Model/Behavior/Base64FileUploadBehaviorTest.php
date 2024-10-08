<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\Base64FileUploadBehavior;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\FileUploadBehavior Test Case
 */
class Base64FileUploadBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\Base64FileUploadBehavior
     */
    protected $Base64FileUpload;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $table = new Table();
        $this->Base64FileUpload = new Base64FileUploadBehavior($table);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Base64FileUpload);

        parent::tearDown();
    }
}
