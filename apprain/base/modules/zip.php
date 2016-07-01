<?php
/**
 * appRain CMF
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@apprain.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.org/
 *
 * Download Link
 * http://www.apprain.org/download
 *
 * Documents Link
 * http ://www.apprain.org/general-help-center
 */

/**
 * Class Orginally Developed by : Alexandre Tedeschi (d), alexandrebr@gmail.com
 *
 * Updated by : Reazaul Karim, info@apprain.com
 */

/**
 *    1. Create ZIP by adding file manually
 *        $zip  = App::Module('Zip')
->setFileName('/var/www/works/other/wikipedia.zip')
->addDir('wikipedia')
->addFile('/var/www/works/other/wikipedia.php',  'wikipedia/wikipedia.php')
->save(true);
 *
 * 2. Compress a full directory
$zip  = App::Module('Zip')
->setFileName('racipe.zip')
->Compress('/var/www/works/other/racipe',true);
 *
 * 3. Unzip a full Zip file
$zip  = App::Module('Zip')
->setFileName('test.zip')
->Extract('/var/www');*/
class appRain_Base_Modules_Zip extends appRain_Base_Objects
{
    public $lastError;
    public $compressedList;
    public $centralDirList;
    public $endOfCentral = Array();

    private $fh;
    // Signatures
    private $zipSignature = "\x50\x4b\x03\x04";
    private $dirSignature = "\x50\x4b\x01\x02";
    private $dirSignatureE = "\x50\x4b\x05\x06";

    var $overwrite = true;
    var $files_count = 0;

    public function __construct()
    {
    }

    /* DO UNZIP SECTION
       =========================================================================*/

    public function extract($path = "")
    {
        $this->getList();
        $this->unzipAll($path);
        $this->close();
        return $this;
    }

    private function archiveFileName()
    {
        if (!$this->getFileName()) {
            die('UpZip file name not found');
        }
        return $this->getFileName();
    }

    private function getList($stopOnFile = false)
    {
        if (sizeof($this->compressedList)) {
            return $this->compressedList;
        }

        // Open file, and set file handler
        $fh = fopen($this->archiveFileName(), "r");
        $this->fh = &$fh;
        if (!$fh) {
            return false;
        }

        if (!$this->_loadFileListByEOF($fh, $stopOnFile)) {
            if (!$this->_loadFileListBySignatures($fh, $stopOnFile)) {
                return false;
            }
        }

        return $this->compressedList;
    }

    private function getExtraInfo($compressedFileName)
    {
        return
            isset($this->centralDirList[$compressedFileName]) ?
                $this->centralDirList[$compressedFileName] :
                false;
    }

    private function getZipInfo($detail = false)
    {
        return $detail ?
            $this->endOfCentral[$detail] :
            $this->endOfCentral;
    }

    private function unzip($compressedFileName, $targetFileName = false, $applyChmod = 0777)
    {
        if (!sizeof($this->compressedList)) {
            $this->getList(false, $compressedFileName);
        }

        $fdetails = &$this->compressedList[$compressedFileName];
        if (!isset($this->compressedList[$compressedFileName])) {
            return false;
        }
        if (substr($compressedFileName, -1) == "/") {
            return false;
        }
        if (!$fdetails['uncompressed_size']) {
            return $targetFileName ?
                file_put_contents($targetFileName, "") :
                "";
        }

        fseek($this->fh, $fdetails['contents-startOffset']);
        $toUncompress = fread($this->fh, $fdetails['compressed_size']);
        $ret = $this->uncompress(
            $toUncompress,
            $fdetails['compression_method'],
            $fdetails['uncompressed_size'],
            $targetFileName
        );
        unset($toUncompress);
        if ($applyChmod && $targetFileName)
            chmod($targetFileName, 0777);

        return $ret;
    }

