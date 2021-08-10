<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadFormLogo extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageLogo;

    public function rules()
    {
        return [
            [['imageLogo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 5, 'tooBig' => 'Debe ingresar una imagen menor a 5MB'],
        ];
    }

    public function upload($folder = null)
    {
        if ($this->validate()) {
            if ($folder != null) {
                $path = '../web/eventos/images/logos/' . $folder;
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                };
                $this->imageLogo->saveAs($path . '/' . $this->imageLogo->baseName . '.' . $this->imageLogo->extension);
            } else {
                $this->imageLogo->saveAs('../web/eventos/images/logos/' . $this->imageLogo->baseName . '.' . $this->imageLogo->extension);
            }

            return true;
        } else {
            return false;
        }
    }
}
