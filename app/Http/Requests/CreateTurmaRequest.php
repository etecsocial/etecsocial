<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTurmaRequest extends Request
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
        //@todo Não deixar cadastrar turmas com mesma sigla ou desc!
        return [
            'desc' => 'required|min:8',
            'sigla' => 'required|min:2',
            'modulos' => 'required'
        ];
    }
}