    private function unzipAll($targetDir = false, $baseDir = "", $maintainStructure = true, $applyChmod = 0777)
    {
        if ($targetDir === false) {
            $targetDir = dirname($_SERVER['SCRIPT_FILENAME']) . "/";
        }
        if (substr($targetDir, -1) != "/") {
            $targetDir .= "/";
        }

        $lista = $this->getList();
        if (sizeof($lista)) {
            foreach ($lista as $fileName => $trash) {
                $dirname = dirname($fileName);
                $outDN = "$targetDir/$dirname";

                if (substr($dirname, 0, strlen($baseDir)) != $baseDir) {
                    continue;
                }
                if (!is_dir($outDN) && $maintainStructure) {
                    $str = "";
                    $folders = explode("/", $dirname);
                    foreach ($folders as $folder) {
                        $str = $str ? "$str/$folder" : $folder;
                        if (!is_dir("$targetDir/$str")) {
                            mkdir("$targetDir/$str");
                            if ($applyChmod) {
                                chmod("$targetDir/$str", $applyChmod);
                            }
                        }
                    }
                }
                if (substr($fileName, -1, 1) == "/") {
                    continue;
                }
                $maintainStructure ?
                    $this->unzip($fileName, "$targetDir/$fileName", $applyChmod) :
                    $this->unzip($fileName, "$targetDir/" . basename($fileName), $applyChmod);
            }
        }
    }

    private function close()
    {
        if ($this->fh) {
            fclose($this->fh);
        }
    }

    private function __destroy()
    {
        $this->close();
    }

    private function uncompress(&$content, $mode, $uncompressedSize, $targetFileName = false)
    {
        switch ($mode) {
            case 0:
                // Not compressed
                return $targetFileName ?
                    file_put_contents($targetFileName, $content) :
                    $content;
            case 1:
                return false;
            case 2:
            case 3:
            case 4:
            case 5:
                return false;
            case 6:
                return false;
            case 7:
                return false;
            case 8:
                // Deflate
                return $targetFileName ?
                    file_put_contents($targetFileName, gzinflate($content, $uncompressedSize)) :
                    gzinflate($content, $uncompressedSize);
            case 9:
                return false;
            case 10:
                return false;
            case 12:
                // Bzip2
                return $targetFileName ?
                    file_put_contents($targetFileName, bzdecompress($content)) :
                    bzdecompress($content);
            case 18:
                return false;
            default:
                return false;
        }
    }

    private function getLastError()
    {
        return $this->lastError;
    }

