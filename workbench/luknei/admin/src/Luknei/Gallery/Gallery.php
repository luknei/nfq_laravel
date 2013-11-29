<?php

namespace Luknei\Gallery;

class Gallery {

    protected $thumb_width = 200;
    protected $thumb_height = 200;

    protected $photo_max_width = 640;
    protected $photo_max_height = 640;

    protected $thumb_path = 'public_gallery/thumbs/';
    protected $photo_path = 'public_gallery/images/';

    public function __construct()
    {
        $thumb_width = \Settings::findSettings('gallery', 'thumb_width');
        $thumb_height = \Settings::findSettings('gallery', 'thumb_height');
        $photo_max_width = \Settings::findSettings('gallery', 'max_photo_width');
        $photo_max_height = \Settings::findSettings('gallery', 'max_photo_height');

        $this->thumb_width = (integer)$thumb_width;
        $this->thumb_height = (integer)$thumb_height;
        $this->photo_max_width = (integer)$photo_max_width;
        $this->photo_max_height = (integer)$photo_max_height;
    }

    public function thumbnail($open, $save_name)
    {

        $save = public_path($this->thumb_path . $save_name);

        try{
            $imagine = new \Imagine\Gd\Imagine();

            $crop_size = new \Imagine\Image\Box($this->thumb_width, $this->thumb_height);

            $mode_crop = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

            $imagine->open($open)
                ->thumbnail($crop_size, $mode_crop)
                ->save($save);

            return TRUE;
        }
        catch(\Imagine\Exception\Exception $e)
        {
            return FALSE;
        }


    }

    public function image($open, $save_name)
    {

        $save = public_path($this->photo_path . $save_name);

        try{
            $imagine = new \Imagine\Gd\Imagine();

            $resize_size = new \Imagine\Image\Box($this->photo_max_width, 20000);

            if($imagine->open($open)->getSize()->getWidth() < $imagine->open($open)->getSize()->getHeight())
            {
                $resize_size = new \Imagine\Image\Box(20000, $this->photo_max_height);
            }

            $mode_resize = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

            $imagine->open($open)
                ->thumbnail($resize_size, $mode_resize)
                ->save($save);

            return TRUE;
        }
        catch(\Imagine\Exception\Exception $e)
        {
            return FALSE;
        }
    }

    public function crop($open_name, $save_name, $x, $y, $width, $height)
    {
        $imagine = new \Imagine\Gd\Imagine();

        $open = public_path($this->photo_path . $open_name);

        $save = public_path($this->photo_path . $save_name);

        try{
            $imagine->open($open)
                ->crop(new \Imagine\Image\Point($x, $y), new \Imagine\Image\Box($width, $height))
                ->save($save);

            $this->thumbnail($save, $save_name);

            return TRUE;
        }
        catch(\Imagine\Exception\Exception $e){
            return FALSE;
        }
    }

    public function rotate($open_name, $save_name, $rotate)
    {
        $imagine = new \Imagine\Gd\Imagine();

        $open = public_path($this->photo_path . $open_name);

        $save = public_path($this->photo_path . $save_name);

        try{
            $imagine->open($open)
                ->rotate($rotate)
                ->save($save);

            $this->thumbnail($save, $save_name);

            return TRUE;
        }
        catch(\Imagine\Exception\Exception $e){
            return FALSE;
        }
    }

    /**
     * @param int $photo_max_height
     */
    public function setPhotoMaxHeight($photo_max_height)
    {
        $this->photo_max_height = (integer)$photo_max_height;
    }

    /**
     * @param int $photo_max_width
     */
    public function setPhotoMaxWidth($photo_max_width)
    {
        $this->photo_max_width = (integer)$photo_max_width;
    }

    /**
     * @param string $photo_path
     */
    public function setPhotoPath($photo_path)
    {
        $this->photo_path = $photo_path;
    }

    /**
     * @param int $thumb_height
     */
    public function setThumbHeight($thumb_height)
    {
        $this->thumb_height = (integer)$thumb_height;
    }

    /**
     * @param string $thumb_path
     */
    public function setThumbPath($thumb_path)
    {
        $this->thumb_path = $thumb_path;
    }

    /**
     * @param int $thumb_width
     */
    public function setThumbWidth($thumb_width)
    {
        $this->thumb_width = (integer)$thumb_width;
    }


} 