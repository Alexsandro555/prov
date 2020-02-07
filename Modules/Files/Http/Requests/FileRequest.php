<?php

namespace Modules\Files\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Files\Entities\TypeFile;

class FileRequest extends FormRequest
{
  public $resize;
  public $typeFile;
  private $extensions;
  private $maxsize;

  public function __construct()
  {
    $this->typeFile = TypeFile::where('name',request('name_type_file'))->firstOrFail();
    $this->extensions = $this->typeFile->extensions;
    $this->maxsize = $this->typeFile->maxsize;
    $this->resize = $this->typeFile->resize;
  }

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
      'file' => 'required|file|max:'.$this->maxsize.$this->extensions?'|mimes:'.$this->extensions:''
    ];
  }

  public function messages()
  {
    return [
      'file.required' => "Загрузите файл",
      'file.mimes' => 'Поддерживаемые расширения: '.$this->extensions,
      'file.max' => "Максимальный размер загружаемого файла не должен превышать ".($this->maxsize/1024)."МБ (".$this->maxsize."КB). Если вы загружаете изображение, то попробуйте снизить его разрешение, чтобы файл занимал меньший объем. В случае невозможности уменьшить размер файла обратитесь к системному админстратору ".config('info.admin_email')
    ];
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
