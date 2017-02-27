<?php
namespace Smart\StoreSwitcher\Model\GeoIP\Config\Source;

use Magento\Framework\App\Filesystem\DirectoryList;

class Path implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => DirectoryList::PUB, 'label' => __('pub')],
            ['value' => DirectoryList::VAR_DIR, 'label' => __('var')]
        ]
            ;
    }

    public function toArray()
    {
        return [
            DirectoryList::PUB => __('pub'),
            DirectoryList::VAR_DIR => __('var')
        ];
    }
}