<?php
/**
 * 上传附件和上传视频
 * User: Jinqn
 * Date: 14-04-09
 * Time: 上午10:17
 */
include "Uploader.class.php";

/* 上传配置 */
$base64 = "upload";
switch (htmlspecialchars($_GET['action'])) {
    case 'uploadimage':
	
		$link=mysql_connect('localhost','root','web6328');
		mysql_select_db('haohuisua');
		$result=mysql_query("select  value from mcs_configs where code = 'picture_system' ");
		$result=mysql_fetch_row($result);
		$result=$result[0];
		$result=explode('.',$result);
		
		unset($result[0]);
		
		$result1='.'.$result[1];
		@$result2='.'.$result[2];
		@$result3='.'.$result[3];
		@$result4='.'.$result[4];
		
		
		$picture_size=mysql_query("select  value from mcs_configs where code = 'picture_size' ");
		$pictures=mysql_fetch_row($picture_size);
		$picture=intval($pictures['0']);
		
        $config = array(
            "pathFormat" => $CONFIG['imagePathFormat'],
			"maxSize" => $picture,
            //"allowFiles" => [".jpg", ".jpeg", ".gif", ".bmp"],
           // "maxSize" => $CONFIG[$picture],
            
            "allowFiles" => [$result1, $result2,$result3, $result4],
        );
        $fieldName = $CONFIG['imageFieldName'];
        break;
    case 'uploadscrawl':
        $config = array(
            "pathFormat" => $CONFIG['scrawlPathFormat'],
            "maxSize" => $CONFIG['scrawlMaxSize'],
            "allowFiles" => $CONFIG['scrawlAllowFiles'],
            "oriName" => "scrawl.png"
        );
        $fieldName = $CONFIG['scrawlFieldName'];
        $base64 = "base64";
        break;
    case 'uploadvideo':
        $config = array(
            "pathFormat" => $CONFIG['videoPathFormat'],
            "maxSize" => $CONFIG['videoMaxSize'],
            "allowFiles" => $CONFIG['videoAllowFiles']
        );
        $fieldName = $CONFIG['videoFieldName'];
        break;
    case 'uploadfile':
    default:
        $config = array(
            "pathFormat" => $CONFIG['filePathFormat'],
            "maxSize" => $CONFIG['fileMaxSize'],
            "allowFiles" => $CONFIG['fileAllowFiles']
        );
        $fieldName = $CONFIG['fileFieldName'];
        break;
}

/* 生成上传实例对象并完成上传 */
$up = new Uploader($fieldName, $config, $base64);

/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => ""            //文件类型
 *     "size" => "",           //文件大小
 * )
 */

/* 返回数据 */
return json_encode($up->getFileInfo());
