<?php

declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\ORM\Behavior;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\Utility\Security;
use Intervention\Image\ImageManagerStatic as Image;
use Cake\Core\Configure;

/**
 * Base64FileUpload behavior
 */
class Base64FileUploadBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'origin_field' => 'file',
        'dest_field' => 'file_path',
        'path' => 'uploads',
    ];

    public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
    {
        $originField = $this->getConfig('origin_field');
        $destField = $this->getConfig('dest_field');
        if ($entity->has($originField) && $entity->get($originField)) {
            $filePath = $this->saveBase64File($entity->get($originField));
            $entity->set($destField, $filePath);
        }
    }

    protected function saveBase64File($base64File)
    {
        $path = STORAGE_PATH . $this->getConfig('path');

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $base64FileString = preg_replace('#^data:image/\w+;base64,#i', '', $base64File);
        $fileData = base64_decode($base64FileString);

        $filename = Security::hash(time() . rand()) . '.png';
        $filePath = $path . DS . $filename;

        $image = Image::make($fileData);

        $imageResizeWidth = Configure::read('ImageResizeWidth');
        $image->resize($imageResizeWidth, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save($filePath);

        return $this->getConfig('path') . DS . $filename;
    }
}
