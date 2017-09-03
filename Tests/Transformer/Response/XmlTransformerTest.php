<?php

namespace KaneMenicou\FastControllerBundle\Tests\Transformer\Response;

use KaneMenicou\FastControllerBundle\Transformer\Response\XmlTransformer;

class XmlTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider arraysAndExpectedXml
     *
     * @param array $array
     * @param string $expectedXml
     */
    public function itWillCorrectTransformAnArrayIntoXml($array, $expectedXml)
    {
        $this->markTestIncomplete();
        $xml = new XmlTransformer;

        $this->assertSame($expectedXml, $xml->transform($array));
    }

    /**
     * @test
     * @dataProvider arraysAndExpectedXml
     *
     * @param array $array
     * @param string $expectedXml
     */
    public function itWillCorrectTransformXmlIntoAnArray($array, $expectedXml)
    {
        $this->markTestIncomplete();
        $xml = new XmlTransformer;

        $this->assertSame($expectedXml, $xml->transform($array));
    }

    /**
     * @return array
     */
    public function arraysAndExpectedXml()
    {
        return [
            'Single dimension array' => [
                'array' => [
                    'message' => 'single dimension'
                ],
                'expectedXml' => <<<'TAG'
<?xml version="1.0"?>
<root><message>single dimension</message></root>
TAG

            ],
            'Multi dimension array' => [
                'array' => [
                    'message' => 'multi dimension',
                    'Others' => [
                        'hi' => 'hi'
                    ]
                ],
                'expectedXml' => '<?xml version="1.0"?><root><message>multi dimension</message><other><hi>hi</hi></other></root>'
            ]
        ];
    }
}
