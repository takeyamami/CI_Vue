<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hatena extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		/* ----------------------------------------
        はてなブログAtomPubから最新ブログURLを取得 
        ------------------------------------------ */
        $url = HATENA_ENDPOINT;
        $userid = HATENA_USERID;
        $apiKey = HATENA_API_KEY;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERPWD, "$userid:$apiKey");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);

        $entryListData = curl_exec($ch);
        curl_close($ch);

        $resultList = [];

        // 取得できなかった場合
        if (! $entryListData) {
            return;
        }

        $result = new SimpleXMLELement($entryListData);

        /* ----------------------------------------
        はてなブログoEmbed APIから表示用データを取得 
        ------------------------------------------ */

        for ($i = 0; $i < count($result->entry); $i++) {

            $param = '?url=' . $result->entry[$i]->link[1]['href']->__toString();

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://hatenablog.com/oembed' . $param);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);

            $resultData = curl_exec($ch);
            curl_close($ch);

            // 公開されていない記事や正しく取得できなかった場合は、スキップ
            if ($resultData === FALSE) continue;

            $entryData = json_decode($resultData, TRUE);

            // 適当に突っ込む
            $resultList[] = [
                'title' => $entryData['title'],
                'description' =>$entryData['description'],
                'published' => date('Y/n/j', strtotime($entryData['published'])),
                'url' => $entryData['url'],
                'image_url' => $entryData['image_url'],
            ];
        }

        var_dump($resultList); exit;
	}
}
