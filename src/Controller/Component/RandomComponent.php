<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Filesystem\File;

/**
 * Random component
 */
class RandomComponent extends Component
{
    public function randomString($length = 8) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
    
    public function randomFileName($path, $prefix = '', $extension, $length = 8) {
        do {
            $filename = $prefix . $this->randomString($length);
            $file = new File($path . $filename);
        } while ($file->exists());
        return $filename . '.' . $extension;
    }
}