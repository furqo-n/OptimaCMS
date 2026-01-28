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

                // Check if image is a full URL (Cloudinary) or local path
                $logoUrl = filter_var($post->logo, FILTER_VALIDATE_URL) ? $post->logo : asset('storage/klien/' . $post->logo);

                $nestedData['nama'] = $post->nama;
                $nestedData['kategori'] = $post->kategori;
                $nestedData['logo'] = '<img src="' . $logoUrl . '" width="100px">';
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

            if ($request->hasFile('logo')) {
                try {
                    $image = $request->file('logo');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'klien',
                    ]);
                    $input['logo'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['logo' => 'Upload failed. Please check logs.']);
                }
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

            if ($request->hasFile('logo')) {
                try {
                    $image = $request->file('logo');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'klien',
                    ]);
                    $input['logo'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed (Edit): ' . $e->getMessage());
                    return redirect()->back()->withErrors(['logo' => 'Upload failed. Please check logs.']);
                }
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
        // Cloudinary deletion skipped for now
        $klien->delete();
        return response()->json(['msg' => 'Data Klien berhasil dihapus']);
    }
}
