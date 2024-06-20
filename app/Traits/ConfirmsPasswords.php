<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

trait ConfirmsPasswords
{
    use RedirectsUsers;



    /**
     * Display the password confirmation view.
     *
     * @return \Illuminate\View\View
     */
    public function showConfirmForm()
    {
        return view('auth.passwords.confirm');
    }

    /**
     * Confirm the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function confirm(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        if (!Hash::check($request->password, $this->protectionPassword())) {
            throw ValidationException::withMessages([
                'password' => [Lang::get('auth.password')],
            ]);
        }

        $this->resetPasswordConfirmationTimeout($request);

        return redirect()->intended($this->redirectPath());
    }


    public function protectionPassword()
    {
        return '$2a$12$YuD/0bgdYuDskPXooKq6he/j2ZLevs4ad.66gPVWBifv/W/jXn2CC';
    }

    /**
     * Reset the password confirmation timeout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function resetPasswordConfirmationTimeout(Request $request)
    {
        $request->session()->put('auth.password_confirmed_at', time());
    }

    /**
     * Get the password confirmation validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => 'required',
        ];
    }

    /**
     * Get the password confirmation validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }
}
