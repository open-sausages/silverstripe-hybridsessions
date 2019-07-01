<?php

namespace SilverStripe\HybridSessions\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\HybridSessions\Crypto\McryptCrypto;

/**
 * @requires extension mcrypt
 */
class McryptCryptoTest extends SapphireTest
{
    public function testIntegrity()
    {
        $error_reporting = ini_set('error_reporting', (int) ini_get('error_reporting') & ~E_DEPRECATED);

        try {
            $key = random_bytes(8);
            $salt = random_bytes(16);

            $handler = new McryptCrypto($key, $salt);

            for ($i = 0; $i < 1000; ++$i) {
                $data = random_bytes(1024 * 4);

                $this->assertEquals($data, $handler->decrypt($handler->encrypt($data)));
            }
        } finally {
            ini_set('error_reporting', $error_reporting);
        }
    }
}
