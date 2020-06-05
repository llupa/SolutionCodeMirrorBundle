<?php

declare(strict_types=1);

namespace Solution\CodeMirrorBundle\Tests;

use Solution\CodeMirrorBundle\Asset\AssetManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AssertTest extends WebTestCase
{
    /**
     * @var AssetManager
     */
    protected $asset;

    protected function setUp(): void
    {
        self::bootKernel(['APP_ENV' => 'test', 'APP_DEBUG' => true]);
        $this->asset = self::$container->get('code_mirror.asset_manager');
    }

    /**
     * Test themes
     */
    public function testGetThemes(): void
    {
        $this->assertEquals(
            array(
                'twilight' => __DIR__ . '/App/dummy_js/twilight.css',
            ),
            $this->asset->getThemes()
        );
    }

    /**
     * Test modes
     */
    public function testGetModes(): void
    {
        $this->assertEquals(
            array(
                'text/css' => __DIR__ . '/App/dummy_js/css.js',
                'application/x-httpd-php' => __DIR__ . '/App/dummy_js/php.js',
                'application/x-httpd-php-open' => __DIR__ . '/App/dummy_js/php.js',
                'text/x-php' => __DIR__ . '/App/dummy_js/php.js',
            ),
            $this->asset->getModes()
        );
    }

    /**
     * Test instance
     */
    public function testMustBeInstance(): void
    {
        $this->assertInstanceOf('Solution\CodeMirrorBundle\Asset\AssetManager', $this->asset);
    }

    /**
     * Test add mode
     */
    public function testAddMode(): void
    {
        $mode = array('text/html', '@SolutionCodeMirrorBundle/Resource/public/js/mode/php.js');
        $this->asset->addMode($mode[0], $mode[1]);

        $this->assertEquals($mode[1], $this->asset->getMode($mode[0]));
    }

    /**
     * Test add mode
     */
    public function testTheme(): void
    {
        $mode = array('twilight', '@SolutionCodeMirrorBundle/Resource/public/css/theme/twilight.css');
        $this->asset->addTheme($mode[0], $mode[1]);

        $this->assertEquals($mode[1], $this->asset->getTheme($mode[0]));
    }
}
