<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Datas;
use App\Models\Prediction;
use App\Models\Ai_model;

class RealTimeController extends Controller
{

    public function index(): View
    {
        $model = Ai_model::all();

        return view('realtime.data', [
            'models' => $model,
            'option' => '',
        ]);
    } 

    public function rtdata(Request $request): String
    {
        $rts = Datas::orderBy('data_id', 'desc')->first();
        
        return json_encode([
            'rts' => $rts,
        ]);
    }

    public function option(Request $request): String
    {
        $id = $request->option;
        if($id == null){
            $pred = Prediction::where('fk_model_id', '=', 1)->orderBy('added_on', 'desc')->first();
        }
        else{
            $pred = Prediction::where('fk_model_id', '=', $id)->orderBy('added_on', 'desc')->first();
        }
        
        return json_encode([
            'pred' => $pred,
        ]);
    }

    public function predictData(Request $request): String
    {
        $model = Ai_model::all();
        $id = $request->option;

        if($id == ''){
            $pred = Prediction::where('fk_model_id', '=', 1)->orderBy('added_on', 'desc')->first();
            $option = '';
        }
        else{
            $pred = Prediction::where('fk_model_id', '=', $id)->orderBy('added_on', 'desc')->first();
            $option = $id;
        }

        return view('realtime.data', [
            'pred' => $pred,
            'models' => $model,
            'option' => $option,
        ]);
    }
}

