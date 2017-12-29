<?php

	$file1 = $argv[1];
	$file2 = $argv[2];

	$f1 = fopen(dirname(__FILE__) . "/{$file1}", "r");
	$f2 = fopen(dirname(__FILE__) . "/{$file2}", "r");

	$s1 = filesize($file1);
	$s2 = filesize($file2);

	if ($s1 === $s2) {

		if (isset($argv[3])) {
                        $chunk = $argv[3];
                } else {
                        $chunk = 128 * 1024;
                }


		echo "File 1: {$file1}\n";
		echo "File 2: {$file2}\n";

		echo "Byte size: {$s1} bytes\n";
		echo "Chunk size: {$chunk} bytes\n";

		$n = 0;
		$e = 0;

		while (!feof($f1)) {

			$ch1 = fread($f1, $chunk);
			$ch2 = fread($f2, $chunk);

			$md1 = md5($ch1);
			$md2 = md5($ch2);

			if ($md1 !== $md2) {
				$err = "***ERROR***";
				$e++;
			} else {
				$err = "";
			}

			$p = $n * $chunk;
			$q = $p + strlen($ch1) - 1;

			$msg = "#{$n}\t{$md1}\t{$md2}\t[{$p}-{$q}]\t{$err}\n";

			echo $msg;

			$n++;
		}

		echo "Errors: {$e}\n";

	} else {
		echo "The byte size of both files are not the same.\n";
	}
