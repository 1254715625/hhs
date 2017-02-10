<?php
class Image{
    /* 驱动相关常量定义 */
    const IMAGE_GD              =   1; //常量，标识GD库类型
    const IMAGE_IMAGICK         =   2; //常量，标识imagick库类型

    /* 缩略图相关常量定义 */
    const IMAGE_THUMB_SCALE     =   1 ; //常量，标识缩略图等比例缩放类型
    const IMAGE_THUMB_FILLED    =   2 ; //常量，标识缩略图缩放后填充类型
    const IMAGE_THUMB_CENTER    =   3 ; //常量，标识缩略图居中裁剪类型
    const IMAGE_THUMB_NORTHWEST =   4 ; //常量，标识缩略图左上角裁剪类型
    const IMAGE_THUMB_SOUTHEAST =   5 ; //常量，标识缩略图右下角裁剪类型
    const IMAGE_THUMB_FIXED     =   6 ; //常量，标识缩略图固定尺寸缩放类型

    /* 水印相关常量定义 */
    const IMAGE_WATER_NORTHWEST =   1 ; //常量，标识左上角水印
    const IMAGE_WATER_NORTH     =   2 ; //常量，标识上居中水印
    const IMAGE_WATER_NORTHEAST =   3 ; //常量，标识右上角水印
    const IMAGE_WATER_WEST      =   4 ; //常量，标识左居中水印
    const IMAGE_WATER_CENTER    =   5 ; //常量，标识居中水印
    const IMAGE_WATER_EAST      =   6 ; //常量，标识右居中水印
    const IMAGE_WATER_SOUTHWEST =   7 ; //常量，标识左下角水印
    const IMAGE_WATER_SOUTH     =   8 ; //常量，标识下居中水印
    const IMAGE_WATER_SOUTHEAST =   9 ; //常量，标识右下角水印

    /**
     * 图片资源
     * @var resource
     */
    private $img;

    /**
     * 构造方法，用于实例化一个图片处理对象
     * @param string $type 要使用的类库，默认使用GD库
     */
    public function __construct($type = self::IMAGE_GD, $imgname = null){
        /* 判断调用库的类型 */
        switch ($type) {
            case self::IMAGE_GD:
                $class = 'Gd';
                break;
            case self::IMAGE_IMAGICK:
                $class = 'Imagick';
                break;
            default:
                E('不支持的图片处理库类型');
        }

        /* 引入处理库，实例化图片处理对象 */
        $class  =    "{$class}";
        $this->img = new $class($imgname);
    }

    /**
     * 打开一幅图像
     * @param  string $imgname 图片路径
     * @return Object          当前图片处理库对象
     */
    public function open($imgname){
        $this->img->open($imgname);
        return $this;
    }

    /**
     * 保存图片
     * @param  string  $imgname   图片保存名称
     * @param  string  $type      图片类型
     * @param  integer $quality   图像质量      
     * @param  boolean $interlace 是否对JPEG类型图片设置隔行扫描
     * @return Object             当前图片处理库对象
     */
    public function save($imgname, $type = null, $quality=80,$interlace = true){
        $this->img->save($imgname, $type, $quality,$interlace);
        return $this;
    }

    /**
     * 返回图片宽度
     * @return integer 图片宽度
     */
    public function width(){
        return $this->img->width();
    }

    /**
     * 返回图片高度
     * @return integer 图片高度
     */
    public function height(){
        return $this->img->height();
    }

    /**
     * 返回图像类型
     * @return string 图片类型
     */
    public function type(){
        return $this->img->type();
    }

    /**
     * 返回图像MIME类型
     * @return string 图像MIME类型
     */
    public function mime(){
        return $this->img->mime();
    }

    /**
     * 返回图像尺寸数组 0 - 图片宽度，1 - 图片高度
     * @return array 图片尺寸
     */
    public function size(){
        return $this->img->size();
    }

    /**
     * 裁剪图片
     * @param  integer $w      裁剪区域宽度
     * @param  integer $h      裁剪区域高度
     * @param  integer $x      裁剪区域x坐标
     * @param  integer $y      裁剪区域y坐标
     * @param  integer $width  图片保存宽度
     * @param  integer $height 图片保存高度
     * @return Object          当前图片处理库对象
     */
    public function crop($w, $h, $x = 0, $y = 0, $width = null, $height = null){
        $this->img->crop($w, $h, $x, $y, $width, $height);
        return $this;
    }

    /**
     * 生成缩略图
     * @param  integer $width  缩略图最大宽度
     * @param  integer $height 缩略图最大高度
     * @param  integer $type   缩略图裁剪类型
     * @return Object          当前图片处理库对象
     */
    public function thumb($width, $height, $type = self::IMAGE_THUMB_SCALE){
        $this->img->thumb($width, $height, $type);
        return $this;
    }

    /**
     * 添加水印
     * @param  string  $source 水印图片路径
     * @param  integer $locate 水印位置
     * @param  integer $alpha  水印透明度
     * @return Object          当前图片处理库对象
     */
    public function water($source, $locate = self::IMAGE_WATER_SOUTHEAST,$alpha=80){
        $this->img->water($source, $locate,$alpha);
        return $this;
    }

    /**
     * 图像添加文字
     * @param  string  $text   添加的文字
     * @param  string  $font   字体路径
     * @param  integer $size   字号
     * @param  string  $color  文字颜色
     * @param  integer $locate 文字写入位置
     * @param  integer $offset 文字相对当前位置的偏移量
     * @param  integer $angle  文字倾斜角度
     * @return Object          当前图片处理库对象
     */
    public function text($text, $font, $size, $color = '#00000000', 
        $locate = self::IMAGE_WATER_SOUTHEAST, $offset = 0, $angle = 0){
        $this->img->text($text, $font, $size, $color, $locate, $offset, $angle);
        return $this;
    }
}


class Imagick{
    /**
     * 图像资源对象
     * @var resource
     */
    private $img;

    /**
     * 图像信息，包括width,height,type,mime,size
     * @var array
     */
    private $info;

    /**
     * 构造方法，可用于打开一张图像
     * @param string $imgname 图像路径
     */
    public function __construct($imgname = null) {
        $imgname && $this->open($imgname);
    }

    /**
     * 打开一张图像
     * @param  string $imgname 图像路径
     */
    public function open($imgname){
        //检测图像文件
        if(!is_file($imgname)) E('不存在的图像文件');

        //销毁已存在的图像
        empty($this->img) || $this->img->destroy();

        //载入图像
        $this->img = new \Imagick(realpath($imgname));

        //设置图像信息
        $this->info = array(
            'width'  => $this->img->getImageWidth(),
            'height' => $this->img->getImageHeight(),
            'type'   => strtolower($this->img->getImageFormat()),
            'mime'   => $this->img->getImageMimeType(),
        );
    }

