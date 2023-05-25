<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->validate(["short" => "string"]);

        return Inertia::render(
            "Index",
            $data
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "full" => "required|url|string",
        ]);
        $shortUrl = ShortUrl::create($data);
        $short = $this->base62Encode($shortUrl->id);
        $shortUrl->update(["short" => $short]);
        return response()->json(['short' => route('shortner.show', ['short' =>  $short])]);
    }

    public function base62Encode($num, $b = 62)
    {
        $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $r = $num % $b;
        $res = $base[$r];
        $q = floor($num / $b);
        while ($q) {
            $r = $q % $b;
            $q = floor($q / $b);
            $res = $base[$r] . $res;
        }
        return $res;
    }

    public function base62_decode($str, $b = 62)
    {
        $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $limit = strlen($str);
        $res = strpos($base, substr($str, 0, 1));
        for ($i = 1; $i < $limit; $i++) {
            $res = $b * $res + strpos($base, substr($str, $i, 1));
        }
        return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $short)
    {
        $shortUrl = ShortUrl::where("short", $short)->first();
        if (!$shortUrl) {
            return redirect()->to(route("home"));
        }
        return redirect()->to($shortUrl->full);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
