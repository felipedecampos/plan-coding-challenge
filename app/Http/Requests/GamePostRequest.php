<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class GamePostRequest extends FormRequest
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
            'player_one_nickname' => 'required|string|max:255',
            'player_two_nickname' => 'required|string|max:255',
            'player_x_nickname'   => 'required|string|max:255',
            'player_o_nickname'   => 'required|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            Session::flash('error', $validator->errors());
//            $this->response($validator->errors());
        }
    }

    public function response(array $errors): \Illuminate\Http\RedirectResponse
    {
        return redirect()->back()->withErrors($errors)->withInput();
    }
}
