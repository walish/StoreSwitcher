<?php
namespace Smart\StoreSwitcher\Model\System\StoreSwitcher;

use Magento\Framework\App\Config\Value;

class RedirectConfig extends Value
{
    public function setValue($value)
    {
        $value = $this->_formatDataToSave($value);

        $this->setData('value', $value);

        return $this;
    }

    public function beforeSave()
    {
        if (is_array($this->getValue())) {
            $this->setData('value', $this->getValue());
        }
        return parent::beforeSave();
    }

    protected function _formatDataToSave($values)
    {
        $return = '';

        if (is_array($values)) {
            $array = [];
            foreach ($values as $value) {
                if (array_key_exists($value['store'], $array)) {
                    $array[$value['store']] = array_merge($array[$value['store']], $value['countries']);
                } else {
                    $array[$value['store']] = $value['countries'];
                }
            }

            $return = json_encode($array);
        }

        return $return;
    }
}