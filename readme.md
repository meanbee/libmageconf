# LibMageConf

[![Build Status](https://travis-ci.org/meanbee/libmageconf.svg?branch=master)](https://travis-ci.org/meanbee/libmageconf)

This library provides a mechanism for discovering a Magento installation, given a starting directory.  This is useful
for building tools that integrate externally with Magento but still need access to its configuration or certain files,
such as [magedbm](https://github.com/meanbee/magedbm) and [mageconfigsync](https://github.com/punkstar/mageconfigsync).

## Installation

    composer require meanbee/libmageconf

## Usage

Given that I have Magento installed in `/home/nrj/magento`, I can discover its location with the following code:

    $rootDiscovery = new RootDiscovery('/home/nrj');

    // Outputs: "Root: /home/nrj/magento"
    printf("Root: %s", $rootDiscovery->getRootDirectory());

