<?php

namespace App\Http\Controllers;

use App\Models\CourseGrant;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function mpesa(Request $request){

        $payment= new Payment();
        $payment->user_id=auth()->user()->id;
        $payment->amount=$request->amount;
        $payment->course_id= $request->course_id;
        $payment->phone_number='258'.$request->phone_number;
        $payment->status='PENDENTE';
        $payment->save();

        $valid=$this->validRequest($request);
        if($valid!="0"){
            $payment->status="ERRO_VALIDACAO";
            $payment->response=$valid;
            $payment->save();
            return response()->json($valid, 423);
        }

        $mpesa = new \Karson\MpesaPhpSdk\Mpesa();

        $mpesa->setApiKey(env('MPESA_API_KEY'));
        $mpesa->setPublicKey(env('MPESA_PUBLIC_KEY'));
        $mpesa->setEnv('test');

        $result = $mpesa->c2b('Expert'.$payment->id, '258'.$request->phone_number,
        $request->amount, 'ExpertCurso', env('SERVICECODE'));

        
        if($result->response->output_ResponseCode!='INS-0'){
            $payment->status='ERRO';
            $payment->response=json_encode($result);
            $payment->save();
            return response()->json('Pagamento falhou', 401);
        }

        $courseGrant = new CourseGrant();
        $courseGrant->user_id = auth()->user()->id;
        $courseGrant->course_id = $request->course_id;
        $token = Str::random(8);
        try {
            $courseGrant->token = $token;
            $courseGrant->save();
        } catch (QueryException $ex) {

            if (Str::contains($ex->getMessage(), 'course_grants_token_unique')) {
                $courseGrant->token = $token . Str::random(3);
                $courseGrant->save();
            }
        }

        $payment->status='SUCESSO';
        $payment->save();
        return response()->json($result);
    }

    private function composeValidReference (Request $request) {


    }
    private function validRequest($request){
        if (strlen($request->phone_number)!=9){
            return "Número Vodacom deve ter 9 dígitos";
        }

        if(substr($request->phone_number, 0, 2)!="84" && substr($request->phone_number, 0, 2)!="85"){
            return "Número vodacom deve iniciar por 84/85";
        }
        if($request->amount<=0){
            return "Erro ao gravar curso";
        }
      
        return "0";
    }

    public function getPaymentSucess(Request $request, $course_id){

        return response()->json(Payment::where('user_id', auth()->user()->id)->where('status', 'SUCESSO')
            ->where('course_id', $course_id)
            ->first());
    }
}
