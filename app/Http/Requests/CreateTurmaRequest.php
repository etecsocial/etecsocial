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
     * Impede que coordenadores cadastrem turmas com mesmo nome ou sigla para uma mesma escola
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|min:8|unique:turmas,nome,NULL,escola_id escola_id',
            'sigla' => 'required|min:2|unique:turmas,sigla,NULL,escola_id escola_id',
            'modulos' => 'required|max:1'
        ];
    }
}
