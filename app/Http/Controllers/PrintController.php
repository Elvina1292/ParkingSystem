<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use PDF;

class PrintController extends Controller
{
    //

    // Generate PDF
    public function createPDF() {
      // retreive all records from db
      $data = Parking::all();

      // share data to view
      view()->share('parkings',$data);
      $pdf = PDF::loadView('parkings.parking_pdf', $data);

      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
    }
}
