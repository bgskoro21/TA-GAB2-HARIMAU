<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class Pemasukkan extends Controller
{
    public function index(){
        $pemasukkan = Http::withToken(session('token'))->get(Custom::APIPEMASUKKAN)->object();
        if(isset($pemasukkan->result)){
            return redirect('/expToken');
        }
        // var_dump($pemasukkan);die;
        return view('content.pemasukkan.index',[
            'title' => 'Daftar Pemasukkan',
            'pemasukkan' => $pemasukkan,
        ]);
    }

    public function add_data(Request $request){
        for($i=0;$i<count($request->waktu_transaksi);$i++){
             $arr = [
                'waktu_transaksi' => $request->waktu_transaksi[$i],
                'pemasukkan' =>$request->pemasukkan[$i],
                'perincian' =>$request->perincian[$i],
                'user_id' => session('id')
            ];

            $tambah = Http::withToken(session('token'))->post(Custom::APIPEMASUKKAN,$arr)->object();
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
        $delete = Http::withToken(session('token'))->asForm()->delete(Custom::APIPEMASUKKAN,['id' => $id])->object();
        if(isset($delete->result)){
            return redirect('/expToken');
        }
        if($delete->status == true){
            return redirect('/pemasukkan')->with('message', $delete->message);
        }else{
            return redirect('/pemasukkan')->with('error', $delete->message);
        }
    }

    public function getPemasukkanById($id){
        $pemasukkan = Http::withToken(session('token'))->get(Custom::APIPEMASUKKAN, ['id' => $id])->object();
        if(isset($pemasukkan->result)){
            echo json_encode($pemasukkan);
        }else{
            echo json_encode($pemasukkan->pendapatan[0]);
        }
    }

    public function edit_data(Request $request){
        $data = [
            'waktu_transaksi' => $request->waktu_transaksi,
            'pemasukkan' =>$request->pemasukkan,
            'perincian' =>$request->perincian,
            'id' => $request->id,
            'user_id' => session('id')
        ];
        
        $edit = Http::withToken(session('token'))->put(Custom::APIPEMASUKKAN, $data)->object();
        if(isset($edit->result)){
            return redirect('/expToken');
        }
        // var_dump($edit);die;
        if($edit->status == true){
            return redirect('/pemasukkan')->with('message', $edit->message);
        }else{
            return redirect('/pemasukkan')->with('error', $edit->message);
        }
    }

    public function deleteSelectedData(Request $request){
        if($request->ajax()){
            
            // echo json_encode($request->ids);
            $delete = Http::withToken(session('token'))->asForm()->delete(Custom::APIPEMASUKKAN,['selected' => $request->ids])->object();
            echo json_encode($delete);
        }
    }

    public function set_session(Request $request){
        if($request->status == true){
            if(isset($request->route)){
                return redirect('/pengeluaran')->with('message',$request->messages);
            }
            return redirect('/pemasukkan')->with('message',$request->messages);
        }else{
            return redirect('/pemasukkan')->with('error',$request->messages);
        }
    }

    public function create(){
        $pemasukkan = Http::withToken(session('token'))->get(Custom::APIPEMASUKKAN)->object();
        if(isset($pemasukkan->result)){
            return redirect('/expToken');
        }
        return view('content.pemasukkan.create',[
            'title' => "Tambah Data"
        ]);
    }
}
