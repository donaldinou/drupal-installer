<?php

namespace Acreat\Drupal\Composer\Tools\Installer {

    use Symfony\Component\Yaml\Yaml;
    use Symfony\Component\Yaml\Exception\ParseException;
    use Composer\Composer;
    use Composer\IO\IOInterface;
    use Composer\Repository\InstalledRepositoryInterface;
    use Composer\Package\PackageInterface;
    use Composer\Util\Filesystem;
    use Composer\Installer\BinaryInstaller;
    use Composer\Installers\Installer as InstallerInstallers;

    /**
     *
     */
    class DrupalInstaller extends InstallerInstallers {

        protected $drupalConfig;

        /**
         *
         */
        protected function isInstalledInDrupalAll(PackageInterface $package) {
            if (!empty($this->drupalConfig)) {
                if (!empty($this->drupalConfig->root)) {
                    return (is_dir($this->drupalConfig->root.DIRECTORY_SEPARATOR.'sites'.DIRECTORY_SEPARATOR.'all'.DIRECTORY_SEPARATOR.'modules'.$this->getPrettyPackageName($package)));
                }
            }
            return false;
        }

        /**
         *
         */
        protected function getPrettyPackageName(PackageInterface $package) {
            $vendor = '';
            $extra = $package->getExtra();
            $type = $package->getType();
            $prettyName = $packege->getPrettyName();
            if (!empty($extra['installer-name'])) {
                $prettyName = $extra['installer-name'];
            }
            return $prettyName;
        }

        /**
         * {@inheritDoc}
         */
        public function __construct(IOInterface $io, Composer $composer, $type = 'library', Filesystem $filesystem = null, BinaryInstaller $binaryInstaller = null) {
            parent::__construct($io, $composer, $type, $filesystem, $binaryInstaller);
            if ($composer->getConfig()->has('extra')) {
                $extra = $composer->getConfig()->get('extra');
                if (!empty($extra['drupal-config'])) {
                    if(is_string($extra['drupal-config'])) {
                        try {
                            $this->drupalConfig = Yaml::parse(file_get_contents($extra['drupal-config']));
                        } catch (ParseException $e) {

                        }
                    } else {
                        $this->drupalConfig = $extra['drupal-config'];
                    }
                }
            }
        }

        /**
         * {@inheritDoc}
         */
        public function isInstalled(InstalledRepositoryInterface $repo, PackageInterface $package) {
            return (parent::isInstalled($repo, $package) || $this->isInstalledInDrupalAll());
        }

        /**
         *
         */
        public function getInstallPath(PackageInterface $package) {
            $installPath = parent::getInstallPath($package);
            return $installPath;
        }

        /**
         *
         */
        public function install(InstalledRepositoryInterface $repo, PackageInterface $package) {
            if ($this->isInstalledInDrupalAll()) {
                throw new Exception('Already install in all');
            }
            return parent::install($repo, $package);
        }

        /**
         *
         */
        public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target) {
            if ($this->isInstalledInDrupalAll()) {
                throw new Exception('Already install in all');
            }
            return parent::update($repo, $initial, $target);
        }

        /**
         *
         */
        public function getDrupalConfig() {
            return $this->drupalConfig;
        }

    }

}
