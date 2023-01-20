<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Pengeluaran extends Controller
{
    public function index(){
        $pengeluaran = Http::withToken(session('token'))->get(Custom::APIPENGELUARAN)->object();
        if(isset($pengeluaran->result)){
            return redirect('/expToken');
        }
        // var_dump($pengeluaran);die;
        return view('content.pengeluaran.index',[
            'title' => 'Daftar Pengeluaran',
            'pengeluaran' => $pengeluaran
        ]);
    }

    public function add_data(Request $request){
        for($i=0;$i<count($request->waktu_transaksi);$i++){
            $arr = [
               'waktu_transaksi' => $request->waktu_transaksi[$i],
               'pengeluaran' =>$request->pengeluaran[$i],
               'perincian' =>$request->perincian[$i],
               'user_id' => session('id')
           ];

           $tambah = Http::withToken(session('token'))->post(Custom::APIPENGELUARAN,$arr)->object();
       };

       if(isset($tambah->status)){
        echo json_encode([
            'messages' => $tambah->message,
            'status' => $tambah->status
        ]);
    }else{
        echo json_encode([
            'result' => 0
        ]);
    }
       
    }

    public function hapus_data($id){
        $delete = Http::withToken(session('token'))->asForm()->delete(Custom::APIPENGELUARAN,['id' => $id])->object();

        if(isset($delete->result)){
            return redirect('/expToken');
        }

        if($delete->status == true){
            return redirect('/pengeluaran')->with('message', $delete->message);
        }else{
            return redirect('/pengeluaran')->with('error', $delete->message);
        }
    }

    public function getPengeluaranById($id){
        $pengeluaran = Http::withToken(session('token'))->get(Custom::APIPENGELUARAN, ['id' => $id])->object();
        if(isset($pengeluaran->result)){
            return redirect('/expToken');
        }
        echo json_encode($pengeluaran->pengeluaran[0]);
    }

    public function edit_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pengeluaran' =>$request->pengeluaran,
            'perincian' =>$request->perincian,
            'id' => $request->id,
            'user_id' => session('id')
        ];

        $edit = Http::withToken(session('token'))->put(Custom::APIPENGELUARAN, $data)->object();
        if(isset($edit->result)){
            return redirect('/expToken');
        }
        if($edit->status == true){
            return redirect('/pengeluaran')->with('message', $edit->message);
        }else{
            return redirect('/pengeluaran')->with('error', $edit->message);
        }
    }

    public function deleteSelectedData(Request $request){
        if($request->ajax()){
            
            // echo json_encode($request->ids);
            $delete = Http::withToken(session('token'))->asForm()->delete(Custom::APIPENGELUARAN,['selected' => $request->ids])->object();
            echo json_encode($delete);
        }
    }

    public function create(){
        $pengeluaran = Http::withToken(session('token'))->get(Custom::APIPENGELUARAN)->object();
        if(isset($pengeluaran->result)){
            return redirect('/expToken');
        }
        return view('content.pengeluaran.create',[
            'title' => "Tambah Data"
        ]);
    }
}