    /**
     * 保存图像
     * @param  string  $imgname   图像保存名称
     * @param  string  $type      图像类型
     * @param  integer $quality   JPEG图像质量      
     * @param  boolean $interlace 是否对JPEG类型图像设置隔行扫描
     */
    public function save($imgname, $type = null, $quality=80,$interlace = true){
        if(empty($this->img)) E('没有可以被保存的图像资源');

        //设置图片类型
        if(is_null($type)){
            $type = $this->info['type'];
        } else {
            $type = strtolower($type);
            $this->img->setImageFormat($type);
        }

        //JPEG图像设置隔行扫描
        if('jpeg' == $type || 'jpg' == $type){
            $this->img->setImageInterlaceScheme(1);
        }

        // 设置图像质量
        $this->img->setImageCompressionQuality($quality); 

        //去除图像配置信息
        $this->img->stripImage();

        //保存图像
        $imgname = realpath(dirname($imgname)) . '/' . basename($imgname); //强制绝对路径
        if ('gif' == $type) {
            $this->img->writeImages($imgname, true);
        } else {
            $this->img->writeImage($imgname);
        }
    }

    /**
     * 返回图像宽度
     * @return integer 图像宽度
     */
    public function width(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['width'];
    }

    /**
     * 返回图像高度
     * @return integer 图像高度
     */
    public function height(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['height'];
    }

    /**
     * 返回图像类型
     * @return string 图像类型
     */
    public function type(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['type'];
    }

    /**
     * 返回图像MIME类型
     * @return string 图像MIME类型
     */
    public function mime(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['mime'];
    }

    /**
     * 返回图像尺寸数组 0 - 图像宽度，1 - 图像高度
     * @return array 图像尺寸
     */
    public function size(){
        if(empty($this->img)) E('没有指定图像资源');
        return array($this->info['width'], $this->info['height']);
    }

    /**
     * 裁剪图像
     * @param  integer $w      裁剪区域宽度
     * @param  integer $h      裁剪区域高度
     * @param  integer $x      裁剪区域x坐标
     * @param  integer $y      裁剪区域y坐标
     * @param  integer $width  图像保存宽度
     * @param  integer $height 图像保存高度
     */
    public function crop($w, $h, $x = 0, $y = 0, $width = null, $height = null){
        if(empty($this->img)) E('没有可以被裁剪的图像资源');

        //设置保存尺寸
        empty($width)  && $width  = $w;
        empty($height) && $height = $h;

        //裁剪图片
        if('gif' == $this->info['type']){
            $img = $this->img->coalesceImages();
            $this->img->destroy(); //销毁原图

            //循环裁剪每一帧
            do {
                $this->_crop($w, $h, $x, $y, $width, $height, $img);
            } while ($img->nextImage());
            
            //压缩图片
            $this->img = $img->deconstructImages();
            $img->destroy(); //销毁零时图片
        } else {
            $this->_crop($w, $h, $x, $y, $width, $height);
        }
    }

    /* 裁剪图片，内部调用 */
    private function _crop($w, $h, $x, $y, $width, $height, $img = null){
        is_null($img) && $img = $this->img;

        //裁剪
        $info = $this->info;
        if($x != 0 || $y != 0 || $w != $info['width'] || $h != $info['height']){
            $img->cropImage($w, $h, $x, $y);
            $img->setImagePage($w, $h, 0, 0); //调整画布和图片一致
        }
        
        //调整大小
        if($w != $width || $h != $height){
            $img->sampleImage($width, $height);
        }

        //设置缓存尺寸
        $this->info['width']  = $w;
        $this->info['height'] = $h;
    }

    /**
     * 生成缩略图
     * @param  integer $width  缩略图最大宽度
     * @param  integer $height 缩略图最大高度
     * @param  integer $type   缩略图裁剪类型
     */
    public function thumb($width, $height, $type = Image::IMAGE_THUMB_SCALE){
        if(empty($this->img)) E('没有可以被缩略的图像资源');

        //原图宽度和高度
        $w = $this->info['width'];
        $h = $this->info['height'];

        /* 计算缩略图生成的必要参数 */
        switch ($type) {
            /* 等比例缩放 */
            case Image::IMAGE_THUMB_SCALE:
                //原图尺寸小于缩略图尺寸则不进行缩略
                if($w < $width && $h < $height) return;

                //计算缩放比例
                $scale = min($width/$w, $height/$h);
                
                //设置缩略图的坐标及宽度和高度
                $x = $y = 0;
                $width  = $w * $scale;
                $height = $h * $scale;
                break;

            /* 居中裁剪 */
            case Image::IMAGE_THUMB_CENTER:
                //计算缩放比例
                $scale = max($width/$w, $height/$h);

                //设置缩略图的坐标及宽度和高度
                $w = $width/$scale;
                $h = $height/$scale;
                $x = ($this->info['width'] - $w)/2;
                $y = ($this->info['height'] - $h)/2;
                break;

            /* 左上角裁剪 */
            case Image::IMAGE_THUMB_NORTHWEST:
                //计算缩放比例
                $scale = max($width/$w, $height/$h);

                //设置缩略图的坐标及宽度和高度
                $x = $y = 0;
                $w = $width/$scale;
                $h = $height/$scale;
                break;

            /* 右下角裁剪 */
            case Image::IMAGE_THUMB_SOUTHEAST:
                //计算缩放比例
                $scale = max($width/$w, $height/$h);

                //设置缩略图的坐标及宽度和高度
                $w = $width/$scale;
                $h = $height/$scale;
                $x = $this->info['width'] - $w;
                $y = $this->info['height'] - $h;
                break;

            /* 填充 */
            case Image::IMAGE_THUMB_FILLED:
                //计算缩放比例
                if($w < $width && $h < $height){
                    $scale = 1;
                } else {
                    $scale = min($width/$w, $height/$h);
                }

                //设置缩略图的坐标及宽度和高度
                $neww = $w * $scale;
                $newh = $h * $scale;
                $posx = ($width  - $w * $scale)/2;
                $posy = ($height - $h * $scale)/2;

                //创建一张新图像
                $newimg = new \Imagick();
                $newimg->newImage($width, $height, 'white', $this->info['type']);


                if('gif' == $this->info['type']){
                    $imgs = $this->img->coalesceImages();
                    $img  = new \Imagick();
                    $this->img->destroy(); //销毁原图

                    //循环填充每一帧
                    do {
                        //填充图像
                        $image = $this->_fill($newimg, $posx, $posy, $neww, $newh, $imgs);
                        
                        $img->addImage($image);
                        $img->setImageDelay($imgs->getImageDelay());
                        $img->setImagePage($width, $height, 0, 0);

                        $image->destroy(); //销毁零时图片

                    } while ($imgs->nextImage());

                    //压缩图片
                    $this->img->destroy();
                    $this->img = $img->deconstructImages();
                    $imgs->destroy(); //销毁零时图片
                    $img->destroy(); //销毁零时图片

                } else {
                    //填充图像
                    $img = $this->_fill($newimg, $posx, $posy, $neww, $newh);
                    //销毁原图
                    $this->img->destroy();
                    $this->img = $img;
                }

                //设置新图像属性
                $this->info['width']  = $width;
                $this->info['height'] = $height;
                return;

            /* 固定 */
            case Image::IMAGE_THUMB_FIXED:
                $x = $y = 0;
                break;

            default:
                E('不支持的缩略图裁剪类型');
        }

        /* 裁剪图像 */
        $this->crop($w, $h, $x, $y, $width, $height);
    }

