<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KlubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas['klub'] = Klub::get();
        return view('klub.index', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        try {

            $validator = Validator::make($request->all(),[
                'nama' => 'required',
                'kota' => 'required'
            ],[
                'nama.required' => 'Nama Klub tidak boleh kosong',
                'kota.required' => 'Kota Klub tidak boleh kosong'
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }else {
                $cekKlub = Klub::where('nama','LIKE','%'.$request->nama.'%')->first();
                if($cekKlub) {
                    return redirect()->back()->with('error', 'Klub sudah ada!');
                }

                $create = Klub::create($request->all());
                if($create) {
                    DB::commit();
                    return redirect()->back()->with('message', 'Data berhasil ditambahkan!');
                }
            }
        } catch(\Exception $e) {
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
        DB::beginTransaction();
        try {
            $data = Klub::find($id);
            if($data) {
                $data->delete();
                DB::commit();
                return redirect()->back()->with('message', 'Berhasil dihapus');
            }else{
                return redirect()->back()->with('error', 'Data tidak ada');
            }
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'error: '.$e->getMessage());
        }
    }
}
