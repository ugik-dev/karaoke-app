<?php

namespace App\Http\Controllers;

use App\Models\BankLagu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BankLaguController extends Controller
{
    //
    public function index()
    {
        $title = 'Kode Akun';
        // $accountCodes = AccountCode::all();
        return view('app.bank-lagu', compact('title'));
    }

    public function scan()
    {
        try {
            $files = File::allFiles(storage_path('app/public/bank-lagu'));
            // dd($files);
            // Jika kamu hanya ingin file di root sub-directory tanpa sub-sub-directory
            // $files = File::files(storage_path('app/public/genrelagu'));
            foreach ($files as $file) {
                $fl = explode('#', $file->getFilename());

                BankLagu::firstOrCreate([
                    'title' => $fl[0],
                    'artist' => $fl[1],
                    'country' => $fl[2],
                    'genre' => $fl[3],
                    'source' => 'scanner',
                    'year' => date('Y'),
                    'filename' => $file->getFilename(),
                    'path' => $file->getRelativePath()
                ]);
                // echo $file->getRelativePath() . '=>' . $file->getRelativePathname() . "<br>";
            }
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function survey(Request $request)
    {
        if ($request->ajax()) {
            $data =  BankLagu::select('surveys.*')
                // ->complete()
                ->latest();
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $searchValue = $request->input('search')['value'];
                $data = $data->filter($searchValue);
            }
            $data = $data->get();

            return DataTables::of($data)->addColumn('id', function ($data) {
                return $data->id;
            })->addColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d');
            })->addColumn('filename_span', function ($data) {
                return '
                      <a href="' . url('/bank-data') . '/' . $data->id . '" alt="Download" target="_blank" class="btn btn-info btn-download w-100"><i class="fa fa-download"></i></a>
                    ';
            })->rawColumns(['filename_span'])->make(true);
        }
        $refAgency = Agency::get();
        return view('panel.monitoring.survey', compact('request', 'refAgency'));
    }
}
