<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];

    private static $extensions = ['txt', 'png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'pages', 'xls', 'xlsx', 'pdf', 'md'];

    /**
     * Provide a FontAwesome icon for this file type
     *
     * @return string
     */
    public function icon()
    {
        switch($this->fileType())
        {
            default:
                return 'file-text-o';
                break;

            case 'image':
                return 'file-image-o';
                break;

            case 'document':
                return 'file-word-o';
                break;

            case 'excel':
                return 'file-excel-o';
                break;

            case 'pdf':
                return 'file-pdf-o';
                break;

            case 'code':
                return 'file-code-o';
                break;
        }
    }

    /**
     * Simplify this file type based on extension
     *
     * @return string
     */
    public function fileType() {
        switch($this->extension)
        {
            default:
                return 'unknown';
                break;

            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'image';
                break;

            case 'doc':
            case 'docx':
            case 'txt':
            case 'pages':
                return 'document';
                break;

            case 'xls':
            case 'xlsx':
                return 'excel';
                break;

            case 'pdf':
                return 'pdf';
                break;

            case 'md':
                return 'code';
                break;
        }
    }

    /**
     * Return the contents of the file
     *
     * @return bool|string
     */
    public function contents()
    {
        return file_get_contents(storage_path('app/' . $this->path));
    }

    /**
     * Verify we are allowed to accept this extension
     *
     * @param $extension
     * @return bool
     */
    public static function allowed($extension)
    {
        return in_array($extension, self::$extensions);
    }
}