    /* 填充指定图像，内部使用 */
    private function _fill($newimg, $posx, $posy, $neww, $newh, $img = null){
        is_null($img) && $img = $this->img;

        /* 将指定图片绘入空白图片 */
        $draw  = new \ImagickDraw();
        $draw->composite($img->getImageCompose(), $posx, $posy, $neww, $newh, $img);
        $image = $newimg->clone();
        $image->drawImage($draw);
        $draw->destroy();

        return $image;
    }

    /**
     * 添加水印
     * @param  string  $source 水印图片路径
     * @param  integer $locate 水印位置
     * @param  integer $alpha  水印透明度
     */
    public function water($source, $locate = Image::IMAGE_WATER_SOUTHEAST,$alpha=80){
        //资源检测
        if(empty($this->img)) E('没有可以被添加水印的图像资源');
        if(!is_file($source)) E('水印图像不存在');

        //创建水印图像资源
        $water = new \Imagick(realpath($source));
        $info  = array($water->getImageWidth(), $water->getImageHeight());

        /* 设定水印位置 */
        switch ($locate) {
            /* 右下角水印 */
            case Image::IMAGE_WATER_SOUTHEAST:
                $x = $this->info['width'] - $info[0];
                $y = $this->info['height'] - $info[1];
                break;

            /* 左下角水印 */
            case Image::IMAGE_WATER_SOUTHWEST:
                $x = 0;
                $y = $this->info['height'] - $info[1];
                break;

            /* 左上角水印 */
            case Image::IMAGE_WATER_NORTHWEST:
                $x = $y = 0;
                break;

            /* 右上角水印 */
            case Image::IMAGE_WATER_NORTHEAST:
                $x = $this->info['width'] - $info[0];
                $y = 0;
                break;

            /* 居中水印 */
            case Image::IMAGE_WATER_CENTER:
                $x = ($this->info['width'] - $info[0])/2;
                $y = ($this->info['height'] - $info[1])/2;
                break;

            /* 下居中水印 */
            case Image::IMAGE_WATER_SOUTH:
                $x = ($this->info['width'] - $info[0])/2;
                $y = $this->info['height'] - $info[1];
                break;

            /* 右居中水印 */
            case Image::IMAGE_WATER_EAST:
                $x = $this->info['width'] - $info[0];
                $y = ($this->info['height'] - $info[1])/2;
                break;

            /* 上居中水印 */
            case Image::IMAGE_WATER_NORTH:
                $x = ($this->info['width'] - $info[0])/2;
                $y = 0;
                break;

            /* 左居中水印 */
            case Image::IMAGE_WATER_WEST:
                $x = 0;
                $y = ($this->info['height'] - $info[1])/2;
                break;

            default:
                /* 自定义水印坐标 */
                if(is_array($locate)){
                    list($x, $y) = $locate;
                } else {
                    E('不支持的水印位置类型');
                }
        }

        //创建绘图资源
        $draw = new \ImagickDraw();
        $draw->composite($water->getImageCompose(), $x, $y, $info[0], $info[1], $water);
        
        if('gif' == $this->info['type']){
            $img = $this->img->coalesceImages();
            $this->img->destroy(); //销毁原图

            do{
                //添加水印
                $img->drawImage($draw);
            } while ($img->nextImage());

            //压缩图片
            $this->img = $img->deconstructImages();
            $img->destroy(); //销毁零时图片

        } else {
            //添加水印
            $this->img->drawImage($draw);
        }

        //销毁水印资源
        $draw->destroy();
        $water->destroy();
    }

    /**
     * 图像添加文字
     * @param  string  $text   添加的文字
     * @param  string  $font   字体路径
     * @param  integer $size   字号
     * @param  string  $color  文字颜色
     * @param  integer $locate 文字写入位置
     * @param  integer $offset 文字相对当前位置的偏移量
     * @param  integer $angle  文字倾斜角度
     */
    public function text($text, $font, $size, $color = '#00000000', 
        $locate = Image::IMAGE_WATER_SOUTHEAST, $offset = 0, $angle = 0){
        //资源检测
        if(empty($this->img)) E('没有可以被写入文字的图像资源');
        if(!is_file($font)) E("不存在的字体文件：{$font}");

        //获取颜色和透明度
        if(is_array($color)){
            $color = array_map('dechex', $color);
            foreach ($color as &$value) {
                $value = str_pad($value, 2, '0', STR_PAD_LEFT);
            }
            $color = '#' . implode('', $color);
        } elseif(!is_string($color) || 0 !== strpos($color, '#')) {
            E('错误的颜色值');
        }
        $col = substr($color, 0, 7);
        $alp = strlen($color) == 9 ? substr($color, -2) : 0;
        

        //获取文字信息
        $draw = new \ImagickDraw();
        $draw->setFont(realpath($font));
        $draw->setFontSize($size);
        $draw->setFillColor($col);
        $draw->setFillAlpha(1-hexdec($alp)/127);
        $draw->setTextAntialias(true);
        $draw->setStrokeAntialias(true);
        
        $metrics = $this->img->queryFontMetrics($draw, $text);

        /* 计算文字初始坐标和尺寸 */
        $x = 0;
        $y = $metrics['ascender'];
        $w = $metrics['textWidth'];
        $h = $metrics['textHeight'];

        /* 设定文字位置 */
        switch ($locate) {
            /* 右下角文字 */
            case Image::IMAGE_WATER_SOUTHEAST:
                $x += $this->info['width']  - $w;
                $y += $this->info['height'] - $h;
                break;

            /* 左下角文字 */
            case Image::IMAGE_WATER_SOUTHWEST:
                $y += $this->info['height'] - $h;
                break;

            /* 左上角文字 */
            case Image::IMAGE_WATER_NORTHWEST:
                // 起始坐标即为左上角坐标，无需调整
                break;

            /* 右上角文字 */
            case Image::IMAGE_WATER_NORTHEAST:
                $x += $this->info['width'] - $w;
                break;

            /* 居中文字 */
            case Image::IMAGE_WATER_CENTER:
                $x += ($this->info['width']  - $w)/2;
                $y += ($this->info['height'] - $h)/2;
                break;

            /* 下居中文字 */
            case Image::IMAGE_WATER_SOUTH:
                $x += ($this->info['width'] - $w)/2;
                $y += $this->info['height'] - $h;
                break;

            /* 右居中文字 */
            case Image::IMAGE_WATER_EAST:
                $x += $this->info['width'] - $w;
                $y += ($this->info['height'] - $h)/2;
                break;

            /* 上居中文字 */
            case Image::IMAGE_WATER_NORTH:
                $x += ($this->info['width'] - $w)/2;
                break;

            /* 左居中文字 */
            case Image::IMAGE_WATER_WEST:
                $y += ($this->info['height'] - $h)/2;
                break;

            default:
                /* 自定义文字坐标 */
                if(is_array($locate)){
                    list($posx, $posy) = $locate;
                    $x += $posx;
                    $y += $posy;
                } else {
                    E('不支持的文字位置类型');
                }
        }

        /* 设置偏移量 */
        if(is_array($offset)){
            $offset = array_map('intval', $offset);
            list($ox, $oy) = $offset;
        } else{
            $offset = intval($offset);
            $ox = $oy = $offset;
        }

        /* 写入文字 */
        if('gif' == $this->info['type']){
            $img = $this->img->coalesceImages();
            $this->img->destroy(); //销毁原图
            do{
                $img->annotateImage($draw, $x + $ox, $y + $oy, $angle, $text);
            } while ($img->nextImage());

            //压缩图片
            $this->img = $img->deconstructImages();
            $img->destroy(); //销毁零时图片

        } else {
            $this->img->annotateImage($draw, $x + $ox, $y + $oy, $angle, $text);
        }
        $draw->destroy();
    }

