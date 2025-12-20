<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelOperator;
use App\Models\ModelWO;
use Illuminate\Http\Request;

class ControllerOperator extends Controller
{
    //
    public function OperatorHome(){
        $operatorget = [
            'operator'=>ModelOperator::all()
        ];
        return view('Admin.Operator.operatorhome', $operatorget);
    }

    public function Operatoraddform(){
        return view('Admin.Operator.operatoradd');
    }

    public function OperatorAdd(Request $request){
        // return $request->all();
        ModelOperator::create([
            // 'id'=>$request->id,
            'nama_operator'=>$request->namaoperator,
        ]);

        return redirect()->route('OperatorHome')->with('msgdone','');
    }


    public function ToolsOperator(Request $request){
        // return $request->all();
        $idoperator = $request->idOperator;

        if($request->has('detail')){

              $datawo = [
                    'woget' => ModelWO::where(function ($q) use ($idoperator) {
                            $q->where('id_operatorcetak', $idoperator)
                            ->orWhere('id_operatorpotong', $idoperator)
                            ->orWhere('id_operatorproduksi', $idoperator);
                        })
                        ->with('wocetak')
                        ->with('wopotong')
                        ->with('woproduksi')
                        ->get(),

                    'idoperator' => $idoperator
                ];

        

             return view('Admin.Operator.operatordetail', $datawo);
        }
       
        elseif($request->has('hapus')){
            ModelOperator::where('id',$idoperator)->delete();
            return redirect()->route('OperatorHome')->with('msgdone','');
        }
    }
}
