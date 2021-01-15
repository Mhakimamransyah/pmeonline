<?php
/**
 * Created by PhpStorm.
 * User: ruuko
 * Date: 14/10/18
 * Time: 15:23
 */

namespace App\Http\Controllers;


use App\Participant;
use Illuminate\Http\Request;
use OzdemirBurak\JsonCsv\File\Json;

class ExporterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function exportParticipants(Request $request)
    {
        $cycle_id = $request->get('cycle_id');
        $participants = Participant::whereHas('order', function ($query) use ($cycle_id) {
            return $query->whereHas('cycle', function ($query) use ($cycle_id) {
                return $query->where('id', '=', $cycle_id);
            });
        })->get();

        $data = array();

        $index = 1;
        foreach ($participants as $participant) {
            $telepon = $participant->order->laboratory->phones->first();
            $contact_person = $participant->order->laboratory->contactPerson;
            $cp_telepon = '';
            if ($contact_person != null && $contact_person->defaultPhoneNumber() != null) {
                $cp_telepon = '(' . $contact_person->defaultPhoneNumber()['number'] . ')' ?: '';
            }
            $item = [
                'No' => $index,
                'Provinsi' => $participant->order->laboratory->province->name ?: '',
                'Kab' => $participant->order->laboratory->city ?: '',
                'Kec' => $participant->order->laboratory->district ?: '',
                'Kel/Desa' => $participant->order->laboratory->village ?: '',
                'Instansi' => $participant->order->laboratory->name ?: '',
                'Pemerintah' => $participant->order->laboratory->laboratory_ownership_id == 1 ? '1' : '',
                'Swasta' => $participant->order->laboratory->laboratory_ownership_id == 2 ? '1' : '',
                'RS' => $participant->order->laboratory->laboratory_type_id == 1 ? '1' : '',
                'PKM' => $participant->order->laboratory->laboratory_type_id == 2 ? '1' : '',
                'BLK' => $participant->order->laboratory->laboratory_type_id == 3 ? '1' : '',
                'LK' => $participant->order->laboratory->laboratory_type_id == 4 ? '1' : '',
                'Kode Peserta' => $participant->number ?: '',
                'Alamat' => $participant->order->laboratory->address ?: '',
                'Telepon' => $telepon ? $telepon->number : '',
                'Fax' => '',
                'Email' => $participant->order->laboratory->email ?: '',
                'Kontak Person' => $contact_person ? $contact_person->user->name . ' ' . $cp_telepon . ' ' . $contact_person->user->email : '',
            ];
            $index++;
            array_push($data, $item);
        }

        $filename = 'participants.json';
        $file = fopen($filename, 'w');
        fwrite($file, json_encode($data));
        fclose($file);
        $json = new Json(public_path($filename));
        $csvString = $json->convert();
        unlink(public_path($filename));
        $json->convertAndDownload();
        return $data;
    }

}