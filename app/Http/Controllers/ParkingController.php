<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Parking;
use DateTime;
use PhpParser\Node\Stmt\DeclareDeclare;

use PDF;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parkings = Parking::latest()->paginate(4);
        return view('parkings.index', compact('parkings'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('parkings.create');
    }

    public function checkTimeDiff($jenis_kendaraan, $hari, $jam, $menit, $detik)
    {

        $tarif = 0;

        // logic

        if ($jam > 0 && $menit > 0 || $detik > 0) {
            if ($jenis_kendaraan == 'Mobil') {
                $tarif = ($this->jam + 1) * '4000';
            } else {
                $tarif = ($jam + 1) * '2000';
            }
        } else if ($jam > 0) {
            if ($jenis_kendaraan == 'Mobil') {
                $tarif = $jam * '4000';
            } else {
                $tarif = $jam * ' 2000';
            }
        } else {
            if ($jenis_kendaraan == 'Mobil') {
                $tarif = '4000';
            } else {
                $tarif = ' 2000';
            }
        }

        return $tarif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // logic
        $request->validate([
        'plat_no_1' => 'required|min:1',
        'plat_no_2' => 'required|numeric|digits_between:1,4',
        'plat_no_3' => 'required|min:1|max:3'
        ]);

        $jamMasuk = new DateTime(Carbon::now());
        $jamKeluar = new DateTime($request->updated_at);
        $interval = $jamMasuk->diff($jamKeluar);
        $hari = $interval->format('%d');
        $bulan = $interval->format('%m');
        $tahun = $interval->format('%Y');
        $jam = $interval->format('%h');
        $menit = $interval->format('%i');
        $detik = $interval->format('%s');

        $parking = new Parking();

        $parking_cek = Parking::find($request->parking_id);

        if (is_null($parking_cek))
        {
            $kodeTerakhir = Parking::select('id')->orderBy('id', 'desc')->first();
            $cek = Parking::all();

            if (count($cek)<1)
            {
                 $hasilKode ='PC001' ;
            }
            else {

                $kode = $kodeTerakhir->id;
                if($kode > 99)
                {
                    $kode = $kode+1;
                    $hasilKode ='PC' . $kode ;
                }
                else if ($kode > 9)
                {
                    $kode = $kode+1;
                    $hasilKode ='PC0' . $kode;
                }
                else
                {
                    $kode = $kode+1;
                    $hasilKode ='PC00' . $kode ;
                }
            }

        }
        else
        {
             $hasilKode -> $request->kode_tiket;
        }

        
        $parking->id = $request->parking_id;
        $parking->kode_tiket = $hasilKode;
        $parking->created_at = Carbon::now();
        $parking->updated_at = $request->updated_at;
        $parking->jenis_kendaraan = $request->jenis_kendaraan;
        $parking->plat_no = $request->plat_no_1 . ' ' . $request->plat_no_2 . ' ' . $request->plat_no_3;
        $parking->plat_no_1 = $request->plat_no_1;
        $parking->plat_no_2 = $request->plat_no_2;
        $parking->plat_no_3 = $request->plat_no_3;
        $parking->durasi = $hari . ' hari ' . $jam . ' jam ' . $menit . ' menit ' . $detik . ' detik';

        $parking->tarif = $this->checkTimeDiff($jamKeluar, $hari, $bulan, $tahun, $jam, $menit, $detik);


        Parking::updateOrCreate(['id' => $parking->id],['kode_tiket' => $parking->kode_tiket, 'jenis_kendaraan' => $parking->jenis_kendaraan,'plat_no'=>$parking->plat_no,'plat_no_1'=>$request->plat_no_1,'plat_no_2'=>$request->plat_no_2,'plat_no_3'=>$request->plat_no_3, 'durasi'=> $parking->durasi, 'tarif'=> $parking->tarif, 'updated_at'=>$parking->updated_at ]);

        //$parking->save();

        if (empty($request->parking_id))
            $msg = 'Parking entry created successfully.';
        else
            $msg = 'Parking data is updated successfully';
        return redirect()->route('parkings.index')->with('success', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($kode_tiket)
    {
        // logic
        $parking = Parking::find($kode_tiket);
        return view('parkings.show', compact('parking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($kode_tiket)
    {
        $parking = Parking::find($kode_tiket);
        return response()->json($parking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_tiket)
    {
        /*$jamMasuk = new DateTime(Carbon::now());
        $jamKeluar = new DateTime($request->updated_at);
        $interval = $jamMasuk->diff($jamKeluar);
        $hari = $interval->format('%d');
        $bulan = $interval->format('%m');
        $tahun = $interval->format('%Y');
        $jam = $interval->format('%h');
        $menit = $interval->format('%i');
        $detik = $interval->format('%s');

        $parking = Parking::find($kode_tiket);

        $parking->updated_at = $request->updated_at;
        $parking->jenis_kendaraan = $request->jenis_kendaraan;
        $parking->plat_no = $request->plat_no_1 . ' ' . $request->plat_no_2 . ' ' . $request->plat_no_3;
        $parking->durasi = $hari . ' hari ' . $jam . ' jam ' . $menit . ' menit ' . $detik . ' detik';

        $parking->tarif = $this->checkTimeDiff($jamKeluar, $hari, $bulan, $tahun, $jam, $menit, $detik);
        $parking->save();

        if (empty($request->parking_id))
            $msg = 'Parking entry updated successfully.';
        else
            $msg = 'Parking data is updated successfully';
        return redirect()->route('parkings.index')->with('success', $msg);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //logic

        $parking = Parking::where('id',$id)->delete();
        return response()->json(['success'=>'Data  deleted successfully.']);
    }
}
