<?php

namespace AfriCC\Tests\EPP\Frame;

use AfriCC\EPP\Frame\Response;
use AfriCC\EPP\Frame\ResponseFactory;
use AfriCC\EPP\Frame\Response\MessageQueue;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testLegacyResponseWithoutValueOrResData()
    {
        $response = ResponseFactory::build(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
             <response>
               <result code="1000">
                 <msg lang="en">Command completed successfully</msg>
               </result>
               <trID>
                 <clTRID>ABC-12345</clTRID>
                 <svTRID>54321-XYZ</svTRID>
               </trID>
             </response>
            </epp>
            '
        );

        $this->assertTrue($response->success());
        $this->assertEquals(1000, $response->code());
        $this->assertEquals('Command completed successfully', $response->message());
        $this->assertEquals('ABC-12345', $response->clientTransactionId());
        $this->assertEquals('54321-XYZ', $response->serverTransactionId());
        $this->assertEquals([], $response->data());
    }

    public function testLegacyMsgQ()
    {
        $response = ResponseFactory::build(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
             <response>
               <result code="1000">
                 <msg>Command completed successfully</msg>
               </result>
               <msgQ count="5" id="12345">
                 <qDate>2000-06-08T22:00:00.0Z</qDate>
                 <msg>Transfer requested.</msg>
               </msgQ>
               <trID>
                 <clTRID>ABC-12345</clTRID>
                 <svTRID>54321-XYZ</svTRID>
               </trID>
             </response>
            </epp>
            '
        );

        $this->assertInstanceOf(MessageQueue::class, $response);
        $this->assertEquals(1000, $response->code());
        $this->assertEquals('12345', $response->queueId());
        $this->assertEquals(5, $response->queueCount());
        $this->assertEquals('2000-06-08 22:00:00', $response->queueDate('Y-m-d H:i:s'));
        $this->assertEquals('Transfer requested.', $response->queueMessage());
    }

    public function testResponse()
    {
        $response = ResponseFactory::build(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                <response>
                    <result code="2303">
                        <msg lang="fr">Object does not exist</msg>
                        <value xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                            <domain:hostObj>ns21.yoann.mx</domain:hostObj>
                        </value>
                    </result>
                    <result code="2306">
                        <msg lang="en">Parameter value policy error</msg>
                        <extValue>
                            <value xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                                <domain:hostObj>ns2.yoann.mx</domain:hostObj>
                            </value>
                            <reason lang="en">A host that wants to be added is repeated</reason>
                        </extValue>
                    </result>
                    <trID>
                        <clTRID>rar_infos-554c07c8a541b</clTRID>
                        <svTRID>1163276970</svTRID>
                    </trID>
                </response>
            </epp>
            '
        );

        $results = $response->results();

        //var_dump($results[0]->values());

        $this->assertFalse($results[0]->success());

        $this->assertEquals(2303, $results[0]->code());
        $this->assertEquals(2306, $results[1]->code());

        $this->assertEquals('fr', $results[0]->messageLanguage());
        $this->assertEquals('en', $results[1]->messageLanguage());

        $this->assertEquals('Object does not exist', $results[0]->message());
        $this->assertEquals('Parameter value policy error', $results[1]->message());
    }
}
