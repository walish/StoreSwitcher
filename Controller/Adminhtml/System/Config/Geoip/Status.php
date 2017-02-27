<?php
namespace Smart\StoreSwitcher\Controller\Adminhtml\System\Config\Geoip;

class Status extends \Magento\Backend\App\Action
{
    /**
     * @var \Smart\StoreSwitcher\Model\GeoIP\Info
     */
    protected $_geoipInfo;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $_session;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\Session $session,
        \Smart\StoreSwitcher\Model\GeoIP\Info $info
    ) {
        parent::__construct($context);
        $this->_session = $session;
        $this->_geoipInfo = $info;
    }

    public function execute()
    {
        $realSize = 0;
        if (file_exists($this->_geoipInfo->getArchivePath())) {
            $realSize = filesize($this->_geoipInfo->getArchivePath());
        }
        $totalSize = $this->_session->getData('_geoip_file_size');
        echo $totalSize ? ($realSize / $totalSize) * 100 : 0;
    }
}