    private function _loadFileListByEOF(&$fh, $stopOnFile = false)
    {
        // Check if there's a valid Central Dir signature.
        // Let's consider a file comment smaller than 1024 characters...
        // Actually, it length can be 65536.. But we're not going to support it.

        for ($x = 0; $x < 1024; $x++) {
            fseek($fh, -22 - $x, SEEK_END);

            $signature = fread($fh, 4);
            if ($signature == $this->dirSignatureE) {
                // If found EOF Central Dir
                $eodir['disk_number_this'] = unpack("v", fread($fh, 2)); // number of this disk
                $eodir['disk_number'] = unpack("v", fread($fh, 2)); // number of the disk with the start of the central directory
                $eodir['total_entries_this'] = unpack("v", fread($fh, 2)); // total number of entries in the central dir on this disk
                $eodir['total_entries'] = unpack("v", fread($fh, 2)); // total number of entries in
                $eodir['size_of_cd'] = unpack("V", fread($fh, 4)); // size of the central directory
                $eodir['offset_start_cd'] = unpack("V", fread($fh, 4)); // offset of start of central directory with respect to the starting disk number
                $zipFileCommentLenght = unpack("v", fread($fh, 2)); // zipfile comment length
                $eodir['zipfile_comment'] = $zipFileCommentLenght[1] ? fread($fh, $zipFileCommentLenght[1]) : ''; // zipfile comment
                $this->endOfCentral = Array(
                    'disk_number_this' => $eodir['disk_number_this'][1],
                    'disk_number' => $eodir['disk_number'][1],
                    'total_entries_this' => $eodir['total_entries_this'][1],
                    'total_entries' => $eodir['total_entries'][1],
                    'size_of_cd' => $eodir['size_of_cd'][1],
                    'offset_start_cd' => $eodir['offset_start_cd'][1],
                    'zipfile_comment' => $eodir['zipfile_comment'],
                );

                // Then, load file list
                fseek($fh, $this->endOfCentral['offset_start_cd']);
                $signature = fread($fh, 4);

                while ($signature == $this->dirSignature) {
                    $dir['version_madeby'] = unpack("v", fread($fh, 2)); // version made by
                    $dir['version_needed'] = unpack("v", fread($fh, 2)); // version needed to extract
                    $dir['general_bit_flag'] = unpack("v", fread($fh, 2)); // general purpose bit flag
                    $dir['compression_method'] = unpack("v", fread($fh, 2)); // compression method
                    $dir['lastmod_time'] = unpack("v", fread($fh, 2)); // last mod file time
                    $dir['lastmod_date'] = unpack("v", fread($fh, 2)); // last mod file date
                    $dir['crc-32'] = fread($fh, 4); // crc-32
                    $dir['compressed_size'] = unpack("V", fread($fh, 4)); // compressed size
                    $dir['uncompressed_size'] = unpack("V", fread($fh, 4)); // uncompressed size
                    $fileNameLength = unpack("v", fread($fh, 2)); // filename length
                    $extraFieldLength = unpack("v", fread($fh, 2)); // extra field length
                    $fileCommentLength = unpack("v", fread($fh, 2)); // file comment length
                    $dir['disk_number_start'] = unpack("v", fread($fh, 2)); // disk number start
                    $dir['internal_attributes'] = unpack("v", fread($fh, 2)); // internal file attributes-byte1
                    $dir['external_attributes1'] = unpack("v", fread($fh, 2)); // external file attributes-byte2
                    $dir['external_attributes2'] = unpack("v", fread($fh, 2)); // external file attributes
                    $dir['relative_offset'] = unpack("V", fread($fh, 4)); // relative offset of local header
                    $dir['file_name'] = fread($fh, $fileNameLength[1]); // filename
                    $dir['extra_field'] = $extraFieldLength[1] ? fread($fh, $extraFieldLength[1]) : ''; // extra field
                    $dir['file_comment'] = $fileCommentLength[1] ? fread($fh, $fileCommentLength[1]) : ''; // file comment

                    // Convert the date and time, from MS-DOS format to UNIX Timestamp
                    $BINlastmod_date = str_pad(decbin($dir['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
                    $BINlastmod_time = str_pad(decbin($dir['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);
                    $lastmod_dateY = bindec(substr($BINlastmod_date, 0, 7)) + 1980;
                    $lastmod_dateM = bindec(substr($BINlastmod_date, 7, 4));
                    $lastmod_dateD = bindec(substr($BINlastmod_date, 11, 5));
                    $lastmod_timeH = bindec(substr($BINlastmod_time, 0, 5));
                    $lastmod_timeM = bindec(substr($BINlastmod_time, 5, 6));
                    $lastmod_timeS = bindec(substr($BINlastmod_time, 11, 5));

                    // Some protection agains attacks...
                    $dir['file_name'] = $this->_decodeFilename($dir['file_name']);
                    if (!$dir['file_name'] = $this->_protect($dir['file_name'])) {
                        continue;
                    }
                    $this->centralDirList[$dir['file_name']] = Array(
                        'version_madeby' => $dir['version_madeby'][1],
                        'version_needed' => $dir['version_needed'][1],
                        'general_bit_flag' => str_pad(decbin($dir['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
                        'compression_method' => $dir['compression_method'][1],
                        'lastmod_datetime' => mktime($lastmod_timeH, $lastmod_timeM, $lastmod_timeS, $lastmod_dateM, $lastmod_dateD, $lastmod_dateY),
                        'crc-32' => str_pad(dechex(ord($dir['crc-32'][3])), 2, '0', STR_PAD_LEFT) .
                            str_pad(dechex(ord($dir['crc-32'][2])), 2, '0', STR_PAD_LEFT) .
                            str_pad(dechex(ord($dir['crc-32'][1])), 2, '0', STR_PAD_LEFT) .
                            str_pad(dechex(ord($dir['crc-32'][0])), 2, '0', STR_PAD_LEFT),
                        'compressed_size' => $dir['compressed_size'][1],
                        'uncompressed_size' => $dir['uncompressed_size'][1],
                        'disk_number_start' => $dir['disk_number_start'][1],
                        'internal_attributes' => $dir['internal_attributes'][1],
                        'external_attributes1' => $dir['external_attributes1'][1],
                        'external_attributes2' => $dir['external_attributes2'][1],
                        'relative_offset' => $dir['relative_offset'][1],
                        'file_name' => $dir['file_name'],
                        'extra_field' => $dir['extra_field'],
                        'file_comment' => $dir['file_comment'],
                    );
                    $signature = fread($fh, 4);
                }

                // If loaded centralDirs, then try to identify the offsetPosition of the compressed data.
                if ($this->centralDirList) foreach ($this->centralDirList as $filename => $details) {
                    $i = $this->_getFileHeaderInformation($fh, $details['relative_offset']);
                    $this->compressedList[$filename]['file_name'] = $filename;
                    $this->compressedList[$filename]['compression_method'] = $details['compression_method'];
                    $this->compressedList[$filename]['version_needed'] = $details['version_needed'];
                    $this->compressedList[$filename]['lastmod_datetime'] = $details['lastmod_datetime'];
                    $this->compressedList[$filename]['crc-32'] = $details['crc-32'];
                    $this->compressedList[$filename]['compressed_size'] = $details['compressed_size'];
                    $this->compressedList[$filename]['uncompressed_size'] = $details['uncompressed_size'];
                    $this->compressedList[$filename]['lastmod_datetime'] = $details['lastmod_datetime'];
                    $this->compressedList[$filename]['extra_field'] = $i['extra_field'];
                    $this->compressedList[$filename]['contents-startOffset'] = $i['contents-startOffset'];
                    if (strtolower($stopOnFile) == strtolower($filename))
                        break;
                }
                return true;
            }
        }
        return false;
    }

    private function _loadFileListBySignatures(&$fh, $stopOnFile = false)
    {
        fseek($fh, 0);

        $return = false;
        for (; ;) {
            $details = $this->_getFileHeaderInformation($fh);
            if (!$details) {
                fseek($fh, 12 - 4, SEEK_CUR); // 12: Data descriptor - 4: Signature (that will be read again)
                $details = $this->_getFileHeaderInformation($fh);
            }
            if (!$details) {
                break;
            }
            $filename = $details['file_name'];
            $this->compressedList[$filename] = $details;
            $return = true;
            if (strtolower($stopOnFile) == strtolower($filename))
                break;
        }

        return $return;
    }

    private function _getFileHeaderInformation(&$fh, $startOffset = false)
    {
        if ($startOffset !== false) {
            fseek($fh, $startOffset);
        }
        $signature = fread($fh, 4);
        if ($signature == $this->zipSignature) {
            // Get information about the zipped file
            $file['version_needed'] = unpack("v", fread($fh, 2)); // version needed to extract
            $file['general_bit_flag'] = unpack("v", fread($fh, 2)); // general purpose bit flag
            $file['compression_method'] = unpack("v", fread($fh, 2)); // compression method
            $file['lastmod_time'] = unpack("v", fread($fh, 2)); // last mod file time
            $file['lastmod_date'] = unpack("v", fread($fh, 2)); // last mod file date
            $file['crc-32'] = fread($fh, 4); // crc-32
            $file['compressed_size'] = unpack("V", fread($fh, 4)); // compressed size
            $file['uncompressed_size'] = unpack("V", fread($fh, 4)); // uncompressed size
            $fileNameLength = unpack("v", fread($fh, 2)); // filename length
            $extraFieldLength = unpack("v", fread($fh, 2)); // extra field length
            $file['file_name'] = fread($fh, $fileNameLength[1]); // filename
            $file['extra_field'] = $extraFieldLength[1] ? fread($fh, $extraFieldLength[1]) : ''; // extra field
            $file['contents-startOffset'] = ftell($fh);

            // Bypass the whole compressed contents, and look for the next file
            fseek($fh, $file['compressed_size'][1], SEEK_CUR);

            // Convert the date and time, from MS-DOS format to UNIX Timestamp
            $BINlastmod_date = str_pad(decbin($file['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
            $BINlastmod_time = str_pad(decbin($file['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);
            $lastmod_dateY = bindec(substr($BINlastmod_date, 0, 7)) + 1980;
            $lastmod_dateM = bindec(substr($BINlastmod_date, 7, 4));
            $lastmod_dateD = bindec(substr($BINlastmod_date, 11, 5));
            $lastmod_timeH = bindec(substr($BINlastmod_time, 0, 5));
            $lastmod_timeM = bindec(substr($BINlastmod_time, 5, 6));
            $lastmod_timeS = bindec(substr($BINlastmod_time, 11, 5));

            // Some protection agains attacks...
            $file['file_name'] = $this->_decodeFilename($file['file_name']);
            if (!$file['file_name'] = $this->_protect($file['file_name']))
                return false;

            // Mount file table
            $i = Array(
                'file_name' => $file['file_name'],
                'compression_method' => $file['compression_method'][1],
                'version_needed' => $file['version_needed'][1],
                'lastmod_datetime' => mktime($lastmod_timeH, $lastmod_timeM, $lastmod_timeS, $lastmod_dateM, $lastmod_dateD, $lastmod_dateY),
                'crc-32' => str_pad(dechex(ord($file['crc-32'][3])), 2, '0', STR_PAD_LEFT) .
                    str_pad(dechex(ord($file['crc-32'][2])), 2, '0', STR_PAD_LEFT) .
                    str_pad(dechex(ord($file['crc-32'][1])), 2, '0', STR_PAD_LEFT) .
                    str_pad(dechex(ord($file['crc-32'][0])), 2, '0', STR_PAD_LEFT),
                'compressed_size' => $file['compressed_size'][1],
                'uncompressed_size' => $file['uncompressed_size'][1],
                'extra_field' => $file['extra_field'],
                'general_bit_flag' => str_pad(decbin($file['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
                'contents-startOffset' => $file['contents-startOffset']
            );
            return $i;
        }
        return false;
    }

    private function _decodeFilename($filename)
    {
        $from = "\xb7\xb5\xb6\xc7\x8e\x8f\x92\x80\xd4\x90\xd2\xd3\xde\xd6\xd7\xd8\xd1\xa5\xe3\xe0" .
            "\xe2\xe5\x99\x9d\xeb\xe9\xea\x9a\xed\xe8\xe1\x85\xa0\x83\xc6\x84\x86\x91\x87\x8a" .
            "\x82\x88\x89\x8d\xa1\x8c\x8b\xd0\xa4\x95\xa2\x93\xe4\x94\x9b\x97\xa3\x96\xec\xe7" .
            "\x98ï";
        $to = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýþÿ´";

        return strtr($filename, $from, $to);
    }

    private function _protect($fullPath)
    {

        $fullPath = strtr($fullPath, ":*<>|\"\x0\\", "......./");
        while ($fullPath[0] == "/")
            $fullPath = substr($fullPath, 1);

        if (substr($fullPath, -1) == "/") {
            $base = '';
            $fullPath = substr($fullPath, 0, -1);
        }
        else {
            $base = basename($fullPath);
            $fullPath = dirname($fullPath);
        }

        $parts = explode("/", $fullPath);
        $lastIdx = false;
        foreach ($parts as $idx => $part) {
            if ($part == ".") {
                unset($parts[$idx]);
            }
            elseif ($part == "..") {
                unset($parts[$idx]);
                if ($lastIdx !== false) {
                    unset($parts[$lastIdx]);
                }
            }
            elseif ($part === '') {
                unset($parts[$idx]);
            }
            else {
                $lastIdx = $idx;
            }
        }
        $fullPath = sizeof($parts) ? implode("/", $parts) . "/" : "";
        return $fullPath . $base;
    }


    /* DO ZIP SECTION
       =========================================================================*/
    public function Compress($path = null, $isAutoDownload = false)
    {
        if (!isset($path) || !file_exists($path)) return false;
        $this->setTmpRootPath($path);
        $this->createBundle($path);
        $this->Save($isAutoDownload);
    }

    public function createBundle($dir = null)
    {
        $listDir = array();
        if (!isset($dir)) return $listDir;

        if ($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if (is_file($dir . DS . $sub)) {
                        $this->addFile($dir . DS . $sub, str_replace($this->getTmpRootPath() . DS, "", $dir . DS . $sub));
                    }
                    elseif (is_dir($dir . DS . $sub)) {
                        $this->addDir(str_replace($this->getTmpRootPath() . DS, "", $dir . DS . $sub));
                        $listDir[$sub] = $this->createBundle($dir . "/" . $sub);
                    }
                }
            }
            closedir($handler);
        }
        return $listDir;
    }


    public function addDir($dirname, $fileComments = '')
    {
        if (substr($dirname, -1) != '/')
            $dirname .= '/';
        $this->addFile(false, $dirname, $fileComments);

        return $this;
    }

    public function addFile($filename, $cfilename, $fileComments = '', $data = false)
    {
        if (!($fh = &$this->fh))
            $fh = fopen($this->archiveFileName(), $this->overwrite ? 'wb' : 'a+b');

        // $filename can be a local file OR the data wich will be compressed
        if (substr($cfilename, -1) == '/') {
            $details['uncsize'] = 0;
            $data = '';
        }
        elseif (file_exists($filename)) {
            $details['uncsize'] = filesize($filename);
            $data = file_get_contents($filename);
        }
        elseif ($filename) {
            echo "<b>Cannot add $filename. File not found</b><br>";
            return false;
        }
        else {
            $details['uncsize'] = strlen($filename);
            // DATA is given.. use it! :|
        }

        // if data to compress is too small, just store it
        if ($details['uncsize'] < 256) {
            $details['comsize'] = $details['uncsize'];
            $details['vneeded'] = 10;
            $details['cmethod'] = 0;
            $zdata = &$data;
        }
        else {
            // otherwise, compress it
            $zdata = gzcompress($data);
            $zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug (thanks to Eric Mueller)
            $details['comsize'] = strlen($zdata);
            $details['vneeded'] = 10;
            $details['cmethod'] = 8;
        }

        $details['bitflag'] = 0;
        $details['crc_32'] = crc32($data);

        // Convert date and time to DOS Format, and set then
        $lastmod_timeS = str_pad(decbin(date('s') >= 32 ? date('s') - 32 : date('s')), 5, '0', STR_PAD_LEFT);
        $lastmod_timeM = str_pad(decbin(date('i')), 6, '0', STR_PAD_LEFT);
        $lastmod_timeH = str_pad(decbin(date('H')), 5, '0', STR_PAD_LEFT);
        $lastmod_dateD = str_pad(decbin(date('d')), 5, '0', STR_PAD_LEFT);
        $lastmod_dateM = str_pad(decbin(date('m')), 4, '0', STR_PAD_LEFT);
        $lastmod_dateY = str_pad(decbin(date('Y') - 1980), 7, '0', STR_PAD_LEFT);

        # echo "ModTime: $lastmod_timeS-$lastmod_timeM-$lastmod_timeH (".date("s H H").")\n";
        # echo "ModDate: $lastmod_dateD-$lastmod_dateM-$lastmod_dateY (".date("d m Y").")\n";
        $details['modtime'] = bindec("$lastmod_timeH$lastmod_timeM$lastmod_timeS");
        $details['moddate'] = bindec("$lastmod_dateY$lastmod_dateM$lastmod_dateD");

        $details['offset'] = ftell($fh);
        fwrite($fh, $this->zipSignature);
        fwrite($fh, pack('s', $details['vneeded'])); // version_needed
        fwrite($fh, pack('s', $details['bitflag'])); // general_bit_flag
        fwrite($fh, pack('s', $details['cmethod'])); // compression_method
        fwrite($fh, pack('s', $details['modtime'])); // lastmod_time
        fwrite($fh, pack('s', $details['moddate'])); // lastmod_date
        fwrite($fh, pack('V', $details['crc_32'])); // crc-32
        fwrite($fh, pack('I', $details['comsize'])); // compressed_size
        fwrite($fh, pack('I', $details['uncsize'])); // uncompressed_size
        fwrite($fh, pack('s', strlen($cfilename))); // file_name_length
        fwrite($fh, pack('s', 0)); // extra_field_length
        fwrite($fh, $cfilename); // file_name
        // ignoring extra_field
        fwrite($fh, $zdata);

        // Append it to central dir
        $details['external_attributes'] = (substr($cfilename, -1) == '/' && !$zdata) ? 16 : 32; // Directory or file name
        $details['comments'] = $fileComments;
        $this->appendCentralDir($cfilename, $details);
        $this->files_count++;

        return $this;
    }

    public function setExtra($filename, $property, $value)
    {
        $this->centraldirs[$filename][$property] = $value;
    }

    public function save($autoDownload = false, $zipComments = '')
    {
        if (!($fh = &$this->fh)) {
            $fh = fopen($this->archiveFileName(), $this->overwrite ? 'w' : 'a+');
        }
        $cdrec = "";
        foreach ($this->centraldirs as $filename => $cd) {
            $cdrec .= $this->dirSignature;
            $cdrec .= "\x0\x0"; // version made by
            $cdrec .= pack('v', $cd['vneeded']); // version needed to extract
            $cdrec .= "\x0\x0"; // general bit flag
            $cdrec .= pack('v', $cd['cmethod']); // compression method
            $cdrec .= pack('v', $cd['modtime']); // lastmod time
            $cdrec .= pack('v', $cd['moddate']); // lastmod date
            $cdrec .= pack('V', $cd['crc_32']); // crc32
            $cdrec .= pack('V', $cd['comsize']); // compressed filesize
            $cdrec .= pack('V', $cd['uncsize']); // uncompressed filesize
            $cdrec .= pack('v', strlen($filename)); // file comment length
            $cdrec .= pack('v', 0); // extra field length
            $cdrec .= pack('v', strlen($cd['comments'])); // file comment length
            $cdrec .= pack('v', 0); // disk number start
            $cdrec .= pack('v', 0); // internal file attributes
            $cdrec .= pack('V', $cd['external_attributes']); // internal file attributes
            $cdrec .= pack('V', $cd['offset']); // relative offset of local header
            $cdrec .= $filename;
            $cdrec .= $cd['comments'];
        }
        $before_cd = ftell($fh);
        fwrite($fh, $cdrec);

        // end of central dir
        fwrite($fh, $this->dirSignatureE);
        fwrite($fh, pack('v', 0)); // number of this disk
        fwrite($fh, pack('v', 0)); // number of the disk with the start of the central directory
        fwrite($fh, pack('v', $this->files_count)); // total # of entries "on this disk"
        fwrite($fh, pack('v', $this->files_count)); // total # of entries overall
        fwrite($fh, pack('V', strlen($cdrec))); // size of central dir
        fwrite($fh, pack('V', $before_cd)); // offset to start of central dir
        fwrite($fh, pack('v', strlen($zipComments))); // .zip file comment length
        fwrite($fh, $zipComments);

        fclose($fh);

        if ($autoDownload) {
            App::Helper('Utility')->download($this->archiveFileName());
        }
    }

    private function appendCentralDir($filename, $properties)
    {
        $this->centraldirs[$filename] = $properties;
    }
}
// END ZIP CLASS
// info@apprain.com