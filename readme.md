# LibMageConf

[![Build Status](https://travis-ci.org/meanbee/libmageconf.svg?branch=master)](https://travis-ci.org/meanbee/libmageconf) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/meanbee/libmageconf/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/meanbee/libmageconf/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/meanbee/libmageconf/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/meanbee/libmageconf/?branch=master)

This library provides a mechanism for discovering a Magento (1.x and 2.x supported) installation, given a starting directory.  This is useful
for building tools that integrate externally with Magento but still need access to its configuration or certain files,
such as [magedbm](https://github.com/meanbee/magedbm) and [mageconfigsync](https://github.com/punkstar/mageconfigsync).

## Installation

    composer require meanbee/libmageconf

## Usage

Given that I have Magento installed in `/home/nrj/magento`, I can discover its location with the following code:

    $rootDiscovery = new RootDiscovery('/home/nrj');

    // Outputs: "Root: /home/nrj/magento"
    printf("Root: %s", $rootDiscovery->getRootDirectory());


Given that I know where the Magento installation's `local.xml` is, I can access the configuration held in that file with
the following code:

    $configReader = ConfigReader\MagentoOne("path/to/local.xml");
    $databaseName = $configReader->getDatabaseName();

or

    $configReader = ConfigReader\MagentoTwi("path/to/env.php");
    $databaseName = $configReader->getDatabaseName();