<?php

namespace Modules\Edu\Transformers\Front;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;

/**
 * 视频资源
 * @package Modules\Edu\Transformers\Front
 */
class VideoResource extends Resource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    $resource =  parent::toArray($request);
    $resource['is_favour'] = Auth::check() ? $this->isFavour(Auth::user()) : false;
    $resource['is_favorite'] = Auth::check() ? $this->isFavorite(Auth::user()) : false;
    return $resource;
  }
}