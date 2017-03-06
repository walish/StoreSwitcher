<?php
namespace Smart\StoreSwitcher\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Get size of remote file
     *
     * @param $file
     * @return mixed
     */
    public function getSize($file)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        return curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    }

    /**
     * Extracts single gzipped file. If archive will contain more than one file you will got a mess
     *
     * @param $archive
     * @param $destination
     * @return int
     */
    public function unGZip($archive, $destination)
    {
        $bufferSize = 4096; //read 4kb at a time
        $archive = gzopen($archive, 'rb');
        $data = fopen($destination, 'wb');
        while(!gzeof($archive)){
            fwrite($data, gzread($archive, $bufferSize));
        }
        fclose($data);
        gzclose($archive);
        return filesize($destination);
    }

    public function getStoreOptionSelectHtml()
    {

    }
}