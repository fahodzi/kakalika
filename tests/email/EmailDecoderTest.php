<?php

use kakalika\lib\EmailDecoder;

require_once "kakalika/lib/EmailDecoder.php";

class EmailDecoderTest extends \PHPUnit_Framework_TestCase
{
    public function testStripQuotedMessage()
    {
        $this->assertEquals(
            "Okay\n",
            EmailDecoder::stripQuotedMessages(file_get_contents("tests/fixtures/email1.txt"))
        );
        $this->assertEquals(
            "Okay\n",
            EmailDecoder::stripQuotedMessages(file_get_contents("tests/fixtures/email2.txt"))
        );
    }
}
