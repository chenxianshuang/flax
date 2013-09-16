<?php
namespace Icecave\Flax\Wire;

use DateTime as NativeDateTime;
use Icecave\Chrono\DateTime;
use Icecave\Collections\Map;
use PHPUnit_Framework_TestCase;
use stdClass;

class UtilityTest extends PHPUnit_Framework_TestCase
{
    public function testIsBigEndian()
    {
        // This test is a bit redundant, but at least it guards against future impl changes.
        $expected = pack('S', 0x1020) === pack('n', 0x1020);

        $this->assertSame($expected, Utility::isBigEndian());
        $this->assertSame($expected, Utility::isBigEndian());
    }

    public function testConvertEndianess()
    {
        $result = Utility::convertEndianness("ABCD");

        if (Utility::isBigEndian()) {
            $this->assertSame("ABCD", $result);
        } else {
            $this->assertSame("DCBA", $result);
        }
    }

    public function testPackInt64()
    {
        if (PHP_INT_SIZE < 8) {
            $this->maskTestSkipped('Can not use 64-bit integers on this platform.');
        }

        $this->assertSame("ABCDEFGH", Utility::packInt64(0x4142434445464748));
    }

    public function testUnpackInt64()
    {
        if (PHP_INT_SIZE < 8) {
            $this->maskTestSkipped('Can not use 64-bit integers on this platform.');
        }

        $this->assertSame(0x4142434445464748, Utility::unpackInt64("ABCDEFGH"));
    }
}
