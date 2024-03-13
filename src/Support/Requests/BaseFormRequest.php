<?php

namespace Support\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    /*
     * For not overwriting it again and again in child request classes
     */
    abstract public function rules(): array;
}