    /**
     * 析构方法，用于销毁图像资源
     */
    public function __destruct() {
        empty($this->img) || $this->img->destroy();
    }
}

class Gd{
    /**
     * 图像资源对象
     * @var resource
     */
    private $img;

    /**
     * 图像信息，包括width,height,type,mime,size
     * @var array
     */
    private $info;

    /**
     * 构造方法，可用于打开一张图像
     * @param string $imgname 图像路径
     */
    public function __construct($imgname = null) {
        $imgname && $this->open($imgname);
    }

    /**
     * 打开一张图像
     * @param  string $imgname 图像路径
     */
    public function open($imgname){
        //检测图像文件
        if(!is_file($imgname)) E('不存在的图像文件');

        //获取图像信息
        $info = getimagesize($imgname);

        //检测图像合法性
        if(false === $info || (IMAGETYPE_GIF === $info[2] && empty($info['bits']))){
            E('非法图像文件');
        }

        //设置图像信息
        $this->info = array(
            'width'  => $info[0],
            'height' => $info[1],
            'type'   => image_type_to_extension($info[2], false),
            'mime'   => $info['mime'],
        );

        //销毁已存在的图像
        empty($this->img) || imagedestroy($this->img);

        //打开图像
        if('gif' == $this->info['type']){
            $class  =    'GIF';
            $this->gif = new $class($imgname);
            $this->img = imagecreatefromstring($this->gif->image());
        } else {
            $fun = "imagecreatefrom{$this->info['type']}";
            $this->img = $fun($imgname);
        }
    }

    /**
     * 保存图像
     * @param  string  $imgname   图像保存名称
     * @param  string  $type      图像类型
     * @param  integer $quality   图像质量     
     * @param  boolean $interlace 是否对JPEG类型图像设置隔行扫描
     */
    public function save($imgname, $type = null, $quality=80,$interlace = true){
        if(empty($this->img)) E('没有可以被保存的图像资源');

        //自动获取图像类型
        if(is_null($type)){
            $type = $this->info['type'];
        } else {
            $type = strtolower($type);
        }
        //保存图像
        if('jpeg' == $type || 'jpg' == $type){
            //JPEG图像设置隔行扫描
            imageinterlace($this->img, $interlace);
            imagejpeg($this->img, $imgname,$quality);
        }elseif('gif' == $type && !empty($this->gif)){
            $this->gif->save($imgname);
        }else{
            $fun  =   'image'.$type;
            $fun($this->img, $imgname);
        }
    }

    /**
     * 返回图像宽度
     * @return integer 图像宽度
     */
    public function width(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['width'];
    }

    /**
     * 返回图像高度
     * @return integer 图像高度
     */
    public function height(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['height'];
    }

    /**
     * 返回图像类型
     * @return string 图像类型
     */
    public function type(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['type'];
    }

    /**
     * 返回图像MIME类型
     * @return string 图像MIME类型
     */
    public function mime(){
        if(empty($this->img)) E('没有指定图像资源');
        return $this->info['mime'];
    }

    /**
     * 返回图像尺寸数组 0 - 图像宽度，1 - 图像高度
     * @return array 图像尺寸
     */
    public function size(){
        if(empty($this->img)) E('没有指定图像资源');
        return array($this->info['width'], $this->info['height']);
    }

    /**
     * 裁剪图像
     * @param  integer $w      裁剪区域宽度
     * @param  integer $h      裁剪区域高度
     * @param  integer $x      裁剪区域x坐标
     * @param  integer $y      裁剪区域y坐标
     * @param  integer $width  图像保存宽度
     * @param  integer $height 图像保存高度
     */
    public function crop($w, $h, $x = 0, $y = 0, $width = null, $height = null){
        if(empty($this->img)) E('没有可以被裁剪的图像资源');

        //设置保存尺寸
        empty($width)  && $width  = $w;
        empty($height) && $height = $h;

        do {
            //创建新图像
            $img = imagecreatetruecolor($width, $height);
            // 调整默认颜色
            $color = imagecolorallocate($img, 255, 255, 255);
            imagefill($img, 0, 0, $color);

            //裁剪
            imagecopyresampled($img, $this->img, 0, 0, $x, $y, $width, $height, $w, $h);
            imagedestroy($this->img); //销毁原图

            //设置新图像
            $this->img = $img;
        } while(!empty($this->gif) && $this->gifNext());

        $this->info['width']  = $width;
        $this->info['height'] = $height;
    }

    /**
     * 生成缩略图
     * @param  integer $width  缩略图最大宽度
     * @param  integer $height 缩略图最大高度
     * @param  integer $type   缩略图裁剪类型
     */
    public function thumb($width, $height, $type = Image::IMAGE_THUMB_SCALE){
        if(empty($this->img)) E('没有可以被缩略的图像资源');

        //原图宽度和高度
        $w = $this->info['width'];
        $h = $this->info['height'];

        /* 计算缩略图生成的必要参数 */
        switch ($type) {
            /* 等比例缩放 */
            case Image::IMAGE_THUMB_SCALE:
                //原图尺寸小于缩略图尺寸则不进行缩略
                if($w < $width && $h < $height) return;

                //计算缩放比例
                $scale = min($width/$w, $height/$h);
                
                //设置缩略图的坐标及宽度和高度
                $x = $y = 0;
                $width  = $w * $scale;
                $height = $h * $scale;
                break;

            /* 居中裁剪 */
            case Image::IMAGE_THUMB_CENTER:
                //计算缩放比例
                $scale = max($width/$w, $height/$h);

                //设置缩略图的坐标及宽度和高度
                $w = $width/$scale;
                $h = $height/$scale;
                $x = ($this->info['width'] - $w)/2;
                $y = ($this->info['height'] - $h)/2;
                break;

            /* 左上角裁剪 */
            case Image::IMAGE_THUMB_NORTHWEST:
                //计算缩放比例
                $scale = max($width/$w, $height/$h);

                //设置缩略图的坐标及宽度和高度
                $x = $y = 0;
                $w = $width/$scale;
                $h = $height/$scale;
                break;

            /* 右下角裁剪 */
            case Image::IMAGE_THUMB_SOUTHEAST:
                //计算缩放比例
                $scale = max($width/$w, $height/$h);

                //设置缩略图的坐标及宽度和高度
                $w = $width/$scale;
                $h = $height/$scale;
                $x = $this->info['width'] - $w;
                $y = $this->info['height'] - $h;
                break;

            /* 填充 */
            case Image::IMAGE_THUMB_FILLED:
                //计算缩放比例
                if($w < $width && $h < $height){
                    $scale = 1;
                } else {
                    $scale = min($width/$w, $height/$h);
                }

                //设置缩略图的坐标及宽度和高度
                $neww = $w * $scale;
                $newh = $h * $scale;
                $posx = ($width  - $w * $scale)/2;
                $posy = ($height - $h * $scale)/2;

                do{
                    //创建新图像
                    $img = imagecreatetruecolor($width, $height);
                    // 调整默认颜色
                    $color = imagecolorallocate($img, 255, 255, 255);
                    imagefill($img, 0, 0, $color);

                    //裁剪
                    imagecopyresampled($img, $this->img, $posx, $posy, $x, $y, $neww, $newh, $w, $h);
                    imagedestroy($this->img); //销毁原图
                    $this->img = $img;
                } while(!empty($this->gif) && $this->gifNext());
                
                $this->info['width']  = $width;
                $this->info['height'] = $height;
                return;

            /* 固定 */
            case Image::IMAGE_THUMB_FIXED:
                $x = $y = 0;
                break;

            default:
                E('不支持的缩略图裁剪类型');
        }

        /* 裁剪图像 */
        $this->crop($w, $h, $x, $y, $width, $height);
    }

