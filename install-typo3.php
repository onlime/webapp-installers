<?php
/**
 * Typo3 6.2+ installer for webhosting customers without shell access
 * by Philip Iezzi
 *
 * @copyright Copyright (c) 2015 Onlime Webhosting (http://www.onlime.ch)
 */
class Typo3Installer
{
    const MSG_INFO    = 'info';
    const MSG_NOTICE  = 'notice';
    const MSG_WARNING = 'warning';
    const MSG_ERROR   = 'error';

    const MIN_VERSION = '6.2.0';

    /**
     * @var string
     */
    protected $_currPath;

    /**
     * @var string
     */
    protected $_version;

    /**
     * Constructor
     *
     * @param string $version
     */
    public function __construct($version = '6.2.15')
    {
        $this->_currPath = realpath(dirname(__FILE__));
        $this->_version  = (isset($_GET['version'])) ? $_GET['version'] : $version;

        // check minimum Typo3 version requirement
        if (version_compare($this->_version, self::MIN_VERSION, '<')) {
            $this->_msg(sprintf("You are trying to install a version below %s. Installer aborted.", self::MIN_VERSION), self::MSG_ERROR);
        }
    }

    /**
     * Run installer
     */
    public function run()
    {
        $typo3Src  = 'typo3_src-' . $this->_version;
        $srcTarget = '../' . $typo3Src;

        // check if typo3_src target directory exists
        if (!is_dir($srcTarget) || !is_readable($srcTarget)) {
            $srcArchive = $srcTarget . '.tar.gz';
            // try to decompress the Typo3 archive (.tar.gz) if it was found
            if (is_readable($srcArchive)) {
                $status = system("cd ..; tar xzf ${typo3Src}.tar.gz");
                if ($status == 0) {
                    $this->_msg("decompressed $srcArchive to $srcTarget");
                } else {
                    $this->_msg("Unable to decompress $srcArchive. Installer aborted.", self::MSG_ERROR);
                }
            } else {
                $this->_msg("$srcTarget is not readable or does not exist!", self::MSG_ERROR);
            }
        }

        // default symlinks
        $symlinks = array(
            'typo3_src' => $srcTarget,
            'index.php' => 'typo3_src/index.php',
            'typo3'     => 'typo3_src/typo3'
        );

        foreach ($symlinks as $link => $target) {

            // $link = $this->_currPath . '/' . $link;

            // removing existing symlink
            if (is_link($link)) {
                $success = unlink($link);
                if ($success) {
                    $this->_msg("unlinked existing symlink $link", self::MSG_NOTICE);
                } else {
                    $this->_msg("Could not unlink existing symlink $link. Please remove manually and restart installer.", self::MSG_ERROR);
                }
            }

            // creating new symlink
            $status = system("ln -sf $target $link"); // symlink() might not work on every system
            if ($status == 0) {
                $this->_msg("created symlink $link -> $target");
            } else {
                $this->_msg("Could not create symlink $link -> $target. Installer aborted.", self::MSG_ERROR);
            }
        }

        // create .htaccess
        copy('typo3_src/_.htaccess', '.htaccess');
        $this->_msg("copied typo3_src/_.htaccess to .htaccess");

        // create FIRST_INSTALL
        touch('FIRST_INSTALL');
        $this->_msg("created FIRST_INSTALL");

        $this->_msg("done. Sucessfully installed Typo3 $this->_version.");
    }

    /**
     * Display a message.
     *
     * @param string $message
     * @param string $status
     */
    protected function _msg($message, $status = self::MSG_INFO)
    {
        $lineBreak = (PHP_SAPI == 'cli') ? PHP_EOL : '<br />';
        echo sprintf('[%s] %s%s', strtoupper($status), $message, $lineBreak);
        if ($status == self::MSG_ERROR) {
            exit(1);
        }
    }
}

$typo3Installer = new Typo3Installer();
$typo3Installer->run();
