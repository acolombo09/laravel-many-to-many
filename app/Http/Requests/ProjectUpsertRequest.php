<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectUpsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        
        $user = Auth::user(); //recupera l'utente attualmente loggato													
        if($user->email === "acolombo0911@hotmail.com") {
        // per questo progetto, mettere true di default in quanto ci sarà un solo account che farà login (l'admin->io)
        return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "title" => "required|max:255",
            "description" => "required|string",
            "image" => "nullable|image|max:6000",
            "image_link" => "nullable|max:255",
            "link" => "required|string",
            "is_published" => "nullable|boolean",
            // tip in classe, exists si assicura che l'id passato esista
            // nella tabella indicata
            // best practice nei validatori
            "type_id" => "nullable|exists:types,id"
        ];
    }
}
