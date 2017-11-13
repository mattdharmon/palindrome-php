<?php
namespace spec;

use Main;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Files\File;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MainSpec extends ObjectBehavior
{
    private $outputFile = __DIR__ . '/testOutput.txt';
    private $inputFile =  __DIR__ . '/testFile.txt';
    private $loggerFile = __DIR__ . '/../logs/test/app.log';

    public function let()
    {
        $this->beConstructedWith($this->logger());
    }

    public function letGo()
    {
        $file = new File($this->logger());

        // Comment out this line if you want to
        // see the output file.
        $file->write($this->outputFile, '');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Main::class);
    }

    public function it_should_run(File $file)
    {
       $this->run(
           $this->inputFile,
           $this->outputFile
        )->shouldReturn(true);

        $expectedResult = new \ArrayIterator([
            'yay',
            "poop\n"
        ]);

        $this->getPalindromes()
            ->shouldIterateAs($expectedResult);
    }

    private function logger(): Logger
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler($this->loggerFile));

        return $log;
    }
}
