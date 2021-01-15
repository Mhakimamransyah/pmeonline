<?php

namespace App\LittleFlower;


use App\v3\Package;

class SubmitAdapter
{
    public function adapt(Package $package, $submitValue, $order_id)
    {
        if ($package->id == 1) {
            return $this->packageId1Adapter($submitValue, $order_id);
        }
        return $submitValue;
    }

    private function packageId1Adapter($submitValue, $order_id)
    {
        $stringify = json_encode($submitValue);
        $jsonify = json_decode($stringify, true);

        $forms_data = [];
        for ($forms = 0; $forms < 2; $forms++) {
            $parameters_data = [];
            for ($parameters = 0; $parameters < 19; $parameters++) {
                $parameter_data = [
                    'id' => $parameters + 1,
                    'name' => $jsonify['parameter_name_'.$parameters],
                    'data' => [
                        [
                            'reagen_id' => $jsonify['reagen_'.$parameters.'_'.($forms+1)],
                            'equipment_id' => $jsonify['alat_'.$parameters.'_'.($forms+1)],
                            'method_id' => $jsonify['metode_pemeriksaan_'.$parameters.'_'.($forms+1)],
                            'qualification_id' => $jsonify['qualification_'.$parameters.'_'.($forms+1)],
                            'result' => $jsonify['hasil_'.$parameters.'_'.($forms+1)],
                        ]
                    ],
                ];
                array_push($parameters_data, $parameter_data);
            }
            $form_data = [
                'id' => ($forms+1),
                'data' => [
                    'number' => $jsonify['kode_bahan_kontrol_'.($forms+1)],
                    'date_of_arrival' => $jsonify['tanggal_penerimaan_'.($forms+1)],
                    'date_of_inspection' => $jsonify['tanggal_pemeriksaan_'.($forms+1)],
                    'condition' => $jsonify['kualitas_bahan_'.($forms+1)],
                    'condition_description' => null,
                    'note' => $jsonify['keterangan'],
                    'advice' => $jsonify['saran'],
                    'inspector_name' => $jsonify['nama_pemeriksa'],
                ],
                'parameters' => $parameters_data,
            ];
            array_push($forms_data, $form_data);
        }

        $adaptedSubmitValue = [
            '_token' => $jsonify['_token'],
            'form' => $forms_data,
        ];

        return $adaptedSubmitValue;
    }
}