    /**
     * 添加水印
     * @param  string  $source 水印图片路径
     * @param  integer $locate 水印位置
     * @param  integer $alpha  水印透明度
     */
    public function water($source, $locate = Image::IMAGE_WATER_SOUTHEAST,$alpha=80){
        //资源检测
        if(empty($this->img)) E('没有可以被添加水印的图像资源');
        if(!is_file($source)) E('水印图像不存在');

        //获取水印图像信息
        $info = getimagesize($source);
        if(false === $info || (IMAGETYPE_GIF === $info[2] && empty($info['bits']))){
            E('非法水印文件');
        }

        //创建水印图像资源
        $fun   = 'imagecreatefrom' . image_type_to_extension($info[2], false);
        $water = $fun($source);

        //设定水印图像的混色模式
        imagealphablending($water, true);

        /* 设定水印位置 */
        switch ($locate) {
            /* 右下角水印 */
            case Image::IMAGE_WATER_SOUTHEAST:
                $x = $this->info['width'] - $info[0];
                $y = $this->info['height'] - $info[1];
                break;

            /* 左下角水印 */
            case Image::IMAGE_WATER_SOUTHWEST:
                $x = 0;
                $y = $this->info['height'] - $info[1];
                break;

            /* 左上角水印 */
            case Image::IMAGE_WATER_NORTHWEST:
                $x = $y = 0;
                break;

            /* 右上角水印 */
            case Image::IMAGE_WATER_NORTHEAST:
                $x = $this->info['width'] - $info[0];
                $y = 0;
                break;

            /* 居中水印 */
            case Image::IMAGE_WATER_CENTER:
                $x = ($this->info['width'] - $info[0])/2;
                $y = ($this->info['height'] - $info[1])/2;
                break;

            /* 下居中水印 */
            case Image::IMAGE_WATER_SOUTH:
                $x = ($this->info['width'] - $info[0])/2;
                $y = $this->info['height'] - $info[1];
                break;

            /* 右居中水印 */
            case Image::IMAGE_WATER_EAST:
                $x = $this->info['width'] - $info[0];
                $y = ($this->info['height'] - $info[1])/2;
                break;

            /* 上居中水印 */
            case Image::IMAGE_WATER_NORTH:
                $x = ($this->info['width'] - $info[0])/2;
                $y = 0;
                break;

            /* 左居中水印 */
            case Image::IMAGE_WATER_WEST:
                $x = 0;
                $y = ($this->info['height'] - $info[1])/2;
                break;

            default:
                /* 自定义水印坐标 */
                if(is_array($locate)){
                    list($x, $y) = $locate;
                } else {
                    E('不支持的水印位置类型');
                }
        }

        do{
            //添加水印
            $src = imagecreatetruecolor($info[0], $info[1]);
            // 调整默认颜色
            $color = imagecolorallocate($src, 255, 255, 255);
            imagefill($src, 0, 0, $color);

            imagecopy($src, $this->img, 0, 0, $x, $y, $info[0], $info[1]);
            imagecopy($src, $water, 0, 0, 0, 0, $info[0], $info[1]);
            imagecopymerge($this->img, $src, $x, $y, 0, 0, $info[0], $info[1], $alpha);

            //销毁零时图片资源
            imagedestroy($src);
        } while(!empty($this->gif) && $this->gifNext());

        //销毁水印资源
        imagedestroy($water);
    }

    /**
     * 图像添加文字
     * @param  string  $text   添加的文字
     * @param  string  $font   字体路径
     * @param  integer $size   字号
     * @param  string  $color  文字颜色
     * @param  integer $locate 文字写入位置
     * @param  integer $offset 文字相对当前位置的偏移量
     * @param  integer $angle  文字倾斜角度
     */
    public function text($text, $font, $size, $color = '#00000000', 
        $locate = Image::IMAGE_WATER_SOUTHEAST, $offset = 0, $angle = 0){
        //资源检测
        if(empty($this->img)) E('没有可以被写入文字的图像资源');
        if(!is_file($font)) E("不存在的字体文件：{$font}");

        //获取文字信息
        $info = imagettfbbox($size, $angle, $font, $text);
        $minx = min($info[0], $info[2], $info[4], $info[6]); 
        $maxx = max($info[0], $info[2], $info[4], $info[6]); 
        $miny = min($info[1], $info[3], $info[5], $info[7]); 
        $maxy = max($info[1], $info[3], $info[5], $info[7]); 

        /* 计算文字初始坐标和尺寸 */
        $x = $minx;
        $y = abs($miny);
        $w = $maxx - $minx;
        $h = $maxy - $miny;

        /* 设定文字位置 */
        switch ($locate) {
            /* 右下角文字 */
            case Image::IMAGE_WATER_SOUTHEAST:
                $x += $this->info['width']  - $w;
                $y += $this->info['height'] - $h;
                break;

            /* 左下角文字 */
            case Image::IMAGE_WATER_SOUTHWEST:
                $y += $this->info['height'] - $h;
                break;

            /* 左上角文字 */
            case Image::IMAGE_WATER_NORTHWEST:
                // 起始坐标即为左上角坐标，无需调整
                break;

            /* 右上角文字 */
            case Image::IMAGE_WATER_NORTHEAST:
                $x += $this->info['width'] - $w;
                break;

            /* 居中文字 */
            case Image::IMAGE_WATER_CENTER:
                $x += ($this->info['width']  - $w)/2;
                $y += ($this->info['height'] - $h)/2;
                break;

            /* 下居中文字 */
            case Image::IMAGE_WATER_SOUTH:
                $x += ($this->info['width'] - $w)/2;
                $y += $this->info['height'] - $h;
                break;

            /* 右居中文字 */
            case Image::IMAGE_WATER_EAST:
                $x += $this->info['width'] - $w;
                $y += ($this->info['height'] - $h)/2;
                break;

            /* 上居中文字 */
            case Image::IMAGE_WATER_NORTH:
                $x += ($this->info['width'] - $w)/2;
                break;

            /* 左居中文字 */
            case Image::IMAGE_WATER_WEST:
                $y += ($this->info['height'] - $h)/2;
                break;

            default:
                /* 自定义文字坐标 */
                if(is_array($locate)){
                    list($posx, $posy) = $locate;
                    $x += $posx;
                    $y += $posy;
                } else {
                    E('不支持的文字位置类型');
                }
        }

        /* 设置偏移量 */
        if(is_array($offset)){
            $offset = array_map('intval', $offset);
            list($ox, $oy) = $offset;
        } else{
            $offset = intval($offset);
            $ox = $oy = $offset;
        }

        /* 设置颜色 */
        if(is_string($color) && 0 === strpos($color, '#')){
            $color = str_split(substr($color, 1), 2);
            $color = array_map('hexdec', $color);
            if(empty($color[3]) || $color[3] > 127){
                $color[3] = 0;
            }
        } elseif (!is_array($color)) {
            E('错误的颜色值');
        }

        do{
            /* 写入文字 */
            $col = imagecolorallocatealpha($this->img, $color[0], $color[1], $color[2], $color[3]);
            imagettftext($this->img, $size, $angle, $x + $ox, $y + $oy, $col, $font, $text);
        } while(!empty($this->gif) && $this->gifNext());
    }

