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
            $tmp[$key] = array_search(strtolower($value), $this->abjad);
        }
        return $tmp;
    }

    public function store(Request $request)
    {
        $plainText = str_split(preg_replace('/\s+/', '', $request->plaintext));
        $chipperText = str_split(preg_replace('/\s+/', '', $request->chippertext));

        $result = [
            'plainText' => $this->calculateChar($plainText),
            'chipperText' => $this->calculateChar($chipperText)
        ];

        // dd(Correlation::r($result['plainText'], $result['chipperText']));
        return view('result', compact('result'));
    }
}
