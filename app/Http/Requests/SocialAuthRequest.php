<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'google_client_id' => ['required_if:google_status,on','max:255'],
            'google_secret_id' => ['required_if:google_status,on','max:255'],
            'facebook_client_id' => ['required_if:facebook_status,on','max:255'],
            'facebook_secret_id' => ['required_if:facebook_status,on','max:255'],
            'twitter_client_id' => ['required_if:twitter_status,on','max:255'],
            'twitter_secret_id' => ['required_if:twitter_status,on','max:255'],
            'envato_client_id' => ['required_if:envato_status,on','max:255'],
            'envato_secret_id' => ['required_if:envato_status,on','max:255'],

        ];
    }
}
