<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class FormUploadImg extends Model
{
    /**
     * @var UploadedFile|UploadedFile[]
     */
    public $file;

    public function rules()
    {
        return [
            [
                'file',
                'file',
                'skipOnEmpty' => false,
                'uploadRequired' => 'No has seleccionado ningún archivo',
                'extensions' => ['jpg', 'png', 'jpeg', 'gif', 'webp'],
                'maxSize' => 250 * 1024, // 250 KB
                'tooBig' => 'El tamaño máximo permitido es 250 KB',
                'minSize' => 10,
                'tooSmall' => 'El tamaño mínimo permitido son 10 bytes',
                'maxFiles' => 1,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Seleccionar imagen',
        ];
    }

    /**
     * Guarda la imagen y retorna la ruta
     */
    public function upload($path, $baseName)
    {
        if (!$this->validate()) {
            return false;
        }

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = strtolower(preg_replace('/\s+/', '-', $baseName))
            . '-' . time()
            . '.' . $this->file->extension;

        $fullPath = $path . $fileName;

        if ($this->file->saveAs($fullPath)) {
            return $fileName;
        }

        return false;
    }

    public function uploadAndReplace($oldFilePath = null, $id = null)
    {
        if ($this->validate()) {
            $rutFile = Yii::getAlias('@webroot') . '/archivos/' . $oldFilePath;
           
            if ($oldFilePath && file_exists($rutFile)) {
                // Eliminar archivo anterior
                unlink($rutFile);
            }
            $newFilePath = 'contrato-' . $id . '-'. time() . '.' . $this->file->extension;
            $this->file->saveAs('archivos/'.$newFilePath);

            return $newFilePath;
        }
        return false;
    }

}
