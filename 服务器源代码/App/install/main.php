<?php
/**
 * 赞博客，赞生活 v1.0
 * =====================================
 * 当数据写入到数据库后，进行添加管理员，生成配置文件等操作
 * +++++++++++++++++++++++++++++++++++++
 * 天下大事必作于细，天下难事必作于易
 * =====================================
 * $Author: 陈海赞 QQ:526199364$
 */

$username = trim($_POST['manager']);
$password = trim($_POST['manager_pwd']);
//网站名称
$site_name = addslashes(trim($_POST['sitename']));
//网站域名
$site_url = trim($_POST['siteurl']);

//描述
$seo_description = trim($_POST['sitedescription']);
//关键词
$seo_keywords = trim($_POST['sitekeywords']);



//更新配置信息
mysqli_query($conn,"UPDATE `{$dbPrefix}setting` SET  `v` = '$site_name' WHERE k='title'");
mysqli_query($conn,"UPDATE `{$dbPrefix}setting` SET  `v` = '$site_url' WHERE k='site' ");
mysqli_query($conn,"UPDATE `{$dbPrefix}setting` SET  `v` = '$seo_description' WHERE k='description'");
mysqli_query($conn,"UPDATE `{$dbPrefix}setting` SET  `v` = '$seo_keywords' WHERE k='keywords'");


if(INSTALLTYPE == 'HOST'){
	//读取配置文件，并替换真实配置数据
	$strConfig = file_get_contents($config['dbSetFile']);

	$strConfig = str_replace('#DB_HOST#', $dbHost, $strConfig);
	$strConfig = str_replace('#DB_NAME#', $dbName, $strConfig);
	$strConfig = str_replace('#DB_USER#', $dbUser, $strConfig);
	$strConfig = str_replace('#DB_PWD#', $dbPwd, $strConfig);
	$strConfig = str_replace('#DB_PORT#', $dbPort, $strConfig);
	$strConfig = str_replace('#DB_PREFIX#', $dbPrefix, $strConfig);
// 	$strConfig = str_replace('#AUTHCODE#', genRandomString(18), $strConfig);
// 	$strConfig = str_replace('#COOKIE_PREFIX#', genRandomString(6) . "_", $strConfig);
// 	$strConfig = str_replace('#DATA_CACHE_PREFIX#', genRandomString(6) . "_", $strConfig);
// 	$strConfig = str_replace('#SESSION_PREFIX#', genRandomString(6) . "_", $strConfig);
	@file_put_contents($config['dbConfig'], $strConfig);
}

// //插入管理员
//生成随机认证码
// $verify = genRandomString(6);
// $time = time();
// $ip = get_client_ip();

$password = md5('Q'.$password.'W');
$email = trim($_POST['manager_email']);
mysqli_query($conn,"UPDATE `{$dbPrefix}member` SET  `password` = '$password' WHERE uid='1'");
mysqli_query($conn,"UPDATE `{$dbPrefix}member` SET  `email` = '$email' WHERE uid='1'");

return array('status'=>2,'info'=>'成功添加管理员<br />成功写入配置文件<br>安装完成...');


// if(mysql_query($query)){
// 	return array('status'=>2,'info'=>'成功添加管理员<br />成功写入配置文件<br>安装完成...');
// }
// return array('status'=>0,'info'=>'安装失败...');
