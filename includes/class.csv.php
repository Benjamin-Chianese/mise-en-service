<?php
class CSV{

	static function export($datas,$filename){
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachement; filename="'.$filename.'.csv"');
		$i = 0 ;
		foreach ($datas as $v) {
			if($i==0){
				echo '"'.implode('";"',array_keys($v)).'"'."\n";
			}
			echo '"'.implode('";"',($v)).'"'."\n";
			$i++;
		}
}
}
