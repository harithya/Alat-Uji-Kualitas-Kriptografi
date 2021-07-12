<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MathPHP\Statistics\Correlation;

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
            $tmp[$key]['char'] = $value;
            $tmp[$key]['value'] = array_search(strtolower($value), $this->abjad);
        }
        return $tmp;
    }

    public function groupChar($data)
    {
        return collect($data)->groupBy(['char'])->map(function ($val, $key) {
            $tmp = [];
            $tmp['char'] = $key;
            $tmp['total'] = count($val);
            return $tmp;
        })->values();
    }

    public function store(Request $request)
    {
        $plainText = str_split(strtolower(preg_replace('/[^a-zA-Z]+/', '', $request->plaintext)));
        $chipperText = str_split(strtolower(preg_replace('/[^a-zA-Z]+/', '', $request->chippertext)));
        $result = [
            'plainText' => $this->calculateChar($plainText),
            'chipperText' => $this->calculateChar($chipperText),
        ];
        $array1 = collect($result['plainText'])->pluck('value')->toArray();
        $array2 = collect($result['chipperText'])->pluck('value')->toArray();
        $result['correlation'] = Correlation::r($array1, $array2);
        $result['chartPlainText'] = $this->groupChar($result['plainText']);
        $result['chartChipperText'] = $this->groupChar($result['chipperText']);
        return view('result', compact('result'));
    }
}
