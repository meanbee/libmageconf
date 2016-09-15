<?php

namespace Meanbee\LibMageConf\Util;

/**
 * Provides a mechanism for querying the contents of an array using an xpath style query string, e.g.
 *
 * $array = [
 *     'product' => [
 *         'name' => 'Test Product'
 *     ]
 * ]
 *
 * The name of the product can be extracted using the query string 'product/name'.
 *
 * @package Meanbee\LibMageConf\Util
 */
class ArrayQuery
{
    protected $subject;

    /**
     * @param $array
     */
    public function __construct($array)
    {
        $this->subject = $array;
    }

    /**
     * @param $path string
     *
     * @return mixed
     */
    public function query($path)
    {
        $pathParts = explode('/', $path);

        $pointer = &$this->subject;

        foreach ($pathParts as $pathPart) {
            if (isset($pointer[$pathPart])) {
                $pointer = &$pointer[$pathPart];
            } else {
                return null;
            }
        }

        return $pointer;
    }
}