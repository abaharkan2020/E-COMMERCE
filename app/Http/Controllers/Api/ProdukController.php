<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Transformers\ProdukTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractal\Fractal;

class ProdukController extends Controller
{
    public function index()
    {
        $paginator = new Produk();
        if (request()->kategori) {
            $paginator = $paginator->where('kategori_id', request()->kategori);
        }
        if (request()->brand) {
            $paginator = $paginator->whereIn('brand_id', request()->brand);
        }
        $paginator = $paginator->paginate(12);
    	
    	$produk = $paginator->getCollection();

    	return Fractal::create()
		    ->collection($produk, new ProdukTransformer())
            ->parseIncludes('gambar')
            ->parseIncludes('brand')
		    // ->serializeWith(new JsonApiSerializer())
		    ->paginateWith(new IlluminatePaginatorAdapter($paginator))
		    ->toArray();
    }

    public function getByUrl($url)
    {
        $produk = Produk::where('kode', $url)->first();

        return Fractal::create()
            ->item($produk, new ProdukTransformer())
            ->parseIncludes('gallery');
    }




    public function show(Produk $produk)
    {
        return response()->json($produk);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode' => 'required|unique:produk',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'berat' => 'required',
            'warna' => 'required',
            'keterangan' => 'required',
            'brand_id' => 'required',
            'kategori_id' => 'required'
        ]);

        Produk::create($request->all());

        return response()->json([
            'title' => 'Created!',
            'message' => 'Data Berhasil Ditambahkan'
        ], 201);
    }

    public function update(Request $request, Produk $produk)
    {
        $this->validate($request, [
            'kode' => 'required',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'berat' => 'required',
            'warna' => 'required',
            'keterangan' => 'required',
            'brand_id' => 'required',
            'kategori_id' => 'required'
        ]);

        $produk->update($request->all());

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Data Berhasil Diubah'
        ], 201);
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Data Berhasil Dihapus'
        ], 201);
    }
}
