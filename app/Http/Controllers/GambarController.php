<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GambarController extends Controller
{
    public function index()
    {
        return view('page.admin.image.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = Gambar::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = Gambar::offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = Gambar::where('kategori', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalFiltered = Gambar::where('kategori', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                // Assuming we will create edit route later or if it exists
                // For now, based on menu image logic.
                // The user only asked to continue the menu.
                // I should probably create edit view as well if I want full CRUD.
                // But let's stick to what's requested explicitly or implicitly.
                // The index view has 'options' which includes edit button.
                $edit = route('gambar.edit', $post->id);

                // Check if image is a full URL (Cloudinary) or local path
                $imageUrl = filter_var($post->gambar, FILTER_VALIDATE_URL) ? $post->gambar : asset('storage/gambar/' . $post->gambar);

                $nestedData['id'] = $post->id;
                $nestedData['kategori'] = $post->kategori;
                $nestedData['gambar'] = '<img src="' . $imageUrl . '" width="100px">';
                $nestedData['options'] = "&emsp;<a href='{$edit}' title='EDIT' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                          &emsp;<a href='javascript:void(0)' data-id='{$post->id}' data-url='" . route('gambar.delete', $post->id) . "' title='DELETE' class='btn btn-danger btn-sm hapusData'><i class='fas fa-trash'></i></a>";
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

    public function tambahGambar(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'kategori' => 'required',
                'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($request->hasFile('gambar')) {
                try {
                    $image = $request->file('gambar');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'gambar',
                    ]);
                    $input['gambar'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['gambar' => 'Upload failed. Please check logs.']);
                }
            }

            Gambar::create($input);

            return redirect()->route('gambar.index')->with('status', 'Data Gambar berhasil ditambahkan');
        }
        return view('page.admin.image.add');
    }

    public function ubahGambar(Request $request, $id)
    {
        $gambar = Gambar::findOrFail($id);
        if ($request->isMethod('post')) {
            $request->validate([
                'kategori' => 'required',
                'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($request->hasFile('gambar')) {
                try {
                    $image = $request->file('gambar');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'gambar',
                    ]);
                    $input['gambar'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed (Edit): ' . $e->getMessage());
                    return redirect()->back()->withErrors(['gambar' => 'Upload failed. Please check logs.']);
                }
            } else {
                unset($input['gambar']);
            }

            $gambar->update($input);
            return redirect()->route('gambar.index')->with('status', 'Data Gambar berhasil diubah');
        }
        return view('page.admin.image.edit', compact('gambar'));
    }

    public function hapusGambar($id)
    {
        $gambar = Gambar::find($id);
        // Cloudinary deletion not implemented, same as Portofolio
        $gambar->delete();
        return response()->json(['msg' => 'Data Gambar berhasil dihapus']);
    }
}
