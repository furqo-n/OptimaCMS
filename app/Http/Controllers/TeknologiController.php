<?php

namespace App\Http\Controllers;

use App\Models\Teknologi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeknologiController extends Controller
{
    public function index()
    {
        return view('page.admin.teknologi.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = Teknologi::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = Teknologi::offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = Teknologi::where('nama', 'LIKE', "%{$search}%")
                ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalFiltered = Teknologi::where('nama', 'LIKE', "%{$search}%")
                ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $edit = route('teknologi.edit', $post->id);

                // Check if image is a full URL (Cloudinary) or local path
                $logoUrl = filter_var($post->logo, FILTER_VALIDATE_URL) ? $post->logo : asset('storage/teknologi/' . $post->logo);

                $nestedData['nama'] = $post->nama;
                $nestedData['deskripsi'] = $post->deskripsi;
                $nestedData['logo'] = '<img src="' . $logoUrl . '" width="100px">';
                $nestedData['options'] = "&emsp;<a href='{$edit}' title='EDIT' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                          &emsp;<a href='javascript:void(0)' data-id='{$post->id}' data-url='" . route('teknologi.delete', $post->id) . "' title='DELETE' class='btn btn-danger btn-sm hapusData'><i class='fas fa-trash'></i></a>";
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

    public function tambahTeknologi(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'nama' => 'required',
                'deskripsi' => 'required',
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($request->hasFile('logo')) {
                try {
                    $image = $request->file('logo');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'teknologi',
                    ]);
                    $input['logo'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['logo' => 'Upload failed. Please check logs.']);
                }
            }

            Teknologi::create($input);

            return redirect()->route('teknologi.index')->with('status', 'Data Teknologi berhasil ditambahkan');
        }
        return view('page.admin.teknologi.add');
    }

    public function ubahTeknologi(Request $request, $id)
    {
        $teknologi = Teknologi::findOrFail($id);
        if ($request->isMethod('post')) {
            $request->validate([
                'nama' => 'required',
                'deskripsi' => 'required',
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($request->hasFile('logo')) {
                try {
                    $image = $request->file('logo');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'teknologi',
                    ]);
                    $input['logo'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed (Edit): ' . $e->getMessage());
                    return redirect()->back()->withErrors(['logo' => 'Upload failed. Please check logs.']);
                }
            } else {
                unset($input['logo']);
            }

            $teknologi->update($input);
            return redirect()->route('teknologi.index')->with('status', 'Data Teknologi berhasil diubah');
        }
        return view('page.admin.teknologi.edit', compact('teknologi'));
    }

    public function hapusTeknologi($id)
    {
        $teknologi = Teknologi::find($id);
        // Cloudinary deletion skipped for now
        $teknologi->delete();
        return response()->json(['msg' => 'Data Teknologi berhasil dihapus']);
    }
}
