<?php

class Utility {
    public function expandDirectory($dir, $prefix="") {
        echo "Inside Directory";
        echo "<table>";
        echo "<tr><th>Folder Name</th></tr>";
        echo "<tr><td>";
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    $extension = isset(pathinfo($file)['extension']) ? pathinfo($file)['extension'] : null;
                    if ($extension == 'txt') {
                        echo "<a href='download.php?fileName=$prefix$file'> $file </a><br />";
                        echo "<br>";
                    } else {
                        $results_array[] = $file;
                    }

                }
                closedir($dh);
            }
        }

        foreach ($results_array as $value) {
            if($value != "." && $value != ".." ){
                echo "<a href='show.php?fileName=$prefix$value'>$value  </a><br />";
            }
            
        }
        echo "</td></tr>";
        echo "</table>";
    }


    public function expandZipDirectory($dir, $prefix="") {
        // echo "Inside Zip Directory";
        // echo $dir;
        // echo $prefix;

        if($this->checkForZipDir($dir)) {
            //create a ZipArchive instance
            $zip = new ZipArchive;

            //open the archive
            if ($zip->open($dir) === TRUE) {
                //echo "Directory Opened";
                //iterate the archive files array and display the filename or each one
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    
                    $name = $zip->statIndex($i)['name'];
                    $extension = isset(pathinfo($name)['extension']) ? pathinfo($name)['extension'] : null;

                    if($extension == 'txt') {
                        $textFileNameArr = $this->getFileName($name);
                        $textFileName = $textFileNameArr[count($textFileNameArr)-1];

                        echo "<a href='download-zip.php?fileName=$prefix$textFileName'> $textFileName </a><br />";
                        echo "<br>";
                    }
                    // echo 'Filename: ' . $zip->statIndex($i)['name'] . '<br />';
                }
            }else {
                echo 'Failed to open the archive!';
            }
        }else {
            echo "Its not a Zipped Dir";
        }
    }

    public function getZipPath($path, $dir) {
        $pathArr = explode('/', $path);
        $pathArrLen = count($pathArr);
        $zipFound = FALSE;
        $zipPath = $dir;

        for($i = 0; $i < $pathArrLen; $i++) {
            if(!$zipFound) {
                if($this->endsWith($pathArr[$i], '.zip')) {
                    $zipFound = TRUE;   
                }

                $zipPath = $this->createPath($zipPath, $pathArr[$i]);
            }
        }

        if($zipFound) {
            return $zipPath;
        }else {
            return '';
        }    
    }

    public function getFileNameInZipDir($path) {
        $pathArr = explode('/', $path);
        $pathArrLen = count($pathArr);
        $file = '';

        if($pathArrLen >= 2 && $this->endsWith($pathArr[$pathArrLen - 2], '.zip')) {
            $file = $pathArr[$pathArrLen - 1];
        }

        return $file;
    }

    private function createPath($zipPath, $pathFragment) {
        $zipPath = $zipPath . '/' . $pathFragment;
        return $zipPath;
    }

    private function checkForZipDir($dir) {
        //check if $dir ends with .zip
        return $this->endsWith($dir, '.zip');
    }

    private function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    private function getFileName($name) {
        //split $name with '/'
        return explode('/', $name);
    }
}