    /* 切换到GIF的下一帧并保存当前帧，内部使用 */
    private function gifNext(){
        ob_start();
        ob_implicit_flush(0);
        imagegif($this->img);
        $img = ob_get_clean();

        $this->gif->image($img);
        $next = $this->gif->nextImage();

        if($next){
            $this->img = imagecreatefromstring($next);
            return $next;
        } else {
            $this->img = imagecreatefromstring($this->gif->image());
            return false;
        }
    }

    /**
     * 析构方法，用于销毁图像资源
     */
    public function __destruct() {
        empty($this->img) || imagedestroy($this->img);
    }
}

class GIF{
    /**
     * GIF帧列表
     * @var array
     */
    private $frames = array();

    /**
     * 每帧等待时间列表
     * @var array
     */
    private $delays = array();

    /**
     * 构造方法，用于解码GIF图片
     * @param string $src GIF图片数据
     * @param string $mod 图片数据类型
     */
    public function __construct($src = null, $mod = 'url') {
        if(!is_null($src)){
            if('url' == $mod && is_file($src)){
                $src = file_get_contents($src);
            }
            
            /* 解码GIF图片 */
            try{
                $de = new GIFDecoder($src);
                $this->frames = $de->GIFGetFrames();
                $this->delays = $de->GIFGetDelays();
            } catch(\Exception $e){
                E("解码GIF图片出错");
            }
        }
    }

    /**
     * 设置或获取当前帧的数据
     * @param  string $stream 二进制数据流
     * @return boolean        获取到的数据
     */
    public function image($stream = null){
        if(is_null($stream)){
            $current = current($this->frames);
            return false === $current ? reset($this->frames) : $current;
        } else {
            $this->frames[key($this->frames)] = $stream;
        }
    }

    /**
     * 将当前帧移动到下一帧
     * @return string 当前帧数据
     */
    public function nextImage(){
        return next($this->frames);
    }

    /**
     * 编码并保存当前GIF图片
     * @param  string $gifname 图片名称
     */
    public function save($gifname){
        $gif = new GIFEncoder($this->frames, $this->delays, 0, 2, 0, 0, 0, 'bin');
        file_put_contents($gifname, $gif->GetAnimation());
    }

}


/*
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::
::  GIFEncoder Version 2.0 by László Zsidi, http://gifs.hu
::
::  This class is a rewritten 'GifMerge.class.php' version.
::
::  Modification:
::   - Simplified and easy code,
::   - Ultra fast encoding,
::   - Built-in errors,
::   - Stable working
::
::
::  Updated at 2007. 02. 13. '00.05.AM'
::
::
::
::  Try on-line GIFBuilder Form demo based on GIFEncoder.
::
::  http://gifs.hu/phpclasses/demos/GifBuilder/
::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
*/

