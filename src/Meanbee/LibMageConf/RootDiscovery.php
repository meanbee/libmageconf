<?php

namespace Meanbee\LibMageConf;

use Meanbee\LibMageConf\ConfigReader\Factory as ConfigReaderFactory;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Discover the root directory of a Magento installation given a starting directory.
 *
 * @package Meanbee\LibMageConf
 */
class RootDiscovery
{
    protected $baseDirectory;
    protected $rootDirectory;
    protected $configReaderFactory;

    /**
     * @param string $baseDirectory The directory from which to start the search
     * @param ConfigReaderFactory $configReaderFactory
     */
    public function __construct($baseDirectory, ConfigReaderFactory $configReaderFactory = null)
    {
        if ($configReaderFactory === null) {
            $configReaderFactory = new ConfigReaderFactory();
        }

        $this->baseDirectory = $baseDirectory;
        $this->configReaderFactory = $configReaderFactory;
    }

    /**
     * The root directory of the first Magento installation found in the base directory.
     *
     * @return null|string
     */
    public function getRootDirectory()
    {
        if ($this->rootDirectory === null) {
            $this->rootDirectory = $this->discoverRootDirectory();
        }

        return $this->rootDirectory;
    }

    /**
     * @return ConfigReader
     */
    public function getConfigReader()
    {
        return $this->configReaderFactory->create(
            $this->getLocalXmlPath(
                $this->getRootDirectory()
            )
        );
    }

    /**
     * @return null|string
     */
    protected function discoverRootDirectory()
    {
        if ($dir = $this->checkCurrentDirectory()) {
            return $dir;
        }

        if ($dir = $this->checkParentDirectories()) {
            return $dir;
        }

        if ($dir = $this->checkChildDirectories()) {
            return $dir;
        }

        return null;
    }

    /**
     * @return null|string
     */
    protected function checkCurrentDirectory()
    {
        if (is_dir($this->baseDirectory)) {
            if ($this->isDirectoryRoot($this->baseDirectory)) {
                return $this->baseDirectory;
            }
        }

        return null;
    }

    /**
     * @return null|string
     */
    protected function checkParentDirectories()
    {
        $dir = new SplFileInfo($this->baseDirectory);
        while ($testDir = $dir->getPath()) {
            if ($this->isDirectoryRoot($testDir)) {
                return $testDir;
            }

            $dir = new SplFileInfo($testDir);
        }

        return null;
    }

    /**
     * @return null|string
     */
    protected function checkChildDirectories()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->baseDirectory),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach($iterator as $fileInfo) {
            /** @var SplFileInfo $fileInfo */
            $filename = $fileInfo->getPath() . DIRECTORY_SEPARATOR . $fileInfo->getFilename();

            if ($fileInfo->isDir()) {
                if ($this->isDirectoryRoot($filename)) {
                    return $filename;
                }
            }
        }

        return null;
    }

    /**
     * @param $directory
     * @return bool
     */
    protected function isDirectoryRoot($directory)
    {
        return file_exists($this->getLocalXmlPath($directory));
    }

    /**
     * @param $directory
     * @return string
     */
    protected function getLocalXmlPath($directory)
    {
        return sprintf("%s/app/etc/local.xml", $directory);
    }
}