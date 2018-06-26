<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING' => array(
	    '__AIMG__'    =>  __ROOT__.'/Public/admin/images',// 站点公共js文件目录
	    '__ACSS__'    => __ROOT__.'/Public/admin/css',// 站点公共js文件目录 //CSS目录
	    '__AJS__'     => __ROOT__.'/Public/admin/js',//JS目录
    	/* '__IMG__'    =>  __ROOT__.'/Public/perfectrenew2018/images',// 站点公共js文件目录
    	'__CSS__'    => __ROOT__.'/Public/perfectrenew2018/css',// 站点公共js文件目录 //CSS目录
    	'__JS__'     => __ROOT__.'/Public/perfectrenew2018/js',//JS目录 */
    	
	    '__IMG__'    =>  C('CDN').'/H5/laneige/perfectrennew2018/images',// 站点公共js文件目录
	    '__CSS__'    => C('CDN').'/H5/laneige/perfectrennew2018/css',// 站点公共js文件目录 //CSS目录
	    '__JS__'     => C('CDN').'/H5/laneige/perfectrennew2018/js',//JS目录,//JS目录
    ),
    'DB_PREFIX' => 'laneige_perfectrenew2018_',     // 数据库表前缀
);