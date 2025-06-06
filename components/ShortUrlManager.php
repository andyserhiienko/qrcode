<?php 

namespace app\components;

use Yii;

class ShortUrlManager
{
	public function hash(): string
	{
		return Yii::$app->security->generateRandomString(6);
	}

	public function pathToFileDirectory(): string
	{
        $path = Yii::getAlias('@webroot/uploads/qr-codes/' . date('Y-m-d') . '/' . date('H'));

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        return $path;
	}

	public function saveToDirectory(string $fullFilePath,string $source): int|false
	{
		return file_put_contents($fullFilePath, $source);
	}

	public function shortLink(string $hash): string
	{
		return Yii::$app->request->hostInfo . "/lets/go/$hash"; 
	}

	public function relativePath(string $fullFilePath): string
	{
		return str_replace(Yii::getAlias('@webroot'), '', $fullFilePath);
	}

}