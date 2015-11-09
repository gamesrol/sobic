<?php
//** Compilacion de css a less **//
function autoCompileLess($inputFile, $outputFile) {
	// load the cache
	if($_SERVER['PHP_SELF'] != "sobic" && $_SERVER['PHP_SELF'] != "./sobic"){
		$cacheFile = $inputFile.".cache";
	
		if (file_exists($cacheFile)) {
		$cache = unserialize(file_get_contents($cacheFile));
		} else {
			$cache = $inputFile;
		}
	
		$less = new lessc;
		$less->setFormatter("compressed");
		$newCache = $less->cachedCompile($cache);
	
		if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
			file_put_contents($cacheFile, serialize($newCache));
			file_put_contents($outputFile, $newCache['compiled']);
		}
	}
}


//** Validacion del cliente AngularJS **/
function validatedKey($user) {
	try {
		$veri = User::where('id', '=', $user['id'])->first();
		$encriptedKey = hash('sha512', $veri->id.$veri->email.$veri->created_at);
		
		if($user['key'] == $encriptedKey) {
			return true;
		} else {
			return false;
		}
	} catch (Exception $e) {
		return false;
	}
}