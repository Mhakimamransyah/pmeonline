<?php

namespace App\Http\Controllers\v1\Administrator;

use App\ContactPerson;
use App\Http\Controllers\Controller;
use App\Phone;
use App\Traits\PasswordGeneratorTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ContactPersonController extends Controller
{

    use PasswordGeneratorTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('v1.administrator.contact-person.index');
    }

    public function fetch()
    {
        return ContactPerson::with(['user', 'laboratories', 'participation'])->get();
    }

    public function get($id)
    {
        return view('v1.administrator.contact-person.item', [
            'contact_person' => ContactPerson::findOrFail($id),
        ]);
    }

    public function update($id, Request $request)
    {
        return $this->userEmailValidator($request, function () use ($id, $request) {
            $contactPerson = ContactPerson::findOrFail($id);
            $contactPerson->position = $request->get('contact-person-position');
            $contactPerson->save();
            $contactPerson->user->email = $request->get('contact-person-email');
            $contactPerson->user->name = $request->get('contact-person-name');
            $contactPerson->user->save();
            return redirect()->back()->with([
                'success' => 'Akun personil penghubung <strong>' . $contactPerson->user->name . '</strong> berhasil diperbaharui.'
            ]);
        });
    }

    public function create(Request $request)
    {
        return $this->userEmailValidator($request, function () use ($request) {
            $email = $request->get('contact-person-email');

            $user = User::where('email', '=', $email)->first();
            if ($user != null) {
                return redirect()->back()->withErrors([
                    'Email <strong>' . $email . '</strong> telah digunakan oleh <strong>' .  $user->name . '</strong>.'
                ]);
            }

            $password = str_random(12);

            $contactPerson = new ContactPerson();
            $contactPerson->position = $request->get('contact-person-position');

            $user = new User();
            $user->name = $request->get('contact-person-name');
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            DB::table('role_user')->insert([
                'user_id' => $user->id,
                'role_id' => 1,
            ]);

            $contactPerson->user()->associate($user);
            $contactPerson->save();

            $phone = Phone::firstOrNew([
                'number' => $request->get('contact-person-phone'),
            ]);
            $phone->phone_type_id = 1;
            $phone->save();
            $contactPerson->phoneNumbers()->save($phone);

            $this->sendPasswordToMail($password, $email);

            return redirect()->back()->with([
                'success' => '<strong>' . $user->name . '</strong> berhasil ditambahkan sebagai personil penghubung. Password <strong>' . $password .
                    '</strong> telah dikirim ke <strong>' . $email . '</strong>',
            ]);
        });
    }

    public function appendPhone(Request $request)
    {
        if ($request->get('phone-id') != null) {
            return $this->updatePhone($request);
        }
        return $this->attachPhone($request);
    }

    private function updatePhone(Request $request)
    {
        $this->deletePhone($request);
        $phone = Phone::firstOrNew([
            'number' => $request->get('phone-number'),
        ]);
        $phone->phone_type_id = $request->get('phone-type');
        $phone->save();
        $this->attachPhone($request);
        $contactPerson = ContactPerson::findOrFail($request->get('contact-person-id'));
        return redirect()->back()->with([
            'success' => 'Nomor telepon <strong>' . $phone->number . '</strong> milik <strong>' . $contactPerson->user->name . '</strong> berhasil diperbaharui.',
        ]);
    }

    private function attachPhone(Request $request)
    {
        $contactPerson = ContactPerson::findOrFail($request->get('contact-person-id'));
        $phone = Phone::firstOrCreate(['number' => $request->get('phone-number')], ['phone_type_id' => $request->get('phone-type')]);
        $contactPerson->phoneNumbers()->detach($phone);
        $contactPerson->phoneNumbers()->attach($phone);
        return redirect()->back()->with([
            'success' => 'Nomor telepon <strong>' . $phone->number . '</strong> berhasil ditambahkan menjadi milik <strong>' . $contactPerson->user->name . '</strong>.',
        ]);
    }

    public function deletePhone(Request $request)
    {
        $contactPerson = ContactPerson::findOrFail($request->get('contact-person-id'));
        $phone = Phone::findOrFail($request->get('phone-id'));
        $contactPerson->phoneNumbers()->detach($phone);
        return redirect()->back()->with([
            'success' => 'Nomor telepon <strong>' . $phone->number . '</strong> berhasil dihapus dari profil <strong>' . $contactPerson->user->name . '</strong>.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $userId = $request->get('user-id');
        $user = User::findOrFail($userId);
        $email = $user->email;
        return redirect()->back()->with([
            'success' => 'Password <strong>' . $this->generatePassword($email) . '</strong> telah dikirim ke <strong>' . $email . '</strong>.',
        ]);
    }

    /**
     * Validator for User's email unique.
     *
     * @param Request $request
     * @param \Closure $closure
     * @return array|\Closure|\Illuminate\Http\RedirectResponse
     */
    private function userEmailValidator(Request $request, \Closure $closure) {
        $validator = Validator::make($request->all(), [
            'contact-person-email' => 'unique:users,email|required'
        ], [
            'contact-person-email.unique' => 'Email <strong>:input</strong> telah digunakan oleh akun lain.'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            return $closure();
        }
    }

}