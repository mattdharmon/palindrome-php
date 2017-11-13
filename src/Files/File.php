<?php
namespace Files;

use Monolog\Logger;
use Palindromes\ArrayList;

/**
 * Read files line by line and write to files as well.
 */
class File
{
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
     * Read a file and get a Generator that each item is a line from
     * the file.
     *
     * @param string $targetFile
     * @return \Generator
     * @throws \Exception
     */
    public function readLines(string $targetFile): \Generator
    {
        try {
            if (!file_exists($targetFile)) {
                throw new \Exception("File {$targetFile} not found.");
            }

            $file = fopen($targetFile, 'r');

            if (!$file) {
                throw new \Exception("File {$targetFile} failed to open.");
            }

            while ($text = fgets($file)) {
                yield [
                    'pointer' => ftell($file),
                    'text' => $text
                ];
            }
            $this->logger
                ->info("File read from {$targetFile}");
            fclose($file);
        } catch (\Exception $e) {
            $this->logger
                ->error($e->getMessage());
            throw($e);
        }
    }

    /**
     * Write a line to a file.
     *
     * @param string $targetFile
     * @param string $text
     * @return bool
     */
    public function write(string $targetFile, string $text): bool
    {
        $return = false;
        try {
            // Create the output file and dirs if they do not exist.
            $this->createOutputPath($targetFile);

            $file = fopen($targetFile, 'w');

            if (!$file) {
                throw new \Exception("File {$targetFile} failed to open.");
            }

            $result = fwrite($file, $text);
            $return = !is_bool($result) ?? false;

            fclose($file);

            $this->logger
                ->info("Content written to {$targetFile}");
        } catch (\Exception $e) {
            $this->logger
                ->error($e->getMessage());
            $return = false;
        } finally {
            return $return;
        }
    }

    /**
     * Create the file output file and directory if it doesn't exist.
     *
     * @param string $targetFile
     * @return bool
     */
    public function createOutputPath(string $targetFile): bool
    {
        $file = new \SplFileInfo($targetFile);
        $parent = $file->getPathInfo();
        $return = true;

        if (!$parent->isDir()) {
            $parentPath = $parent->getPathName();
            $return = mkdir(
                $parentPath,
                0755,
                true
            );
            $this->logger
                ->info("Path {$parentPath} did not exists, created.");
        }

        if (!file_exists($targetFile)) {
            $this->logger
                ->info("File {$targetFile} did not exists, created.");
            touch($targetFile);
        }

        return $return;
    }
}
