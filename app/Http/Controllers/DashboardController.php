<?php

namespace App\Http\Controllers;

use App\Models\BankLagu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Yajra\DataTables\Datatables;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{

    public function app(Request $request)
    {
        $title = 'Dashboard';
        return view('app.app', compact('title'));
    }
    public function play(Request $request, BankLagu $music)
    {
        $music->total_play++;
        $music->save(); // Save the updated play count
        $encodedFilename = urlencode($music->filename);
        return response()->json([
            'videoHtml' => '<video id="videoPlayer" width="600"  controls autoplay>
                                <source id="videoSource" src="' . url('storage/bank-lagu/' . $encodedFilename) . '" type="video/mp4">
                            </video>'
        ]);
    }
    public function search(Request $request)
    {

        if ($request->ajax()) {
            $data =  BankLagu::latest()->get();
            // if ($request->has('search') && !empty($request->input('search')['value'])) {
            //     $searchValue = $request->input('search')['value'];
            //     $data = $data->where('heroes.text_1', 'like', '%' . $searchValue . '%')
            //         ->orWhere('button_text', 'like', '%' . $searchValue . '%')
            //         ->orWhere('text_2', 'like', '%' . $searchValue . '%');
            // }
            // $data = $data->leftJoin('contents', function ($join) {
            //     $join->on('heroes.key', '=', 'contents.id')
            //         ->where('heroes.button_type', '=', 'content');
            // })
            //     ->leftJoin('menus', function ($join) {
            //         $join->on('heroes.key', '=', 'menus.id')
            //             ->where('heroes.button_type', '=', 'page');
            //     })
            //     ->select('heroes.*', DB::raw('IF(heroes.button_type = "content", contents.judul, menus.name) AS key_label'))
            //     ->get();
            // $data = $data->get();

            return DataTables::of($data)->addColumn('id', function ($data) {
                return $data->id;
            })->addColumn('number', function ($data) {
                return $data->number;
            })->addColumn('text_1', function ($data) {
                return $data->text_1;
            })->addColumn('text_2', function ($data) {
                return $data->text_2;
            })->addColumn('button', function ($data) {
                return $data->button;
            })->addColumn('img', function ($data) {
                return '<img style="max-width:100px; max-height:80px" src="' . url('/upload/hero') . '/' . $data->image . '" alt="' . $data->image . '" class="img-thumbnail">';
            })->addColumn('aksi', function ($data) {
                return '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="edit-btn btn btn-warning" data-id="' . $data->id . '"><i class="fas fa-pencil-alt" ></i></button>
                <button type="button" class="delete-btn btn btn-danger" data-id="' . $data->id . '"><i class="fas fa-trash" ></i></button>
            </div>';
            })->rawColumns(['aksi', 'img'])->make(true);
        }
    }

    public function index(Request $request)
    {
        if (!empty($request->year)) {
            $year = $request->year;
        } else {
            $year = date('Y');
        }
        $title = 'Dashboard';

        return view('app.dashboard', compact('title'));
    }
}
