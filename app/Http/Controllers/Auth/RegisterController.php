<?php

namespace App\Http\Controllers\Auth;

use App\Laboratory;
use App\LaboratoryOwnership;
use App\LaboratoryType;
use App\Notifications\RegisterNotification;
use App\Province;
use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'max' => ':attribute terlalu panjang (paling banyak :max karakter).',
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute sudah dipakai oleh personil penghubung / instansi lain.',
            'email' => ':attribute harus berformat email.',
            'numeric' => ':attribute hanya boleh diisi oleh angka.',
            'digits_between' => ':attribute harus berisi :min - :max angka.',
            'acceptance.required' => 'Pastikan Anda telah memeriksa ulang formulir pendaftaran dan menyatakan bahwa data yang diisi benar dan dapat dipertanggung jawabkan.'
        ];
        $attributes = [
            'laboratory.name' => '<strong>Nama instansi</strong>',
            'laboratory.type_id' => '<strong>Tipe instansi</strong>',
            'laboratory.ownership_id' => '<strong>Kepemilikan instansi</strong>',
            'laboratory.email' => '<strong>Email instansi</strong>',
            'laboratory.phone_number' => '<strong>Nomor telepon instansi</strong>',
            'laboratory.address' => '<strong>Alamat instansi</strong>',
            'laboratory.village' => '<strong>Lokasi kelurahan instansi</strong>',
            'laboratory.district' => '<strong>Lokasi kecamatan instansi</strong>',
            'laboratory.city' => '<strong>Lokasi kota/kabupaten instansi</strong>',
            'laboratory.province_id' => '<strong>Lokasi provinsi instansi</strong>',
            'laboratory.postal_code' => '<strong>Kode pos instansi</strong>',
            'laboratory.user_position' => '<strong>Posisi personil penghubung di instansi</strong>',
            'user.name' => '<strong>Nama personil penghubung</strong>',
            'user.email' => '<strong>Email personil penghubung</strong>',
            'user.phone_number' => '<strong>Nomor telepon personil penghubung</strong>',
        ];
        return Validator::make($data, [
            'laboratory.name' => 'required|string|max:255',
            'laboratory.type_id' => 'required|exists:laboratory_types,id',
            'laboratory.ownership_id' => 'required|exists:laboratory_ownerships,id',
            'laboratory.email' => 'required|string|email|max:255|unique:laboratories,email',
            'laboratory.phone_number' => 'required|numeric|digits_between:6,36|unique:laboratories,phone_number',
            'laboratory.address' => 'required|string|max:255',
            'laboratory.village' => 'required|string|max:128',
            'laboratory.district' => 'required|string|max:128',
            'laboratory.city' => 'required|string|max:128',
            'laboratory.province_id' => 'required|exists:provinces,id',
            'laboratory.postal_code' => 'required|numeric|digits_between:4,6',
            'laboratory.user_position' => 'required|string|max:128',
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|string|email|max:255|unique:users,email',
            'user.phone_number' => 'required|string|numeric|digits_between:6,36|unique:users,phone_number',
            'acceptance' => 'required',
        ], $messages, $attributes);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $password = Str::random(12);

        $user = (new User)
            ->fill($data['user'])
            ->setLoginAllowed(true)
            ->setPassword($password)
            ->setRole(Role::participant());
        $user->save();

        (new Laboratory)
            ->fill($data['laboratory'])
            ->setUser($user)
            ->save();

        $user->notify(new RegisterNotification($user->getEmail(), $password));

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return redirect()->route('login')->with(['success' => __('Password Anda telah dikirim ke email ' . $user->getEmail())]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'optionsProvince' => Province::all(),
            'optionsLaboratoryType' => LaboratoryType::all(),
            'optionsLaboratoryOwnership' => LaboratoryOwnership::all(),
        ]);
    }
}
