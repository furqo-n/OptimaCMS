<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('page.admin.kontak.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = Kontak::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = Kontak::offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = Kontak::where('office', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalFiltered = Kontak::where('office', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $edit = route('kontak.edit', $post->id);

                $nestedData['office'] = $post->office;
                $nestedData['alamat'] = $post->alamat;
                $nestedData['no_hp'] = $post->no_hp;
                $nestedData['email'] = $post->email;
                $nestedData['options'] = "&emsp;<a href='{$edit}' title='EDIT' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                          &emsp;<a href='javascript:void(0)' data-id='{$post->id}' data-url='" . route('kontak.delete', $post->id) . "' title='DELETE' class='btn btn-danger btn-sm hapusData'><i class='fas fa-trash'></i></a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return response()->json($json_data);
    }

    public function tambahKontak(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'office' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
                'email' => 'required|email',
            ]);

            Kontak::create($request->all());

            return redirect()->route('kontak.index')->with('status', 'Data Kontak berhasil ditambahkan');
        }
        return view('page.admin.kontak.add');
    }

    public function ubahKontak(Request $request, $id)
    {
        $kontak = Kontak::findOrFail($id);
        if ($request->isMethod('post')) {
            $request->validate([
                'office' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
                'email' => 'required|email',
            ]);

            $kontak->update($request->all());
            return redirect()->route('kontak.index')->with('status', 'Data Kontak berhasil diubah');
        }
        return view('page.admin.kontak.edit', compact('kontak'));
    }

    public function hapusKontak($id)
    {
        Kontak::findOrFail($id)->delete();
        return response()->json(['msg' => 'Data Kontak berhasil dihapus']);
    }
}
