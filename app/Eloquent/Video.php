<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    const FILE_SIZE_LIMITATION = 51200;// in kilobytes
    const THUMBNAIL_DIR = 'uploads/videos/';
    const THUMBNAIL_PREFIX = '800x450';
    const THUMBNAIL_WIDTH = 800;
    const THUMBNAIL_HEIGHT = 450;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function getCreatedByUsername(): string
    {
        return DB::table('users')
            ->where('id', $this->created_by)
            ->value('name');
    }

    public function getUpdatedByUsername(): string
    {
        if (!$this->updated_by) {
            return '-';
        }
        return DB::table('users')
            ->where('id', $this->created_by)
            ->value('name');
    }
}
