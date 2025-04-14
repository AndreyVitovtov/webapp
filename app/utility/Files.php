<?php

namespace App\Utility;

class Files
{
	public static function saveImage($name, $path, &$instance, $errorRedirect): void
	{
		if (!empty($_FILES[$name]['name'])) {
			$errors = [];
			$fileName = $_FILES[$name]['name'];
			$fileSize = $_FILES[$name]['size'];
			$fileTmp = $_FILES[$name]['tmp_name'];
			$fileExt = explode('.', $fileName);
			$fileExt = strtolower(end($fileExt));
			$fileName = md5(time()) . '.' . $fileExt;
			$extensions = EXTENSIONS_IMAGES;

			if (in_array($fileExt, $extensions) === false) {
				redirect($errorRedirect, [
					'error' => __('extension not allowed', [
						'extensions' => implode(', ', EXTENSIONS_IMAGES)
					])
				]);
				exit;
			}

			if ($fileSize > (MAX_SIZE_IMAGES * 1024 * 1024)) {
				redirect($errorRedirect, [
					'error' => __('file size must be less', [
						'mb' => MAX_SIZE_IMAGES
					])
				]);
				exit;
			}

			if (empty($errors)) {
				if (move_uploaded_file($fileTmp, 'app/assets/images/' . $path . $fileName)) {
					$instance->$name = $fileName;
				} else {
					redirect($errorRedirect, [
						'error' => __('failed to upload file')
					]);
					exit;
				}
			} else {
				redirect($errorRedirect, [
					'error' => $errors
				]);
				exit;
			}
		}
	}
}