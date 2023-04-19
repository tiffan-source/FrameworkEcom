<?php
namespace Tests\Framework;

use Framework\Upload;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UploadedFileInterface;

class UploadTest extends TestCase{
    private $upload;
    
    public function setUp():void
    {
        $this->upload = new Upload('tests');
    }

    public function testUpload()
    {
        $uploadFile = $this->getMockBuilder(UploadedFileInterface::class)->getMock();

        $uploadFile
        ->expects($this->any())
        ->method('getClientFileName')
        -> willReturn('demo.jpg');

        $uploadFile
        ->expects($this->once())
        ->method('moveTo')
        ->with($this->equalTo('tests/demo.jpg'));

        $result = $this->upload->upload($uploadFile);

        $this->assertEquals('demo.jpg', $result);
    }


    public function testUploadWithExistingFile()
    {
        $uploadFile = $this->getMockBuilder(UploadedFileInterface::class)->getMock();

        $uploadFile
        ->expects($this->any())
        ->method('getClientFileName')
        -> willReturn('demo.jpg');

        touch('tests/demo.jpg');

        $uploadFile
        ->expects($this->once())
        ->method('moveTo')
        ->with($this->equalTo('tests/demo_copy.jpg'));

        $result = $this->upload->upload($uploadFile);

        $this->assertEquals('demo_copy.jpg', $result);

        unlink('tests/demo.jpg');
    }

    public function tearDown():void
    {
        if(file_exists('tests/demo.jpg'))
            unlink('tests/demo.jpg');
    }
}