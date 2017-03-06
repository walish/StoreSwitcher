<?php
namespace Smart\StoreSwitcher\Controller\Adminhtml\System\Config\Geoip;

use Magento\Backend\App\Action\Context;
use Smart\StoreSwitcher\Helper\GeoIP;

class TestClass extends \Magento\Backend\App\Action
{
    /**
     * @var GeoIP
     */
    protected $_geoIPHelper;

    /**
     * @var Context
     */
    private $context;

    /**
     * TestClass constructor.
     * @param Context $context
     * @param GeoIP $geoIPHelper
     */
    public function __construct(
        Context $context,
        GeoIP $geoIPHelper
    ) {
        parent::__construct($context);
        $this->_geoIPHelper = $geoIPHelper;
        $this->context = $context;
    }

    public function execute()
    {
        $record = $this->_geoIPHelper->getCountryByIp('118.70.67.134');
        var_dump($record);
    }
}