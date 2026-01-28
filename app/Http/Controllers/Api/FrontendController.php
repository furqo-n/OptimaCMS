<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use App\Models\Klien;
use App\Models\Teknologi;
use App\Models\Karir;
use App\Models\Kontak;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function getHomeData()
    {
        try {
            // Mengambil semua data yang dibutuhkan untuk landing page
            $data = [
                'portofolios' => Portofolio::latest()->get()->map(function ($item) {
                    $item->image_url = filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : asset('storage/portofolio/' . $item->image);
                    return $item;
                }),
                'kliens' => Klien::all()->map(function ($item) {
                    $item->logo_url = filter_var($item->logo, FILTER_VALIDATE_URL) ? $item->logo : asset('storage/klien/' . $item->logo);
                    return $item;
                }),
                'teknologis' => Teknologi::all()->map(function ($item) {
                    $item->logo_url = filter_var($item->logo, FILTER_VALIDATE_URL) ? $item->logo : asset('storage/teknologi/' . $item->logo);
                    return $item;
                }),
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getKarir()
    {
        try {
            $karir = Karir::latest()->get()->map(function ($item) {
                $item->gambar_url = filter_var($item->gambar, FILTER_VALIDATE_URL) ? $item->gambar : asset('storage/karir/' . $item->gambar);
                return $item;
            });

            return response()->json([
                'status' => 'success',
                'data' => $karir
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getKontak()
    {
        try {
            $kontak = Kontak::first();

            return response()->json([
                'status' => 'success',
                'data' => $kontak
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPortofolio()
    {
        try {
            $data = Portofolio::latest()->get()->map(function ($item) {
                $item->image_url = filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : asset('storage/portofolio/' . $item->image);
                return $item;
            });

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getKlien()
    {
        try {
            $data = Klien::all()->map(function ($item) {
                $item->logo_url = filter_var($item->logo, FILTER_VALIDATE_URL) ? $item->logo : asset('storage/klien/' . $item->logo);
                return $item;
            });

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTeknologi()
    {
        try {
            $data = Teknologi::all()->map(function ($item) {
                $item->logo_url = filter_var($item->logo, FILTER_VALIDATE_URL) ? $item->logo : asset('storage/teknologi/' . $item->logo);
                return $item;
            });

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
