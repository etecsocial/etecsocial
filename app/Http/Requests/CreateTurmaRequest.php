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
            'nome' => 'required|min:8|unique:turmas,nome,NULL,id_escola id_escola',
            'sigla' => 'required|min:2|unique:turmas,sigla,NULL,id_escola id_escola',
            'modulos' => 'required|max:1'
        ];
    }
}
