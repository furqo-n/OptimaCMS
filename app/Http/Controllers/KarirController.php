<?php

namespace App\Http\Controllers;

use App\Models\Karir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KarirController extends Controller
{
    public function index()
    {
        return view('page.admin.karir.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = Karir::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = Karir::offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = Karir::where('nama', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalFiltered = Karir::where('nama', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $edit = route('karir.edit', $post->id);

                $nestedData['nama'] = $post->nama;
                $nestedData['gambar'] = '<img src="' . asset('storage/karir/' . $post->gambar) . '" width="100px">';
                $nestedData['options'] = "&emsp;<a href='{$edit}' title='EDIT' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                          &emsp;<a href='javascript:void(0)' data-id='{$post->id}' data-url='" . route('karir.delete', $post->id) . "' title='DELETE' class='btn btn-danger btn-sm hapusData'><i class='fas fa-trash'></i></a>";
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

    public function tambahKarir(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'nama' => 'required',
                'jobdesk' => 'required',
                'kualifikasi' => 'required|array',
                'benefit' => 'nullable|array',
                'kontak' => 'nullable|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($image = $request->file('gambar')) {
                $destinationPath = 'storage/karir/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['gambar'] = "$profileImage";
            }

            Karir::create($input);

            return redirect()->route('karir.index')->with('status', 'Data Karir berhasil ditambahkan');
        }
        return view('page.admin.karir.add');
    }

    public function ubahKarir(Request $request, $id)
    {
        $karir = Karir::findOrFail($id);
        if ($request->isMethod('post')) {
            $request->validate([
                'nama' => 'required',
                'jobdesk' => 'required',
                'kualifikasi' => 'required|array',
                'benefit' => 'nullable|array',
                'kontak' => 'nullable|string',
                'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($image = $request->file('gambar')) {
                // Hapus gambar lama
                if ($karir->gambar) {
                    $oldPath = public_path('storage/karir/' . $karir->gambar);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $destinationPath = 'storage/karir/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['gambar'] = "$profileImage";
            } else {
                unset($input['gambar']);
            }

            $karir->update($input);
            return redirect()->route('karir.index')->with('status', 'Data Karir berhasil diubah');
        }
        return view('page.admin.karir.edit', compact('karir'));
    }

    public function hapusKarir($id)
    {
        $karir = Karir::find($id);
        if ($karir->gambar) {
            $oldPath = public_path('storage/karir/' . $karir->gambar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        $karir->delete();
        return response()->json(['msg' => 'Data Karir berhasil dihapus']);
    }
}
