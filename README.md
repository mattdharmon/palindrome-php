# Palindrome-PHP

## Description

An test project for a job that I applied for. The project is suppossed to read a large file filled with "words" where "zzzzzz" could be a word, then sort the words from shortest length to longest length, and write it to a file.

## Requirements

- PHP 7.1
- [Composer](https://getcomposer.org/)

## Building

```bash
$ composer install
```

## Run

```bash
$ php index.php
```

If you downloaded the .phar from the release pages:

```bash
$ php palindromes.phar
```

## Testing

After the build section, run:

```bash
$ ./bin/phpspec run
```