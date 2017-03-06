<?php
namespace Smart\StoreSwitcher\Helper;

use Magento\Framework\App\Helper\Context;
use Smart\StoreSwitcher\Model\DbReader\Reader as mmdbReader;
use Smart\StoreSwitcher\Model\GeoIP\Info;

class GeoIP extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Smart\StoreSwitcher\Model\GeoIP\Info
     */
    protected $_info;

    protected $_reader = null;

    /**
     * @param Context $context
     * @param Info $info
     */
    public function __construct(
        Context $context,
        Info $info
    ) {
        parent::__construct($context);
        $this->_info = $info;
    }

    /**
     * @return null|mmdbReader
     */
    protected function _getReader()
    {
        if (null == $this->_reader) {
            $this->_reader = new mmdbReader($this->_info->getLocalFilePath());
        }
        return $this->_reader;
    }

    /**
     * Get Country Data By IP address
     * @param string $ip
     * @return array
     */
    public function getCountryByIp($ip)
    {
        $reader = $this->_getReader();
        return $reader->get($ip);
    }
}