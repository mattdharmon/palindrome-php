<?php
use Files\File;
use Monolog\Logger;
use Palindromes\{
    ArrayList,
    LengthSort,
    Palindrome
};
use Rx\{
    Observable,
    Scheduler\ImmediateScheduler
};

/**
 * The main entry point for processing a file of Palindromes
 * and writing them in a file sorted by length.
 */
class Main
{
    /**
     * @var ArrayList
     */
    private $palindromes;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->palindromes = new ArrayList();
        $this->logger = $logger;
    }

    /**
     * The main entry point.
     *
     * @param string $inputFile
     * @param string $outputFile
     * @return bool
     */
    public function run(
        string $inputFile,
        string $outputFile,
        ?callable $currentProgress = null
    ): bool
    {
        try {
            $file = new File($this->logger);
            $lines = $file->readLines($inputFile);

            // Read each line, filter the lines, and add them to the
            // palindromes list.
            Observable::fromIterator($lines, new ImmediateScheduler)
                ->map(function($elem) use ($currentProgress) {
                    // Return the current read progress if it was passed.
                    if ($currentProgress) {
                        $currentProgress($elem['pointer']);
                    }

                    // cast everything to string, just to be safe.
                    return (string) $elem['text'];
                })
                ->filter(new Palindrome)
                ->subscribe($this->palindromes);

            // Sort the palindromes by length and return a string.
            $output = $this->palindromes
                ->sort(new LengthSort)
                ->toString("\n");

            // write the output to the file.
            $file->write($outputFile, $output);

            $this->logger
                ->info('Job Done');

            return true;
        } catch (\Exception $e) {
            $this->logger
                ->error($e->getMessage());
            return false;
        }
    }

    /**
     * An Accessor to the Palindromes ArrayList
     *
     * @return ArrayList
     */
    public function getPalindromes(): ArrayList
    {
        return $this->palindromes;
    }
}
