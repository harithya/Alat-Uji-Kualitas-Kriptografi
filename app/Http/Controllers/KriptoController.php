<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KriptoController extends Controller
{
    public $abjad;

    public function __construct()
    {
        $this->abjad = range('a', 'z');
    }

    public function index()
    {
        return view('welcome');
    }

    public function calculateChar($text)
    {
        $tmp = [];
        foreach ($text as $key => $value) {
            $tmp[$key]['value'] = array_search(strtolower($value), $this->abjad);
        }
        return $tmp;
    }

    public function calculateCorelation($x, $y)
    {
        if (count($x) !== count($y)) {
            return -1;
        }
        $x = array_values($x);
        $y = array_values($y);
        $xs = array_sum($x) / count($x);
        $ys = array_sum($y) / count($y);
        $a = 0;
        $bx = 0;
        $by = 0;
        for ($i = 0; $i < count($x); $i++) {
            $xr = $x[$i] - $xs;
            $yr = $y[$i] - $ys;
            $a += $xr * $yr;
            $bx += pow($xr, 2);
            $by += pow($yr, 2);
        }
        $b = sqrt($bx * $by);
        if ($b == 0) return 0;
        return $a / $b;
    }

    public function store(Request $request)
    {
        $plainText = str_split(preg_replace('/\s+/', '', $request->plaintext));
        $chipperText = str_split(preg_replace('/\s+/', '', $request->chippertext));

        $result = [
            'plainText' => $this->calculateChar($plainText),
            'chipperText' => $this->calculateChar($chipperText)
        ];

        dd($this->calculateCorelation($result['plainText'], $result['chipperText']));

        return view('result', compact('result'));
    }
}
