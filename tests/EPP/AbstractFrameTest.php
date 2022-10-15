<?php

namespace AfriCC\Tests\EPP;

use AfriCC\EPP\AbstractFrame;
use AfriCC\EPP\Frame\ResponseFactory;
use AfriCC\EPP\ObjectSpec;
use PHPUnit\Framework\TestCase;

class AbstractFrameTest extends TestCase
{
    public function testImport()
    {
        $raw_data = <<< 'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
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
EOF;
        $import = ResponseFactory::build($raw_data);
        $stub = $this->getMockForAbstractClass(AbstractFrame::class, [$import]);

        $this->assertXmlStringEqualsXmlString((string) $import, (string) $stub);
    }

    public function testImportSpec()
    {
        $raw_data = <<< 'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
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
EOF;
        $objectSpec = new ObjectSpec();
        $objectSpec->specs['epp']['xmlns'] = 'http://www.dns.pl/nask-epp-schema/epp-2.0';

        $import = ResponseFactory::build($raw_data, $objectSpec);
        $stub = $this->getMockForAbstractClass(AbstractFrame::class, [$import, $objectSpec]);

        $this->assertXmlStringEqualsXmlString((string) $import, (string) $stub);
    }

    public function testExtensionName()
    {
        $stub = $this->getMockForAbstractClass(AbstractFrame::class, [], 'MockFrame');

        $this->assertEquals('mockframe', $stub->getExtensionName());
    }

    public function testGetFalseOnEmpty()
    {
        $stub = $this->getMockForAbstractClass(AbstractFrame::class);

        $return = $stub->get('//epp:epp/epp:response/epp:result');

        $this->assertFalse($return);
    }

    public function testGetCodeOnSuccess()
    {
        $raw_data = <<< 'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="1000">
      <msg lang="en">Command completed successfully</msg>
    </result>
  </response>
</epp>
EOF;
        $import = ResponseFactory::build($raw_data);
        $stub = $this->getMockForAbstractClass(AbstractFrame::class, [$import]);

        $return = $stub->get('//epp:epp/epp:response/epp:result/@code');

        $this->assertEquals(1000, $return);
    }

    public function testGetMessageOnSuccess()
    {
        $raw_data = <<< 'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="1000">
      <msg lang="en">Command completed successfully</msg>
    </result>
  </response>
</epp>
EOF;
        $import = ResponseFactory::build($raw_data);
        $stub = $this->getMockForAbstractClass(AbstractFrame::class, [$import]);

        $return = $stub->get('//epp:epp/epp:response/epp:result/epp:msg/text()');

        $this->assertEquals('Command completed successfully', $return);
    }

    public function testGetDomNodeListOnSuccess()
    {
        $raw_data = <<< 'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="1000">
      <msg lang="en">Command completed successfully</msg>
    </result>
  </response>
</epp>
EOF;
        $import = ResponseFactory::build($raw_data);
        $stub = $this->getMockForAbstractClass(AbstractFrame::class, [$import]);

        $return = $stub->get('//epp:epp/epp:response/epp:result/epp:msg');

        $this->AssertInstanceOf(\DOMNodeList::class, $return);
    }

    /**
     * @requires PHP 5.6
     */
    public function testNonExistingXmlns()
    {
        $stub = $this->getMockForAbstractClass(AbstractFrame::class);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('unknown namespace: notepp');

        $return = $stub->set('//epp:epp/notepp:response/');
    }
}
