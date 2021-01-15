<?php

namespace App\Sanitizer;


use App\LittleFlower\LaboratoryFinder;
use App\LittleFlower\ParticipantFinder;
use App\OrderPackage;
use stdClass;

class HematologiSanitizer
{
    public static function sanitize($inputs)
    {
        $sanity = [];
        foreach ($inputs as $input) {
            $sanitized_input = self::sanitizeItem($input);
            array_push($sanity, $sanitized_input);
        }
        return $sanity;
    }

    /**
     * @param $input : sanitized item, please call FormInputParser before call this method.
     * @return stdClass
     */
    public static function sanitizeItem($input)
    {
        $sanitized_input = new stdClass();
        $sanitized_input->id = $input->id;
        $sanitized_input->participant_number = ParticipantFinder::findByOrderPackage($input->order_package_id)->number;
        $sanitized_input->laboratory = LaboratoryFinder::findByOrderPackage($input->order_package_id);

        $order_package = OrderPackage::find($input->order_package_id);

        $bottles = [];
        for ($h = 1; $h <= 2; $h++) {
            $bottle = new stdClass();
            $bottle->kode_bahan_kontrol = $input->{'kode_bahan_kontrol_'.$h};
            $parameters = [];
            for ($i = 0; $i <= 7; $i++) {
                $parameter = new stdClass();
                $parameter->name = $order_package->package->parameters[$i]->name;
                $parameter->metode = $input->{'method_'.$i.'_bottle_'.$h};
                $parameter->alat = $input->{'equipment_'.$i.'_bottle_'.$h};
                $parameter->reagen = $input->{'model_'.$i.'_bottle_'.$h};

                $hasil = $input->{'hasil_'.$i.'_bottle_'.$h};
                $parameter->hasil = $hasil != null && is_numeric($hasil) ? (double) $hasil : null;
                $parameter->hasil_raw = $hasil;

                $parameter->kualifikasi_pemeriksa = $input->{'kualifikasi_pemeriksa_'.$i.'_bottle_'.$h};
                array_push($parameters, $parameter);
            }
            $bottle->parameters = $parameters;
            array_push($bottles, $bottle);
        }
        $sanitized_input->bottles = $bottles;
        $sanitized_input->saran = $input->{'saran'};
        $sanitized_input->keterangan = $input->{'keterangan'};
        $sanitized_input->nama_pemeriksa = $input->{'nama_pemeriksa'};
        return $sanitized_input;
    }
}