<?php

namespace Modules\Files\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Files\Entities\TypeFile;
use Modules\Files\Entities\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class Base64ImageRequest extends FileRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name_type_file' => 'required',
      'fileable_id' => 'required',
      'fileable_type' => 'required',
      'file' => 'file|max:2000|mimes:jpg,jpeg,png'
    ];
  }

  public function prepareForValidation()
  {
    $rules = $this->rules();
    foreach ($rules as $field => $ruleSet) {
      $ruleSet = is_string($ruleSet) ? explode('|', $ruleSet) : $ruleSet;
      if (in_array('file', $ruleSet) && $this->has($field)) {
        if (!$this->file($field) && ($content = $this->input($field)) && is_string($content)) {
          $content = array_last(explode(',', $content));
          $content = base64_decode($content);
          $mimeType = File::streamMimeType($content);
          $extension = File::mimeExtension($mimeType);
          $size = File::streamSize($content);
          $name = uniqid('decoded_').'.'.$extension;
          $path = tempnam(sys_get_temp_dir(), uniqid('laravel', true));
          File::put($path, $content);

          $file = app(UploadedFile::class, [
            'path' => $path,
            'originalName' => $name,
            'mimeType' => $mimeType,
            'size' => $size,
            'error' => null,
            'test' => true
          ]);

          $this->files->add([$field => $file]);
          $this->offsetUnset($field);
        }
      }
    }
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }
}
