<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Spatie\PdfToImage\Pdf;

class DocumentsController extends Controller
{
    public function showTerms()
    {
        $path = public_path('/docs/terms-and-conditions.pdf');

        if (!File::exists($path)) {
            abort(404, 'The terms and conditions file was not found.');
        }

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="terms-and-conditions.pdf"',
        ];

        return Response::make(File::get($path), 200, $headers);
    }
     public function showTermsAsImages()
    {
        // $pdfPath = public_path('/docs/terms-and-conditions.pdf');
        // $imagesDirectory = public_path('/docs/terms-images');

        // // Check if the images have already been converted
        // if (!File::isDirectory($imagesDirectory) || count(File::files($imagesDirectory)) == 0) {
        //     // Create the directory if it doesn't exist
        //     File::makeDirectory($imagesDirectory, 0755, true, true);

        //     // Convert the PDF to images (this may take time)
        //     try {
        //         $pdf = new Pdf($pdfPath);
        //         $pdf->saveAllPagesAsImages($imagesDirectory);
        //     } catch (\Exception $e) {
        //         // Handle the error (e.g., log it or show a message)
        //         abort(500, 'Could not convert PDF to images. Check if Ghostscript is installed.');
        //     }
        // }

        // // Get the paths of all the generated images
        // $imagePaths = File::files($imagesDirectory);
        // $images = collect($imagePaths)->map(function ($path) {
        //     return asset('/docs/terms-images/' . $path->getFilename());
        // });

        // Pass the image paths to a new view
        return view('terms-images');
    }
}
