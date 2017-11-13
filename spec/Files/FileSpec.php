<?php
namespace spec\Files;

use Files\File;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileSpec extends ObjectBehavior
{
    private $outputFile = __DIR__ . '/../testOutput.txt';
    private $inputFile =  __DIR__ . '/../testFile.txt';
    private $loggerFile = __DIR__ . '/../../logs/test/app.log';

    public function let()
    {
        $this->beConstructedWith($this->logger());
    }

    public function letGo()
    {
        $file = new File($this->logger());
        $file->write($this->outputFile, '');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(File::class);
    }

    public function it_reads_a_file()
    {
        $expectedResult = [
            'pointer' => 18,
            'text' => 'yay'
        ];
        $lines = $this->readLines($this->inputFile);
        $lines->shouldReturnAnInstanceOf('Generator');
        $lines->shouldContain($expectedResult);
    }

    public function it_writes_to_file()
    {
        $expectedResult = [
            'pointer' => 4,
            'text' => 'test'
        ];
        $this->write($this->outputFile, 'test')
            ->shouldReturn(true);
        $this->readLines($this->outputFile)
            ->shouldContain($expectedResult);
    }

    public function it_creates_a_file()
    {
        $this->createOutputPath($this->outputFile)
            ->shouldReturn(true);
    }

    private function logger(): Logger
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler($this->loggerFile));

        return $log;
    }
}
