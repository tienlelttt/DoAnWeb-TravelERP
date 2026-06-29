<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\AppException;
use Illuminate\Http\JsonResponse;

// Module quản lý dữ liệu.
class UploadController extends Controller
{
    /**
     * Upload file và tr? v? Base64 Data URI
     */

    public function uploadFile(Request $request): JsonResponse
    {
        if (!$request->hasFile('file')) {
            throw AppException::badRequest("Không tìm th?y file ?? upload.");
        }

        $file = $request->file('file');
        
        if (!$file->isValid()) {
            throw AppException::badRequest("File upload không h?p l? ho?c b? l?i.");
        }

        try {
            $fileContent = file_get_contents($file->getRealPath());
            $mimeType = $file->getMimeType();
            
            if (!$mimeType) {
                $mimeType = "image/png";
            }

            $base64 = base64_encode($fileContent);
            $dataUri = "data:" . $mimeType . ";base64," . $base64;

            return response()->json([
                'url' => $dataUri
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Không th? l?u tr? file. Vui lòng th? l?i!", 0, $e);
        }
    }
}
