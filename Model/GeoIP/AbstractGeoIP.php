<?php
namespace Smart\StoreSwitcher\Model\GeoIP;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\Model\Session as BackendSession;
use Smart\StoreSwitcher\Helper\Data as SwitcherHelper;

abstract class AbstractGeoIP
{
    const XML_PATH_DB_FILE_PATH = 'geoip/general/file_path';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;

    /**
     * @var \Smart\StoreSwitcher\Helper\Data
     */
    protected $_switcherHelper;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $_session;

    protected $_localDir, $_localFile, $_localArchive, $_remoteCountryDBArchive;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        DirectoryList $directoryList,
        BackendSession $session,
        SwitcherHelper $switcherHelper
    ) {
        $this->_session = $session;
        $this->_scopeConfig = $scopeConfig;
        $this->_directoryList = $directoryList;
        $this->_switcherHelper = $switcherHelper;
        $this->_construct();
    }

    /**
     * Model construct that should be used for object initialization
     */
    protected function _construct()
    {
        $this->_localDir = 'geoip';
        $this->_localFile = $this->getAbsoluteDirectoryPath() . '/' . $this->_localDir . '/GeoLite2-Country.mmdb';
        $this->_localArchive = $this->getAbsoluteDirectoryPath() . '/' . $this->_localDir . '/GeoLite2-Country.mmdb.gz';
        $this->_remoteCountryDBArchive = 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz';
    }

    public function getRelativeDirectoryPath()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_DB_FILE_PATH);
    }

    public function getAbsoluteDirectoryPath()
    {
        return $this->_directoryList->getPath($this->getRelativeDirectoryPath());
    }

    public function getArchivePath()
    {
        return $this->_localArchive;
    }

    public function getLocalFilePath()
    {
        return $this->_localFile;
    }
}