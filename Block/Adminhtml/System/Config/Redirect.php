<?php
namespace Smart\StoreSwitcher\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Directory\Model\ResourceModel\Country\Collection;
use Magento\Store\Ui\Component\Listing\Column\Store\Options;

class Redirect extends \Magento\Config\Block\System\Config\Form\Field
{
    const GEOIP_REDIRECT_REDIRECT_CONFIG = 'geoip/redirect/redirect_config';

    /**
     * Countries
     *
     * @var Collection
     */
    protected $_countryCollection;


    /**
     * @var Options
     */
    protected $_storeOptions;

    /**
     * Redirect constructor.
     * @param Context $context
     * @param Collection $countryCollection
     * @param Options $storeOptions
     * @param array $data
     */
    public function __construct(
        Context $context,
        Collection $countryCollection,
        Options $storeOptions,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_countryCollection = $countryCollection;
        $this->_storeOptions = $storeOptions;
    }

    protected $_idSuffix = null;

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/redirect_field.phtml');
        }

        return $this;
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $this->setElement($element);
        return $this->_toHtml();
    }

    public function getFieldName()
    {
        return $this->getElement()->getName();
    }

    public function getIdSuffix()
    {
        if (null === $this->_idSuffix) {
            $this->_idSuffix = $this->_prepareIDSuffix($this->getFieldName());
        }
        return $this->_idSuffix;
    }

    protected function _prepareIDSuffix($id)
    {
        return preg_replace('/[^a-zA-Z0-9\$]/', '_', $id);
    }

    public function suffixId($id)
    {
        return $id . $this->getIdSuffix();
    }

    public function getCountryOptions()
    {
        return $this->_countryCollection->loadData()->toOptionArray(false);
    }

    public function getStoreOptions()
    {
        return $this->_storeOptions->toOptionArray();
    }

    public function getConfigData()
    {
        return $this->_scopeConfig->getValue(self::GEOIP_REDIRECT_REDIRECT_CONFIG,
            \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE);
    }
}
