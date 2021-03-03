<?php
require_once('db.class.php');
require_once('errors.php');

$save_path = session_save_path();

// 세션지속시간(세션이 살아있는 시간, 여기선 php.ini 설정값으로 함.
//$SESS_LIFE = get_cfg_var("session.gc_maxlifetime");
$SESS_LIFE = 60 * 60 * 24;

// open()함수 : 디비에 연결작업
function sess_open($savePath, $session_name)
{	
	global $save_path;
	
	if (!is_dir($save_path)) {
		mkdir($save_path, 0777);
	}

	try {
		DB::connectSession();
	} catch (PDOException $e) {
		// DB 연결 실패
		return false;
	}
	return true;
}


// close()함수 : 암것도 안한다~ 혹시나 디비를 닫아주고싶으면 여기서 한다.
function sess_close()
{
	return true;
}


// read()함수 : $key에 해당되는, 저장된 세션값을 DB에서 가져오기 
// 값 있으면 sess_destroy
// 없으면 sess_write
function sess_read($key)
{
	global $save_path;

	// 현재시간보다 세션지속시간이 크다면( 즉 세션이 살아있다면..) 불러온다
	$sess_result = DB::s_query2("SELECT session_value, user_ip, user_id FROM sessions WHERE session_key = :sesskey AND session_expiry > :expiry", array(":sesskey" => $key, ":expiry" => time()));

	// 읽을 데이터 없을 때
	$sess_value = $sess_result[0]['session_value'];
	$user_ip = $sess_result[0]['user_ip'];
	
	if ($sess_value == '') {
		if($user_ip == '-1'){
			ErrorManager::alert('중복 로그인 방지');
		}
		return ''; // 세션 새로 생성
	} else {
		return stripslashes($sess_value);
	}
}

// write()함수 : $key세션에 $val값을 저장합니다. 즉 session_register()를 처리해준다
function sess_write($key, $val)
{
	global $save_path, $SESS_LIFE;

	// 현재시간에 세션지속시간을 더해준다
	$expiry = time() + $SESS_LIFE;
	$value = addslashes($val);
	$user_id = '';
	if(strlen($val) > 0){
		$val_split = explode(';', $val);
		$id_split = explode(':', $val_split[0]);
		$user_id = trim($id_split[2], '"');
	}

	try{
		DB::s_query2("UPDATE sessions SET session_value = :sessvalue, user_ip = :overlap_code WHERE session_key <> :sesskey AND user_id = :user_id", array(':sessvalue' => '', ':overlap_code' => '-1', ':sesskey' => $key, ':user_id' => $user_id));
		
		DB::s_query2(
			"REPLACE INTO sessions SET session_key = :sesskey, session_value = :sessvalue, session_expiry = :expiry, user_id = :user_id, user_ip = :user_ip",
			array(
				':sesskey' => $key,
				':sessvalue' => $value,
				':expiry' => $expiry,
				':user_id' => $user_id,
				':user_ip' => (strlen($value) == 0) ? '' : $_SERVER['REMOTE_ADDR']
			)
		);
	}catch(PDOException $e){
		return false;
	}
	
	return true;
}


// destroy()함수 : $key에 해당하는 값을 지워주자. session_unregister()를 처리해준다.
function sess_destroy($key)
{
	global $save_path;

	try {
		DB::s_query2("DELETE FROM sessions WHERE session_key = :sesskey", array(':sesskey' => $key));
	} catch (PDOException $e) {
		return false;
	}

	$file = "$save_path/sess_$key";
	if (file_exists($file))
	{
		unlink($file);
	}

	return true;
}


// gc()함수 : 세션지속시간이 현재시간보다 작은 쓰레기 세션들을 지워주자~
function sess_gc($maxlifetime)
{
	global $SESS_LIFE, $save_path;

	foreach (glob("$save_path/sess_*") as $file) {
		$key = explode('_', $file)[1];
		if (filemtime($file) + $SESS_LIFE < time()) {
			DB::s_query2("DELETE FROM sessions WHERE session_key = :sesskey", array(':sesskey' => $key));
			if(file_exists($file)){
				unlink($file);
			}
		}
	}
	return true;
}

if ( !isset($_SESSION) ){
	session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");
}
register_shutdown_function('session_write_close');
@session_start();