Class GIFEncoder {
    private $GIF = "GIF89a";        /* GIF header 6 bytes   */
    private $VER = "GIFEncoder V2.05";  /* Encoder version      */

    private $BUF = Array ( );
    private $LOP =  0;
    private $DIS =  2;
    private $COL = -1;
    private $IMG = -1;

    private $ERR = Array (
        'ERR00' =>  "Does not supported function for only one image!",
        'ERR01' =>  "Source is not a GIF image!",
        'ERR02' =>  "Unintelligible flag ",
        'ERR03' =>  "Does not make animation from animated GIF source",
    );

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFEncoder...
    ::
    */
    public function __construct($GIF_src, $GIF_dly, $GIF_lop, $GIF_dis,$GIF_red, $GIF_grn, $GIF_blu, $GIF_mod) {
        if ( ! is_array ( $GIF_src ) && ! is_array ( $GIF_dly ) ) {
            printf  ( "%s: %s", $this->VER, $this->ERR [ 'ERR00' ] );
            exit    ( 0 );
        }
        $this->LOP = ( $GIF_lop > -1 ) ? $GIF_lop : 0;
        $this->DIS = ( $GIF_dis > -1 ) ? ( ( $GIF_dis < 3 ) ? $GIF_dis : 3 ) : 2;
        $this->COL = ( $GIF_red > -1 && $GIF_grn > -1 && $GIF_blu > -1 ) ?
                        ( $GIF_red | ( $GIF_grn << 8 ) | ( $GIF_blu << 16 ) ) : -1;

        for ( $i = 0; $i < count ( $GIF_src ); $i++ ) {
            if ( strToLower ( $GIF_mod ) == "url" ) {
                $this->BUF [ ] = fread ( fopen ( $GIF_src [ $i ], "rb" ), filesize ( $GIF_src [ $i ] ) );
            }
            else if ( strToLower ( $GIF_mod ) == "bin" ) {
                $this->BUF [ ] = $GIF_src [ $i ];
            }
            else {
                printf  ( "%s: %s ( %s )!", $this->VER, $this->ERR [ 'ERR02' ], $GIF_mod );
                exit    ( 0 );
            }
            if ( substr ( $this->BUF [ $i ], 0, 6 ) != "GIF87a" && substr ( $this->BUF [ $i ], 0, 6 ) != "GIF89a" ) {
                printf  ( "%s: %d %s", $this->VER, $i, $this->ERR [ 'ERR01' ] );
                exit    ( 0 );
            }
            for ( $j = ( 13 + 3 * ( 2 << ( ord ( $this->BUF [ $i ] { 10 } ) & 0x07 ) ) ), $k = TRUE; $k; $j++ ) {
                switch ( $this->BUF [ $i ] { $j } ) {
                    case "!":
                        if ( ( substr ( $this->BUF [ $i ], ( $j + 3 ), 8 ) ) == "NETSCAPE" ) {
                            printf  ( "%s: %s ( %s source )!", $this->VER, $this->ERR [ 'ERR03' ], ( $i + 1 ) );
                            exit    ( 0 );
                        }
                        break;
                    case ";":
                        $k = FALSE;
                        break;
                }
            }
        }
        $this->GIFAddHeader ( );
        for ( $i = 0; $i < count ( $this->BUF ); $i++ ) {
            $this->GIFAddFrames ( $i, $GIF_dly [ $i ] );
        }
        $this->GIFAddFooter ( );
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFAddHeader...
    ::
    */
    private function GIFAddHeader ( ) {
        $cmap = 0;

        if ( ord ( $this->BUF [ 0 ] { 10 } ) & 0x80 ) {
            $cmap = 3 * ( 2 << ( ord ( $this->BUF [ 0 ] { 10 } ) & 0x07 ) );

            $this->GIF .= substr ( $this->BUF [ 0 ], 6, 7       );
            $this->GIF .= substr ( $this->BUF [ 0 ], 13, $cmap  );
            $this->GIF .= "!\377\13NETSCAPE2.0\3\1" . $this->GIFWord ( $this->LOP ) . "\0";
        }
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFAddFrames...
    ::
    */
    private function GIFAddFrames ( $i, $d ) {

        $Locals_str = 13 + 3 * ( 2 << ( ord ( $this->BUF [ $i ] { 10 } ) & 0x07 ) );

        $Locals_end = strlen ( $this->BUF [ $i ] ) - $Locals_str - 1;
        $Locals_tmp = substr ( $this->BUF [ $i ], $Locals_str, $Locals_end );

        $Global_len = 2 << ( ord ( $this->BUF [ 0  ] { 10 } ) & 0x07 );
        $Locals_len = 2 << ( ord ( $this->BUF [ $i ] { 10 } ) & 0x07 );

        $Global_rgb = substr ( $this->BUF [ 0  ], 13,
                            3 * ( 2 << ( ord ( $this->BUF [ 0  ] { 10 } ) & 0x07 ) ) );
        $Locals_rgb = substr ( $this->BUF [ $i ], 13,
                            3 * ( 2 << ( ord ( $this->BUF [ $i ] { 10 } ) & 0x07 ) ) );

        $Locals_ext = "!\xF9\x04" . chr ( ( $this->DIS << 2 ) + 0 ) .
                        chr ( ( $d >> 0 ) & 0xFF ) . chr ( ( $d >> 8 ) & 0xFF ) . "\x0\x0";

        if ( $this->COL > -1 && ord ( $this->BUF [ $i ] { 10 } ) & 0x80 ) {
            for ( $j = 0; $j < ( 2 << ( ord ( $this->BUF [ $i ] { 10 } ) & 0x07 ) ); $j++ ) {
                if  (
                        ord ( $Locals_rgb { 3 * $j + 0 } ) == ( ( $this->COL >> 16 ) & 0xFF ) &&
                        ord ( $Locals_rgb { 3 * $j + 1 } ) == ( ( $this->COL >>  8 ) & 0xFF ) &&
                        ord ( $Locals_rgb { 3 * $j + 2 } ) == ( ( $this->COL >>  0 ) & 0xFF )
                    ) {
                    $Locals_ext = "!\xF9\x04" . chr ( ( $this->DIS << 2 ) + 1 ) .
                                    chr ( ( $d >> 0 ) & 0xFF ) . chr ( ( $d >> 8 ) & 0xFF ) . chr ( $j ) . "\x0";
                    break;
                }
            }
        }
        switch ( $Locals_tmp { 0 } ) {
            case "!":
                $Locals_img = substr ( $Locals_tmp, 8, 10 );
                $Locals_tmp = substr ( $Locals_tmp, 18, strlen ( $Locals_tmp ) - 18 );
                break;
            case ",":
                $Locals_img = substr ( $Locals_tmp, 0, 10 );
                $Locals_tmp = substr ( $Locals_tmp, 10, strlen ( $Locals_tmp ) - 10 );
                break;
        }
        if ( ord ( $this->BUF [ $i ] { 10 } ) & 0x80 && $this->IMG > -1 ) {
            if ( $Global_len == $Locals_len ) {
                if ( $this->GIFBlockCompare ( $Global_rgb, $Locals_rgb, $Global_len ) ) {
                    $this->GIF .= ( $Locals_ext . $Locals_img . $Locals_tmp );
                }
                else {
                    $byte  = ord ( $Locals_img { 9 } );
                    $byte |= 0x80;
                    $byte &= 0xF8;
                    $byte |= ( ord ( $this->BUF [ 0 ] { 10 } ) & 0x07 );
                    $Locals_img { 9 } = chr ( $byte );
                    $this->GIF .= ( $Locals_ext . $Locals_img . $Locals_rgb . $Locals_tmp );
                }
            }
            else {
                $byte  = ord ( $Locals_img { 9 } );
                $byte |= 0x80;
                $byte &= 0xF8;
                $byte |= ( ord ( $this->BUF [ $i ] { 10 } ) & 0x07 );
                $Locals_img { 9 } = chr ( $byte );
                $this->GIF .= ( $Locals_ext . $Locals_img . $Locals_rgb . $Locals_tmp );
            }
        }
        else {
            $this->GIF .= ( $Locals_ext . $Locals_img . $Locals_tmp );
        }
        $this->IMG  = 1;
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFAddFooter...
    ::
    */
    private function GIFAddFooter ( ) {
        $this->GIF .= ";";
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFBlockCompare...
    ::
    */
    private function GIFBlockCompare ( $GlobalBlock, $LocalBlock, $Len ) {

        for ( $i = 0; $i < $Len; $i++ ) {
            if  (
                    $GlobalBlock { 3 * $i + 0 } != $LocalBlock { 3 * $i + 0 } ||
                    $GlobalBlock { 3 * $i + 1 } != $LocalBlock { 3 * $i + 1 } ||
                    $GlobalBlock { 3 * $i + 2 } != $LocalBlock { 3 * $i + 2 }
                ) {
                    return ( 0 );
            }
        }

        return ( 1 );
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFWord...
    ::
    */
    private function GIFWord ( $int ) {

        return ( chr ( $int & 0xFF ) . chr ( ( $int >> 8 ) & 0xFF ) );
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GetAnimation...
    ::
    */
    public function GetAnimation ( ) {
        return ( $this->GIF );
    }
}


/*
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::
::  GIFDecoder Version 2.0 by László Zsidi, http://gifs.hu
::
::  Created at 2007. 02. 01. '07.47.AM'
::
::
::
::
::  Try on-line GIFBuilder Form demo based on GIFDecoder.
::
::  http://gifs.hu/phpclasses/demos/GifBuilder/
::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
*/

Class GIFDecoder {
    private $GIF_buffer = Array ( );
    private $GIF_arrays = Array ( );
    private $GIF_delays = Array ( );
    private $GIF_stream = "";
    private $GIF_string = "";
    private $GIF_bfseek =  0;

    private $GIF_screen = Array ( );
    private $GIF_global = Array ( );
    private $GIF_sorted;
    private $GIF_colorS;
    private $GIF_colorC;
    private $GIF_colorF;

    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFDecoder ( $GIF_pointer )
    ::
    */
    public function __construct ( $GIF_pointer ) {
        $this->GIF_stream = $GIF_pointer;

        $this->GIFGetByte ( 6 );    // GIF89a
        $this->GIFGetByte ( 7 );    // Logical Screen Descriptor

        $this->GIF_screen = $this->GIF_buffer;
        $this->GIF_colorF = $this->GIF_buffer [ 4 ] & 0x80 ? 1 : 0;
        $this->GIF_sorted = $this->GIF_buffer [ 4 ] & 0x08 ? 1 : 0;
        $this->GIF_colorC = $this->GIF_buffer [ 4 ] & 0x07;
        $this->GIF_colorS = 2 << $this->GIF_colorC;

        if ( $this->GIF_colorF == 1 ) {
            $this->GIFGetByte ( 3 * $this->GIF_colorS );
            $this->GIF_global = $this->GIF_buffer;
        }
        /*
         *
         *  05.06.2007.
         *  Made a little modification
         *
         *
         -  for ( $cycle = 1; $cycle; ) {
         +      if ( GIFDecoder::GIFGetByte ( 1 ) ) {
         -          switch ( $this->GIF_buffer [ 0 ] ) {
         -              case 0x21:
         -                  GIFDecoder::GIFReadExtensions ( );
         -                  break;
         -              case 0x2C:
         -                  GIFDecoder::GIFReadDescriptor ( );
         -                  break;
         -              case 0x3B:
         -                  $cycle = 0;
         -                  break;
         -          }
         -      }
         +      else {
         +          $cycle = 0;
         +      }
         -  }
        */
        for ( $cycle = 1; $cycle; ) {
            if ( $this->GIFGetByte ( 1 ) ) {
                switch ( $this->GIF_buffer [ 0 ] ) {
                    case 0x21:
                        $this->GIFReadExtensions ( );
                        break;
                    case 0x2C:
                        $this->GIFReadDescriptor ( );
                        break;
                    case 0x3B:
                        $cycle = 0;
                        break;
                }
            }
            else {
                $cycle = 0;
            }
        }
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFReadExtension ( )
    ::
    */
    private function GIFReadExtensions ( ) {
        $this->GIFGetByte ( 1 );
        for ( ; ; ) {
            $this->GIFGetByte ( 1 );
            if ( ( $u = $this->GIF_buffer [ 0 ] ) == 0x00 ) {
                break;
            }
            $this->GIFGetByte ( $u );
            /*
             * 07.05.2007.
             * Implemented a new line for a new function
             * to determine the originaly delays between
             * frames.
             *
             */
            if ( $u == 4 ) {
                $this->GIF_delays [ ] = ( $this->GIF_buffer [ 1 ] | $this->GIF_buffer [ 2 ] << 8 );
            }
        }
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFReadExtension ( )
    ::
    */
    private function GIFReadDescriptor ( ) {
        $GIF_screen = Array ( );

        $this->GIFGetByte ( 9 );
        $GIF_screen = $this->GIF_buffer;
        $GIF_colorF = $this->GIF_buffer [ 8 ] & 0x80 ? 1 : 0;
        if ( $GIF_colorF ) {
            $GIF_code = $this->GIF_buffer [ 8 ] & 0x07;
            $GIF_sort = $this->GIF_buffer [ 8 ] & 0x20 ? 1 : 0;
        }
        else {
            $GIF_code = $this->GIF_colorC;
            $GIF_sort = $this->GIF_sorted;
        }
        $GIF_size = 2 << $GIF_code;
        $this->GIF_screen [ 4 ] &= 0x70;
        $this->GIF_screen [ 4 ] |= 0x80;
        $this->GIF_screen [ 4 ] |= $GIF_code;
        if ( $GIF_sort ) {
            $this->GIF_screen [ 4 ] |= 0x08;
        }
        $this->GIF_string = "GIF87a";
        $this->GIFPutByte ( $this->GIF_screen );
        if ( $GIF_colorF == 1 ) {
            $this->GIFGetByte ( 3 * $GIF_size );
            $this->GIFPutByte ( $this->GIF_buffer );
        }
        else {
            $this->GIFPutByte ( $this->GIF_global );
        }
        $this->GIF_string .= chr ( 0x2C );
        $GIF_screen [ 8 ] &= 0x40;
        $this->GIFPutByte ( $GIF_screen );
        $this->GIFGetByte ( 1 );
        $this->GIFPutByte ( $this->GIF_buffer );
        for ( ; ; ) {
            $this->GIFGetByte ( 1 );
            $this->GIFPutByte ( $this->GIF_buffer );
            if ( ( $u = $this->GIF_buffer [ 0 ] ) == 0x00 ) {
                break;
            }
            $this->GIFGetByte ( $u );
            $this->GIFPutByte ( $this->GIF_buffer );
        }
        $this->GIF_string .= chr ( 0x3B );
        /*
           Add frames into $GIF_stream array...
        */
        $this->GIF_arrays [ ] = $this->GIF_string;
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFGetByte ( $len )
    ::
    */

    /*
     *
     *  05.06.2007.
     *  Made a little modification
     *
     *
     -  function GIFGetByte ( $len ) {
     -      $this->GIF_buffer = Array ( );
     -
     -      for ( $i = 0; $i < $len; $i++ ) {
     +          if ( $this->GIF_bfseek > strlen ( $this->GIF_stream ) ) {
     +              return 0;
     +          }
     -          $this->GIF_buffer [ ] = ord ( $this->GIF_stream { $this->GIF_bfseek++ } );
     -      }
     +      return 1;
     -  }
     */
    private function GIFGetByte ( $len ) {
        $this->GIF_buffer = Array ( );

        for ( $i = 0; $i < $len; $i++ ) {
            if ( $this->GIF_bfseek > strlen ( $this->GIF_stream ) ) {
                return 0;
            }
            $this->GIF_buffer [ ] = ord ( $this->GIF_stream { $this->GIF_bfseek++ } );
        }
        return 1;
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFPutByte ( $bytes )
    ::
    */
    private function GIFPutByte ( $bytes ) {
        for ( $i = 0; $i < count ( $bytes ); $i++ ) {
            $this->GIF_string .= chr ( $bytes [ $i ] );
        }
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  PUBLIC FUNCTIONS
    ::
    ::
    ::  GIFGetFrames ( )
    ::
    */
    public function GIFGetFrames ( ) {
        return ( $this->GIF_arrays );
    }
    /*
    :::::::::::::::::::::::::::::::::::::::::::::::::::
    ::
    ::  GIFGetDelays ( )
    ::
    */
    public function GIFGetDelays ( ) {
        return ( $this->GIF_delays );
    }
}
