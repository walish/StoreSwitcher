<?php
namespace Smart\StoreSwitcher\Model\GeoIP;

class Info extends AbstractGeoIP
{
    public function checkFilePermissions()
    {
        $relativeDirPath = $this->getRelativeDirectoryPath();

        $dir = $this->getAbsoluteDirectoryPath() . '/' . $this->_localDir;

        if (file_exists($dir)) {
            if (!is_dir($dir)) {
                return sprintf(__('%1 exists but it is file, not dir.', "$relativeDirPath/{$this->_localDir}"));
            } elseif ((!file_exists($this->_localFile) || !file_exists($this->_localArchive)) && !is_writable($dir)) {
                return sprintf(__('%1 exists but files are not and directory is not writable.'), "$relativeDirPath/{$this->local_dir}");
            } elseif (file_exists($this->_localFile) && !is_writable($this->_localFile)) {
                return sprintf(__('%1 is not writable.'), "$relativeDirPath/{$this->local_dir}" . '/GeoLite2-Country.mmdb');
            } elseif (file_exists($this->_localArchive) && !is_writable($this->_localArchive)) {
                return sprintf(__('%1 is not writable.'), "$relativeDirPath/{$this->local_dir}" . '/GeoLite2-Country.mmdb.gz');
            }
        } elseif (!@mkdir($dir)) {
            return sprintf(__('Can\'t create %1 directory.'), "$relativeDirPath/{$this->_localDir}");
        }

        return "";
    }

    public function update()
    {
        $ret = ['status' => 'error'];

        if($permissionErr = $this->checkFilePermissions()) {
            $ret["message"] = $permissionErr;
        } else {
            $remote_file_size = $this->_switcherHelper->getSize($this->_remoteCountryDBArchive);
            if($remote_file_size < 100000) {
                $ret['message'] = __('You are banned from downloading the file. Please try again in several hours.');
            } else {

                //Delete old files to get the new ones
                if(file_exists($this->_localFile)) {
                    unlink($this->_localFile);
                }

                if(file_exists($this->_localArchive)) {
                    unlink($this->_localArchive);
                }

                $this->_session->setData('_geoip_file_size', $remote_file_size);

                $src = fopen($this->_remoteCountryDBArchive, 'r');
                $target = fopen($this->_localArchive, 'w');
                stream_copy_to_stream($src, $target);
                fclose($target);

                if(filesize($this->_localArchive)){
                    if($this->_switcherHelper->unGZip($this->_localArchive, $this->_localFile)) {
                        $ret['status'] = 'success';
                    } else {
                        $ret['message'] = __('UnGZipping failed');
                    }
                }else {
                    $ret['message'] = __('Download Failed.');
                }
            }
        }

        return $ret;
    }
}