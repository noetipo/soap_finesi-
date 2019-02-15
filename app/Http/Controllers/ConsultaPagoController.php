<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultaPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($dni)
    {$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
<root>
     <dni>' . $dni . '
    </dni>
</root>';

        $headers = array(
            "Content-type: application/xml; charset=utf-8",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-length: " . strlen($xml_post_string),
        );
        $url = 'http://127.0.0.1:8000/consulta-pago/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode == 201) {
            $doc = new \DOMDocument();
            $doc->loadXML($response);
            if(isset($doc->getElementsByTagName('id')->item(0)->nodeValue)){
                $id_deposito=$doc->getElementsByTagName('id')->item(0)->nodeValue;
                $id_estudiante=$doc->getElementsByTagName('estudiante')->item(0)->nodeValue;
                $dni=$doc->getElementsByTagName('dni')->item(0)->nodeValue;
                $importe=$doc->getElementsByTagName('importe')->item(0)->nodeValue;
                $fecha_pago=$doc->getElementsByTagName('created_at')->item(0)->nodeValue;
                $datos_pago= new \stdClass();
                $datos_pago->id_deposito=$id_deposito;
                $datos_pago->estado_deposito='si';
                $datos_pago->id_estudiante=$id_estudiante;
                $datos_pago->dni=$dni;
                $datos_pago->importe=$importe;
                $datos_pago->fecha_pago=$fecha_pago;
                $jResponse['success'] = true;
                $jResponse['data'] = $datos_pago;
            }else{
                $datos_pago= new \stdClass();
                $datos_pago->estado_deposito='no existe deposito';
                $jResponse['success'] = false;
                $jResponse['data'] = $datos_pago;
            }

            return response()->json($jResponse, 201);

        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
