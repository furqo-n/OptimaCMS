<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KlienController extends Controller
{
    public function index()
    {
        return view('page.admin.klien.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = Klien::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = Klien::offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = Klien::where('nama', 'LIKE', "%{$search}%")
                ->orWhere('kategori', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalFiltered = Klien::where('nama', 'LIKE', "%{$search}%")
                ->orWhere('kategori', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $edit = route('klien.edit', $post->id);

                $nestedData['nama'] = $post->nama;
                $nestedData['kategori'] = $post->kategori;
                $nestedData['logo'] = '<img src="' . asset('storage/klien/' . $post->logo) . '" width="100px">';
                $nestedData['options'] = "&emsp;<a href='{$edit}' title='EDIT' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                          &emsp;<a href='javascript:void(0)' data-id='{$post->id}' data-url='" . route('klien.delete', $post->id) . "' title='DELETE' class='btn btn-danger btn-sm hapusData'><i class='fas fa-trash'></i></a>";
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

    public function tambahKlien(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'nama' => 'required',
                'kategori' => 'required',
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($image = $request->file('logo')) {
                $destinationPath = 'storage/klien/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['logo'] = "$profileImage";
            }

            Klien::create($input);

            return redirect()->route('klien.index')->with('status', 'Data Klien berhasil ditambahkan');
        }
        return view('page.admin.klien.add');
    }

    public function ubahKlien(Request $request, $id)
    {
        $klien = Klien::findOrFail($id);
        if ($request->isMethod('post')) {
            $request->validate([
                'nama' => 'required',
                'kategori' => 'required',
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($image = $request->file('logo')) {
                // Hapus logo lama
                if ($klien->logo) {
                    $oldPath = public_path('storage/klien/' . $klien->logo);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $destinationPath = 'storage/klien/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['logo'] = "$profileImage";
            } else {
                unset($input['logo']);
            }

            $klien->update($input);
            return redirect()->route('klien.index')->with('status', 'Data Klien berhasil diubah');
        }
        return view('page.admin.klien.edit', compact('klien'));
    }

    public function hapusKlien($id)
    {
        $klien = Klien::find($id);
        if ($klien->logo) {
            $oldPath = public_path('storage/klien/' . $klien->logo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        $klien->delete();
        return response()->json(['msg' => 'Data Klien berhasil dihapus']);
    }
}
