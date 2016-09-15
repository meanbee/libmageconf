<?php

namespace Meanbee\LibMageConf;

interface ConfigReader
{
    /**
     * @return null|string
     */
    public function getDatabaseHost();

    /**
     * @return null|string
     */
    public function getDatabasePort();

    /**
     * @return null|string
     */
    public function getDatabaseUsername();

    /**
     * @return null|string
     */
    public function getDatabasePassword();

    /**
     * @return null|string
     */
    public function getDatabaseName();

    /**
     * @return null|string
     */
    public function getInstallDate();

    /**
     * @return null|string
     */
    public function getAdminFrontName();
}