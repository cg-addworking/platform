<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Helpers;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\StringDataExtractorHelperInterface;

class StringDataExtractorHelper implements StringDataExtractorHelperInterface
{
    /**
     * @param string $contents
     * @param string $needle
     * @return string|null
     *
     * Will search for the $needle inside the $contents and return whatever follows the givent $needle on the same line
     */
    public function extractDataOfLinesStartingWith(string $contents, string $needle): ?string
    {
        $regex = "/{$needle}(.*)/";
        preg_match($regex, $contents, $matches);

        $data = null;
        if (count($matches)) {
            $data = $matches[0];
            $data = preg_replace("/{$needle}[ ]*/", '', $data);
            $data = preg_replace("/\r|\n/", '', $data);
        }

        return $data;
    }

    /**
     * @param string $contents
     * @param string $needle
     * @return string|null
     *
     * Will search for the $needle inside of the $contents and return the following line
     */
    public function extractDataFromLinesFollowingLineStartingWith(string $contents, string $needle): ?string
    {
        $regex = "/{$needle}\s.*\w+/";
        preg_match($regex, $contents, $matches);
        $data = null;
        if (count($matches)) {
            $data = $matches[0];
            $data = preg_replace("/{$needle}[ ]*/", '', $data);
            $data = preg_replace("/\r|\n/", '', $data);
        }

        return $data;
    }

    /**
     * @param string $contents
     * @param string $needle
     * @return bool
     *
     * Will check if the givent $contents has $needle
     */
    public function extractDataContains(string $contents, string $needle): bool
    {
        $regex = "/{$needle}/";
        preg_match($regex, $contents, $matches);
        return !empty($matches);
    }
}
