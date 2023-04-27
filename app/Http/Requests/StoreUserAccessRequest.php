<?php

namespace App\Http\Requests;

use App\Models\Site;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserAccessRequest extends FormRequest
{
    protected ?Site $site = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $input = $this->get('app_key');
        $site = Site::where('app_key', $input);
        return (bool) ($this->site = $site->first()) && $this->site->domain === $this->getHost();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'app_key' => 'required'
        ];
    }

    public function getSite(): Site
    {
        return $this->site;
    }
}
