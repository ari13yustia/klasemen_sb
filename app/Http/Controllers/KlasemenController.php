<?php

namespace App\Http\Controllers;

use App\Models\Klasemen;
use App\Models\KlasemenDetail;
use App\Models\Klub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class KlasemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $datas['data'] = Klub::get();

        $datas['data'] = Klub::with('klasemen_detail')->get()->map(function (Klub $klub) {

            $win = 0;
            $lose = 0;
            $draw = 0;
            $gm = 0;
            $gk = 0;
            $point = 0;
            foreach($klub->klasemen_detail as $row) { //ALL CLUBS KLASEMEN
                $opponent = KlasemenDetail::where('klasemen_id',$row->klasemen_id)
                ->where('klub_id','!=',$row->klub_id)->first(); // GET OPPONENT DATA
                if($row->skor > $opponent->skor){
                    $win += 1; //WIN + 1
                    $point += 3; //POINT + 3
                    $gm += $row->skor;
                }elseif($row->skor == $opponent->skor){
                    $draw += 1; //DRAW + 1
                    $point += 1; // POINT + 1
                }else{
                    $lose += 1; //LOSE + 1
                    $gk += $row->skor;
                }
            }

            return [
                'nama' => $klub->nama,
                'ma' => $klub->klasemen_detail->count(),
                'me' => $win,
                's' => $draw,
                'k' => $lose,
                'gm' => $gm,
                'gk' => $gk,
                'point' => $point,
            ];
        });

        return view('klasemen.index', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['klub'] = Klub::get();
        $datas['klasemen'] = Klasemen::orderBy('created_at','DESC')->get();
        return view('klasemen.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();


        for($i = 0; $i < count($request->klub1); $i++){
            if( $request->skor1[$i] == null || $request->skor2[$i] == null) {
                return redirect()->back()->with('error', 'Skor tidak boleh kosong!');
            }
        }

        try {
            for($i = 0; $i < count($request->klub1); $i++){
                $klub1 = $request->klub1[$i];
                $klub2 = $request->klub2[$i];
                $skor1 = $request->skor1[$i];
                $skor2 = $request->skor2[$i];

                if($klub1 == $klub2) {
                    return redirect()->back()->with('error', 'Klub tidak boleh sama dalam 1 klasemen!');
                }

                //CECK DATABASE
                $klasemens = Klasemen::get();
                foreach($klasemens as $klasemen) {
                    if(($klasemen->klasemen_detail->first()->klub_id == $klub1) && ($klasemen->klasemen_detail->last()->klub_id == $klub2)){
                        return redirect()->back()->with('error', 'Klasemen sudah ada!');
                    } else if (($klasemen->klasemen_detail->first()->klub_id == $klub2) && ($klasemen->klasemen_detail->last()->klub_id == $klub1)) {
                        return redirect()->back()->with('error', 'Klasemen sudah ada!');
                    }
                }

                $createKlasemen = new Klasemen();
                $createKlasemen->kode_klasemen = 'Kode';
                $createKlasemen->save();

                if($createKlasemen) {
                    $createKlasemen->kode_klasemen = strtotime(Carbon::now()).$klub1.$klub2.$skor1.$skor2.$createKlasemen->id;
                    $createKlasemen->save();

                    for($u = 1; $u <= 2; $u++){
                        $createKlasemenDetail = new KlasemenDetail();
                        $createKlasemenDetail->klasemen_id = $createKlasemen->id;
                        $createKlasemenDetail->klub_id = ${'klub'.$u};
                        $createKlasemenDetail->skor = ${'skor'.$u};
                        $createKlasemenDetail->save();
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('message', 'Berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'error: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
