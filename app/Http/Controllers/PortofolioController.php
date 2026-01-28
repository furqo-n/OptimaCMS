<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        return view('page.admin.portofolio.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = Portofolio::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $posts = Portofolio::offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = Portofolio::where('title', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%")
                ->orWhere('kategori_produk', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalFiltered = Portofolio::where('title', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%")
                ->orWhere('kategori_produk', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show = route('portofolio.edit', $post->id);
                $edit = route('portofolio.edit', $post->id);

                // Check if image is a full URL (Cloudinary) or local path
                $imageUrl = filter_var($post->image, FILTER_VALIDATE_URL) ? $post->image : asset('storage/portofolio/' . $post->image);

                $nestedData['title'] = $post->title;
                $nestedData['category'] = $post->category;
                $nestedData['category_produk'] = $post->kategori_produk;
                $nestedData['deskripsi_panjang'] = substr(strip_tags($post->deskripsi_panjang), 0, 100) . "...";
                $nestedData['tools_pengembangan'] = $post->tools_pengembangan;
                $nestedData['deskripsi_keunggulan_singkat'] = $post->deskripsi_keunggulan_singkat;
                $advantages = is_array($post->advantages) ? $post->advantages : json_decode($post->advantages, true);
                $nestedData['advantages'] = implode(', ', array_column($advantages ?? [], 'text'));
                $nestedData['image'] = '<img src="' . $imageUrl . '" width="100px">';
                $nestedData['options'] = "&emsp;<a href='{$edit}' title='EDIT' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                          &emsp;<a href='javascript:void(0)' data-id='{$post->id}' data-url='" . route('portofolio.delete', $post->id) . "' title='DELETE' class='btn btn-danger btn-sm hapusData'><i class='fas fa-trash'></i></a>";
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

    public function tambahPortofolio(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required',
                'category' => 'required',
                'kategori_produk' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'portofolio',
                    ]);
                    $input['image'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['image' => 'Upload failed. Please check logs.']);
                }
            }

            Portofolio::create($input);

            return redirect()->route('portofolio.index')->with('status', 'Data berhasil ditambahkan');
        }
        return view('page.admin.portofolio.add');
    }

    public function ubahPortofolio(Request $request, $id)
    {
        $portofolio = Portofolio::findOrFail($id);
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required',
                'category' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($request->hasFile('image')) {
                // Delete old image if it exists and is not a URL (optional, or rely on clean up later)
                // For Cloudinary, we might want to delete by public ID, but secure URL doesn't directly map to it simply.
                // For now, simpler to just upload the new one.

                try {
                    $image = $request->file('image');
                    $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'portofolio',
                    ]);
                    $input['image'] = $result->getSecurePath();
                } catch (\Exception $e) {
                    \Log::error('Cloudinary Upload Failed (Edit): ' . $e->getMessage());
                    return redirect()->back()->withErrors(['image' => 'Upload failed. Please check logs.']);
                }
            } else {
                unset($input['image']);
            }

            $portofolio->update($input);
            return redirect()->route('portofolio.index')->with('status', 'Data berhasil diubah');
        }
        return view('page.admin.portofolio.edit', compact('portofolio'));
    }

    public function hapusPortofolio($id)
    {
        $portofolio = Portofolio::find($id);
        // Note: Deleting from Cloudinary would require storing the Public ID. 
        // Current implementation stores URL. We'll skip deletion for now or user can implement later.
        $portofolio->delete();
        return response()->json(['msg' => 'Data berhasil dihapus']);
    }
}
