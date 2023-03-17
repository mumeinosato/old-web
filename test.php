<?php

// ファイルに書き込むテキスト
$content = "改行を含む
テキストを書き込む\n\n";
$content2 = "テストテキスト";


// ディレクトリに書き込み可能か確認
if( is_writable($path) ) {

	// ファイルを書き込みモードで開く
	$file_handle = fopen("data.txt", "w");

	// ファイルへデータを書き込み
	fwrite( $file_handle, $content);
	fwrite( $file_handle, $content2);

	// ファイルを閉じる
	fclose($file_handle);
}

return;