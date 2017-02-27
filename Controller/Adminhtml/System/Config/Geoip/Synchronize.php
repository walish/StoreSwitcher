<?php
namespace Smart\StoreSwitcher\Controller\Adminhtml\System\Config\Geoip;

class Synchronize extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Smart\StoreSwitcher\Model\GeoIP\Info
     */
    protected $_geoipInfo;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Smart\StoreSwitcher\Model\GeoIP\Info $info

    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_geoipInfo = $info;
    }


    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($this->_geoipInfo->update());
    }
}